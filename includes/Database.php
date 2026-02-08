<?php
/**
 * Database Connection Manager
 * 
 * This class manages database connections using the MysqliDb library
 * It loads configuration from the config file and provides a singleton instance
 */

require_once 'MysqliDb.php';  // Include the MysqliDb library

class Database {
    
    private static $instance = null;
    private static $db = null;
    private static $config = null;
    
    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct() {}
    
    /**
     * Get singleton instance of Database class
     * 
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Initialize database connection with configuration
     * 
     * @return MysqliDb
     * @throws Exception
     */
    public static function connect() {
        if (self::$db !== null) {
            return self::$db;
        }
        
        try {
            // Load configuration
            self::loadConfig();
            
            // Create MysqliDb instance
            self::$db = new MysqliDb(self::$config['database']);
            
            // Apply settings
            self::applySettings();
            
            // Test connection
            if (!self::$db->ping()) {
                throw new Exception("Database connection failed");
            }
            
            return self::$db;
            
        } catch (Exception $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new Exception("Failed to connect to database: " . $e->getMessage());
        }
    }
    
    /**
     * Get database connection instance
     * 
     * @return MysqliDb
     */
    public static function getConnection() {
        if (self::$db === null) {
            self::connect();
        }
        return self::$db;
    }
    
    /**
     * Load database configuration from config file
     * 
     * @throws Exception
     */
    private static function loadConfig() {
        $configFile = __DIR__ . '/../config/database.php';
        
        if (!file_exists($configFile)) {
            throw new Exception("Database configuration file not found: " . $configFile);
        }
        
        self::$config = require $configFile;
        
        if (!is_array(self::$config) || !isset(self::$config['database'])) {
            throw new Exception("Invalid database configuration format");
        }
    }
    
    /**
     * Apply database settings from configuration
     */
    private static function applySettings() {
        $settings = self::$config['settings'] ?? [];
        
        // Set auto reconnect
        if (isset($settings['auto_reconnect'])) {
            self::$db->autoReconnect = $settings['auto_reconnect'];
        }
        
        // Enable tracing if needed
        if (!empty($settings['enable_trace'])) {
            self::$db->setTrace(true);
        }
    }
    
    /**
     * Execute a raw SQL query
     * 
     * @param string $query
     * @param array $params
     * @return array|false
     */
    public static function query($query, $params = []) {
        $db = self::getConnection();
        return $db->rawQuery($query, $params);
    }
    
    /**
     * Execute a query and return single row
     * 
     * @param string $query
     * @param array $params
     * @return array|null
     */
    public static function queryOne($query, $params = []) {
        $db = self::getConnection();
        return $db->rawQueryOne($query, $params);
    }
    
    /**
     * Execute a query and return single value
     * 
     * @param string $query
     * @param array $params
     * @return mixed
     */
    public static function queryValue($query, $params = []) {
        $db = self::getConnection();
        return $db->rawQueryValue($query, $params);
    }
    
    /**
     * Begin transaction
     * 
     * @return bool
     */
    public static function beginTransaction() {
        $db = self::getConnection();
        return $db->startTransaction();
    }
    
    /**
     * Commit transaction
     * 
     * @return bool
     */
    public static function commit() {
        $db = self::getConnection();
        return $db->commit();
    }
    
    /**
     * Rollback transaction
     * 
     * @return bool
     */
    public static function rollback() {
        $db = self::getConnection();
        return $db->rollback();
    }
    
    /**
     * Get last error
     * 
     * @return string
     */
    public static function getLastError() {
        if (self::$db) {
            return self::$db->getLastError();
        }
        return '';
    }
    
    /**
     * Get last error number
     * 
     * @return int
     */
    public static function getLastErrno() {
        if (self::$db) {
            return self::$db->getLastErrno();
        }
        return 0;
    }
    
    /**
     * Get last executed query (for debugging)
     * 
     * @return string
     */
    public static function getLastQuery() {
        if (self::$db) {
            return self::$db->getLastQuery();
        }
        return '';
    }
    
    /**
     * Check if table exists
     * 
     * @param string $tableName
     * @return bool
     */
    public static function tableExists($tableName) {
        $db = self::getConnection();
        return $db->tableExists($tableName);
    }
    
    /**
     * Escape string for SQL queries
     * 
     * @param string $str
     * @return string
     */
    public static function escape($str) {
        $db = self::getConnection();
        return $db->escape($str);
    }
    
    /**
     * Close database connection
     */
    public static function disconnect() {
        if (self::$db) {
            self::$db->disconnect();
            self::$db = null;
        }
    }
    
    /**
     * Get trace information (for performance monitoring)
     * 
     * @return array
     */
    public static function getTrace() {
        if (self::$db) {
            return self::$db->trace;
        }
        return [];
    }
    
    /**
     * Prevent cloning
     */
    private function __clone() {}
    
    /**
     * Prevent unserialization
     */
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

/**
 * Helper function to get database connection
 * 
 * @return MysqliDb
 */
function db() {
    return Database::getConnection();
}

/**
 * Helper function for quick queries
 * 
 * @param string $query
 * @param array $params
 * @return array|false
 */
function dbQuery($query, $params = []) {
    return Database::query($query, $params);
}
?>
