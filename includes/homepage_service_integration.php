<?php
/**
 * Homepage Service Integration
 * Functions to fetch and display services on homepage
 */

require_once __DIR__ . '/Database.php';

/**
 * Get featured services for homepage with today's order count
 * 
 * @return array Array of services with all display data
 */
function getHomepageServices() {
    $db = Database::getConnection();
    
    // Get services that should be shown on homepage
    $db->where('show_on_homepage', 1);
    $db->where('is_active', 1);
    $db->orderBy('homepage_order', 'ASC');
    
    $services = $db->get('services');
    
    if (!$services) {
        return [];
    }
    
    $result = [];
    
    foreach ($services as $service) {
        // Get today's order count for this service
        $todayCount = getTodayOrderCount($service['id']);
        
        // Get min and max package quantities for this service
        $packageRange = getPackageQuantityRange($service['id']);
        
        // Parse features JSON
        $features = json_decode($service['features'], true);
        if (!is_array($features)) {
            $features = [];
        }
        
        // Build service data array
        $result[] = [
            'id' => $service['id'],
            'emoji' => $service['emoji'] ?: '📱',
            'title' => $service['name'],
            'subtitle' => $service['subtitle'] ?: '',
            'badge' => $service['badge'] ?: '',
            'badge_class' => $service['badge_class'] ?: '',
            'rating' => '5.0', // Hardcoded as requested
            'reviews' => number_format($service['review_count']) . '+',
            'today' => '+' . number_format($todayCount) . ' today',
            'today_count' => $todayCount,
            'avatars' => generateRandomAvatars(3), // Random avatar IDs for display
            'features' => $features,
            'link' => Config::baseUrl() . $service['slug'],
            'avg_delivery' => $service['avg_delivery'] ?: '30 min',
            'min_quantity' => $packageRange['min'],
            'max_quantity' => $packageRange['max']
        ];
    }
    
    return $result;
}

/**
 * Get today's order count for a specific service
 * 
 * @param int $serviceId Service ID
 * @return int Number of orders today
 */
function getTodayOrderCount($serviceId) {
    $db = Database::getConnection();
    
    // Get service name to match with orders
    $service = $db->where('id', $serviceId)->getOne('services', 'name');
    
    if (!$service) {
        return 0;
    }
    
    // Count orders created today for this service
    $db->where('service_name', $service['name']);
    $db->where('DATE(created_at)', date('Y-m-d'));
    
    $count = $db->getValue('orders', 'COUNT(*)');
    
    return (int)$count ?: 0;
}

/**
 * Get package quantity range for a service
 * 
 * @param int $serviceId Service ID
 * @return array ['min' => int, 'max' => int]
 */
function getPackageQuantityRange($serviceId) {
    $db = Database::getConnection();
    
    $db->where('service_id', $serviceId);
    $db->where('is_active', 1);
    
    $result = $db->getOne('service_packages', 'MIN(quantity) as min_qty, MAX(quantity) as max_qty');
    
    if (!$result) {
        return ['min' => 0, 'max' => 0];
    }
    
    return [
        'min' => (int)$result['min_qty'],
        'max' => (int)$result['max_qty']
    ];
}

/**
 * Generate random avatar IDs for display
 * 
 * @param int $count Number of avatars
 * @return array Array of random numbers between 1-68
 */
function generateRandomAvatars($count = 3) {
    $avatars = [];
    for ($i = 0; $i < $count; $i++) {
        $avatars[] = rand(1, 68);
    }
    return $avatars;
}

/**
 * Get all orders count for today (global stat)
 * 
 * @return int Total orders today
 */
function getTotalOrdersToday() {
    $db = Database::getConnection();
    
    $db->where('DATE(created_at)', date('Y-m-d'));
    $count = $db->getValue('orders', 'COUNT(*)');
    
    return (int)$count ?: 0;
}

/**
 * Get total orders this week (global stat)
 * 
 * @return int Total orders this week
 */
function getTotalOrdersThisWeek() {
    $db = Database::getConnection();
    
    // Get start of current week (Monday)
    $startOfWeek = date('Y-m-d', strtotime('monday this week'));
    
    $db->where('DATE(created_at) >= ?', [$startOfWeek]);
    $count = $db->getValue('orders', 'COUNT(*)');
    
    return (int)$count ?: 0;
}

/**
 * Format number with K/M suffix
 * 
 * @param int $number Number to format
 * @return string Formatted number (e.g., "1.2K", "5M")
 */
function formatNumberShort($number) {
    if ($number >= 1000000) {
        return round($number / 1000000, 1) . 'M';
    } elseif ($number >= 1000) {
        return round($number / 1000, 1) . 'K';
    } else {
        return (string)$number;
    }
}
