# Quick Start Guide: Securing Your Application

## Step 1: Install PHP dotenv Library (Optional but Recommended)

```bash
cd C:\century\socialig\socialig
composer require vlucas/phpdotenv
```

## Step 2: Create Your .env File

```bash
# Copy the example file
copy .env.example .env

# Edit .env with your actual credentials
notepad .env
```

## Step 3: Update config/database.php to Use Environment Variables

### Option A: Using vlucas/phpdotenv (Recommended)

Create a new file `config/load_env.php`:

```php
<?php
// Load environment variables
require_once __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
} catch (Exception $e) {
    // Fallback if .env file doesn't exist
    error_log("Warning: .env file not found. Using default configuration.");
}

// Helper function to get environment variables with fallback
function env($key, $default = null) {
    return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
}
```

Then update your `config/database.php`:

```php
<?php
// Load environment variables
require_once __DIR__ . '/load_env.php';

// Site Configuration
$site_config = [
    'base_url'    => env('APP_URL', 'https://betabd.zodiaccdn.com/sgi'),
    'site_name'   => env('SITE_NAME', 'SocialIG'),
    'site_title'  => env('SITE_TITLE', 'SocialIG - Social Media Growth Services'),
    'admin_email' => env('ADMIN_EMAIL', 'admin@socialig.com'),
    'support_email' => env('SUPPORT_EMAIL', 'support@socialig.com'),
];

// Database Configuration
$db_config = [
    'host'     => env('DB_HOST', '10.10.20.3'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'db'       => env('DB_NAME', 'social'),
    'port'     => (int)env('DB_PORT', 3306),
    'prefix'   => env('DB_PREFIX', 'si_'),
    'charset'  => env('DB_CHARSET', 'utf8mb4')
];

// SMTP Configuration
$smtp_config = [
    'enabled'   => filter_var(env('SMTP_ENABLED', true), FILTER_VALIDATE_BOOLEAN),
    'host'      => env('SMTP_HOST', 'smtp.gmail.com'),
    'port'      => (int)env('SMTP_PORT', 587),
    'username'  => env('SMTP_USERNAME', ''),
    'password'  => env('SMTP_PASSWORD', ''),
    'from_email' => env('SMTP_FROM_EMAIL', 'noreply@socialig.com'),
    'from_name'  => env('SMTP_FROM_NAME', 'SocialIG'),
    'encryption' => env('SMTP_ENCRYPTION', 'tls'),
    // ... rest of SMTP config
];

// Database Settings
$db_settings = [
    'auto_reconnect' => true,
    'debug_mode'     => filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOLEAN),
    'enable_trace'   => false,
    'connection_timeout' => 30
];

// Rest of your config...
```

### Option B: Simple PHP Approach (No Composer Required)

Create `config/env_loader.php`:

```php
<?php
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        // Parse KEY=VALUE
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Remove quotes if present
            $value = trim($value, '"\'');
            
            // Set environment variable
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
}

// Helper function
function env($key, $default = null) {
    return $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key) ?: $default;
}

// Load .env file
loadEnv(__DIR__ . '/../.env');
```

Then add to top of `config/database.php`:

```php
<?php
require_once __DIR__ . '/env_loader.php';
```

## Step 4: Secure Your Files

1. **Check file permissions:**
```bash
# .env should NOT be web-accessible
# On Linux/Mac:
chmod 600 .env

# On Windows: Right-click .env > Properties > Security
# Remove all users except your web server user
```

2. **Update .htaccess to deny access to .env:**
```apache
# Add to your .htaccess file
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

## Step 5: Test Your Configuration

Create `test_config.php` in your root directory:

```php
<?php
require_once __DIR__ . '/config/database.php';

echo "<h1>Configuration Test</h1>";
echo "<p><strong>DB Host:</strong> " . $db_config['host'] . "</p>";
echo "<p><strong>DB Name:</strong> " . $db_config['db'] . "</p>";
echo "<p><strong>Debug Mode:</strong> " . ($db_settings['debug_mode'] ? 'ON' : 'OFF') . "</p>";
echo "<p><strong>Base URL:</strong> " . $site_config['base_url'] . "</p>";

// Test database connection
try {
    require_once __DIR__ . '/includes/Database.php';
    $db = Database::connect();
    echo "<p style='color: green;'><strong>✓ Database connection successful!</strong></p>";
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>✗ Database connection failed:</strong> " . $e->getMessage() . "</p>";
}

// DELETE THIS FILE AFTER TESTING!
echo "<hr><p style='color: red;'><strong>WARNING: Delete this file after testing!</strong></p>";
```

Visit: `https://betabd.zodiaccdn.com/sgi/test_config.php`

**IMPORTANT: Delete test_config.php after testing!**

## Step 6: Enable Production Mode

In your `.env` file:
```env
APP_ENV=production
APP_DEBUG=false
```

## Step 7: Backup Your Configuration

```bash
# Backup your old config (in case you need to rollback)
copy config\database.php config\database.php.backup

# Never commit the backup file
echo config/database.php.backup >> .gitignore
```

## Common Issues & Solutions

### Issue 1: "Call to undefined function env()"
**Solution:** Make sure you're loading the env loader at the top of database.php

### Issue 2: Environment variables not loading
**Solution:** Check that .env file exists and has correct format (KEY=VALUE, no spaces around =)

### Issue 3: Database connection fails
**Solution:** Double-check credentials in .env file, ensure database server is running

### Issue 4: SMTP not working
**Solution:** 
- For Gmail, use App Password, not regular password
- Enable "Less secure app access" or use OAuth2
- Check port (587 for TLS, 465 for SSL)

## Security Checklist

- [ ] .env file created and configured
- [ ] .gitignore file added
- [ ] Database credentials moved to .env
- [ ] SMTP credentials moved to .env
- [ ] Debug mode disabled in production
- [ ] .env file permissions set correctly
- [ ] .htaccess blocks access to .env
- [ ] test_config.php deleted
- [ ] Backup of original config saved elsewhere
- [ ] Changes tested on development server first

## Need Help?

If you encounter issues:
1. Check error logs: `logs/error.log`
2. Temporarily enable debug mode in .env: `APP_DEBUG=true`
3. Check PHP error log
4. Verify file permissions
5. Ensure all required PHP extensions are installed (mysqli, etc.)

---

**Remember:** 
- NEVER commit .env to version control
- NEVER share your .env file
- ALWAYS use different credentials for development and production
- ALWAYS backup before making changes

Good luck! 🚀
