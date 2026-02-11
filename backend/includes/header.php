<?php
require_once __DIR__ . '/auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Admin Panel'; ?> - SocialIG Admin</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2>SocialIG Admin</h2>
                <p>Welcome, <strong><?php echo htmlspecialchars(getAdminName()); ?></strong></p>
                <p style="font-size: 0.75rem; opacity: 0.7; margin-top: 0.25rem;">
                    @<?php echo htmlspecialchars(getAdminUsername()); ?>
                </p>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                    <span>📊</span> Dashboard
                </a>
                <a href="users.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                    <span>👥</span> Users
                </a>
                <a href="orders.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : ''; ?>">
                    <span>📦</span> Orders
                </a>
                <a href="services.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">
                    <span>🛍️</span> Services
                </a>
                <a href="service_tags.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'service_tags.php' ? 'active' : ''; ?>">
                    <span>🏷️</span> Service Tags
                </a>
                <a href="packages.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'packages.php' ? 'active' : ''; ?>">
                    <span>💰</span> Packages
                </a>
                <a href="faqs.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'faqs.php' ? 'active' : ''; ?>">
                    <span>❓</span> FAQs
                </a>
                <a href="testimonials.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'testimonials.php' ? 'active' : ''; ?>">
                    <span>⭐</span> Testimonials
                </a>
                <a href="admin_users.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin_users.php' ? 'active' : ''; ?>">
                    <span>🔐</span> Admin Users
                </a>
                <a href="logout.php" class="logout">
                    <span>🚪</span> Logout
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <h1><?php echo $pageTitle ?? 'Admin Panel'; ?></h1>
            </header>
            <div class="admin-content">
