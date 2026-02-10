<?php
$pageTitle = 'Dashboard';
require_once 'includes/db.php';
include 'includes/header.php';

// Get stats
$stats = getDashboardStats();
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-info">
            <h3>Total Users</h3>
            <p><?php echo number_format($stats['total_users']); ?></p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-info">
            <h3>Total Orders</h3>
            <p><?php echo number_format($stats['total_orders']); ?></p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">❓</div>
        <div class="stat-info">
            <h3>Total FAQs</h3>
            <p><?php echo number_format($stats['total_faqs']); ?></p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">⭐</div>
        <div class="stat-info">
            <h3>Total Testimonials</h3>
            <p><?php echo number_format($stats['total_testimonials']); ?></p>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="table-header">
        <h2>Quick Actions</h2>
    </div>
    <div style="padding: 2rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <a href="users.php" class="btn-primary" style="text-align: center; padding: 1.5rem;">
                👥 View Users
            </a>
            <a href="orders.php" class="btn-primary" style="text-align: center; padding: 1.5rem;">
                📦 View Orders
            </a>
            <a href="faqs.php" class="btn-primary" style="text-align: center; padding: 1.5rem;">
                ❓ Manage FAQs
            </a>
            <a href="testimonials.php" class="btn-primary" style="text-align: center; padding: 1.5rem;">
                ⭐ Manage Testimonials
            </a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
