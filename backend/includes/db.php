<?php
/**
 * Database Helper for Admin Panel
 * Connects to main database and provides helper functions
 */

// Include main database config
$config = require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/MysqliDb.php';

// Initialize database connection
$db = new MysqliDb(
    $config['database']['host'],
    $config['database']['username'],
    $config['database']['password'],
    $config['database']['db']
);

// Set table prefix
$db->setPrefix($config['database']['prefix']);

/**
 * Get all users
 */
function getAllUsers() {
    global $db;
    return $db->orderBy('created_at', 'DESC')->get('users');
}

/**
 * Get all orders
 */
function getAllOrders() {
    global $db;
    return $db->orderBy('created_at', 'DESC')->get('orders');
}

/**
 * Get all FAQs
 */
function getAllFaqs() {
    global $db;
    return $db->orderBy('sort_order', 'ASC')->get('faqs');
}

/**
 * Get FAQ by ID
 */
function getFaqById($id) {
    global $db;
    return $db->where('id', $id)->getOne('faqs');
}

/**
 * Add FAQ
 */
function addFaq($question, $answer, $category = 'general', $sort_order = 0, $active = 1, $featured = 0) {
    global $db;
    $data = [
        'question' => $question,
        'answer' => $answer,
        'category' => $category,
        'sort_order' => $sort_order,
        'active' => $active,
        'featured' => $featured
    ];
    return $db->insert('faqs', $data);
}

/**
 * Update FAQ
 */
function updateFaq($id, $question, $answer, $category, $sort_order, $active, $featured) {
    global $db;
    $data = [
        'question' => $question,
        'answer' => $answer,
        'category' => $category,
        'sort_order' => $sort_order,
        'active' => $active,
        'featured' => $featured
    ];
    $db->where('id', $id);
    return $db->update('faqs', $data);
}

/**
 * Delete FAQ
 */
function deleteFaq($id) {
    global $db;
    $db->where('id', $id);
    return $db->delete('faqs');
}

/**
 * Get FAQ categories
 */
function getFaqCategories() {
    global $db;
    // Use just 'faqs' - MysqliDb will automatically add the prefix
    $result = $db->rawQuery("SELECT DISTINCT category FROM faqs WHERE category IS NOT NULL ORDER BY category");
    $categories = [];
    if ($result) {
        foreach ($result as $row) {
            $categories[] = $row['category'];
        }
    }
    return $categories;
}

/**
 * Get all testimonials
 */
function getAllTestimonials() {
    global $db;
    // Order by featured first, then by id descending
    return $db->orderBy('featured', 'DESC')->orderBy('id', 'DESC')->get('testimonials');
}

/**
 * Get testimonial by ID
 */
function getTestimonialById($id) {
    global $db;
    return $db->where('id', $id)->getOne('testimonials');
}

/**
 * Add testimonial
 */
function addTestimonial($name, $content, $rating = 5, $email = null, $service_type = null, $title = null, $avatar_url = null, $active = 0, $featured = 0, $user_id = null) {
    global $db;
    $data = [
        'name' => $name,
        'content' => $content,
        'rating' => $rating,
        'email' => $email,
        'service_type' => $service_type,
        'title' => $title,
        'avatar_url' => $avatar_url,
        'active' => $active,
        'featured' => $featured,
        'user_id' => $user_id
    ];
    return $db->insert('testimonials', $data);
}

/**
 * Update testimonial
 */
function updateTestimonial($id, $name, $content, $rating, $email, $service_type, $title, $avatar_url, $active, $featured, $user_id = null) {
    global $db;
    $data = [
        'name' => $name,
        'content' => $content,
        'rating' => $rating,
        'email' => $email,
        'service_type' => $service_type,
        'title' => $title,
        'avatar_url' => $avatar_url,
        'active' => $active,
        'featured' => $featured,
        'user_id' => $user_id
    ];
    $db->where('id', $id);
    return $db->update('testimonials', $data);
}

/**
 * Delete testimonial
 */
function deleteTestimonial($id) {
    global $db;
    $db->where('id', $id);
    return $db->delete('testimonials');
}

/**
 * Get dashboard stats
 */
function getDashboardStats() {
    global $db;
    
    return [
        'total_users' => $db->getValue('users', 'COUNT(*)'),
        'total_orders' => $db->getValue('orders', 'COUNT(*)'),
        'total_faqs' => $db->getValue('faqs', 'COUNT(*)'),
        'total_testimonials' => $db->getValue('testimonials', 'COUNT(*)'),
        'total_admins' => $db->getValue('admin_users', 'COUNT(*)')
    ];
}

/**
 * Get all admin users
 */
function getAllAdminUsers() {
    global $db;
    return $db->orderBy('created_at', 'DESC')->get('admin_users');
}

/**
 * Get admin user by ID
 */
function getAdminUserById($id) {
    global $db;
    return $db->where('id', $id)->getOne('admin_users');
}

/**
 * Create admin user
 */
function createAdminUser($username, $password, $name, $email, $role = 'admin') {
    global $db;
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    
    $data = [
        'username' => $username,
        'password' => $hashedPassword,
        'name' => $name,
        'email' => $email,
        'role' => $role,
        'status' => 'active',
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    return $db->insert('admin_users', $data);
}

/**
 * Update admin user
 */
function updateAdminUser($id, $name, $email, $role, $status) {
    global $db;
    
    $data = [
        'name' => $name,
        'email' => $email,
        'role' => $role,
        'status' => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $db->where('id', $id);
    return $db->update('admin_users', $data);
}

/**
 * Update admin password
 */
function updateAdminPassword($id, $newPassword) {
    global $db;
    
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
    
    $data = [
        'password' => $hashedPassword,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    $db->where('id', $id);
    return $db->update('admin_users', $data);
}

/**
 * Delete admin user
 */
function deleteAdminUser($id) {
    global $db;
    $db->where('id', $id);
    return $db->delete('admin_users');
}

/**
 * Check if admin table exists
 */
function adminTableExists() {
    global $db;
    
    $result = $db->rawQuery("SHOW TABLES LIKE 'si_admin_users'");
    return count($result) > 0;
}
