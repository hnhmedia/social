<?php
/**
 * Database Configuration File
 * 
 * This file contains all database connection settings, SMTP email configuration, and site URLs
 * Make sure to update these values with your actual credentials
 */

// Site Configuration
$site_config = [
    'base_url'    => 'https://betabd.zodiaccdn.com/sgi',    // Site base URL (no trailing slash)
    'site_name'   => 'SocialIG',                             // Site name - CHANGE THIS to update entire site
    'site_title'  => 'SocialIG - Social Media Growth Services',
    'admin_email' => 'admin@socialig.com',                   // Admin email
    'support_email' => 'support@socialig.com',               // Support email
];

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
    'from_email' => 'noreply@socialig.com',       // From email address
    'from_name'  => $site_config['site_name'],    // From name (uses site name)
    'encryption' => 'tls',                         // Encryption type: 'tls', 'ssl', or '' for none
    'timeout'    => 30,                            // Connection timeout in seconds
    'debug'      => false,                         // Enable SMTP debug output (2 = detailed, 1 = messages, 0 = off)
    
    // Email Templates
    'templates' => [
        'logo_url'       => $site_config['base_url'] . '/images/logo.png',
        'company_name'   => $site_config['site_name'],
        'company_url'    => $site_config['base_url'] . '/',
        'support_email'  => $site_config['support_email'],
        'primary_color'  => '#667eea',
        'secondary_color' => '#764ba2'
    ]
];

// Alternative configuration for production/staging environments
$environments = [
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
        'host'     => '10.10.20.3',
        'username' => 'root', 
        'password' => 'OCOJv7FgoBMpaznG',
        'db'       => 'social',
        'port'     => 3306,
        'prefix'   => 'si_',
        'charset'  => 'utf8mb4'
    ],
    
    'staging' => [
        'host'     => '10.10.20.3',
        'username' => 'root',
        'password' => 'OCOJv7FgoBMpaznG', 
        'db'       => 'social',
        'port'     => 3306,
        'prefix'   => 'si_',
        'charset'  => 'utf8mb4'
    ]
];

// Determine current environment (default to development)
$current_environment = $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'development';

// Use environment-specific config if available, otherwise use default
if (isset($environments[$current_environment])) {
    $db_config = $environments[$current_environment];
}

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
