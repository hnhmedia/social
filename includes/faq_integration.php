<?php


/**
 * Get FAQs from database
 * 
 * @param int $limit Number of FAQs to retrieve
 * @param bool $featuredOnly Whether to get only featured FAQs
 * @param string $category Filter by specific category
 * @return array Array of FAQs
 */
function getFaqs($limit = null, $featuredOnly = true, $category = null) {
    try {
        $db = Database::getConnection();
        
        // Build the query
        $db->where('active', 1);
        
        if ($featuredOnly) {
            $db->where('featured', 1);
        }
        
        if ($category) {
            $db->where('category', $category);
        }
        
        $db->orderBy('sort_order', 'ASC');
        $db->orderBy('created_at', 'ASC');
        
        return $db->get('faqs', $limit);
        
    } catch (Exception $e) {
        error_log("Error loading FAQs: " . $e->getMessage());
        return [];
    }
}

/**
 * Get FAQs formatted for the existing site structure
 * This maintains compatibility with your current index.php format
 * 
 * @return array Array formatted like your original $faqs array
 */
function getFormattedFaqs() { 
    $faqs = getFaqs(8, true); // Get 8 featured FAQs
    $formatted = [];
    
    foreach ($faqs as $faq) {
        $formatted[] = [
            'q' => $faq['question'],
            'a' => $faq['answer']
        ];
    }
    
    return $formatted;
}

/**
 * Get FAQs by category
 * 
 * @param string $category Category name
 * @param int $limit Number of FAQs to retrieve
 * @return array Array of FAQs
 */
function getFaqsByCategory($category, $limit = null) {
    try {
        $db = Database::getConnection();
        
        $db->where('active', 1);
        $db->where('category', $category);
        $db->orderBy('sort_order', 'ASC');
        
        return $db->get('faqs', $limit);
        
    } catch (Exception $e) {
        error_log("Error loading FAQs by category: " . $e->getMessage());
        return [];
    }
}

/**
 * Get all FAQ categories
 * 
 * @return array Array of unique categories
 */
function getFaqCategories() {
    try {
        $db = Database::getConnection();
        
        $db->where('active', 1);
        $db->groupBy('category');
        $db->orderBy('category', 'ASC');
        
        $results = $db->get('faqs', null, 'category');
        
        $categories = [];
        foreach ($results as $result) {
            $categories[] = $result['category'];
        }
        
        return $categories;
        
    } catch (Exception $e) {
        error_log("Error loading FAQ categories: " . $e->getMessage());
        return [];
    }
}

/**
 * Search FAQs
 * 
 * @param string $query Search term
 * @param int $limit Number of results
 * @return array Array of matching FAQs
 */
function searchFaqs($query, $limit = 10) {
    try {
        $db = Database::getConnection();
        
        $db->where('active', 1);
        $db->where('(question LIKE ? OR answer LIKE ?)', ["%{$query}%", "%{$query}%"]);
        $db->orderBy('sort_order', 'ASC');
        
        return $db->get('faqs', $limit);
        
    } catch (Exception $e) {
        error_log("Error searching FAQs: " . $e->getMessage());
        return [];
    }
}

/**
 * Create FAQ model for easier management
 */
class Faq {
    private $db;
    private $table = 'faqs';
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    /**
     * Get all active FAQs
     */
    public function getActive($limit = null, $featured = null, $category = null) {
        $this->db->where('active', 1);
        
        if ($featured !== null) {
            $this->db->where('featured', $featured ? 1 : 0);
        }
        
        if ($category) {
            $this->db->where('category', $category);
        }
        
        $this->db->orderBy('sort_order', 'ASC');
        $this->db->orderBy('created_at', 'ASC');
        
        return $this->db->get($this->table, $limit);
    }
    
    /**
     * Get FAQ by ID
     */
    public function getById($id) {
        $this->db->where('id', $id);
        $this->db->where('active', 1);
        return $this->db->getOne($this->table);
    }
    
    /**
     * Create new FAQ
     */
    public function create($data) {
        $data['created_at'] = $this->db->now();
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * Update FAQ
     */
    public function update($id, $data) {
        unset($data['id'], $data['created_at']);
        $data['updated_at'] = $this->db->now();
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Delete FAQ
     */
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    /**
     * Get FAQ statistics
     */
    public function getStats() {
        $stats = [];
        
        // Total FAQs
        $stats['total'] = $this->db->getValue($this->table, "COUNT(*)");
        
        // Active FAQs
        $this->db->where('active', 1);
        $stats['active'] = $this->db->getValue($this->table, "COUNT(*)");
        
        // Featured FAQs
        $this->db->where('active', 1);
        $this->db->where('featured', 1);
        $stats['featured'] = $this->db->getValue($this->table, "COUNT(*)");
        
        // Categories count
        $stats['categories'] = count($this->getCategories());
        
        return $stats;
    }
    
    /**
     * Get unique categories
     */
    public function getCategories() {
        $this->db->where('active', 1);
        $this->db->groupBy('category');
        $this->db->orderBy('category', 'ASC');
        
        $results = $this->db->get($this->table, null, 'category');
        
        $categories = [];
        foreach ($results as $result) {
            $categories[] = $result['category'];
        }
        
        return $categories;
    }
    
    /**
     * Reorder FAQs
     */
    public function reorder($orders) {
        try {
            $this->db->startTransaction();
            
            foreach ($orders as $id => $order) {
                $this->db->where('id', $id);
                $this->db->update($this->table, ['sort_order' => $order]);
            }
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
}


?>