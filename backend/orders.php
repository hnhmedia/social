<?php
$pageTitle = 'Orders';
require_once 'includes/db.php';
include 'includes/header.php';

// Get all orders
$orders = getAllOrders();
?>

<div class="table-container">
    <div class="table-header">
        <h2>All Orders (<?php echo count($orders); ?>)</h2>
    </div>
    
    <?php if (count($orders) > 0): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Service</th>
                    <th>Package</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($order['order_number'] ?? '#' . $order['id']); ?></strong></td>
                        <td><?php echo htmlspecialchars($order['user_name'] ?? $order['email'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($order['service_name'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($order['package_name'] ?? 'N/A'); ?></td>
                        <td><strong>$<?php echo number_format($order['amount'] ?? 0, 2); ?></strong></td>
                        <td>
                            <?php 
                            $status = $order['status'] ?? 'pending';
                            $badgeClass = 'badge-info';
                            if ($status === 'completed') $badgeClass = 'badge-success';
                            if ($status === 'pending') $badgeClass = 'badge-warning';
                            ?>
                            <span class="badge <?php echo $badgeClass; ?>">
                                <?php echo ucfirst($status); ?>
                            </span>
                        </td>
                        <td><?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <h3>No Orders Found</h3>
            <p>There are no orders in the database yet.</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
