<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Genuine Socials: Buy Instagram Followers, Likes & Views | #1 Agency'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    // Include database connection and models
    require_once __DIR__ . '/includes/Database.php';
    require_once __DIR__ . '/models/User.php';
    
    // Check if user is logged in
    session_start();
    $loggedInUser = null;
    if (isset($_SESSION['user_id'])) {
        try {
            $userModel = new User();
            $loggedInUser = $userModel->findById($_SESSION['user_id']);
        } catch (Exception $e) {
            // Handle error silently or log it
            error_log("Error loading user: " . $e->getMessage());
        }
    }
    ?>
    
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="index.php" class="logo">Genuine Socials</a>
            <ul class="nav-links">
                <li><a href="index.php#services">Services</a></li>
                <li><a href="index.php#faq">FAQ</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if ($loggedInUser): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                <?php endif; ?>
            </ul>
            <div class="nav-right">
                <div class="lang-dropdown">
                    <div class="lang-select">🇺🇸 EN ▾</div>
                    <div class="lang-menu">
                        <a href="?lang=en" class="active">🇺🇸 English</a>
                        <a href="?lang=de">🇩🇪 Deutsch</a>
                        <a href="?lang=fr">🇫🇷 Français</a>
                        <a href="?lang=es">🇪🇸 Español</a>
                        <a href="?lang=ar">🇦🇪 Arabic</a>
                        <a href="?lang=pt">🇧🇷 Português (BR)</a>
                    </div>
                </div>
                
                <?php if ($loggedInUser): ?>
                    <!-- Logged in user menu -->
                    <div class="account-dropdown">
                        <button class="btn btn-outline account-btn">
                            <?php echo htmlspecialchars($loggedInUser['name']); ?> ▾
                        </button>
                        <div class="account-menu">
                            <a href="dashboard.php">📊 Dashboard</a>
                            <a href="orders.php">📦 My Orders</a>
                            <a href="profile.php">👤 Profile</a>
                            <a href="settings.php">⚙️ Settings</a>
                            <div class="menu-divider"></div>
                            <a href="logout.php">🚪 Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Guest user menu -->
                    <div class="account-dropdown">
                        <button class="btn btn-outline account-btn">My Account ▾</button>
                        <div class="account-menu">
                            <a href="login.php">🔐 Login</a>
                            <a href="register.php">📝 Register</a>
                            <a href="track-order.php">📦 Track Order</a>
                            <div class="menu-divider"></div>
                            <a href="help.php">❓ Help Center</a>
                            <a href="contact.php">💬 Contact Support</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <?php if ($loggedInUser): ?>
        <!-- User notification bar (optional) -->
        <div id="user-notifications" style="display: none; background: linear-gradient(135deg, #7c3aed, #ec4899); color: white; text-align: center; padding: 0.5rem; font-size: 0.9rem;">
            <!-- Notifications will be loaded here via JavaScript -->
        </div>
    <?php endif; ?>
    
    <script>
        // Add some JavaScript for user-specific functionality
        // Shared user context
        let currentUser = null;

        <?php if ($loggedInUser): ?>
        // User is logged in - add user-specific JS
        currentUser = {
            id: <?php echo $loggedInUser['id']; ?>,
            name: '<?php echo htmlspecialchars($loggedInUser['name'], ENT_QUOTES); ?>',
            email: '<?php echo htmlspecialchars($loggedInUser['email'], ENT_QUOTES); ?>'
        };
        
        // Example: Auto-save form data for logged-in users
        document.addEventListener('DOMContentLoaded', function() {
            const orderForms = document.querySelectorAll('form[data-order-form]');
            orderForms.forEach(form => {
                // Auto-fill user email if email field exists
                const emailField = form.querySelector('input[name="email"]');
                if (emailField && !emailField.value) {
                    emailField.value = currentUser.email;
                }
            });
        });
        
        // Example: Show welcome message for new users
        <?php if (isset($_SESSION['just_registered'])): ?>
        setTimeout(() => {
            alert('Welcome to Genuine Socials, <?php echo htmlspecialchars($loggedInUser['name']); ?>! Your account has been created successfully.');
        }, 1000);
        <?php unset($_SESSION['just_registered']); ?>
        <?php endif; ?>
        
        <?php else: ?>
        // Guest user - encourage registration (currentUser remains null)
        <?php endif; ?>
        
        // Enhanced order form handling for logged-in users
        function submitOrderForm(formData, serviceType) {
            <?php if ($loggedInUser): ?>
            // User is logged in - process order directly
            formData.append('user_id', currentUser.id);
            formData.append('action', 'create_order');
            
            fetch('process_order.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'order-confirmation.php?order=' + data.order.order_number;
                } else {
                    alert('Order failed: ' + data.message);
                }
            });
            <?php else: ?>
            // Guest user - redirect to login/register
            sessionStorage.setItem('pending_order', JSON.stringify({
                service_type: serviceType,
                form_data: Object.fromEntries(formData)
            }));
            window.location.href = 'login.php?redirect=order';
            <?php endif; ?>
        }
    </script>
