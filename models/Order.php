<?php
/**
 * Order Model
 * 
 * Handles all order-related database operations for social media services
 */

require_once __DIR__ . '/../includes/Database.php';

class Order {
    
    private $db;
    private $table = 'orders';
    
    // Order statuses
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';
    
    // Service types
    const TYPE_INSTAGRAM_FOLLOWERS = 'instagram_followers';
    const TYPE_INSTAGRAM_LIKES = 'instagram_likes';
    const TYPE_INSTAGRAM_VIEWS = 'instagram_views';
    const TYPE_TIKTOK_FOLLOWERS = 'tiktok_followers';
    const TYPE_TIKTOK_LIKES = 'tiktok_likes';
    const TYPE_TIKTOK_VIEWS = 'tiktok_views';
    
    public function __construct() {
        $this->db = Database::getConnection();
    }
    
    /**
     * Create a new order
     * 
     * @param array $orderData
     * @return int|false Order ID on success, false on failure
     */
    public function create($orderData) {
        // Validate required fields
        $required = ['user_id', 'service_type', 'quantity', 'price', 'target_url'];
        foreach ($required as $field) {
            if (!isset($orderData[$field])) {
                throw new Exception("Field {$field} is required");
            }
        }
        
        // Set default values
        $orderData['status'] = $orderData['status'] ?? self::STATUS_PENDING;
        $orderData['order_number'] = $this->generateOrderNumber();
        $orderData['created_at'] = $this->db->now();
        
        return $this->db->insert($this->table, $orderData);
    }
    
    /**
     * Find order by ID
     * 
     * @param int $id
     * @return array|null
     */
    public function findById($id) {
        $this->db->where('id', $id);
        return $this->db->getOne($this->table);
    }
    
    /**
     * Find order by order number
     * 
     * @param string $orderNumber
     * @return array|null
     */
    public function findByOrderNumber($orderNumber) {
        $this->db->where('order_number', $orderNumber);
        return $this->db->getOne($this->table);
    }
    
    /**
     * Get orders for a specific user
     * 
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function getUserOrders($userId, $limit = null) {
        $this->db->where('user_id', $userId);
        $this->db->orderBy('created_at', 'DESC');
        return $this->db->get($this->table, $limit);
    }
    
    /**
     * Get orders by status
     * 
     * @param string $status
     * @param int $limit
     * @return array
     */
    public function getOrdersByStatus($status, $limit = null) {
        $this->db->where('status', $status);
        $this->db->orderBy('created_at', 'ASC');
        return $this->db->get($this->table, $limit);
    }
    
    /**
     * Update order status
     * 
     * @param int $id
     * @param string $status
     * @param array $additionalData
     * @return bool
     */
    public function updateStatus($id, $status, $additionalData = []) {
        $updateData = array_merge($additionalData, [
            'status' => $status,
            'updated_at' => $this->db->now()
        ]);
        
        // Set completion time if order is completed
        if ($status === self::STATUS_COMPLETED) {
            $updateData['completed_at'] = $this->db->now();
        }
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $updateData);
    }
    
    /**
     * Update order progress
     * 
     * @param int $id
     * @param int $delivered
     * @param int $remaining
     * @return bool
     */
    public function updateProgress($id, $delivered, $remaining = null) {
        $order = $this->findById($id);
        if (!$order) {
            return false;
        }
        
        $remaining = $remaining ?? ($order['quantity'] - $delivered);
        
        $updateData = [
            'delivered' => $delivered,
            'remaining' => $remaining,
            'updated_at' => $this->db->now()
        ];
        
        // Auto-complete if fully delivered
        if ($remaining <= 0) {
            $updateData['status'] = self::STATUS_COMPLETED;
            $updateData['completed_at'] = $this->db->now();
        }
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $updateData);
    }
    
    /**
     * Cancel order
     * 
     * @param int $id
     * @param string $reason
     * @return bool
     */
    public function cancel($id, $reason = '') {
        return $this->updateStatus($id, self::STATUS_CANCELLED, [
            'cancellation_reason' => $reason,
            'cancelled_at' => $this->db->now()
        ]);
    }
    
    /**
     * Refund order
     * 
     * @param int $id
     * @param float $refundAmount
     * @param string $reason
     * @return bool
     */
    public function refund($id, $refundAmount, $reason = '') {
        return $this->updateStatus($id, self::STATUS_REFUNDED, [
            'refund_amount' => $refundAmount,
            'refund_reason' => $reason,
            'refunded_at' => $this->db->now()
        ]);
    }
    
    /**
     * Get order statistics
     * 
     * @return array
     */
    public function getStats() {
        $stats = [];
        
        // Total orders
        $stats['total'] = $this->db->getValue($this->table, "COUNT(*)");
        
        // Orders by status
        $statuses = [self::STATUS_PENDING, self::STATUS_PROCESSING, self::STATUS_COMPLETED, self::STATUS_CANCELLED];
        foreach ($statuses as $status) {
            $this->db->where('status', $status);
            $stats[$status] = $this->db->getValue($this->table, "COUNT(*)");
        }
        
        // Total revenue
        $this->db->where('status', [self::STATUS_COMPLETED, self::STATUS_PROCESSING], 'IN');
        $stats['revenue'] = $this->db->getValue($this->table, "SUM(price)") ?: 0;
        
        // Orders today
        $this->db->where('DATE(created_at) = CURDATE()');
        $stats['today'] = $this->db->getValue($this->table, "COUNT(*)");
        
        return $stats;
    }
    
    /**
     * Search orders
     * 
     * @param string $query
     * @param int $limit
     * @return array
     */
    public function search($query, $limit = 50) {
        $this->db->where('(order_number LIKE ? OR target_url LIKE ? OR service_type LIKE ?)', 
                        ["%{$query}%", "%{$query}%", "%{$query}%"]);
        $this->db->orderBy('created_at', 'DESC');
        return $this->db->get($this->table, $limit);
    }
    
    /**
     * Get orders with user information
     * 
     * @param int $limit
     * @param array $filters
     * @return array
     */
    public function getOrdersWithUsers($limit = null, $filters = []) {
        $this->db->join('users u', 'o.user_id = u.id', 'LEFT');
        
        // Apply filters
        if (!empty($filters['status'])) {
            $this->db->where('o.status', $filters['status']);
        }
        
        if (!empty($filters['service_type'])) {
            $this->db->where('o.service_type', $filters['service_type']);
        }
        
        if (!empty($filters['date_from'])) {
            $this->db->where('DATE(o.created_at) >= ?', [$filters['date_from']]);
        }
        
        if (!empty($filters['date_to'])) {
            $this->db->where('DATE(o.created_at) <= ?', [$filters['date_to']]);
        }
        
        $this->db->orderBy('o.created_at', 'DESC');
        
        return $this->db->get($this->table . ' o', $limit, 
            'o.*, u.name as user_name, u.email as user_email');
    }
    
    /**
     * Get revenue by date range
     * 
     * @param string $dateFrom
     * @param string $dateTo
     * @return array
     */
    public function getRevenueByDateRange($dateFrom, $dateTo) {
        $this->db->where('status', [self::STATUS_COMPLETED, self::STATUS_PROCESSING], 'IN');
        $this->db->where('DATE(created_at) BETWEEN ? AND ?', [$dateFrom, $dateTo]);
        
        return $this->db->get($this->table, null, 
            'DATE(created_at) as date, SUM(price) as revenue, COUNT(*) as order_count');
    }
    
    /**
     * Generate unique order number
     * 
     * @return string
     */
    private function generateOrderNumber() {
        do {
            $orderNumber = 'FAM' . date('Ymd') . mt_rand(1000, 9999);
        } while ($this->findByOrderNumber($orderNumber));
        
        return $orderNumber;
    }
    
    /**
     * Get all available service types
     * 
     * @return array
     */
    public static function getServiceTypes() {
        return [
            self::TYPE_INSTAGRAM_FOLLOWERS => 'Instagram Followers',
            self::TYPE_INSTAGRAM_LIKES => 'Instagram Likes',
            self::TYPE_INSTAGRAM_VIEWS => 'Instagram Views',
            self::TYPE_TIKTOK_FOLLOWERS => 'TikTok Followers',
            self::TYPE_TIKTOK_LIKES => 'TikTok Likes',
            self::TYPE_TIKTOK_VIEWS => 'TikTok Views'
        ];
    }
    
    /**
     * Get all available statuses
     * 
     * @return array
     */
    public static function getStatuses() {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_REFUNDED => 'Refunded'
        ];
    }
}
?>
