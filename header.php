<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    // Include Config for dynamic site name
    require_once __DIR__ . '/includes/Config.php';
    $siteName = Config::siteName();
    $baseUrl = Config::baseUrl();
    ?>
    <title><?php echo isset($page_title) ? $page_title : $siteName . ': Buy Instagram Followers, Likes & Views | #1 Agency'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/service-pages.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/mega-menu.css">
    
    <!-- Google Translate -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,de,fr,es,ar,pt,it,nl,tr,pl,ru,ja,ko,zh-CN,hi',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            }, 'google_translate_element');
        }
    </script>
    

<script type="text/javascript"
  src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
</script>
    <style>
        /* Hide Google Translate banner */
        .goog-te-banner-frame.skiptranslate {
            display: none !important;
        }
        body {
            top: 0 !important;
        }
        #google_translate_element {
            position: absolute;
            left: -9999px;
            visibility: hidden;
        }
        .skiptranslate iframe {
            visibility: hidden !important;
        }
        
        /* Language dropdown active state */
        .lang-dropdown.active .lang-menu {
            display: block;
        }
    </style>
</head>
<body>
    <?php // error_reporting(E_ALL);ini_set('display_errors', 1);
    
    // Include database connection and models
    require_once __DIR__ . '/includes/Database.php';
    require_once __DIR__ . '/includes/testimonial_integration.php';
    require_once __DIR__ . '/includes/service_integration.php';
    require_once __DIR__ . '/includes/faq_integration.php';
    require_once __DIR__ . '/includes/mega_menu_integration.php';
    require_once __DIR__ . '/includes/homepage_service_integration.php';
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
            <a href="<?php echo $baseUrl; ?>/" class="logo"><?php echo $siteName; ?></a>
            <div class="nav-right">
            <ul class="nav-links">
                <!-- Dynamic Services Mega Menu -->
                <li class="mega-menu-container">
                    <a href="#" class="mega-menu-trigger" id="servicesMenuTrigger">
                        Services
                    </a>
                    <?php error_reporting(E_ALL);ini_set('display_errors', 1);
                    echo generateMegaMenuHTML(); ?>
                </li>
                <!-- li><a href="<?php echo $baseUrl; ?>/frequently-asked-questions">FAQ</a></li -->
                <li><a href="<?php echo $baseUrl; ?>/blog">Blog</a></li>
                <li><a href="<?php echo $baseUrl; ?>/contact">Contact</a></li>
                <?php if ($loggedInUser): ?>
                    <li><a href="<?php echo $baseUrl; ?>/dashboard">Dashboard</a></li>
                <?php endif; ?>
            </ul>
            
                <div class="lang-dropdown">
                    <div class="lang-select">🇺🇸 EN ▾</div>
                    <div class="lang-menu">
                        <a href="#" data-lang="en" class="active">🇺🇸 English</a>
                        <a href="#" data-lang="de">🇩🇪 Deutsch</a>
                        <a href="#" data-lang="fr">🇫🇷 Français</a>
                        <a href="#" data-lang="es">🇪🇸 Español</a>
                        <a href="#" data-lang="ar">🇦🇪 Arabic</a>
                        <a href="#" data-lang="pt">🇧🇷 Português (BR)</a>
                        <a href="#" data-lang="it">🇮🇹 Italiano</a>
                        <a href="#" data-lang="nl">🇳🇱 Nederlands</a>
                        <a href="#" data-lang="tr">🇹🇷 Türkçe</a>
                        <a href="#" data-lang="ru">🇷🇺 Русский</a>
                    </div>
                </div>
                
                <?php if ($loggedInUser): ?>
                    <!-- Logged in user menu -->
                    <div class="account-dropdown">
                        <button class="btn btn-outline account-btn">
                            Welcome ▾
                        </button>
                        <div class="account-menu">
                            <a href="<?php echo $baseUrl; ?>/dashboard">📊 Dashboard</a>
                            <a href="<?php echo $baseUrl; ?>/dashboard?section=orders">📦 My Orders</a>
                            <a href="<?php echo $baseUrl; ?>/dashboard?section=profile">👤 Profile</a>
                            <div class="menu-divider"></div>
                            <a href="<?php echo $baseUrl; ?>/logout">🚪 Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Guest user menu -->
                    <div class="account-dropdown">
                        <button class="btn btn-outline account-btn">My Account ▾</button>
                        <div class="account-menu">
                            <a href="<?php echo $baseUrl; ?>/login">🔐 Login</a>
                            <a href="<?php echo $baseUrl; ?>/register">📝 Register</a>
                            <div class="menu-divider"></div>
                            <a href="<?php echo $baseUrl; ?>/contact">💬 Contact Support</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div id="google_translate_element"></div>
<script> 
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'en'
  }, 'google_translate_element');
}
</script>
<script src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> 
    
    <!-- Hidden Google Translate Element -->
    
    <!-- Mega Menu Overlay -->
    <div class="mega-menu-overlay" id="megaMenuOverlay"></div>
    
    <?php if ($loggedInUser): ?>
        <!-- User notification bar (optional) -->
        <div id="user-notifications" style="display: none; background: linear-gradient(135deg, #7c3aed, #ec4899); color: white; text-align: center; padding: 0.5rem; font-size: 0.9rem;">
            <!-- Notifications will be loaded here via JavaScript -->
        </div>
    <?php endif; ?>
    
    <script>
        // Pass site name to JavaScript
        const SITE_NAME = '<?php echo addslashes($siteName); ?>';
        const BASE_URL = '<?php echo addslashes($baseUrl); ?>';
        
        // Mega Menu JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.getElementById('servicesMenuTrigger');
            const dropdown = document.querySelector('.mega-menu-dropdown');
            const overlay = document.getElementById('megaMenuOverlay');
            const container = trigger ? trigger.closest('.mega-menu-container') : null;
            let hoverTimeout = null;
            
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

                // Open on hover for desktop
                if (container) {
                    container.addEventListener('mouseenter', function() {
                        if (hoverTimeout) {
                            clearTimeout(hoverTimeout);
                            hoverTimeout = null;
                        }
                        openMenu();
                    });

                    container.addEventListener('mouseleave', function() {
                        if (hoverTimeout) {
                            clearTimeout(hoverTimeout);
                        }
                        hoverTimeout = setTimeout(closeMenu, 120);
                    });
                }
                
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
            alert('Welcome to ' + SITE_NAME + ', <?php echo htmlspecialchars($loggedInUser['name']); ?>! Your account has been created successfully.');
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
        
        // ===== GOOGLE TRANSLATE LANGUAGE SWITCHING =====
        
        // Language configuration
        const languages = {
            'en': { name: 'English', flag: '🇺🇸', code: 'en' },
            'de': { name: 'Deutsch', flag: '🇩🇪', code: 'de' },
            'fr': { name: 'Français', flag: '🇫🇷', code: 'fr' },
            'es': { name: 'Español', flag: '🇪🇸', code: 'es' },
            'ar': { name: 'Arabic', flag: '🇦🇪', code: 'ar' },
            'pt': { name: 'Português (BR)', flag: '🇧🇷', code: 'pt' },
            'it': { name: 'Italiano', flag: '🇮🇹', code: 'it' },
            'nl': { name: 'Nederlands', flag: '🇳🇱', code: 'nl' },
            'tr': { name: 'Türkçe', flag: '🇹🇷', code: 'tr' },
            'ru': { name: 'Русский', flag: '🇷🇺', code: 'ru' }
        };

        // Change language function
        function waitForTranslateAndSet(langCode) {
            let attempts = 0;
            const maxAttempts = 30;

            const check = setInterval(function() {
                attempts++;
                const selectElement = document.querySelector('.goog-te-combo');
                if (selectElement) {
                    clearInterval(check);
                    selectElement.value = langCode;
                    selectElement.dispatchEvent(new Event('change'));
                } else if (attempts >= maxAttempts) {
                    clearInterval(check);
                }
            }, 100);
        }

        function changeLanguage(langCode) {
            // Save preference
            localStorage.setItem('selectedLanguage', langCode);
            
            // Update display
            updateLanguageDisplay(langCode);
            
            // Trigger Google Translate
            const selectElement = document.querySelector('.goog-te-combo');
            if (selectElement) {
                selectElement.value = langCode;
                selectElement.dispatchEvent(new Event('change'));
            } else {
                waitForTranslateAndSet(langCode);
            }
            
            // Close dropdown
            const dropdown = document.querySelector('.lang-dropdown');
            if (dropdown) {
                dropdown.classList.remove('active');
            }
        }

        // Update language display in header
        function updateLanguageDisplay(langCode) {
            const lang = languages[langCode] || languages['en'];
            const langSelect = document.querySelector('.lang-select');
            
            if (langSelect) {
                langSelect.innerHTML = lang.flag + ' ' + langCode.toUpperCase() + ' ▾';
            }
            
            // Update active state in dropdown
            document.querySelectorAll('.lang-menu a').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('data-lang') === langCode) {
                    link.classList.add('active');
                }
            });
        }

        // Initialize language system when page loads
        window.addEventListener('load', function() {
            // Get saved language or default to English
            const savedLang = localStorage.getItem('selectedLanguage') || 'en';
            
            // Update display immediately
            updateLanguageDisplay(savedLang);
            
            // Wait for Google Translate to load, then set language
            if (savedLang !== 'en') {
                waitForTranslateAndSet(savedLang);
            }
            
            // Setup language dropdown click handlers
            document.querySelectorAll('.lang-menu a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const langCode = this.getAttribute('data-lang');
                    changeLanguage(langCode);
                });
            });
            
            // Toggle language dropdown
            const langSelect = document.querySelector('.lang-select');
            const langDropdown = document.querySelector('.lang-dropdown');
            
            if (langSelect && langDropdown) {
                langSelect.addEventListener('click', function(e) {
                    e.stopPropagation();
                    langDropdown.classList.toggle('active');
                    
                    // Close account dropdown if open
                    document.querySelectorAll('.account-dropdown').forEach(dropdown => {
                        dropdown.classList.remove('active');
                    });
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!langDropdown.contains(e.target)) {
                        langDropdown.classList.remove('active');
                    }
                });
            }
            
            // Account dropdown toggle functionality
            document.querySelectorAll('.account-dropdown .account-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const dropdown = this.closest('.account-dropdown');
                    dropdown.classList.toggle('active');
                    
                    // Close language dropdown if open
                    if (langDropdown) {
                        langDropdown.classList.remove('active');
                    }
                });
            });
            
            // Close account dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.account-dropdown')) {
                    document.querySelectorAll('.account-dropdown').forEach(dropdown => {
                        dropdown.classList.remove('active');
                    });
                }
            });
        });
    </script>
