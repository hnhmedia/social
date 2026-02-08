<?php
/**
 * Service-specific FAQ integration
 * Gets FAQs filtered by service type
 * Uses MysqliDb for database operations
 * 
 * Testimonials are handled by testimonial_integration.php
 */

require_once __DIR__ . '/Database.php';

/**
 * Get FAQs for a specific service
 * 
 * @param string $serviceType Service type (e.g., 'instagram_followers', 'instagram_likes')
 * @param int $limit Maximum number of FAQs to return
 * @return array Array of FAQ items with 'q' and 'a' keys
 */
function getServiceFaqs($serviceType, $limit = 20) {
    try {
        $db = Database::getConnection();
        
        // Get service-specific FAQs
        $db->where('service_type', $serviceType);
        $db->where('is_active', 1);
        $db->orderBy('display_order', 'ASC');
        $db->orderBy('id', 'ASC');
        $faqs = $db->get('faqs', $limit, 'question as q, answer as a');
        
        // If no service-specific FAQs found, return general FAQs
        if (empty($faqs)) {
            $db->where('service_type', 'general');
            $db->where('is_active', 1);
            $db->orderBy('display_order', 'ASC');
            $db->orderBy('id', 'ASC');
            $faqs = $db->get('faqs', $limit, 'question as q, answer as a');
        }
        
        return $faqs;
        
    } catch (Exception $e) {
        error_log("Error getting service FAQs: " . $e->getMessage());
        
        // Return default FAQs as fallback
        return [
            ['q' => 'How does this service work?', 'a' => 'Our service provides high-quality engagement from real accounts to help grow your social media presence.'],
            ['q' => 'Is this safe for my account?', 'a' => 'Yes! We use organic growth methods that comply with platform guidelines to ensure your account stays safe.'],
            ['q' => 'How quickly will I see results?', 'a' => 'Most orders begin processing within 60 seconds and complete within 1-24 hours depending on the package size.'],
        ];
    }
}
