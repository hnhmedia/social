<?php
// Page configuration
$page_title = "Famoid: Buy Instagram Followers, Likes & Views | #1 Agency";


// Get page from URL parameter
$page = isset($_GET['p']) ? $_GET['p'] : 'home';

// Allow only valid characters (security)
$page = preg_replace('/[^a-z0-9\-]/', '', strtolower($page));

// Set page-specific variables
$pageTitle = ucfirst($page);
$currentPage = $page;

// Define valid pages and their titles
$validPages = [
    'home' => 'Famoid: Buy Instagram Followers, Likes & Views | #1 Agency',
    'buy-instagram-followers' => 'Buy Instagram Followers - Real & Active Followers | Starting $2.95 - Famoid',
    'buy-instagram-likes' => 'Buy Instagram Likes - Real Likes | Famoid',
    'buy-instagram-views' => 'Buy Instagram Views - Real Views | Famoid',
    'contact' => 'Contact Us - Famoid',
    'about' => 'About Famoid - Social Media Marketing Agency',
    'faq' => 'FAQ - Frequently Asked Questions - Famoid',
    'testimonials' => 'Customer Reviews & Testimonials - Famoid',
    'privacy' => 'Privacy Policy - Famoid',
    'terms' => 'Terms of Service - Famoid'
];

// Set page title based on current page
if (isset($validPages[$page])) {
    $page_title = $validPages[$page];
}

include 'header.php';


$pageTitle = 'Home';
$currentPage = 'home';

// Get page from URL
$page = isset($_GET['p']) ? $_GET['p'] : 'home';

// Allow only valid characters (security)
$page = preg_replace('/[^a-z0-9\-]/', '', strtolower($page));

// File path
$moduleFile = __DIR__ . '/modules/' . $page . '.php';

// Include Header
include 'header.php';

// Route handling
if (file_exists($moduleFile)) {
    include $moduleFile;
} else {
    // 404 fallback
    include __DIR__ . '/modules/404.php';
}
?>

<?php
// Include footer
include 'footer.php';
?>
