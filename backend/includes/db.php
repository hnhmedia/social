<?php
/**
 * Database Helper for Admin Panel
 * Connects to main database and provides helper functions
 */

// Include main database config
$config = require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/MysqliDb.php';

// Initialize database connection
$db = new MysqliDb(
    $config['database']['host'],
    $config['database']['username'],
    $config['database']['password'],
    $config['database']['db']
);

// Set table prefix
$db->setPrefix($config['database']['prefix']);

// Also create a raw mysqli connection for prepared statements (used by SEO pages)
$conn = new mysqli(
    $config['database']['host'],
    $config['database']['username'],
    $config['database']['password'],
    $config['database']['db']
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/**
 * Get all users
 */
function getAllUsers() {
    global $db;
    return $db->orderBy('created_at', 'DESC')->get('users');
}

/**
 * Get all orders
 */
function getAllOrders() {
    global $db;
    return $db->orderBy('created_at', 'DESC')->get('orders');
}

/**
 * Get orders with filters and user info
 */
function getOrdersFiltered($filters = []) {
    global $db;
    $db->join('users u', 'o.user_id = u.id', 'LEFT');

    if (!empty($filters['status']) && in_array($filters['status'], ['pending','processing','completed','cancelled','refunded'], true)) {
        $db->where('o.status', $filters['status']);
    }

    if (!empty($filters['q'])) {
        $q = '%' . $filters['q'] . '%';
        $db->where('(o.order_number LIKE ? OR u.email LIKE ? OR o.email LIKE ? OR o.target_url LIKE ? OR o.transaction_id LIKE ?)', [$q, $q, $q, $q, $q]);
    }

    if (!empty($filters['date'])) {
        $db->where('DATE(o.created_at)', $filters['date']);
    }

    if (!empty($filters['payment_method'])) {
        $db->where('o.payment_method', $filters['payment_method']);
    }

    if (!empty($filters['amount_min']) && is_numeric($filters['amount_min'])) {
        $db->where('o.price', (float)$filters['amount_min'], '>=');
    }

    if (!empty($filters['attention']) && $filters['attention'] === '1') {
        $db->where("(o.status IN ('pending','processing')) AND o.created_at <= DATE_SUB(NOW(), INTERVAL 24 HOUR)");
    }

    $db->orderBy('o.created_at', 'DESC');
    return $db->get('orders o', null, 'o.*, u.email as user_email, u.name as user_name');
}

// Bulk update statuses
function updateOrdersStatusBulk($ids = [], $status = 'pending') {
    global $db;
    $allowed = ['pending','processing','completed','cancelled','refunded'];
    if (empty($ids) || !in_array($status, $allowed, true)) {
        return false;
    }
    $db->where('id', $ids, 'IN');
    return $db->update('orders', [
        'status' => $status,
        'updated_at' => date('Y-m-d H:i:s'),
        'completed_at' => $status === 'completed' ? date('Y-m-d H:i:s') : null
    ]);
}

function updateOrderNotes($id, $notes) {
    global $db;
    $db->where('id', $id);
    return $db->update('orders', [
        'notes' => $notes,
        'updated_at' => date('Y-m-d H:i:s')
    ]);
}

function appendOrderNote($id, $note) {
    global $db;
    $current = $db->where('id', $id)->getValue('orders', 'notes');
    $current = $current ?: '';
    $timestamp = date('Y-m-d H:i:s');
    $newNotes = trim($current . "\n[$timestamp] " . $note);
    $db->where('id', $id);
    return $db->update('orders', [
        'notes' => $newNotes,
        'updated_at' => $timestamp
    ]);
}

function getOrderStatusCounts() {
    global $db;
    $sql = "SELECT
        SUM(CASE WHEN status='pending' THEN 1 ELSE 0 END) AS pending,
        SUM(CASE WHEN status='processing' THEN 1 ELSE 0 END) AS processing,
        SUM(CASE WHEN status='completed' THEN 1 ELSE 0 END) AS completed,
        SUM(CASE WHEN status='cancelled' THEN 1 ELSE 0 END) AS cancelled,
        SUM(CASE WHEN status='refunded' THEN 1 ELSE 0 END) AS refunded,
        SUM(CASE WHEN status IN ('pending','processing') AND created_at <= DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 1 ELSE 0 END) AS attention
        FROM orders";
    $row = $db->rawQueryOne($sql);
    return $row ?: [];
}

/**
 * Update order status by ID
 */
function updateOrderStatusById($id, $status) {
    global $db;
    $allowed = ['pending','processing','completed','cancelled','refunded'];
    if (!in_array($status, $allowed, true)) {
        return false;
    }
    $db->where('id', $id);
    return $db->update('orders', [
        'status' => $status,
        'updated_at' => date('Y-m-d H:i:s'),
        'completed_at' => $status === 'completed' ? date('Y-m-d H:i:s') : null
    ]);
}

/**
 * Order stats for dashboard
 */
function getOrderDashboardStats() {
    global $db;
    $today = date('Y-m-d');

    $stats = [
        'today_orders' => 0,
        'today_amount' => 0,
        'pending_orders' => 0,
        'processing_orders' => 0,
        'completed_orders' => 0
    ];

    $db->where('DATE(created_at)', $today);
    $stats['today_orders'] = (int)$db->getValue('orders', 'COUNT(*)');

    $db->where('DATE(created_at)', $today);
    $stats['today_amount'] = (float)$db->getValue('orders', 'SUM(price)');

    $db->where('status', 'pending');
    $stats['pending_orders'] = (int)$db->getValue('orders', 'COUNT(*)');

    $db->where('status', 'processing');
    $stats['processing_orders'] = (int)$db->getValue('orders', 'COUNT(*)');

    $db->where('status', 'completed');
    $stats['completed_orders'] = (int)$db->getValue('orders', 'COUNT(*)');

    return $stats;
}

/**
 * Get all FAQs
 */
function getAllFaqs() {
    global $db;
    return $db->orderBy('sort_order', 'ASC')->get('faqs');
}

/**
 * Get FAQ by ID
 */
function getFaqById($id) {
    global $db;
    return $db->where('id', $id)->getOne('faqs');
}

/**
 * Add FAQ
 */
function addFaq($question, $answer, $category = 'general', $sort_order = 0, $active = 1, $featured = 0) {
    global $db;
    $data = [
        'question' => $question,
        'answer' => $answer,
        'category' => $category,
        'sort_order' => $sort_order,
        'active' => $active,
        'featured' => $featured
    ];
    return $db->insert('faqs', $data);
}

/**
 * Update FAQ
 */
function updateFaq($id, $question, $answer, $category, $sort_order, $active, $featured) {
    global $db;
    $data = [
        'question' => $question,
        'answer' => $answer,
        'category' => $category,
        'sort_order' => $sort_order,
        'active' => $active,
        'featured' => $featured
    ];
    $db->where('id', $id);
    return $db->update('faqs', $data);
}

/**
 * Delete FAQ
 */
function deleteFaq($id) {
    global $db;
    $db->where('id', $id);
    return $db->delete('faqs');
}

/**
 * Get FAQ categories
 */
function getFaqCategories() {
    global $db;
    $result = $db->rawQuery("SELECT DISTINCT category FROM faqs WHERE category IS NOT NULL ORDER BY category");
    $categories = [];
    if ($result) {
        foreach ($result as $row) {
            $categories[] = $row['category'];
        }
    }
    return $categories;
}

/**
 * Get all testimonials
 */
function getAllTestimonials() {
    global $db;
    return $db->orderBy('featured', 'DESC')->orderBy('created_at', 'DESC')->get('testimonials');
}

/**
 * Get testimonial by ID
 */
function getTestimonialById($id) {
    global $db;
    return $db->where('id', $id)->getOne('testimonials');
}

/**
 * Add testimonial
 */
function addTestimonial($name, $content, $rating = 5, $email = null, $service_type = null, $title = null, $avatar_url = null, $active = 0, $featured = 0, $user_id = null) {
    global $db;
    $data = [
        'name' => $name,
        'content' => $content,
        'rating' => $rating,
        'email' => $email,
        'service_type' => $service_type,
        'title' => $title,
        'avatar_url' => $avatar_url,
        'active' => $active,
        'featured' => $featured,
        'user_id' => $user_id
    ];
    return $db->insert('testimonials', $data);
}

/**
 * Update testimonial
 */
function updateTestimonial($id, $name, $content, $rating, $email, $service_type, $title, $avatar_url, $active, $featured, $user_id = null) {
    global $db;
    $data = [
        'name' => $name,
        'content' => $content,
        'rating' => $rating,
        'email' => $email,
        'service_type' => $service_type,
        'title' => $title,
        'avatar_url' => $avatar_url,
        'active' => $active,
        'featured' => $featured,
        'user_id' => $user_id
    ];
    $db->where('id', $id);
    return $db->update('testimonials', $data);
}

/**
 * Delete testimonial
 */
function deleteTestimonial($id) {
    global $db;
    $db->where('id', $id);
    return $db->delete('testimonials');
}

/**
 * Get testimonial service types
 */
function getTestimonialServiceTypes() {
    global $db;
    $result = $db->rawQuery("SELECT DISTINCT service_type FROM testimonials WHERE service_type IS NOT NULL ORDER BY service_type");
    $types = [];
    if ($result) {
        foreach ($result as $row) {
            $types[] = $row['service_type'];
        }
    }
    return $types;
}

/**
 * Get dashboard stats
 */
function getDashboardStats() {
    global $db;
    
    return [
        'total_users' => $db->getValue('users', 'COUNT(*)'),
        'total_orders' => $db->getValue('orders', 'COUNT(*)'),
        'total_faqs' => $db->getValue('faqs', 'COUNT(*)'),
        'total_testimonials' => $db->getValue('testimonials', 'COUNT(*)'),
        'total_admins' => $db->getValue('admin_users', 'COUNT(*)'),
        'total_services' => $db->getValue('services', 'COUNT(*)')
    ];
}

/**
 * Get all admin users
 */
function getAllAdminUsers() {
    global $db;
    return $db->orderBy('created_at', 'DESC')->get('admin_users');
}

/**
 * Get admin user by ID
 */
function getAdminUserById($id) {
    global $db;
    return $db->where('id', $id)->getOne('admin_users');
}

/**
 * Create admin user
 */
function createAdminUser($username, $password, $name, $email, $role = 'admin') {
    global $db;

    // Enforce unique username/email
    $existing = $db->where('username', $username)->orWhere('email', $email)->getOne('admin_users');
    if ($existing) {
        return false;
    }
    
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    
    $data = [
        'username' => $username,
        'password' => $hashedPassword,
        'name' => $name,
        'email' => $email,
        'role' => $role,
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    return $db->insert('admin_users', $data);
}

/**
 * Update admin user
 */
function updateAdminUser($id, $name, $email, $role, $status) {
    global $db;

    // Prevent role changes if not super_admin will be enforced upstream
    // Enforce unique email on update
    $dupe = $db->where('email', $email)->where('id', $id, '!=')->getOne('admin_users');
    if ($dupe) {
        return false;
    }
    
    $data = [
        'name' => $name,
        'email' => $email,
        'role' => $role,
        'status' => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $db->where('id', $id);
    return $db->update('admin_users', $data);
}

/**
 * Update admin password
 */
function updateAdminPassword($id, $newPassword) {
    global $db;
    
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
    
    $data = [
        'password' => $hashedPassword,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $db->where('id', $id);
    return $db->update('admin_users', $data);
}

/**
 * Delete admin user
 */
function deleteAdminUser($id) {
    global $db;
    $db->where('id', $id);
    return $db->delete('admin_users');
}

/**
 * Check if admin table exists
 */
function adminTableExists() {
    global $db;
    
    $result = $db->rawQuery("SHOW TABLES LIKE 'si_admin_users'");
    return count($result) > 0;
}

// ============================================
// SERVICES FUNCTIONS
// ============================================

/**
 * Get all services (categories and services)
 */
function getAllServices() {
    global $db;
    return $db->orderBy('parent_id', 'ASC')->orderBy('display_order', 'ASC')->get('services');
}

function getServicesFiltered($filters = []) {
    global $db;
    if (!empty($filters['q'])) {
        $q = '%' . $filters['q'] . '%';
        $db->where('(name LIKE ? OR slug LIKE ? OR service_code LIKE ?)', [$q, $q, $q]);
    }
    if (isset($filters['is_active']) && $filters['is_active'] !== '') {
        $db->where('is_active', $filters['is_active'] ? 1 : 0);
    }
    if (!empty($filters['type']) && in_array($filters['type'], ['category','service'], true)) {
        if ($filters['type'] === 'category') {
            $db->where('parent_id', null, 'IS');
        } else {
            $db->where('parent_id', null, 'IS NOT');
        }
    }
    $db->orderBy('parent_id', 'ASC')->orderBy('display_order', 'ASC');
    return $db->get('services');
}

/**
 * Get only categories (parent_id IS NULL)
 */
function getServiceCategories() {
    global $db;
    return $db->where('parent_id', NULL, 'IS')->orderBy('display_order', 'ASC')->get('services');
}

/**
 * Get services by category
 */
function getServicesByCategory($categoryId) {
    global $db;
    return $db->where('parent_id', $categoryId)->orderBy('display_order', 'ASC')->get('services');
}

/**
 * Get service by ID
 */
function getServiceById($id) {
    global $db;
    return $db->where('id', $id)->getOne('services');
}

/**
 * Add service
 */
function addService($data) {
    global $db;
    return $db->insert('services', $data);
}

/**
 * Update service
 */
function updateService($id, $data) {
    global $db;
    $db->where('id', $id);
    return $db->update('services', $data);
}

// Inline (partial) update for service status/order/flags
function updateServiceInline($id, $data) {
    global $db;
    $allowed = ['display_order', 'is_active', 'is_featured'];
    $payload = [];
    foreach ($allowed as $key) {
        if (array_key_exists($key, $data)) {
            $payload[$key] = $data[$key];
        }
    }
    if (empty($payload)) {
        return false;
    }
    $payload['updated_at'] = date('Y-m-d H:i:s');
    $db->where('id', $id);
    return $db->update('services', $payload);
}

/**
 * Delete service
 */
function deleteService($id) {
    global $db;
    $db->where('id', $id);
    return $db->delete('services');
}

/**
 * Check if service has children
 */
function serviceHasChildren($id) {
    global $db;
    $count = $db->where('parent_id', $id)->getValue('services', 'COUNT(*)');
    return $count > 0;
}

/**
 * Get services with parent_id NOT NULL (actual services, not categories)
 */
function getActualServices() {
    global $db;
    return $db->where('parent_id', NULL, 'IS NOT')->orderBy('display_order', 'ASC')->get('services');
}

// ============================================
// SERVICE TAGS FUNCTIONS
// ============================================

/**
 * Get all service tags
 */
function getAllServiceTags() {
    global $db;
    return $db->orderBy('service_id', 'ASC')->orderBy('display_order', 'ASC')->get('service_tags');
}

/**
 * Get tags by service
 */
function getTagsByService($serviceId) {
    global $db;
    return $db->where('service_id', $serviceId)->orderBy('display_order', 'ASC')->get('service_tags');
}

/**
 * Get service tag by ID
 */
function getServiceTagById($id) {
    global $db;
    return $db->where('id', $id)->getOne('service_tags');
}

/**
 * Add service tag
 */
function addServiceTag($data) {
    global $db;
    return $db->insert('service_tags', $data);
}

/**
 * Update service tag
 */
function updateServiceTag($id, $data) {
    global $db;
    $db->where('id', $id);
    return $db->update('service_tags', $data);
}

/**
 * Delete service tag
 */
function deleteServiceTag($id) {
    global $db;
    $db->where('id', $id);
    return $db->delete('service_tags');
}

// ============================================
// SERVICE PACKAGES FUNCTIONS
// ============================================

/**
 * Get all service packages
 */
function getAllServicePackages() {
    global $db;
    return $db->orderBy('service_id', 'ASC')->orderBy('display_order', 'ASC')->get('service_packages');
}

function getPackagesFiltered($filters = []) {
    global $db;

    if (!empty($filters['q'])) {
        $q = '%' . $filters['q'] . '%';
        $db->where('(package_code LIKE ? OR discount_label LIKE ?)', [$q, $q]);
    }

    if (!empty($filters['service_id']) && is_numeric($filters['service_id'])) {
        $db->where('service_id', (int)$filters['service_id']);
    }

    if (!empty($filters['tag_id']) && is_numeric($filters['tag_id'])) {
        $db->where('tag_id', (int)$filters['tag_id']);
    }

    if (isset($filters['is_active']) && $filters['is_active'] !== '') {
        $db->where('is_active', $filters['is_active'] ? 1 : 0);
    }

    if (isset($filters['is_popular']) && $filters['is_popular'] !== '') {
        $db->where('is_popular', $filters['is_popular'] ? 1 : 0);
    }

    $db->orderBy('service_id', 'ASC')->orderBy('display_order', 'ASC');
    return $db->get('service_packages');
}

/**
 * Get packages by service
 */
function getPackagesByService($serviceId) {
    global $db;
    return $db->where('service_id', $serviceId)->orderBy('display_order', 'ASC')->get('service_packages');
}

/**
 * Get service package by ID
 */
function getServicePackageById($id) {
    global $db;
    return $db->where('id', $id)->getOne('service_packages');
}

/**
 * Add service package
 */
function addServicePackage($data) {
    global $db;
    return $db->insert('service_packages', $data);
}

/**
 * Update service package
 */
function updateServicePackage($id, $data) {
    global $db;
    $db->where('id', $id);
    return $db->update('service_packages', $data);
}

// Inline (partial) update for package flags/order
function updateServicePackageInline($id, $data) {
    global $db;
    $allowed = ['display_order', 'is_active', 'is_popular'];
    $payload = [];
    foreach ($allowed as $key) {
        if (array_key_exists($key, $data)) {
            $payload[$key] = $data[$key];
        }
    }
    if (empty($payload)) {
        return false;
    }
    $payload['updated_at'] = date('Y-m-d H:i:s');
    $db->where('id', $id);
    return $db->update('service_packages', $payload);
}

/**
 * Delete service package
 */
function deleteServicePackage($id) {
    global $db;
    $db->where('id', $id);
    return $db->delete('service_packages');
}
