<?php


/**
 * Get testimonials from database
 * 
 * @param int $limit Number of testimonials to retrieve
 * @param bool $featuredOnly Whether to get only featured testimonials
 * @return array Array of testimonials
 */
function getTestimonials($limit = null, $featuredOnly = true) {
    try {
        $db = Database::getConnection();
        
        // Build the query
        $db->where('active', 1);
        
        if ($featuredOnly) {
            $db->where('featured', 1);
        }
        
        $db->orderBy('created_at', 'DESC');
        
        return $db->get('testimonials', $limit);
        
    } catch (Exception $e) {
        error_log("Error loading testimonials: " . $e->getMessage());
        return [];
    }
}

/**
 * Get testimonials formatted for the existing site structure
 * This maintains compatibility with your current index.php format
 * 
 * @return array Array formatted like your original $testimonials array
 */
function getFormattedTestimonials() {
    $testimonials = getTestimonials(7, true); // Get 7 featured testimonials
    $formatted = [];
    
    foreach ($testimonials as $testimonial) {
        // Extract image number from avatar URL for compatibility
        $imgNumber = 12; // default
        if (preg_match('/img=(\d+)/', $testimonial['avatar_url'], $matches)) {
            $imgNumber = (int)$matches[1];
        }
        
        // Format date to match your original format
        $date = date('j F Y', strtotime($testimonial['created_at']));
        
        $formatted[] = [
            'name' => $testimonial['name'],
            'date' => $date,
            'img' => $imgNumber,
            'text' => $testimonial['content']
        ];
    }
    
    return $formatted;
}

/**
 * Get mini testimonials for the bottom section
 * 
 * @return array Array of mini testimonials
 */
function getMiniTestimonials($limit = 3) {
    try {
        $db = Database::getConnection();
        
        $db->where('active', 1);
        // $db->where('featured', 0); // Non-featured for mini section
        $db->orderBy('RAND()'); // Random order for variety
        
        return $db->get('testimonials', $limit);
        
    } catch (Exception $e) {
        error_log("Error loading mini testimonials: " . $e->getMessage());
        return [];
    }
}

/**
 * Create testimonial model for easier management
 */
class Testimonial {
    private $db;
    private $table = 'testimonials';
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    /**
     * Get all active testimonials
     */
    public function getActive($limit = null, $featured = null) {
        $this->db->where('active', 1);
        
        if ($featured !== null) {
            $this->db->where('featured', $featured ? 1 : 0);
        }
        
        $this->db->orderBy('created_at', 'DESC');
        return $this->db->get($this->table, $limit);
    }
    
    /**
     * Get testimonials by service type
     */
    public function getByServiceType($serviceType, $limit = null) {
        $this->db->where('active', 1);
        $this->db->where('service_type', $serviceType);
        $this->db->orderBy('rating', 'DESC');
        $this->db->orderBy('created_at', 'DESC');
        
        return $this->db->get($this->table, $limit);
    }
    
    /**
     * Get random testimonials for variety
     */
    public function getRandom($limit = 5) {
        $this->db->where('active', 1);
        $this->db->orderBy('RAND()');
        
        return $this->db->get($this->table, $limit);
    }
    
    /**
     * Create new testimonial
     */
    public function create($data) {
        $data['created_at'] = $this->db->now();
        return $this->db->insert($this->table, $data);
    }
}
?>