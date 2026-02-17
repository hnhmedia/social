<?php
/**
 * Database Configuration File
 * 
 * This file contains all database connection settings, SMTP email configuration, and site URLs
 * Make sure to update these values with your actual credentials
 */

// Site Configuration
$site_config = [
    'base_url'    => 'https://genuinesocials.com/',    // Site base URL (no trailing slash)
    'site_name'   => 'Genuine Socials',                     // Site name
    'site_title'  => 'Genuine Socials - Social Media Growth Services',
    'admin_email' => 'admin@genuinesocials.com',            // Admin email
    'support_email' => 'support@genuinesocials.com',        // Support email
];

// Allow environment override for base URL when running locally
$envBaseUrl = getenv('APP_BASE_URL') ?: ($_SERVER['APP_BASE_URL'] ?? null);
if ($envBaseUrl) {
    $envBaseUrl = rtrim($envBaseUrl, '/') . '/';
    $site_config['base_url'] = $envBaseUrl;
}

// Optional overrides for branding via environment
$site_config['site_name'] = getenv('SITE_NAME') ?: ($_SERVER['SITE_NAME'] ?? $site_config['site_name']);
$site_config['site_title'] = getenv('SITE_TITLE') ?: ($_SERVER['SITE_TITLE'] ?? $site_config['site_title']);
$site_config['admin_email'] = getenv('ADMIN_EMAIL') ?: ($_SERVER['ADMIN_EMAIL'] ?? $site_config['admin_email']);
$site_config['support_email'] = getenv('SUPPORT_EMAIL') ?: ($_SERVER['SUPPORT_EMAIL'] ?? $site_config['support_email']);

// Database Configuration
$db_config = [
    'host'     => '10.10.20.3',        // Database server host
    'username' => 'root',              // Database username
    'password' => 'OCOJv7FgoBMpaznG',  // Database password
    'db'       => 'social',            // Database name
    'port'     => 3306,                // Database port (default MySQL port)
    'prefix'   => 'si_',               // Table prefix (optional)
    'charset'  => 'utf8mb4'            // Character set
];

// SMTP Email Configuration
$smtp_config = [
    'enabled'   => true,                           // Enable/disable SMTP
    'host'      => 'smtp.gmail.com',              // SMTP server (e.g., smtp.gmail.com, smtp.mailtrap.io)
    'port'      => 587,                            // SMTP port (587 for TLS, 465 for SSL, 25 for standard)
    'username'  => 'your-email@gmail.com',        // SMTP username (your email)
    'password'  => 'your-app-password',           // SMTP password (use App Password for Gmail)
    'from_email' => 'noreply@genuinesocials.com', // From email address
    'from_name'  => 'Genuine Socials',            // From name
    'encryption' => 'tls',                         // Encryption type: 'tls', 'ssl', or '' for none
    'timeout'    => 30,                            // Connection timeout in seconds
    'debug'      => false,                         // Enable SMTP debug output (2 = detailed, 1 = messages, 0 = off)
    
    // Email Templates
    'templates' => [
        'logo_url'       => 'https://genuinesocials.com/images/logo.png',
        'company_name'   => 'Genuine Socials',
        'company_url'    => 'https://genuinesocials.com/',
        'support_email'  => 'support@genuinesocials.com',
        'primary_color'  => '#0b9e7a',
        'secondary_color' => '#0f766e'
    ]
];

// Alternative configuration for production/staging environments
$environments = [
    'local' => [
        'host'     => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db'       => 'admin_sgmlocal',
        'port'     => 3306,
        'prefix'   => 'si_',
        'charset'  => 'utf8mb4'
    ],

    'development' => [
        'host'     => '10.10.20.3',
        'username' => 'root',
        'password' => 'OCOJv7FgoBMpaznG',
        'db'       => 'social',
        'port'     => 3306,
        'prefix'   => 'si_',
        'charset'  => 'utf8mb4'
    ],
    
    'production' => [
        'host'     => 'localhost',
        'username' => 'admin_sgmlocal', 
        'password' => 'OCOJv7FgoBMpaznG',
        'db'       => 'admin_sgmlocal',
        'port'     => 3306,
        'prefix'   => 'si_',
        'charset'  => 'utf8mb4'
    ],
    
    'staging' => [
        'host'     => 'localhost',
        'username' => 'admin_sgmlocal',
        'password' => 'OCOJv7FgoBMpaznG', 
        'db'       => 'admin_sgmlocal',
        'port'     => 3306,
        'prefix'   => 'si_',
        'charset'  => 'utf8mb4'
    ]
];

// Determine current environment (default to local for dev use)
$current_environment = $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'local';

// Use environment-specific config if available, otherwise use default
if (isset($environments[$current_environment])) {
    $db_config = $environments[$current_environment];
}

// Env overrides for container/local flexibility
$db_config['host'] = getenv('DB_HOST') ?: ($_SERVER['DB_HOST'] ?? $db_config['host']);
$db_config['username'] = getenv('DB_USER') ?: ($_SERVER['DB_USER'] ?? $db_config['username']);
$db_config['password'] = getenv('DB_PASS') ?: ($_SERVER['DB_PASS'] ?? $db_config['password']);
$db_config['db'] = getenv('DB_NAME') ?: ($_SERVER['DB_NAME'] ?? $db_config['db']);
$db_config['port'] = getenv('DB_PORT') ? (int)getenv('DB_PORT') : (isset($_SERVER['DB_PORT']) ? (int)$_SERVER['DB_PORT'] : $db_config['port']);

// Database Error Reporting
$db_settings = [
    'auto_reconnect' => true,    // Automatically reconnect on connection loss
    'debug_mode'     => true,    // Enable debug mode (disable in production)
    'enable_trace'   => false,   // Enable query tracing for performance monitoring
    'connection_timeout' => 30   // Connection timeout in seconds
];

// Security Settings
$security_config = [
    'ssl_enabled'    => false,   // Enable SSL connection
    'ssl_key'        => '',      // Path to SSL key file
    'ssl_cert'       => '',      // Path to SSL certificate file  
    'ssl_ca'         => '',      // Path to SSL CA file
    'ssl_verify'     => true     // Verify SSL certificate
];

return [
    'site'     => $site_config,
    'database' => $db_config,
    'smtp'     => $smtp_config,
    'settings' => $db_settings,
    'security' => $security_config
];
