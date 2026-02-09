<?php
/**
 * User Dashboard
 * Main dashboard with profile and orders
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: " . ($_SERVER['REQUEST_URI'] ?? '/sgi/login'));
    exit;
}

// Include required files (updated paths for modules folder)
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Config.php';

try {
    $db = Database::getConnection();
    
    // Get user information
    $userId = $_SESSION['user_id'];
    $user = $db->where('id', $userId)->getOne('users', 'id, username, email, role, status, created_at, last_login');
    
    if (!$user) {
        // User not found, logout
        session_destroy();
        header("Location: " . Config::baseUrl('login'));
        exit;
    }
    
    // Get user orders
    $orders = $db->where('user_id', $userId)
                 ->orderBy('created_at', 'DESC')
                 ->get('orders');
    
} catch (Exception $e) {
    error_log("Dashboard error: " . $e->getMessage());
    $error = 'An error occurred loading your dashboard.';
}

// Get active section from URL
$section = isset($_GET['section']) ? $_GET['section'] : 'profile';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo Config::siteName(); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-logo {
            font-size: 1.75rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .sidebar-user {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 0.5rem;
        }
        
        .sidebar-menu {
            padding: 2rem 0;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            padding: 1rem 2rem;
            color: white;
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
            border-left: 4px solid transparent;
        }
        
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }
        
        .menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: white;
            font-weight: 600;
        }
        
        .menu-item-icon {
            font-size: 1.25rem;
            margin-right: 1rem;
        }
        
        .menu-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 1rem 2rem;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
        }
        
        .content-header {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .content-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        
        .content-subtitle {
            color: #64748b;
            font-size: 1rem;
        }
        
        .content-body {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        /* Profile Section */
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .profile-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
        }
        
        .profile-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }
        
        .profile-value {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            word-break: break-all;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .status-active {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }
        
        /* Orders Section */
        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .orders-count {
            font-size: 0.9rem;
            color: #64748b;
        }
        
        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .orders-table th {
            background: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.875rem;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .orders-table td {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }
        
        .orders-table tr:hover {
            background: #f8fafc;
        }
        
        .order-number {
            font-weight: 600;
            color: #667eea;
        }
        
        .order-status {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-processing {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        
        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .empty-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.5rem;
        }
        
        .empty-text {
            color: #64748b;
            margin-bottom: 2rem;
        }
        
        .btn-primary {
            display: inline-block;
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: transform 0.2s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
        }
        
        /* Mobile Responsive */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1.25rem;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .content-title {
                font-size: 1.5rem;
            }
            
            .orders-table {
                font-size: 0.875rem;
            }
            
            .orders-table th,
            .orders-table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
    
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="<?php echo Config::baseUrl(); ?>" class="sidebar-logo"><?php echo Config::siteName(); ?></a>
                <div class="sidebar-user">
                    Welcome back,<br>
                    <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                </div>
            </div>
            
            <nav class="sidebar-menu">
                <a href="?section=profile" class="menu-item <?php echo $section === 'profile' ? 'active' : ''; ?>">
                    <span class="menu-item-icon">👤</span>
                    <span>Profile</span>
                </a>
                
                <a href="?section=orders" class="menu-item <?php echo $section === 'orders' ? 'active' : ''; ?>">
                    <span class="menu-item-icon">📦</span>
                    <span>My Orders</span>
                </a>
                
                <div class="menu-divider"></div>
                
                <a href="<?php echo Config::baseUrl(); ?>" class="menu-item">
                    <span class="menu-item-icon">🏠</span>
                    <span>Home</span>
                </a>
                
                <a href="<?php echo Config::baseUrl('logout'); ?>" class="menu-item">
                    <span class="menu-item-icon">🚪</span>
                    <span>Logout</span>
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <?php if ($section === 'profile'): ?>
                <!-- Profile Section -->
                <div class="content-header">
                    <h1 class="content-title">Profile</h1>
                    <p class="content-subtitle">Your account information</p>
                </div>
                
                <div class="content-body">
                    <div class="profile-grid">
                        <div class="profile-card">
                            <div class="profile-label">User ID</div>
                            <div class="profile-value">#<?php echo $user['id']; ?></div>
                        </div>
                        
                        <div class="profile-card">
                            <div class="profile-label">Username</div>
                            <div class="profile-value"><?php echo htmlspecialchars($user['username']); ?></div>
                        </div>
                        
                        <div class="profile-card">
                            <div class="profile-label">Email Address</div>
                            <div class="profile-value"><?php echo htmlspecialchars($user['email']); ?></div>
                        </div>
                        
                        <div class="profile-card">
                            <div class="profile-label">Account Type</div>
                            <div class="profile-value" style="text-transform: capitalize;"><?php echo htmlspecialchars($user['role']); ?></div>
                        </div>
                        
                        <div class="profile-card">
                            <div class="profile-label">Account Status</div>
                            <div class="profile-value">
                                <span class="status-badge <?php echo $user['status'] === 'active' ? 'status-active' : 'status-inactive'; ?>">
                                    <?php echo ucfirst($user['status']); ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="profile-card">
                            <div class="profile-label">Member Since</div>
                            <div class="profile-value"><?php echo date('F j, Y', strtotime($user['created_at'])); ?></div>
                        </div>
                        
                        <?php if ($user['last_login']): ?>
                        <div class="profile-card">
                            <div class="profile-label">Last Login</div>
                            <div class="profile-value"><?php echo date('F j, Y g:i A', strtotime($user['last_login'])); ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="profile-card">
                            <div class="profile-label">Total Orders</div>
                            <div class="profile-value"><?php echo count($orders); ?></div>
                        </div>
                    </div>
                </div>
                
            <?php elseif ($section === 'orders'): ?>
                <!-- Orders Section -->
                <div class="content-header">
                    <h1 class="content-title">My Orders</h1>
                    <p class="content-subtitle">View and track all your orders</p>
                </div>
                
                <div class="content-body">
                    <?php if (empty($orders)): ?>
                        <!-- Empty State -->
                        <div class="empty-state">
                            <div class="empty-icon">📦</div>
                            <h2 class="empty-title">No Orders Yet</h2>
                            <p class="empty-text">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                            <a href="<?php echo Config::baseUrl(); ?>" class="btn-primary">Browse Services</a>
                        </div>
                    <?php else: ?>
                        <!-- Orders Table -->
                        <div class="orders-header">
                            <h3>All Orders</h3>
                            <span class="orders-count"><?php echo count($orders); ?> order(s) found</span>
                        </div>
                        
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Service</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>
                                        <span class="order-number"><?php echo htmlspecialchars($order['order_number']); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($order['service_name']); ?></td>
                                    <td><?php echo number_format($order['quantity']); ?></td>
                                    <td>$<?php echo number_format($order['price'], 2); ?></td>
                                    <td>
                                        <span class="order-status status-<?php echo strtolower($order['status']); ?>">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M j, Y', strtotime($order['created_at'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
    
    <script>
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
    </script>
</body>
</html>
