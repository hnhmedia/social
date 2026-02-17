<?php
/**
 * Config Helper
 * Helper functions to access configuration values
 */

class Config {
    private static $config = null;
    
    /**
     * Load configuration
     */
    private static function load() {
        if (self::$config === null) {
            // Load environment overrides if present
            require_once __DIR__ . '/env.php';
            loadEnv(__DIR__ . '/../.env');

            self::$config = require __DIR__ . '/../config/database.php';
        }
        return self::$config;
    }
    
    /**
     * Get configuration value
     * 
     * @param string $key Dot notation key (e.g., 'site.base_url')
     * @param mixed $default Default value if key not found
     * @return mixed
     */
    public static function get($key, $default = null) {
        $config = self::load();
        $keys = explode('.', $key);
        $value = $config;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }
        
        return $value;
    }
    
    /**
     * Get base URL
     * 
     * @param string $path Optional path to append
     * @return string
     */
    public static function baseUrl($path = '') {
        $baseUrl = self::get('site.base_url', 'https://betabd.zodiaccdn.com/sgi');
        
        if ($path) {
            $path = ltrim($path, '/');
            return $baseUrl  . $path;
        }
        
        return $baseUrl;
    }
    
    /**
     * Get site name
     * 
     * @return string
     */
    public static function siteName() {
        return self::get('site.site_name', 'Genuine Socials');
    }
    
    /**
     * Get support email
     * 
     * @return string
     */
    public static function supportEmail() {
        return self::get('site.support_email', 'support@genuinesocials.com');
    }
    
    /**
     * Get admin email
     * 
     * @return string
     */
    public static function adminEmail() {
        return self::get('site.admin_email', 'admin@genuinesocials.com');
    }
    
    /**
     * Get SMTP configuration
     * 
     * @return array
     */
    public static function smtp() {
        return self::get('smtp', []);
    }
    
    /**
     * Get database configuration
     * 
     * @return array
     */
    public static function database() {
        return self::get('database', []);
    }
}
