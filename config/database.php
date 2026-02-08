<?php
/**
 * Database Configuration File
 * 
 * This file contains all database connection settings
 * Make sure to update these values with your actual database credentials
 */

// Database Configuration
$db_config = [
    'host'     => '10.10.20.3',        // Database server host
    'username' => 'root',    // Database username
    'password' => 'OCOJv7FgoBMpaznG',    // Database password
    'db'       => 'social',      // Database name
    'port'     => 3306,               // Database port (default MySQL port)
    'prefix'   => 'si_',              // Table prefix (optional)
    'charset'  => 'utf8mb4'           // Character set
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
    'database' => $db_config,
    'settings' => $db_settings,
    'security' => $security_config
];
?>
