<?php
/**
 * Main Router - Index.php
 * Routes requests to appropriate module files
 */

// Include Config for dynamic site name
require_once __DIR__ . '/includes/Config.php';

// Get site name from config
$siteName = Config::siteName();

// Get page from URL parameter
$page = isset($_GET['p']) ? $_GET['p'] : 'home';

// Allow only valid characters (security)
$page = preg_replace('/[^a-z0-9\-]/', '', strtolower($page));

// Set page-specific variables
$pageTitle = ucfirst($page);
$currentPage = $page;

// Define valid pages and their titles (using dynamic site name)
$validPages = [
    'home' => $siteName . ': Buy Instagram Followers, Likes & Views | #1 Agency',
    'buy-instagram-followers' => 'Buy Instagram Followers - Real & Active Followers | Starting $2.95 - ' . $siteName,
    'buy-instagram-likes' => 'Buy Instagram Likes - Real Likes | ' . $siteName,
    'buy-instagram-views' => 'Buy Instagram Views - Real Views | ' . $siteName,
    'contact' => 'Contact Us - ' . $siteName,
    'about' => 'About ' . $siteName . ' - Social Media Marketing Agency',
    'faq' => 'FAQ - Frequently Asked Questions - ' . $siteName,
    'testimonials' => 'Customer Reviews & Testimonials - ' . $siteName,
    'privacy' => 'Privacy Policy - ' . $siteName,
    'terms' => 'Terms of Service - ' . $siteName
];

// Set page title based on current page
if (isset($validPages[$page])) {
    $page_title = $validPages[$page];
} else {
    $page_title = $siteName . ': Buy Instagram Followers, Likes & Views | #1 Agency';
}

// Set current page for navigation
$currentPage = $page;

// File path
$moduleFile = __DIR__ . '/modules/' . $page . '.php';

// Include Header
include 'header.php';

// Route handling
if (file_exists($moduleFile)) {
    include $moduleFile;
} else {
    // 404 fallback - create one if doesn't exist
    if (file_exists(__DIR__ . '/modules/404.php')) {
        include __DIR__ . '/modules/404.php';
    } else {
        echo '<div style="text-align:center;padding:50px;"><h1>404 - Page Not Found</h1><p>The page you are looking for does not exist.</p></div>';
    }
}

// Include footer
include 'footer.php';
?>
