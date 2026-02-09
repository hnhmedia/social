<?php
/**
 * Order Success / Thank You Page
 * Shows order confirmation after payment
 * Works with existing si_orders table structure
 * 
 * SECURITY: Requires both oid AND order_number to prevent order scraping
 * URL: /sgi/order-success.php?oid=123&order_number=ORD-20260209-A3F
 */

session_start();

require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/Config.php';

// Get BOTH order ID and order number from URL
$orderId = isset($_GET['oid']) ? (int)$_GET['oid'] : 0;
$orderNumber = isset($_GET['order_number']) ? trim($_GET['order_number']) : '';

// SECURITY: Require both parameters
if ($orderId <= 0 || empty($orderNumber)) {
    header("Location: " . Config::baseUrl() );
    exit;
}

try {
    $db = Database::getConnection();
    
    // SECURITY: Match BOTH oid AND order_number
    $db->where('o.id', $orderId);
    $db->where('o.order_number', $orderNumber);
    $db->join('users u', 'o.user_id = u.id', 'LEFT');
    $order = $db->getOne('orders o', 
        'o.*, u.email as user_email'
    );
    
    // If order not found or mismatch, redirect
    if (!$order) {
        // Invalid oid/order_number combination
        header("Location: " . Config::baseUrl() );
        exit;
    }
    
} catch (Exception $e) {
   // print_r("Error loading order: " . $e->getMessage());
    header("Location: " . Config::baseUrl() );
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - <?php echo $order['order_number']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .success-container {
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .success-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 3rem 2rem;
            text-align: center;
            color: white;
        }
        
        .success-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: scaleIn 0.5s ease-out;
        }
        
        @keyframes scaleIn {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }
        
        .success-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .success-subtitle {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        .success-body {
            padding: 2rem;
        }
        
        .order-details {
            background: #f9fafb;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .detail-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .detail-label {
            color: #6b7280;
            font-weight: 500;
        }
        
        .detail-value {
            color: #111827;
            font-weight: 600;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
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
        
        .info-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        
        .info-box p {
            color: #1e40af;
            font-size: 0.9rem;
            line-height: 1.6;
        }
        
        .btn-primary {
            display: block;
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: transform 0.2s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            display: block;
            width: 100%;
            padding: 1rem;
            background: white;
            color: #667eea;
            text-align: center;
            text-decoration: none;
            border: 2px solid #667eea;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 1rem;
            transition: all 0.2s;
        }
        
        .btn-secondary:hover {
            background: #f9fafb;
        }
        
        .progress-section {
            margin-bottom: 2rem;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #6b7280;
        }
        
        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
            border-radius: 10px;
            transition: width 0.3s;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-header">
            <div class="success-icon">✓</div>
            <h1 class="success-title">Order Confirmed!</h1>
            <p class="success-subtitle">Your order has been received</p>
        </div>
        
        <div class="success-body">
            <div class="order-details">
                <div class="detail-row">
                    <span class="detail-label">Order Number</span>
                    <span class="detail-value"><?php echo $order['order_number']; ?></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Service</span>
                    <span class="detail-value"><?php echo htmlspecialchars($order['service_name']); ?></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Quantity</span>
                    <span class="detail-value"><?php echo number_format($order['quantity']); ?></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Amount Paid</span>
                    <span class="detail-value">$<?php echo number_format($order['price'], 2); ?></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Email</span>
                    <span class="detail-value"><?php echo htmlspecialchars($order['user_email']); ?></span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="status-badge status-<?php echo $order['status']; ?>">
                        <?php echo ucfirst($order['status']); ?>
                    </span>
                </div>
            </div>
            
            <?php if ($order['status'] === 'processing' || $order['status'] === 'completed'): ?>
            <div class="progress-section">
                <div class="progress-label">
                    <span>Delivery Progress</span>
                    <span><?php echo $order['delivered']; ?> / <?php echo $order['quantity']; ?></span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo ($order['quantity'] > 0) ? ($order['delivered'] / $order['quantity'] * 100) : 0; ?>%"></div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="info-box">
                <p><strong>What's next?</strong><br>
                We've sent a confirmation email to <strong><?php echo htmlspecialchars($order['user_email']); ?></strong>. 
                <?php if ($order['status'] === 'pending'): ?>
                Your order will be processed as soon as we receive payment confirmation.
                <?php elseif ($order['status'] === 'processing'): ?>
                Your order is being processed and will be delivered shortly.
                <?php elseif ($order['status'] === 'completed'): ?>
                Your order has been completed successfully!
                <?php endif; ?>
                You can track your order status anytime using your order number.</p>
            </div>
            
            <a href="<?php echo Config::baseUrl(); ?>" class="btn-primary">Continue Shopping</a>
        </div>
    </div>
</body>
</html>
