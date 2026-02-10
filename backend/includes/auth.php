<?php
/**
 * Authentication Helper - Database Driven
 * Handles admin login/logout with database and password encryption
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database
require_once __DIR__ . '/db.php';

/**
 * Check if admin is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Verify admin credentials against database
 */
function verifyLogin($username, $password) {
    global $db;
    
    // Get admin user from database
    $admin = $db->where('username', $username)
                ->where('status', 'active')
                ->getOne('admin_users');
    //  print last query for debugging  
   //  echo $db->getLastQuery();exit;
    if (!$admin) {
        return false;
    }
  //  echo $password.' - '.$admin['password'];
   // var_dump(password_verify($password, $admin['password']));exit;
    // Verify password
    return password_verify($password, $admin['password']);
}

/**
 * Get admin user details by username
 */
function getAdminByUsername($username) {
    global $db;
    
    return $db->where('username', $username)
              ->where('status', 'active')
              ->getOne('admin_users');
}

/**
 * Login admin
 */
function loginAdmin($username) {
    $admin = getAdminByUsername($username);
    
    if ($admin) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_name'] = $admin['username'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_role'] = $admin['role'] ?? 'admin';
        $_SESSION['login_time'] = time();
        
        // Update last login
        updateLastLogin($admin['id']);
        
        return true;
    }
    
    return false;
}

/**
 * Logout admin
 */
function logoutAdmin() {
    session_unset();
    session_destroy();
}

/**
 * Require admin login (redirect if not logged in)
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Get current admin username
 */
function getAdminUsername() {
    return $_SESSION['admin_username'] ?? 'Admin';
}

/**
 * Get current admin name
 */
function getAdminName() {
    return $_SESSION['admin_name'] ?? getAdminUsername();
}

/**
 * Get current admin ID
 */
function getAdminId() {
    return $_SESSION['admin_id'] ?? 0;
}

/**
 * Get current admin role
 */
function getAdminRole() {
    return $_SESSION['admin_role'] ?? 'admin';
}

/**
 * Update last login timestamp
 */
function updateLastLogin($admin_id) {
    global $db;
    
    $data = [
        'last_login' => date('Y-m-d H:i:s')
    ];
    
    $db->where('id', $admin_id);
    $db->update('admin_users', $data);
}

/**
 * Hash password (for creating new admin users)
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}
