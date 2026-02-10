-- ============================================
-- Database Dump - SocialIG Platform
-- Generated: February 10, 2026
-- Database: social
-- ============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- ============================================
-- Table: si_users
-- User accounts with authentication
-- ============================================

DROP TABLE IF EXISTS `si_users`;
CREATE TABLE `si_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'bcrypt hashed password',
  `role` enum('customer','admin','moderator') DEFAULT 'customer',
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User accounts';

-- Sample Data
INSERT INTO `si_users` (`id`, `username`, `email`, `password`, `role`, `status`, `created_at`, `last_login`) VALUES
(1, 'admin', 'admin@socialig.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active', '2026-01-01 00:00:00', '2026-02-10 12:00:00'),
(2, 'johndoe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', 'active', '2026-02-05 10:30:00', '2026-02-10 08:15:00');

-- ============================================
-- Table: si_password_resets
-- Password reset tokens
-- ============================================

DROP TABLE IF EXISTS `si_password_resets`;
CREATE TABLE `si_password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL COMMENT 'SHA256 hashed reset token',
  `expires_at` timestamp NOT NULL COMMENT 'Token expiration time (1 hour)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `token` (`token`),
  KEY `expires_at` (`expires_at`),
  CONSTRAINT `si_password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `si_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Password reset tokens';

-- ============================================
-- Table: si_orders
-- Customer orders
-- ============================================

DROP TABLE IF EXISTS `si_orders`;
CREATE TABLE `si_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(20) NOT NULL COMMENT 'Format: ORD-YYYYMMDD-XXX',
  `service_type` varchar(50) NOT NULL COMMENT 'instagram, tiktok, facebook, etc',
  `service_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `target_url` varchar(500) NOT NULL COMMENT 'Username or profile URL',
  `status` enum('pending','processing','completed','cancelled','refunded') DEFAULT 'pending',
  `delivered` int(11) DEFAULT 0,
  `remaining` int(11) DEFAULT 0,
  `start_count` int(11) DEFAULT 0,
  `current_count` int(11) DEFAULT 0,
  `payment_method` varchar(50) DEFAULT 'online',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  KEY `service_type` (`service_type`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `si_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `si_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Customer orders';

-- Sample Data
INSERT INTO `si_orders` (`id`, `user_id`, `order_number`, `service_type`, `service_name`, `quantity`, `price`, `target_url`, `status`, `delivered`, `remaining`, `start_count`, `current_count`, `payment_method`, `notes`, `created_at`) VALUES
(1, 2, 'ORD-20260209-A3F', 'instagram', 'Instagram Followers', 1000, 14.95, 'https://instagram.com/johndoe', 'completed', 1000, 0, 500, 1500, 'online', 'Package Code: 100IGF', '2026-02-09 10:00:00'),
(2, 2, 'ORD-20260208-B7E', 'instagram', 'Instagram Likes', 500, 7.95, 'https://instagram.com/p/ABC123', 'processing', 250, 250, 100, 350, 'online', 'Package Code: 50IGL', '2026-02-08 15:30:00'),
(3, 2, 'ORD-20260207-C2D', 'tiktok', 'TikTok Followers', 2000, 24.95, '@johndoe', 'pending', 0, 2000, 1000, 1000, 'online', 'Package Code: 200TKF', '2026-02-07 09:45:00');

-- ============================================
-- Table: services
-- Main services table
-- ============================================

DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL COMMENT 'instagram, tiktok, facebook, youtube, twitter',
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `category` (`category`),
  KEY `is_active` (`is_active`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Main services';

-- Sample Data
INSERT INTO `services` (`id`, `name`, `slug`, `category`, `description`, `icon`, `is_active`, `sort_order`) VALUES
(1, 'Buy Instagram Followers', 'buy-instagram-followers', 'instagram', 'Get real Instagram followers delivered instantly', '👥', 1, 1),
(2, 'Buy Instagram Likes', 'buy-instagram-likes', 'instagram', 'Boost your posts with real Instagram likes', '❤️', 1, 2),
(3, 'Buy Instagram Views', 'buy-instagram-views', 'instagram', 'Increase your video views on Instagram', '👁️', 1, 3),
(4, 'Buy Instagram Reels Views', 'buy-instagram-reels-views', 'instagram', 'Get more views on your Instagram Reels', '🎬', 1, 4),
(5, 'Buy TikTok Followers', 'buy-tiktok-followers', 'tiktok', 'Grow your TikTok following with real users', '👥', 1, 5),
(6, 'Buy TikTok Likes', 'buy-tiktok-likes', 'tiktok', 'Get more likes on your TikTok videos', '❤️', 1, 6),
(7, 'Buy TikTok Views', 'buy-tiktok-views', 'tiktok', 'Boost your TikTok video views', '👁️', 1, 7),
(8, 'Buy Facebook Post Likes', 'buy-facebook-post-likes', 'facebook', 'Get likes on your Facebook posts', '👍', 1, 8),
(9, 'Buy Facebook Page Likes', 'buy-facebook-page-likes', 'facebook', 'Increase your Facebook page followers', '📄', 1, 9);

-- ============================================
-- Table: service_tags
-- Service features/tags
-- ============================================

DROP TABLE IF EXISTS `service_tags`;
CREATE TABLE `service_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `tag` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  KEY `sort_order` (`sort_order`),
  CONSTRAINT `service_tags_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Service features/tags';

-- Sample Data
INSERT INTO `service_tags` (`service_id`, `tag`, `icon`, `sort_order`) VALUES
(1, 'Real Followers', '✓', 1),
(1, 'Instant Delivery', '⚡', 2),
(1, '24/7 Support', '💬', 3),
(1, 'Money Back Guarantee', '💰', 4),
(2, 'High Quality Likes', '✓', 1),
(2, 'Fast Delivery', '⚡', 2),
(2, 'Safe & Secure', '🔒', 3),
(3, 'Real Views', '✓', 1),
(3, 'Instant Start', '⚡', 2),
(3, 'No Password Required', '🔐', 3);

-- ============================================
-- Table: service_packages
-- Service pricing packages
-- ============================================

DROP TABLE IF EXISTS `service_packages`;
CREATE TABLE `service_packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL COMMENT 'For showing discount',
  `is_popular` tinyint(1) DEFAULT 0,
  `delivery_time` varchar(50) DEFAULT NULL COMMENT 'e.g., Instant, 1-3 days',
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  KEY `is_active` (`is_active`),
  KEY `sort_order` (`sort_order`),
  CONSTRAINT `service_packages_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Service packages';

-- Sample Data
INSERT INTO `service_packages` (`service_id`, `name`, `quantity`, `price`, `original_price`, `is_popular`, `delivery_time`, `sort_order`, `is_active`) VALUES
(1, '100 Followers', 100, 2.95, 5.95, 0, 'Instant', 1, 1),
(1, '250 Followers', 250, 5.95, 9.95, 0, 'Instant', 2, 1),
(1, '500 Followers', 500, 9.95, 14.95, 0, 'Instant', 3, 1),
(1, '1000 Followers', 1000, 14.95, 24.95, 1, 'Instant', 4, 1),
(1, '2500 Followers', 2500, 29.95, 49.95, 0, 'Instant', 5, 1),
(1, '5000 Followers', 5000, 49.95, 89.95, 0, 'Instant', 6, 1),
(2, '50 Likes', 50, 2.95, NULL, 0, 'Instant', 1, 1),
(2, '100 Likes', 100, 4.95, NULL, 0, 'Instant', 2, 1),
(2, '250 Likes', 250, 7.95, NULL, 1, 'Instant', 3, 1),
(2, '500 Likes', 500, 12.95, NULL, 0, 'Instant', 4, 1),
(3, '1000 Views', 1000, 2.95, NULL, 0, 'Instant', 1, 1),
(3, '5000 Views', 5000, 9.95, NULL, 1, 'Instant', 2, 1),
(3, '10000 Views', 10000, 16.95, NULL, 0, 'Instant', 3, 1);

-- ============================================
-- Table: si_testimonials
-- Customer testimonials
-- ============================================

DROP TABLE IF EXISTS `si_testimonials`;
CREATE TABLE `si_testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5 COMMENT '1-5 stars',
  `content` text NOT NULL,
  `service_type` varchar(50) DEFAULT NULL COMMENT 'instagram, tiktok, facebook, etc',
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `is_active` (`is_active`),
  KEY `is_featured` (`is_featured`),
  KEY `rating` (`rating`),
  KEY `service_type` (`service_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Customer testimonials';

-- Sample Data
INSERT INTO `si_testimonials` (`name`, `username`, `rating`, `content`, `service_type`, `is_featured`, `is_active`, `sort_order`) VALUES
('Sarah Johnson', '@sarahjohnson', 5, 'Amazing service! Got 1000 real followers in minutes. Highly recommend!', 'instagram', 1, 1, 1),
('Mike Chen', '@mikechen', 5, 'Fast delivery and great quality. Customer support was very helpful.', 'instagram', 1, 1, 2),
('Emma Wilson', '@emmawilson', 5, 'Best place to buy Instagram followers! Affordable and reliable.', 'instagram', 0, 1, 3),
('David Brown', '@davidbrown', 5, 'Excellent service! My TikTok account is growing so fast now.', 'tiktok', 1, 1, 4),
('Lisa Anderson', '@lisaanderson', 5, 'Very happy with my purchase. Real followers that actually engage!', 'instagram', 0, 1, 5);

-- ============================================
-- Table: si_faqs
-- Frequently Asked Questions
-- ============================================

DROP TABLE IF EXISTS `si_faqs`;
CREATE TABLE `si_faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(500) NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(100) DEFAULT 'general' COMMENT 'general, payment, delivery, safety, etc',
  `service_type` varchar(50) DEFAULT NULL COMMENT 'instagram, tiktok, facebook, or NULL for all',
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `is_active` (`is_active`),
  KEY `category` (`category`),
  KEY `service_type` (`service_type`),
  KEY `sort_order` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='FAQs';

-- Sample Data
INSERT INTO `si_faqs` (`question`, `answer`, `category`, `service_type`, `is_active`, `sort_order`) VALUES
('Is it safe to buy Instagram followers?', 'Yes! Our service is 100% safe. We use secure methods that comply with Instagram''s terms of service. Your account will never be at risk.', 'safety', 'instagram', 1, 1),
('How fast will I receive my followers?', 'Delivery starts instantly after payment confirmation. Most orders are completed within 1-24 hours depending on the package size.', 'delivery', 'instagram', 1, 2),
('Do you need my password?', 'No! We never ask for your password. We only need your username or profile URL to deliver the service.', 'safety', NULL, 1, 3),
('Will the followers drop?', 'Our followers are real and permanent. We offer a 30-day refill guarantee if any followers drop.', 'general', 'instagram', 1, 4),
('What payment methods do you accept?', 'We accept all major credit cards (Visa, Mastercard, Amex), PayPal, and cryptocurrency.', 'payment', NULL, 1, 5),
('Can I split an order between multiple accounts?', 'No, each order is for a single account. Please place separate orders for different accounts.', 'general', NULL, 1, 6),
('Do you offer refunds?', 'Yes! We offer a 30-day money-back guarantee if you''re not satisfied with our service.', 'payment', NULL, 1, 7),
('Are the followers real people?', 'Yes! All our followers are real, active users. We never use bots or fake accounts.', 'general', 'instagram', 1, 8);

-- ============================================
-- Table: si_sessions (Optional)
-- Session management
-- ============================================

DROP TABLE IF EXISTS `si_sessions`;
CREATE TABLE `si_sessions` (
  `id` varchar(128) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Session storage';

-- ============================================
-- Indexes and Constraints Summary
-- ============================================

-- Performance Indexes
-- si_users: username, email (unique), status, role
-- si_orders: order_number (unique), user_id, status, service_type, created_at
-- services: slug (unique), category, is_active, sort_order
-- si_password_resets: user_id, token, expires_at

-- Foreign Key Constraints
-- si_password_resets.user_id -> si_users.id (CASCADE)
-- si_orders.user_id -> si_users.id (CASCADE)
-- service_tags.service_id -> services.id (CASCADE)
-- service_packages.service_id -> services.id (CASCADE)

COMMIT;

-- ============================================
-- Database Dump Complete
-- ============================================
