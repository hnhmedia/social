<?php
$pageTitle = 'Users';
require_once 'includes/db.php';
include 'includes/header.php';

// Get all users
$users = getAllUsers();
?>

<div class="table-container">
    <div class="table-header">
        <h2>All Users (<?php echo count($users); ?>)</h2>
    </div>
    
    <?php if (count($users) > 0): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>#<?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['name'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                        <td>
                            <?php 
                            $status = $user['status'] ?? 'active';
                            $badgeClass = $status === 'active' ? 'badge-success' : 'badge-warning';
                            ?>
                            <span class="badge <?php echo $badgeClass; ?>">
                                <?php echo ucfirst($status); ?>
                            </span>
                        </td>
                        <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <h3>No Users Found</h3>
            <p>There are no users in the database yet.</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
