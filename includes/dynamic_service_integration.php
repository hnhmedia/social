<?php
/**
 * Clean Dynamic Service Integration
 * Works with parent-child services table
 */

require_once __DIR__ . '/Database.php';

/**
 * Get service by slug
 * 
 * @param string $slug Service slug
 * @return array|null Service data
 */
function getServiceBySlug($slug) {
    try {
        $db = Database::getConnection();
        
        $db->where('slug', $slug);
        $db->where('is_active', 1);
        $service = $db->getOne('services');
        
        return $service;
        
    } catch (Exception $e) {
        error_log("Error getting service by slug: " . $e->getMessage());
        return null;
    }
}

/**
 * Get all categories (parent_id = NULL)
 * 
 * @return array Categories
 */
function getServiceCategories() {
    try {
        $db = Database::getConnection();
        
        $db->where('parent_id', NULL, 'IS');
        $db->where('is_active', 1);
        $db->orderBy('display_order', 'ASC');
        $categories = $db->get('services');
        
        return $categories ?: [];
        
    } catch (Exception $e) {
        error_log("Error getting categories: " . $e->getMessage());
        return [];
    }
}

/**
 * Get all services under a category
 * 
 * @param int $categoryId Category ID
 * @return array Services
 */
function getServicesByCategory($categoryId) {
    try {
        $db = Database::getConnection();
        
        $db->where('parent_id', $categoryId);
        $db->where('is_active', 1);
        $db->orderBy('display_order', 'ASC');
        $services = $db->get('services');
        
        return $services ?: [];
        
    } catch (Exception $e) {
        error_log("Error getting services by category: " . $e->getMessage());
        return [];
    }
}

/**
 * Get service tags with parsed features
 * 
 * @param int $serviceId Service ID
 * @return array Service tags with features array
 */
function getServiceTags($serviceId) {
    try {
        $db = Database::getConnection();
        
        $db->where('service_id', $serviceId);
        $db->where('is_active', 1);
        $db->orderBy('display_order', 'ASC');
        $tags = $db->get('service_tags');
        
        // Parse tag_description into features array
        if ($tags) {
            foreach ($tags as &$tag) {
                if (!empty($tag['tag_description'])) {
                    // Split by comma to get individual features
                    $tag['features'] = array_map('trim', explode(',', $tag['tag_description']));
                } else {
                    $tag['features'] = [];
                }
            }
        }
        
        return $tags ?: [];
        
    } catch (Exception $e) {
        error_log("Error getting service tags: " . $e->getMessage());
        return [];
    }
}

/**
 * Get packages for a service tag
 * 
 * @param int $serviceId Service ID
 * @param int $tagId Tag ID (optional)
 * @return array Packages
 */
function getServicePackages($serviceId, $tagId = null) {
    try {
        $db = Database::getConnection();
        
        $db->where('service_id', $serviceId);
        if ($tagId) {
            $db->where('tag_id', $tagId);
        }
        $db->where('is_active', 1);
        $db->orderBy('display_order', 'ASC');
        $packages = $db->get('service_packages');
        
        return $packages ?: [];
        
    } catch (Exception $e) {
        error_log("Error getting service packages: " . $e->getMessage());
        return [];
    }
}

/**
 * Get all categories with their services (for mega menu)
 * 
 * @return array Categories with nested services
 */
function getAllServicesHierarchy() { 
        $db = Database::getConnection();
        
        // Get categories
        $db->where('parent_id', NULL, 'IS');
        $db->where('is_active', 1);
        $db->orderBy('display_order', 'ASC');
        $categories = $db->get('services');
        
        if ($categories) {
            foreach ($categories as &$category) {
                // Get services for each category
                $category['services'] = getServicesByCategory($category['id']);
            }
        }
        
        return $categories ?: [];
        
    
}

/**
 * Format packages for JavaScript (for tab switching)
 * 
 * @param array $tags Service tags
 * @return array Formatted packages by tag slug
 */
function formatPackagesForJS($tags) {
    $formatted = [];
    
    foreach ($tags as $tag) {
        $packages = getServicePackages($tag['service_id'], $tag['id']);
        $tagPackages = [];
        
        foreach ($packages as $package) {
            $tagPackages[] = [
                'qty' => (int)$package['quantity'],
                'price' => (float)$package['price'],
                'label' => $package['discount_label'] ?: ''
            ];
        }
        
        $formatted[$tag['tag_slug']] = $tagPackages;
    }
    
    return $formatted;
}

/**
 * Get featured services for homepage
 * 
 * @param int $limit Number of services to return
 * @return array Featured services
 */
function getFeaturedServices($limit = 6) {
    try {
        $db = Database::getConnection();
        
        // Get only child records (services, not categories)
        $db->where('parent_id', NULL, 'IS NOT');
        $db->where('is_active', 1);
        $db->where('is_featured', 1);
        $db->orderBy('display_order', 'ASC');
        $services = $db->get('services', $limit);
        
        return $services ?: [];
        
    } catch (Exception $e) {
        error_log("Error getting featured services: " . $e->getMessage());
        return [];
    }
}

/**
 * Get parent category for a service
 * 
 * @param int $serviceId Service ID
 * @return array|null Parent category
 */
function getServiceParent($serviceId) {
    try {
        $db = Database::getConnection();
        
        // First get the service to find parent_id
        $service = $db->where('id', $serviceId)->getOne('services');
        
        if ($service && $service['parent_id']) {
            // Get parent category
            $parent = $db->where('id', $service['parent_id'])->getOne('services');
            return $parent;
        }
        
        return null;
        
    } catch (Exception $e) {
        error_log("Error getting service parent: " . $e->getMessage());
        return null;
    }
}

/**
 * Check if service is a category (has no parent)
 * 
 * @param int $serviceId Service ID
 * @return bool True if category
 */
function isServiceCategory($serviceId) {
    try {
        $db = Database::getConnection();
        
        $service = $db->where('id', $serviceId)->getOne('services', 'parent_id');
        
        return $service && is_null($service['parent_id']);
        
    } catch (Exception $e) {
        error_log("Error checking if service is category: " . $e->getMessage());
        return false;
    }
}

/**
 * Get breadcrumb for a service
 * 
 * @param string $slug Service slug
 * @return array Breadcrumb array
 */
function getServiceBreadcrumb($slug) {
    $breadcrumb = [
        ['name' => 'Home', 'url' => '/']
    ];
    
    try {
        $service = getServiceBySlug($slug);
        
        if ($service && $service['parent_id']) {
            // Get parent category
            $parent = getServiceParent($service['id']);
            if ($parent) {
                $breadcrumb[] = [
                    'name' => $parent['name'],
                    'url' => '/' . $parent['slug']
                ];
            }
            
            // Add current service
            $breadcrumb[] = [
                'name' => $service['name'],
                'url' => '/' . $service['slug']
            ];
        }
        
        return $breadcrumb;
        
    } catch (Exception $e) {
        error_log("Error getting breadcrumb: " . $e->getMessage());
        return $breadcrumb;
    }
}
