<?php
/**
 * Example Usage File
 * 
 * This file demonstrates how to integrate the database functionality
 * into your existing Famoid website code
 */

// Include the database connection
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Order.php';

// Example: User Registration
function registerUser($name, $email, $password) {
    try {
        $user = new User();
        
        // Check if email already exists
        if ($user->emailExists($email)) {
            return ['success' => false, 'message' => 'Email already exists'];
        }
        
        // Create new user
        $userId = $user->create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
        
        if ($userId) {
            return ['success' => true, 'user_id' => $userId];
        } else {
            return ['success' => false, 'message' => 'Registration failed'];
        }
        
    } catch (Exception $e) {
        error_log("Registration error: " . $e->getMessage());
        return ['success' => false, 'message' => 'An error occurred'];
    }
}

// Example: User Login
function loginUser($email, $password) {
    try {
        $user = new User();
        $userData = $user->authenticate($email, $password);
        
        if ($userData) {
            // Start session and store user data
            session_start();
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['user_name'] = $userData['name'];
            $_SESSION['user_email'] = $userData['email'];
            
            // Update last login
            $user->updateLastLogin($userData['id']);
            
            return ['success' => true, 'user' => $userData];
        } else {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }
        
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Login failed'];
    }
}

// Example: Create Order
function createOrder($userId, $serviceType, $quantity, $price, $targetUrl) {
    try {
        $order = new Order();
        
        $orderId = $order->create([
            'user_id' => $userId,
            'service_type' => $serviceType,
            'quantity' => $quantity,
            'price' => $price,
            'target_url' => $targetUrl
        ]);
        
        if ($orderId) {
            // Get the created order with order number
            $orderData = $order->findById($orderId);
            return ['success' => true, 'order' => $orderData];
        } else {
            return ['success' => false, 'message' => 'Order creation failed'];
        }
        
    } catch (Exception $e) {
        error_log("Order creation error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Order creation failed'];
    }
}

// Example: Get User Dashboard Data
function getUserDashboard($userId) {
    try {
        $user = new User();
        $order = new Order();
        
        // Get user info
        $userData = $user->findById($userId);
        
        // Get user orders
        $userOrders = $order->getUserOrders($userId, 10);
        
        // Calculate user stats
        $userStats = [
            'total_orders' => count($order->getUserOrders($userId)),
            'pending_orders' => count($order->getUserOrders($userId)),
            'completed_orders' => 0
        ];
        
        // Count completed orders
        foreach ($order->getUserOrders($userId) as $orderData) {
            if ($orderData['status'] === Order::STATUS_COMPLETED) {
                $userStats['completed_orders']++;
            }
        }
        
        return [
            'success' => true,
            'user' => $userData,
            'orders' => $userOrders,
            'stats' => $userStats
        ];
        
    } catch (Exception $e) {
        error_log("Dashboard error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to load dashboard'];
    }
}

// Example: Process Order Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    switch ($_POST['action']) {
        case 'register':
            $result = registerUser($_POST['name'], $_POST['email'], $_POST['password']);
            echo json_encode($result);
            break;
            
        case 'login':
            $result = loginUser($_POST['email'], $_POST['password']);
            echo json_encode($result);
            break;
            
        case 'create_order':
            session_start();
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['success' => false, 'message' => 'Please login first']);
                break;
            }
            
            $result = createOrder(
                $_SESSION['user_id'],
                $_POST['service_type'],
                (int)$_POST['quantity'],
                (float)$_POST['price'],
                $_POST['target_url']
            );
            echo json_encode($result);
            break;
    }
    exit;
}

// Example: Integration with existing header.php
function getLoggedInUser() {
    session_start();
    if (isset($_SESSION['user_id'])) {
        $user = new User();
        return $user->findById($_SESSION['user_id']);
    }
    return null;
}

// Example: Get site statistics for admin dashboard
function getAdminStats() {
    try {
        $user = new User();
        $order = new Order();
        
        $userStats = $user->getStats();
        $orderStats = $order->getStats();
        
        return [
            'success' => true,
            'users' => $userStats,
            'orders' => $orderStats
        ];
        
    } catch (Exception $e) {
        error_log("Admin stats error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to load statistics'];
    }
}

// Example: Search functionality
function searchOrders($query) {
    try {
        $order = new Order();
        $results = $order->search($query);
        
        return ['success' => true, 'results' => $results];
        
    } catch (Exception $e) {
        error_log("Search error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Search failed'];
    }
}

// Example: Update order status (for admin)
function updateOrderStatus($orderId, $status) {
    try {
        $order = new Order();
        $success = $order->updateStatus($orderId, $status);
        
        if ($success) {
            return ['success' => true, 'message' => 'Order status updated'];
        } else {
            return ['success' => false, 'message' => 'Update failed'];
        }
        
    } catch (Exception $e) {
        error_log("Status update error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Update failed'];
    }
}

// Example: Get popular services
function getPopularServices() {
    try {
        $db = Database::getConnection();
        
        $query = "
            SELECT service_type, COUNT(*) as order_count, SUM(quantity) as total_quantity
            FROM si_orders 
            WHERE status IN ('completed', 'processing')
            AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY service_type
            ORDER BY order_count DESC
            LIMIT 5
        ";
        
        $results = Database::query($query);
        return ['success' => true, 'services' => $results];
        
    } catch (Exception $e) {
        error_log("Popular services error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to load services'];
    }
}

/* 
INTEGRATION EXAMPLES FOR EXISTING FILES:

1. In header.php, add this at the top:
   <?php
   require_once __DIR__ . '/example_usage.php';
   $loggedInUser = getLoggedInUser();
   ?>
   
   Then in the navigation, you can show user info:
   <?php if ($loggedInUser): ?>
       <span>Welcome, <?php echo htmlspecialchars($loggedInUser['name']); ?>!</span>
   <?php else: ?>
       <a href="login.php">Login</a>
   <?php endif; ?>

2. In index.php, add real testimonials from database:
   <?php
   $testimonials = Database::query("SELECT * FROM si_testimonials WHERE active = 1 ORDER BY created_at DESC LIMIT 10");
   ?>

3. Create an order processing page:
   <?php
   if ($_POST['service'] && $_POST['quantity']) {
       $result = createOrder($_SESSION['user_id'], $_POST['service'], $_POST['quantity'], $_POST['price'], $_POST['url']);
       if ($result['success']) {
           header("Location: order-confirmation.php?order=" . $result['order']['order_number']);
       }
   }
   ?>

4. Add analytics to footer:
   <?php
   $stats = getAdminStats();
   echo "Served " . number_format($stats['orders']['total']) . " orders to " . number_format($stats['users']['total']) . " customers";
   ?>
*/
?>
