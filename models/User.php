<?php
/**
 * User Model
 * 
 * Handles all user-related database operations for the Famoid system
 */

require_once __DIR__ . '/../includes/Database.php';

class User {
    
    private $db;
    private $table = 'users';
    
    // User properties
    public $id;
    public $name;
    public $email;
    public $password;
    public $active;
    public $created_at;
    public $updated_at;
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    /**
     * Create a new user
     * 
     * @param array $userData
     * @return int|false User ID on success, false on failure
     */
    public function create($userData) {
        // Validate required fields
        if (!isset($userData['name']) || !isset($userData['email']) || !isset($userData['password'])) {
            throw new Exception("Name, email, and password are required");
        }
        
        // Hash password
        $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        $userData['created_at'] = $this->db->now();
        
        return $this->db->insert($this->table, $userData);
    }
    
    /**
     * Find user by ID
     * 
     * @param int $id
     * @return array|null
     */
    public function findById($id) {
        $this->db->where('id', $id);
        return $this->db->getOne($this->table);
    }
    
    /**
     * Find user by email
     * 
     * @param string $email
     * @return array|null
     */
    public function findByEmail($email) {
        $this->db->where('email', $email);
        return $this->db->getOne($this->table);
    }
    
    /**
     * Get all active users
     * 
     * @param int $limit
     * @return array
     */
    public function getActiveUsers($limit = null) {
        $this->db->where('active', 1);
        $this->db->orderBy('created_at', 'DESC');
        return $this->db->get($this->table, $limit);
    }
    
    /**
     * Update user information
     * 
     * @param int $id
     * @param array $userData
     * @return bool
     */
    public function update($id, $userData) {
        // Don't allow updating of certain fields
        unset($userData['id'], $userData['created_at']);
        
        $userData['updated_at'] = $this->db->now();
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $userData);
    }
    
    /**
     * Deactivate user (soft delete)
     * 
     * @param int $id
     * @return bool
     */
    public function deactivate($id) {
        return $this->update($id, ['active' => 0]);
    }
    
    /**
     * Activate user
     * 
     * @param int $id
     * @return bool
     */
    public function activate($id) {
        return $this->update($id, ['active' => 1]);
    }
    
    /**
     * Permanently delete user
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Authenticate user
     * 
     * @param string $email
     * @param string $password
     * @return array|false User data on success, false on failure
     */
    public function authenticate($email, $password) {
        $user = $this->findByEmail($email);
        
        if (!$user || !$user['active']) {
            return false;
        }
        
        if (password_verify($password, $user['password'])) {
            // Don't return password in user data
            unset($user['password']);
            return $user;
        }
        
        return false;
    }
    
    /**
     * Check if email already exists
     * 
     * @param string $email
     * @param int $excludeId Optional user ID to exclude from check
     * @return bool
     */
    public function emailExists($email, $excludeId = null) {
        $this->db->where('email', $email);
        
        if ($excludeId) {
            $this->db->where('id', $excludeId, '!=');
        }
        
        return $this->db->has($this->table);
    }
    
    /**
     * Get user statistics
     * 
     * @return array
     */
    public function getStats() {
        $stats = [];
        
        // Total users
        $stats['total'] = $this->db->getValue($this->table, "COUNT(*)");
        
        // Active users
        $this->db->where('active', 1);
        $stats['active'] = $this->db->getValue($this->table, "COUNT(*)");
        
        // Users registered today
        $this->db->where('created_at', $this->db->now(), '>=');
        $stats['today'] = $this->db->getValue($this->table, "COUNT(*)");
        
        return $stats;
    }
    
    /**
     * Search users
     * 
     * @param string $query
     * @param int $limit
     * @return array
     */
    public function search($query, $limit = 50) {
        $this->db->where('(name LIKE ? OR email LIKE ?)', ["%{$query}%", "%{$query}%"]);
        $this->db->orderBy('name', 'ASC');
        return $this->db->get($this->table, $limit);
    }
    
    /**
     * Update last login time
     * 
     * @param int $id
     * @return bool
     */
    public function updateLastLogin($id) {
        return $this->update($id, ['last_login' => $this->db->now()]);
    }
}
?>
