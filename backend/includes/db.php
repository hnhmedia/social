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
    return $db->orderBy('featured', 'DESC')->orderBy('created_at', 'DESC')->get('testimonials');
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
 * Get testimonial service types
 */
function getTestimonialServiceTypes() {
    global $db;
    $result = $db->rawQuery("SELECT DISTINCT service_type FROM testimonials WHERE service_type IS NOT NULL ORDER BY service_type");
    $types = [];
    if ($result) {
        foreach ($result as $row) {
            $types[] = $row['service_type'];
        }
    }
    return $types;
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
        'total_admins' => $db->getValue('admin_users', 'COUNT(*)'),
        'total_services' => $db->getValue('services', 'COUNT(*)')
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

// ============================================
// SERVICES FUNCTIONS
// ============================================

/**
 * Get all services (categories and services)
 */
function getAllServices() {
    global $db;
    return $db->orderBy('parent_id', 'ASC')->orderBy('display_order', 'ASC')->get('services');
}

/**
 * Get only categories (parent_id IS NULL)
 */
function getServiceCategories() {
    global $db;
    return $db->where('parent_id', NULL, 'IS')->orderBy('display_order', 'ASC')->get('services');
}

/**
 * Get services by category
 */
function getServicesByCategory($categoryId) {
    global $db;
    return $db->where('parent_id', $categoryId)->orderBy('display_order', 'ASC')->get('services');
}

/**
 * Get service by ID
 */
function getServiceById($id) {
    global $db;
    return $db->where('id', $id)->getOne('services');
}

/**
 * Add service
 */
function addService($data) {
    global $db;
    return $db->insert('services', $data);
}

/**
 * Update service
 */
function updateService($id, $data) {
    global $db;
    $db->where('id', $id);
    return $db->update('services', $data);
}

/**
 * Delete service
 */
function deleteService($id) {
    global $db;
    $db->where('id', $id);
    return $db->delete('services');
}

/**
 * Check if service has children
 */
function serviceHasChildren($id) {
    global $db;
    $count = $db->where('parent_id', $id)->getValue('services', 'COUNT(*)');
    return $count > 0;
}

/**
 * Get services with parent_id NOT NULL (actual services, not categories)
 */
function getActualServices() {
    global $db;
    return $db->where('parent_id', NULL, 'IS NOT')->orderBy('display_order', 'ASC')->get('services');
}

// ============================================
// SERVICE TAGS FUNCTIONS
// ============================================

/**
 * Get all service tags
 */
function getAllServiceTags() {
    global $db;
    return $db->orderBy('service_id', 'ASC')->orderBy('display_order', 'ASC')->get('service_tags');
}

/**
 * Get tags by service
 */
function getTagsByService($serviceId) {
    global $db;
    return $db->where('service_id', $serviceId)->orderBy('display_order', 'ASC')->get('service_tags');
}

/**
 * Get service tag by ID
 */
function getServiceTagById($id) {
    global $db;
    return $db->where('id', $id)->getOne('service_tags');
}

/**
 * Add service tag
 */
function addServiceTag($data) {
    global $db;
    return $db->insert('service_tags', $data);
}

/**
 * Update service tag
 */
function updateServiceTag($id, $data) {
    global $db;
    $db->where('id', $id);
    return $db->update('service_tags', $data);
}

/**
 * Delete service tag
 */
function deleteServiceTag($id) {
    global $db;
    $db->where('id', $id);
    return $db->delete('service_tags');
}

// ============================================
// SERVICE PACKAGES FUNCTIONS
// ============================================

/**
 * Get all service packages
 */
function getAllServicePackages() {
    global $db;
    return $db->orderBy('service_id', 'ASC')->orderBy('display_order', 'ASC')->get('service_packages');
}

/**
 * Get packages by service
 */
function getPackagesByService($serviceId) {
    global $db;
    return $db->where('service_id', $serviceId)->orderBy('display_order', 'ASC')->get('service_packages');
}

/**
 * Get service package by ID
 */
function getServicePackageById($id) {
    global $db;
    return $db->where('id', $id)->getOne('service_packages');
}

/**
 * Add service package
 */
function addServicePackage($data) {
    global $db;
    return $db->insert('service_packages', $data);
}

/**
 * Update service package
 */
function updateServicePackage($id, $data) {
    global $db;
    $db->where('id', $id);
    return $db->update('service_packages', $data);
}

/**
 * Delete service package
 */
function deleteServicePackage($id) {
    global $db;
    $db->where('id', $id);
    return $db->delete('service_packages');
}
