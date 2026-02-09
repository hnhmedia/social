<?php
/**
 * Process Order - Handle Order Form Submission
 * Updated to work with existing si_orders table structure
 * 
 * SECURITY: Success URL includes both oid and order_number to prevent scraping
 * SEO: Uses clean URL format /order/success/123/ORD-20260209-A3F/
 */

// Start session
session_start();

// Include required files
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/dynamic_service_integration.php';
require_once __DIR__ . '/includes/Config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . Config::baseUrl());
    exit;
}

// Get form data
$packageCode = isset($_POST['package_code']) ? trim($_POST['package_code']) : '';
$packageId = isset($_POST['package_id']) ? (int)$_POST['package_id'] : 0;
$serviceId = isset($_POST['service_id']) ? (int)$_POST['service_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
$price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$targetUrl = isset($_POST['target_url']) ? trim($_POST['target_url']) : '';

// Validate required fields
$errors = [];

if (empty($packageCode)) {
    $errors[] = 'Package code is required';
}

if ($packageId <= 0) {
    $errors[] = 'Invalid package';
}

if ($serviceId <= 0) {
    $errors[] = 'Invalid service';
}

if ($quantity <= 0) {
    $errors[] = 'Invalid quantity';
}

if ($price <= 0) {
    $errors[] = 'Invalid price';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Valid email address is required';
}

if (empty($targetUrl)) {
    $errors[] = 'Username or profile URL is required';
}

// If validation fails, redirect back
if (!empty($errors)) {
    $_SESSION['order_errors'] = $errors;
    header("Location: " . Config::baseUrl("order/$packageCode/"));
    exit;
}

try {
    $db = Database::getConnection();
    
    // Get or create guest user for this email
    $userId = getOrCreateGuestUser($db, $email);
    
    // Get service details
    $service = $db->where('id', $serviceId)->getOne('services', 'name, slug');
    
    if (!$service) {
        throw new Exception('Service not found');
    }
    
    // Generate unique order number
    $orderNumber = generateOrderNumber();
    
    // Determine service type from slug
    $serviceType = determineServiceType($service['slug']);
    
    // Prepare order data for existing si_orders table
    $orderData = [
        'user_id' => $userId,
        'order_number' => $orderNumber,
        'service_type' => $serviceType,
        'service_name' => $service['name'],
        'quantity' => $quantity,
        'price' => $price,
        'target_url' => $targetUrl,
        'status' => 'pending',
        'delivered' => 0,
        'remaining' => $quantity,
        'start_count' => 0,
        'current_count' => 0,
        'payment_method' => 'online',
        'notes' => "Package Code: $packageCode",
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    // Insert order into database
    $orderId = $db->insert('orders', $orderData);
    
    if (!$orderId) {
        throw new Exception('Failed to create order: ' . $db->getLastError());
    }
    
    // Store order info in session for tracking
    $_SESSION['last_order_id'] = $orderId;
    $_SESSION['last_order_number'] = $orderNumber;
    $_SESSION['order_email'] = $email;
    
    // Build SEO-friendly success URL (SECURE: includes both oid and order_number)
    $successUrl = buildSuccessUrl($orderId, $orderNumber);
    
    // Build payment gateway URL with success callback
    $paymentUrl = buildPaymentUrl($orderId, $orderNumber, $price, $email, $successUrl);
    
    // Redirect to payment gateway
    header("Location: $paymentUrl");
    exit;
    
} catch (Exception $e) {
    // Log error
    error_log("Order creation failed: " . $e->getMessage());
    
    // Store error in session
    $_SESSION['order_errors'] = ['An error occurred while processing your order. Please try again.'];
    
    // Redirect back to order page
    header("Location: " . Config::baseUrl("order/$packageCode/"));
    exit;
}

/**
 * Get or create guest user for email
 * 
 * @param object $db Database connection
 * @param string $email User email
 * @return int User ID
 */
function getOrCreateGuestUser($db, $email) {
    // Check if user exists with this email
    $user = $db->where('email', $email)->getOne('users', 'id');
    
    if ($user) {
        return $user['id'];
    }
    
    // Create guest user
    $username = 'guest_' . substr(md5($email . time()), 0, 10);
    
    $userData = [
        'username' => $username,
        'email' => $email,
        'password' => password_hash(uniqid(), PASSWORD_DEFAULT), // Random password
        'role' => 'customer',
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $userId = $db->insert('users', $userData);
    
    if (!$userId) {
        throw new Exception('Failed to create user');
    }
    
    return $userId;
}

/**
 * Determine service type from slug
 * 
 * @param string $slug Service slug
 * @return string Service type (instagram, tiktok, facebook, youtube, etc.)
 */
function determineServiceType($slug) {
    if (strpos($slug, 'instagram') !== false) {
        return 'instagram';
    } elseif (strpos($slug, 'tiktok') !== false) {
        return 'tiktok';
    } elseif (strpos($slug, 'facebook') !== false) {
        return 'facebook';
    } elseif (strpos($slug, 'youtube') !== false) {
        return 'youtube';
    } elseif (strpos($slug, 'twitter') !== false || strpos($slug, 'x-') !== false) {
        return 'twitter';
    } else {
        return 'social';
    }
}

/**
 * Generate unique order number
 * Format: ORD-YYYYMMDD-XXX
 * Example: ORD-20260209-A3F
 * 
 * @return string Unique order number (max 20 chars for database)
 */
function generateOrderNumber() {
    // Format: ORD-YYYYMMDD-XXX (19 chars total, fits in VARCHAR(20))
    $date = date('Ymd');
    $random = strtoupper(substr(md5(uniqid(rand(), true)), 0, 3));
    return "ORD-{$date}-{$random}";
}

/**
 * Build secure SEO-friendly success URL
 * SECURITY: Includes both oid AND order_number to prevent order scraping
 * SEO: Clean URL format without query parameters
 * 
 * @param int $orderId Order ID from database
 * @param string $orderNumber Order number (ORD-20260209-A3F)
 * @return string SEO-friendly success URL
 */
function buildSuccessUrl($orderId, $orderNumber) {
    // SEO-friendly clean URL format using Config
    return Config::baseUrl("order/success/{$orderId}/{$orderNumber}/");
}

/**
 * Build payment gateway URL
 * 
 * @param int $orderId Order ID from database (auto-increment)
 * @param string $orderNumber Order number for security
 * @param float $amount Order amount
 * @param string $email Customer email
 * @param string $successUrl Success callback URL
 * @return string Payment gateway URL with GET parameters
 */
function buildPaymentUrl($orderId, $orderNumber, $amount, $email, $successUrl) {
    // Payment gateway base URL
    $baseUrl = 'http://hnh-media.com/pg.php';
    
    // Build query parameters
    $params = [
        'oid' => $orderId,                              // Order increment ID
        'amount' => number_format($amount, 2, '.', ''), // Format: 5.95
        'email' => urlencode($email),                   // URL-encoded email
        'order_number' => $_SESSION['last_order_number']          // Success callback URL (SEO-friendly)
    ];
    
    // Build full URL
    $queryString = http_build_query($params);
    
    // Return complete URL
    return $baseUrl . '?' . $queryString;
}
