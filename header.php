<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Famoid: Buy Instagram Followers, Likes & Views | #1 Agency'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/sgi/css/style.css">
    <link rel="stylesheet" href="/sgi/css/service-pages.css">
    <link rel="stylesheet" href="/sgi/css/mega-menu.css">
</head>
<body>
    <?php // error_reporting(E_ALL);ini_set('display_errors', 1);
    
    // Include database connection and models
    require_once __DIR__ . '/includes/Database.php';
    require_once __DIR__ . '/includes/testimonial_integration.php';
    require_once __DIR__ . '/includes/service_integration.php';
    require_once __DIR__ . '/includes/faq_integration.php';
    require_once __DIR__ . '/includes/mega_menu_integration.php';
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
            <a href="/sgi/" class="logo">Famoid</a>
            <ul class="nav-links">
                <!-- Dynamic Services Mega Menu -->
                <li class="mega-menu-container">
                    <a href="#" class="mega-menu-trigger" id="servicesMenuTrigger">
                        Services
                    </a>
                    <?php echo generateMegaMenuHTML(); ?>
                </li>
                <!-- li><a href="/sgi/frequently-asked-questions">FAQ</a></li -->
                <li><a href="/sgi/blog">Blog</a></li>
                <li><a href="/sgi/contact">Contact</a></li>
                <?php if ($loggedInUser): ?>
                    <li><a href="/sgi/dashboard">Dashboard</a></li>
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
                            <a href="/sgi/dashboard">📊 Dashboard</a>
                            <a href="/sgi/orders">📦 My Orders</a>
                            <a href="/sgi/profile">👤 Profile</a>
                            <a href="/sgi/settings">⚙️ Settings</a>
                            <div class="menu-divider"></div>
                            <a href="/sgi/logout">🚪 Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Guest user menu -->
                    <div class="account-dropdown">
                        <button class="btn btn-outline account-btn">My Account ▾</button>
                        <div class="account-menu">
                            <a href="/sgi/login">🔐 Login</a>
                            <a href="/sgi/register">📝 Register</a>
                            <a href="/sgi/track-order">📦 Track Order</a>
                            <div class="menu-divider"></div>
                            <a href="/sgi/help">❓ Help Center</a>
                            <a href="/sgi/contact">💬 Contact Support</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <!-- Mega Menu Overlay -->
    <div class="mega-menu-overlay" id="megaMenuOverlay"></div>
    
    <?php if ($loggedInUser): ?>
        <!-- User notification bar (optional) -->
        <div id="user-notifications" style="display: none; background: linear-gradient(135deg, #7c3aed, #ec4899); color: white; text-align: center; padding: 0.5rem; font-size: 0.9rem;">
            <!-- Notifications will be loaded here via JavaScript -->
        </div>
    <?php endif; ?>
    
    <script>
        // Mega Menu JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('servicesMenuTrigger');
            const dropdown = document.querySelector('.mega-menu-dropdown');
            const overlay = document.getElementById('megaMenuOverlay');
            
            if (trigger && dropdown) {
                // Toggle menu on click
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const isOpen = dropdown.classList.contains('show');
                    
                    if (isOpen) {
                        closeMenu();
                    } else {
                        openMenu();
                    }
                });
                
                // Close menu when clicking overlay
                if (overlay) {
                    overlay.addEventListener('click', closeMenu);
                }
                
                // Close menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (!trigger.contains(e.target) && !dropdown.contains(e.target)) {
                        closeMenu();
                    }
                });
                
                // Prevent menu from closing when clicking inside
                dropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
            
            function openMenu() {
                dropdown.classList.add('show');
                trigger.classList.add('active');
                if (overlay) overlay.classList.add('show');
            }
            
            function closeMenu() {
                dropdown.classList.remove('show');
                trigger.classList.remove('active');
                if (overlay) overlay.classList.remove('show');
            }
            
            // Close menu on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeMenu();
                }
            });
        });
        
        // User-specific JavaScript
        <?php if ($loggedInUser): ?>
        // User is logged in - add user-specific JS
        const currentUser = {
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
            alert('Welcome to Famoid, <?php echo htmlspecialchars($loggedInUser['name']); ?>! Your account has been created successfully.');
        }, 1000);
        <?php unset($_SESSION['just_registered']); ?>
        <?php endif; ?>
        
        <?php else: ?>
        // Guest user - encourage registration
        const currentUser = null;
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
