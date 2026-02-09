<?php
/**
 * Payment Callback Handler
 * Works with existing si_orders table structure
 * This file receives callbacks from the payment gateway
 * URL: /sgi/payment-callback.php
 */

require_once __DIR__ . '/includes/Database.php';

// Get callback parameters (adjust based on your payment gateway)
$orderId = isset($_GET['oid']) ? (int)$_GET['oid'] : 0;
$status = isset($_GET['status']) ? trim($_GET['status']) : '';
$transactionId = isset($_GET['txn_id']) ? trim($_GET['txn_id']) : '';

// Validate parameters
if ($orderId <= 0) {
    http_response_code(400);
    echo "Invalid order ID";
    exit;
}

try {
    $db = Database::getConnection();
    
    // Get order from database
    $order = $db->where('id', $orderId)->getOne('si_orders');
    
    if (!$order) {
        http_response_code(404);
        echo "Order not found";
        exit;
    }
    
    // Update order based on payment status
    $updateData = [];
    
    switch (strtolower($status)) {
        case 'success':
        case 'paid':
        case 'completed':
            $updateData['status'] = 'processing';
            $updateData['payment_id'] = $transactionId;
            $updateData['payment_method'] = 'online';
            break;
            
        case 'failed':
        case 'declined':
            $updateData['status'] = 'cancelled';
            $updateData['cancelled_at'] = date('Y-m-d H:i:s');
            break;
            
        case 'refunded':
            $updateData['status'] = 'refunded';
            $updateData['refund_amount'] = $order['price'];
            $updateData['refunded_at'] = date('Y-m-d H:i:s');
            break;
            
        default:
            http_response_code(400);
            echo "Invalid status";
            exit;
    }
    
    // Update order
    $db->where('id', $orderId);
    $updated = $db->update('si_orders', $updateData);
    
    if ($updated) {
        // Log successful update
        error_log("Order #{$orderId} updated: status={$updateData['status']}");
        
        // If payment successful, you can trigger additional actions here
        if ($updateData['status'] === 'processing') {
            // TODO: Send order to fulfillment system
            // TODO: Send confirmation email to customer
            
            // Log order details
            error_log("Order #{$orderId} ready for processing: {$order['service_name']} x {$order['quantity']}");
        }
        
        echo "OK";
    } else {
        http_response_code(500);
        echo "Failed to update order";
    }
    
} catch (Exception $e) {
    error_log("Payment callback error: " . $e->getMessage());
    http_response_code(500);
    echo "Server error";
}
