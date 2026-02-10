<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
// Try to include main site header
$main_header = dirname(dirname(__DIR__)) . '/header.php';

if (file_exists($main_header)) {
    // Include main site header
    $baseUrl = socialig_base_url();
    $siteName = socialig_site_name();
    include $main_header;
} else {
    // Fallback: Simple blog header
    ?>
    <!-- Blog Fallback Header -->
    <nav class="navbar" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 1rem 0;">
        <div class="navbar-inner" style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 1rem;">
            <a href="<?php echo socialig_base_url(); ?>" class="logo" style="font-size: 1.5rem; font-weight: 800; color: #7c3aed; text-decoration: none;">
                <?php echo socialig_site_name(); ?>
            </a>
            <nav style="display: flex; gap: 2rem; align-items: center;">
                <a href="<?php echo socialig_base_url(); ?>" style="color: #64748b; text-decoration: none; font-weight: 500;">Home</a>
                <a href="<?php echo home_url(); ?>" style="color: #7c3aed; text-decoration: none; font-weight: 600;">Blog</a>
                <a href="<?php echo socialig_base_url('contact'); ?>" style="color: #64748b; text-decoration: none; font-weight: 500;">Contact</a>
            </nav>
        </div>
    </nav>
    <?php
}
?>

<!-- WordPress Content Starts Here -->
<div id="blog-content-wrapper">
