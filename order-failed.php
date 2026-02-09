<?php
/**
 * Order Failed Page
 * Shows order failure message after payment failure
 *
 * URL Example:
 * /sgi/order-failed.php?oid=123&order_number=ORD-20260209-A3F
 */

session_start();

require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/Config.php';

// Get order details safely (optional)
$orderId = isset($_GET['oid']) ? (int)$_GET['oid'] : 0;
$orderNumber = isset($_GET['order_number']) ? trim($_GET['order_number']) : "";

// Default empty order array (prevents errors)
$order = [
    "order_number" => $orderNumber,
    "service_name" => "N/A",
    "price"        => 0,
    "user_email"   => "N/A"
];

// If order exists, load it (optional)
if ($orderId > 0 && !empty($orderNumber)) {
    try {
        $db = Database::getConnection();

        $db->where("o.id", $orderId);
        $db->where("o.order_number", $orderNumber);
        $db->join("users u", "o.user_id = u.id", "LEFT");

        $result = $db->getOne("orders o", "o.*, u.email as user_email");

        if ($result) {
            $order = $result;
        }

    } catch (Exception $e) {
        // silently ignore error
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Failed - <?php echo htmlspecialchars($order['order_number']); ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ✅ Original Background Same as Success Page */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .failed-container {
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        /* ❌ Red Header for Failed */
        .failed-header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            padding: 3rem 2rem;
            text-align: center;
            color: white;
        }

        .failed-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .failed-subtitle {
            font-size: 1rem;
            opacity: 0.9;
        }

        .failed-body {
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
            font-weight: 700;
        }

        .error-box {
            background: #fee2e2;
            border-left: 4px solid #dc2626;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .error-box p {
            color: #7f1d1d;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Button */
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
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background: #f9fafb;
        }
    </style>
</head>

<body>

<div class="failed-container">

    <!-- Header -->
    <div class="failed-header">
        <h1 class="failed-title">Order Failed</h1>
        <p class="failed-subtitle">Your payment could not be completed</p>
    </div>

    <!-- Body -->
    <div class="failed-body">

        <!-- Order Info -->


        <!-- Failure Message -->
        <div class="error-box">
            <p>
                <strong>Payment Failed!</strong><br>
                Unfortunately, your transaction was not successful.<br>
                Please try again or contact support if money was deducted.
            </p>
        </div>

        <!-- Back Button -->
        <a href="<?php echo Config::baseUrl(); ?>" class="btn-secondary">
            Back to Home
        </a>

    </div>

</div>

</body>
</html>
