<?php
/**
 * Order Page - Clean URL Version
 * URL: /order/2IGF/
 */

require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/Config.php';
require_once __DIR__ . '/includes/dynamic_service_integration.php';

// Get package code from URL
$packageCode = isset($_GET['code']) ? trim($_GET['code']) : '';

if (empty($packageCode)) {
    header("Location: " . Config::baseUrl() );
    exit;
}

// Get package details from database
$package = getPackageByCode($packageCode);

if (!$package) {
    header("Location: " . Config::baseUrl());
    exit;
}

// Set page title
$page_title = "Order {$package['quantity']} {$package['service_name']} - $" . number_format($package['price'], 2);

// Calculate savings
$savings = 0;
$savingsPercent = 0;
if ($package['original_price'] && $package['original_price'] > $package['price']) {
    $savings = $package['original_price'] - $package['price'];
    $savingsPercent = round(($savings / $package['original_price']) * 100);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        /* Header Styles */
        .site-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        .back-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: #1f2937;
        }
        
        .back-btn:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 800;
            color: #2563eb;
        }
        
        .logo-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .lang-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
            color: #1f2937;
        }
        
        .lang-selector:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }
        
        .account-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            font-size: 1.2rem;
        }
        
        /* Main Content */
        .main-content {
            max-width: 600px;
            margin: 3rem auto;
            padding: 0 1.5rem;
        }
        
        .page-title {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .page-title h1 {
            font-size: 2rem;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        
        .page-title p {
            color: #6b7280;
            font-size: 1rem;
        }
        
        .order-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .package-details {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .package-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .package-row:last-child {
            margin-bottom: 0;
        }
        
        .package-label {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .package-value {
            color: #0f172a;
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        .package-quantity {
            font-size: 2rem;
            color: #7c3aed;
        }
        
        .package-price {
            font-size: 2rem;
            color: #10b981;
        }
        
        .original-price {
            text-decoration: line-through;
            color: #94a3b8;
            font-size: 0.9rem;
            margin-right: 0.5rem;
        }
        
        .savings-badge {
            background: #10b981;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-top: 0.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            color: #334155;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: inherit;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }
        
        .form-help {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.5rem;
        }
        
        .checkout-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 1rem;
        }
        
        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .checkout-btn:active {
            transform: translateY(0);
        }
        
        .trust-badges {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .trust-badge {
            text-align: center;
            font-size: 0.8rem;
            color: #64748b;
        }
        
        .trust-icon {
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }
        
        @media (max-width: 640px) {
            .header-container {
                padding: 0 1rem;
            }
            
            .header-left {
                gap: 1rem;
            }
            
            .logo {
                font-size: 1.2rem;
            }
            
            .lang-selector {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }
            
            .main-content {
                margin: 2rem auto;
                padding: 0 1rem;
            }
            
            .page-title h1 {
                font-size: 1.5rem;
            }
            
            .order-card {
                padding: 1.5rem;
            }
            
            .trust-badges {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="site-header">
        <div class="header-container">
            <div class="header-left">
                <a href="<?php echo Config::baseUrl().$package['service_slug']; ?>" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                </a>
                <a href="<?php echo Config::baseUrl(); ?>/" class="logo">
                    <div class="logo-icon">G</div>
                    <span>Genuine Socials</span>
                </a>
            </div>
            <div class="header-right">
                <div class="lang-selector">
                    <span>🌐</span>
                    <span>us EN</span>
                </div>
                <button class="account-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-title">
            <h1>Get Started</h1>
            <p>Complete your order for <?php echo htmlspecialchars($package['service_name']); ?></p>
        </div>

        <div class="order-card">
            <div class="package-details">
                <div class="package-row">
                    <span class="package-label">Service</span>
                    <span class="package-value"><?php echo htmlspecialchars($package['service_name']); ?></span>
                </div>
                
                <div class="package-row">
                    <span class="package-label">Quantity</span>
                    <span class="package-quantity"><?php echo number_format($package['quantity']); ?></span>
                </div>
                
                <div class="package-row">
                    <span class="package-label">Package Type</span>
                    <span class="package-value"><?php echo htmlspecialchars($package['tag_name']); ?></span>
                </div>
                
                <div class="package-row">
                    <span class="package-label">Total Price</span>
                    <div>
                        <?php if ($savings > 0): ?>
                        <span class="original-price">$<?php echo number_format($package['original_price'], 2); ?></span>
                        <?php endif; ?>
                        <span class="package-price">$<?php echo number_format($package['price'], 2); ?></span>
                    </div>
                </div>
                
                <?php if ($savings > 0): ?>
                <div class="package-row">
                    <span class="package-label"></span>
                    <span class="savings-badge">Save $<?php echo number_format($savings, 2); ?> (<?php echo $savingsPercent; ?>% OFF)</span>
                </div>
                <?php endif; ?>
            </div>
            
            <form id="orderForm" method="POST" action="<?php echo Config::baseUrl(); ?>process-order.php">
                <input type="hidden" name="package_code" value="<?php echo htmlspecialchars($packageCode); ?>">
                <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                <input type="hidden" name="service_id" value="<?php echo $package['service_id']; ?>">
                <input type="hidden" name="quantity" value="<?php echo $package['quantity']; ?>">
                <input type="hidden" name="price" value="<?php echo $package['price']; ?>">
                
                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" class="form-input" placeholder="your@email.com" required>
                    <div class="form-help">Order confirmation will be sent here</div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <?php 
                        // Dynamic label based on service
                        if (strpos($package['service_slug'], 'followers') !== false) {
                            if (strpos($package['service_slug'], 'instagram') !== false) {
                                echo 'Instagram Username *';
                            } elseif (strpos($package['service_slug'], 'tiktok') !== false) {
                                echo 'TikTok Username *';
                            } else {
                                echo 'Username *';
                            }
                        } else {
                            echo 'Profile/Page URL *';
                        }
                        ?>
                    </label>
                    <input type="text" name="target_url" class="form-input" placeholder="@username or profile URL" required>
                    <div class="form-help">Where should we deliver your order?</div>
                </div>
                
                <button type="submit" class="checkout-btn">
                    Proceed to Payment →
                </button>
            </form>
            
            <div class="trust-badges">
                <div class="trust-badge">
                    <div class="trust-icon">🔒</div>
                    <div>Secure Payment</div>
                </div>
                <div class="trust-badge">
                    <div class="trust-icon">⚡</div>
                    <div>Instant Delivery</div>
                </div>
                <div class="trust-badge">
                    <div class="trust-icon">💯</div>
                    <div>Money Back</div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            // Form validation
            const email = document.querySelector('input[name="email"]').value;
            const target = document.querySelector('input[name="target_url"]').value;
            
            if (!email || !target) {
                e.preventDefault();
                alert('Please fill in all required fields');
                return false;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address');
                return false;
            }
        });
    </script>
</body>
</html>
