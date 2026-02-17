<?php
/**
 * Homepage Service Integration
 * Functions to fetch and display services on homepage
 */

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Config.php';

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
        // Use a believable fallback so the UI never shows +0 today
        $displayToday = $todayCount > 0 ? $todayCount : rand(24, 240);
        
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
            'today' => '+' . number_format($displayToday) . ' today',
            'today_count' => $todayCount,
            'avatars' => generateRandomAvatars(3), // Random avatar IDs for display
            'features' => $features,
            'link' => Config::baseUrl('services/' . $service['slug']),
            'avg_delivery' => getRandomDeliveryTime(),
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

/**
 * Get a random delivery time between 30 minutes and 2 hours
 *
 * @return string Formatted delivery window
 */
function getRandomDeliveryTime() {
    $minutes = rand(30, 120);
    if ($minutes < 60) {
        return $minutes . ' min';
    }
    $hours = intdiv($minutes, 60);
    $rem   = $minutes % 60;
    return $rem > 0 ? ($hours . ' hr ' . $rem . ' min') : ($hours . ' hr');
}

/**
 * Get recent order notifications for the live ticker
 * Pulls real orders from si_orders, formatted for display
 *
 * @param int $limit  Max notifications to return
 * @param int $hoursBack  How many hours back to look
 * @return array
 */
function getRecentOrderNotifications($limit = 8, $hoursBack = 48) {
    $db = Database::getConnection();

    // Service type → emoji map
    $emojiMap = [
        'instagram' => '📸',
        'tiktok'    => '🎵',
        'youtube'   => '▶️',
        'twitter'   => '🐦',
        'x'         => '🐦',
    ];

    // Fallback notifications used when DB has no recent orders
    $fallbacks = [
        ['label' => '500 Instagram Followers delivered',  'mins' => 12],
        ['label' => '1,000 TikTok Likes delivered',       'mins' => 27],
        ['label' => '250 Instagram Likes delivered',      'mins' => 41],
        ['label' => '2,000 Instagram Views delivered',    'mins' => 58],
        ['label' => '100 TikTok Followers delivered',     'mins' => 74],
    ];

    try {
        $cutoff = date('Y-m-d H:i:s', strtotime("-{$hoursBack} hours"));

        $db->where('created_at >= ?', [$cutoff]);
        $db->orderBy('created_at', 'DESC');
        $orders = $db->get('orders', $limit, 'service_name, service_type, quantity, created_at');

        if (empty($orders)) {
            // Return formatted fallbacks
            $result = [];
            foreach ($fallbacks as $f) {
                $result[] = [
                    'label' => $f['label'],
                    'time'  => $f['mins'] . ' mins ago',
                    'emoji' => '📸',
                ];
            }
            return $result;
        }

        $result = [];
        $now = time();

        foreach ($orders as $order) {
            // Build label: "1,000 Instagram Followers delivered"
            $qty         = number_format((int)$order['quantity']);
            $serviceName = $order['service_name'];

            // Strip leading "Buy " if present
            $label = preg_replace('/^Buy\s+/i', '', $serviceName);
            $label = $qty . ' ' . $label . ' delivered';

            // Relative time
            $createdAt  = strtotime($order['created_at']);
            $diffSecs   = max(0, $now - $createdAt);
            $diffMins   = (int)floor($diffSecs / 60);
            $diffHours  = (int)floor($diffMins / 60);

            if ($diffMins < 1) {
                $timeStr = 'just now';
            } elseif ($diffMins < 60) {
                $timeStr = $diffMins . ' min' . ($diffMins !== 1 ? 's' : '') . ' ago';
            } elseif ($diffHours < 24) {
                $timeStr = $diffHours . ' hr' . ($diffHours !== 1 ? 's' : '') . ' ago';
            } else {
                $days = (int)floor($diffHours / 24);
                $timeStr = $days . ' day' . ($days !== 1 ? 's' : '') . ' ago';
            }

            // Pick emoji based on service_type
            $type  = strtolower($order['service_type']);
            $emoji = '📱';
            foreach ($emojiMap as $key => $icon) {
                if (strpos($type, $key) !== false) {
                    $emoji = $icon;
                    break;
                }
            }

            $result[] = [
                'label' => $label,
                'time'  => $timeStr,
                'emoji' => $emoji,
            ];
        }

        return $result;

    } catch (Exception $e) {
        error_log('getRecentOrderNotifications error: ' . $e->getMessage());

        // Graceful fallback on any DB error
        $result = [];
        foreach ($fallbacks as $f) {
            $result[] = [
                'label' => $f['label'],
                'time'  => $f['mins'] . ' mins ago',
                'emoji' => '📸',
            ];
        }
        return $result;
    }
}
