-- Adminer 4.8.1 MySQL 8.0.27-google dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `si_admin_users`;
CREATE TABLE `si_admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','manager','support') COLLATE utf8mb4_unicode_ci DEFAULT 'support',
  `active` tinyint(1) DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_username` (`username`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_admin_users` (`id`, `username`, `email`, `password`, `role`, `active`, `last_login`, `created_at`, `updated_at`) VALUES
(1,	'admin',	'admin@famoid.local',	'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',	'admin',	1,	NULL,	'2026-02-05 13:53:01',	'2026-02-05 13:53:01');

DROP TABLE IF EXISTS `si_faqs`;
CREATE TABLE `si_faqs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'general',
  `sort_order` int DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `featured` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_active` (`active`),
  KEY `idx_category` (`category`),
  KEY `idx_sort_order` (`sort_order`),
  KEY `idx_featured` (`featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_faqs` (`id`, `question`, `answer`, `category`, `sort_order`, `active`, `featured`, `created_at`, `updated_at`) VALUES
(1,	'What is Famoid??',	'Famoid is a leading social media marketing agency established in 2017. We provide high-quality Instagram followers, likes, views, and engagement services for TikTok, Facebook, and other platforms using ad-based delivery methods.',	'general',	1,	1,	1,	'2024-01-15 10:00:00',	'2024-01-15 10:00:00'),
(2,	'Is it safe to buy Instagram followers from Famoid?',	'Yes, buying followers from Famoid is completely safe. We use ad-based delivery methods that comply with platform guidelines. Your account information remains secure, and we never require your password.',	'safety',	2,	1,	1,	'2024-01-15 10:05:00',	'2024-01-15 10:05:00'),
(3,	'How fast will I receive my order?',	'Most orders begin processing within minutes of purchase. Depending on the package size, delivery typically completes within 1-24 hours. We offer instant delivery on most services.',	'delivery',	3,	1,	1,	'2024-01-15 10:10:00',	'2024-01-15 10:10:00'),
(4,	'Do you offer a money-back guarantee?',	'Yes, Famoid offers a 30-day money-back guarantee. If you are not satisfied with our services or experience any issues, we provide full refunds or free refills.',	'guarantee',	4,	1,	1,	'2024-01-15 10:15:00',	'2024-01-15 10:15:00'),
(5,	'What payment methods do you accept?',	'We accept all major credit cards, debit cards, Apple Pay, Google Pay, and various other secure payment methods. All transactions are encrypted and secure.',	'payment',	5,	1,	1,	'2024-01-15 10:20:00',	'2024-01-15 10:20:00'),
(6,	'Will the followers drop after I buy them?',	'Famoid provides high-quality followers with minimal drop rates. We also offer a 30-day refill guarantee, so if any followers drop within 30 days, we will replace them for free.',	'quality',	6,	1,	1,	'2024-01-15 10:25:00',	'2024-01-15 10:25:00'),
(7,	'Are the likes from real accounts?',	'Yes, all likes from Famoid come from real, active accounts. We use ad-based delivery to ensure genuine engagement that helps boost your content visibility and algorithm ranking.',	'quality',	7,	1,	1,	'2024-01-15 10:30:00',	'2024-01-15 10:30:00'),
(8,	'Can I buy automatic likes for future posts?',	'Absolutely! Famoid offers automatic likes packages that deliver likes to your new posts automatically. This ensures consistent engagement on all your content without manual ordering each time.',	'services',	8,	1,	1,	'2024-01-15 10:35:00',	'2024-01-15 10:35:00'),
(9,	'Do you provide customer support?',	'Yes, we offer 24/7 customer support through live chat, email, and our help center. Our dedicated support team is always ready to assist you with any questions or concerns.',	'support',	9,	1,	0,	'2024-01-20 09:00:00',	'2024-01-20 09:00:00'),
(10,	'How do I track my order?',	'After placing your order, you\'ll receive an order number that you can use to track your progress. You can also log into your account dashboard to monitor all your orders and their current status.',	'orders',	10,	1,	0,	'2024-01-20 09:15:00',	'2024-01-20 09:15:00'),
(11,	'Can I cancel my order?',	'Orders can be canceled within the first 30 minutes of purchase if delivery hasn\'t started yet. Once the delivery process begins, orders cannot be canceled, but our refill guarantee still applies.',	'orders',	11,	1,	0,	'2024-01-20 09:30:00',	'2024-01-20 09:30:00'),
(12,	'What makes Famoid different from other providers?',	'Famoid stands out with our 7+ years of experience, ad-based delivery methods, 24/7 support, money-back guarantee, and commitment to quality. We focus on gradual, organic-looking growth that protects your account.',	'general',	12,	1,	0,	'2024-01-20 09:45:00',	'2024-01-20 09:45:00'),
(13,	'Do you sell services for TikTok and other platforms?',	'Yes! Besides Instagram, we offer services for TikTok (followers, likes, views), Facebook (page likes, post likes), YouTube (views, subscribers), and other major social media platforms.',	'services',	13,	1,	0,	'2024-01-20 10:00:00',	'2024-01-20 10:00:00'),
(14,	'Is my personal information secure?',	'Absolutely. We use industry-standard SSL encryption to protect all data. We never store your passwords or share your personal information with third parties. Your privacy and security are our top priorities.',	'safety',	14,	1,	0,	'2024-01-20 10:15:00',	'2024-01-20 10:15:00'),
(15,	'How do I get started?',	'Getting started is easy! Simply choose your desired service, enter your profile URL, select the quantity, complete the secure payment process, and watch your social media grow. No passwords or personal information required!',	'general',	15,	1,	0,	'2024-01-20 10:30:00',	'2024-01-20 10:30:00');

DROP TABLE IF EXISTS `si_orders`;
CREATE TABLE `si_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `order_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `target_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','processing','completed','cancelled','refunded') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `delivered` int DEFAULT '0',
  `remaining` int DEFAULT '0',
  `start_count` int DEFAULT '0',
  `current_count` int DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `refund_amount` decimal(10,2) DEFAULT NULL,
  `refund_reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `completed_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `refunded_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status` (`status`),
  KEY `idx_order_number` (`order_number`),
  KEY `idx_created_at` (`created_at`),
  CONSTRAINT `si_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `si_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_orders` (`id`, `user_id`, `order_number`, `service_type`, `service_name`, `quantity`, `price`, `target_url`, `status`, `delivered`, `remaining`, `start_count`, `current_count`, `notes`, `admin_notes`, `payment_method`, `payment_id`, `cancellation_reason`, `refund_amount`, `refund_reason`, `created_at`, `updated_at`, `completed_at`, `cancelled_at`, `refunded_at`) VALUES
(1,	1,	'ORD-20260209-AE5',	'instagram',	'Buy Instagram Followers',	100,	3.95,	'asdsa',	'pending',	0,	100,	0,	0,	'Package Code: 1IGF',	NULL,	'online',	NULL,	NULL,	NULL,	NULL,	'2026-02-09 13:03:15',	'2026-02-09 13:03:15',	NULL,	NULL,	NULL),
(2,	3,	'ORD-20260209-94C',	'instagram',	'Buy Instagram Followers',	100,	3.95,	'213123',	'pending',	0,	100,	0,	0,	'Package Code: 1IGF',	NULL,	'online',	NULL,	NULL,	NULL,	NULL,	'2026-02-09 13:22:55',	'2026-02-09 13:22:55',	NULL,	NULL,	NULL),
(3,	4,	'ORD-20260209-722',	'instagram',	'Buy Instagram Followers...',	100,	3.95,	'das@s.com',	'pending',	0,	100,	0,	0,	'Package Code: 1IGF',	NULL,	'online',	NULL,	NULL,	NULL,	NULL,	'2026-02-09 20:58:30',	'2026-02-09 20:58:30',	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `si_password_resets`;
CREATE TABLE `si_password_resets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Hashed reset token',
  `expires_at` timestamp NOT NULL COMMENT 'Token expiration time',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `token` (`token`),
  KEY `expires_at` (`expires_at`),
  CONSTRAINT `si_password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `si_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `si_payments`;
CREATE TABLE `si_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_gateway` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_response` json DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT 'USD',
  `status` enum('pending','completed','failed','refunded') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `gateway_fee` decimal(8,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_status` (`status`),
  KEY `idx_transaction_id` (`transaction_id`),
  CONSTRAINT `si_payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `si_orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `si_payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `si_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `si_service_packages`;
CREATE TABLE `si_service_packages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `package_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique code for package',
  `service_id` int NOT NULL,
  `tag_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `discount_label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '40% Off, 55% Off, /month, Premium',
  `is_popular` tinyint(1) DEFAULT '0',
  `display_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_service` (`service_id`),
  KEY `idx_tag` (`tag_id`),
  KEY `idx_active_order` (`is_active`,`display_order`),
  CONSTRAINT `si_service_packages_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `si_services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `si_service_packages_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `si_service_tags` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_service_packages` (`id`, `package_code`, `service_id`, `tag_id`, `quantity`, `price`, `original_price`, `discount_label`, `is_popular`, `display_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1,	'1IGF',	4,	1,	100,	3.95,	NULL,	'',	0,	1,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(2,	'2IGF',	4,	1,	250,	5.96,	9.90,	'40% Off',	0,	2,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(3,	'3IGF',	4,	1,	500,	9.95,	22.20,	'55% Off',	0,	3,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(4,	'4IGF',	4,	1,	1000,	15.95,	39.90,	'60% Off',	0,	4,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(5,	'5IGF',	4,	1,	2500,	29.95,	74.90,	'60% Off',	0,	5,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(6,	'6IGF',	4,	1,	5000,	49.95,	142.70,	'65% Off',	0,	6,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(7,	'7IGF',	4,	1,	10000,	89.95,	272.60,	'67% Off',	0,	7,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(8,	'8IGF',	4,	1,	15000,	129.95,	382.20,	'66% Off',	0,	8,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(9,	'9IGF',	4,	2,	100,	9.95,	NULL,	'/month',	0,	1,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(10,	'10IGF',	4,	2,	250,	19.95,	NULL,	'/month',	0,	2,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(11,	'11IGF',	4,	2,	500,	34.95,	NULL,	'/month',	0,	3,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(12,	'12IGF',	4,	2,	1000,	59.95,	NULL,	'/month',	0,	4,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(13,	'13IGF',	4,	2,	2500,	99.95,	NULL,	'/month',	0,	5,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(14,	'14IGF',	4,	2,	5000,	179.95,	NULL,	'/month',	0,	6,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(15,	'15IGF',	4,	2,	10000,	299.95,	NULL,	'/month',	0,	7,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(16,	'16IGF',	4,	2,	15000,	449.95,	NULL,	'/month',	0,	8,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(17,	'17IGF',	4,	3,	1000,	29.95,	NULL,	'Premium',	0,	1,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(18,	'18IGF',	4,	3,	2500,	59.95,	NULL,	'Premium',	0,	2,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(19,	'19IGF',	4,	3,	5000,	99.95,	NULL,	'Premium',	0,	3,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(20,	'20IGF',	4,	3,	10000,	179.95,	NULL,	'Premium',	0,	4,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(21,	'21IGF',	4,	3,	15000,	259.95,	NULL,	'Premium',	0,	5,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(22,	'22IGF',	4,	3,	25000,	399.95,	NULL,	'Premium',	0,	6,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(23,	'23IGF',	4,	3,	50000,	699.95,	NULL,	'Premium',	0,	7,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21'),
(24,	'24IGF',	4,	3,	100000,	1299.95,	NULL,	'Premium',	0,	8,	1,	'2026-02-08 19:37:30',	'2026-02-09 10:34:21');

DROP TABLE IF EXISTS `si_service_tags`;
CREATE TABLE `si_service_tags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_id` int NOT NULL,
  `tag_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Real Followers, Managed Growth, Prestige Packs',
  `tag_slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `badge_label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'STANDARD, POPULAR, EXCLUSIVE',
  `badge_color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'CSS color: #3b82f6 or gradient',
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag_description` text COLLATE utf8mb4_unicode_ci COMMENT 'Features list: Real Followers, No Password, 24/7 Support, Fast Growth',
  `display_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_service` (`service_id`),
  KEY `idx_slug` (`tag_slug`),
  KEY `idx_active_order` (`is_active`,`display_order`),
  CONSTRAINT `si_service_tags_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `si_services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_service_tags` (`id`, `service_id`, `tag_name`, `tag_slug`, `badge_label`, `badge_color`, `icon`, `tag_description`, `display_order`, `is_active`, `created_at`) VALUES
(1,	4,	'Real Followers',	'real',	'STANDARD',	'linear-gradient(to right, #f97316, #ef4444)',	'🔥',	'Real Followers, No Password, 24/7 Support, Fast Growth',	1,	1,	'2026-02-08 19:37:30'),
(2,	4,	'Managed Growth',	'managed',	'POPULAR',	'#3b82f6',	'📅',	'Monthly Growth, No Password, 24/7 Support, Analytics Dashboard',	2,	1,	'2026-02-08 19:37:30'),
(3,	4,	'Prestige Packs',	'prestige',	'EXCLUSIVE',	'#ec4899',	'👑',	'Premium Quality, No Password, Priority Support, Instant Delivery',	3,	1,	'2026-02-08 19:37:30');

DROP TABLE IF EXISTS `si_services`;
CREATE TABLE `si_services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL COMMENT 'NULL = Category (Instagram), NOT NULL = Service (Buy Instagram Followers)',
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Short code like IGF, IGL, IGV',
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `emoji` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Emoji for service card',
  `subtitle` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Card subtitle',
  `badge` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Badge text: Most Popular, Best Value, etc.',
  `badge_class` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'CSS class for badge styling',
  `features` text COLLATE utf8mb4_unicode_ci COMMENT 'JSON array of feature bullet points',
  `review_count` int DEFAULT '0' COMMENT 'Total review count for display',
  `avg_delivery` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '30 min' COMMENT 'Average delivery time display',
  `show_on_homepage` tinyint(1) DEFAULT '0' COMMENT 'Display on homepage',
  `homepage_order` int DEFAULT '0' COMMENT 'Sort order on homepage',
  `display_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_subtitle` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `is_featured` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `idx_slug` (`slug`),
  KEY `idx_parent` (`parent_id`),
  KEY `idx_active_order` (`is_active`,`display_order`),
  KEY `idx_homepage_display` (`show_on_homepage`,`homepage_order`),
  CONSTRAINT `si_services_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `si_services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_services` (`id`, `parent_id`, `name`, `slug`, `service_code`, `icon`, `description`, `emoji`, `subtitle`, `badge`, `badge_class`, `features`, `review_count`, `avg_delivery`, `show_on_homepage`, `homepage_order`, `display_order`, `is_active`, `page_title`, `page_subtitle`, `meta_title`, `meta_description`, `is_featured`, `created_at`, `updated_at`) VALUES
(1,	NULL,	'Instagram',	'instagram',	NULL,	'📸',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'30 min',	0,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	0,	'2026-02-08 19:37:30',	'2026-02-08 19:37:30'),
(2,	NULL,	'TikTok',	'tiktok',	NULL,	'🎵',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'30 min',	0,	0,	2,	1,	NULL,	NULL,	NULL,	NULL,	0,	'2026-02-08 19:37:30',	'2026-02-08 19:37:30'),
(3,	NULL,	'Facebook',	'facebook',	NULL,	'👍',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'30 min',	0,	0,	3,	1,	NULL,	NULL,	NULL,	NULL,	0,	'2026-02-08 19:37:30',	'2026-02-08 19:37:30'),
(4,	1,	'Buy Instagram Followers...',	'buy-instagram-followers',	'IGF',	'👥',	'Get real Instagram followers fast..',	'👥',	'Get real followers fast',	'Most Popular',	'',	'[\"Real followers (not bots)\", \"Starts in literally 60 seconds\", \"Choose from 100 to 100,000+\", \"We never ask for your password\"]',	10450,	'30 min',	1,	1,	1,	1,	'Buy Instagram Followers to Accelerate Growth 🔥',	'Famoid offers the best way to buy real Instagram followers safely and efficiently with just a few clicks.',	NULL,	NULL,	1,	'2026-02-08 19:37:30',	'2026-02-09 20:09:07'),
(5,	1,	'Buy Instagram Likes',	'buy-instagram-likes',	NULL,	'❤️',	'Boost your posts with real likes',	'❤️',	'Make your posts pop',	'Best Value',	'',	'[\"Real people, real likes\", \"Works on posts, reels, videos\", \"50 to 100,000+ available\", \"You pick the delivery speed\"]',	8700,	'30 min',	1,	2,	2,	1,	'Buy Instagram Likes to Boost Engagement 💖',	'Get instant Instagram likes from real users to increase your post visibility and engagement.',	NULL,	NULL,	1,	'2026-02-08 19:37:30',	'2026-02-09 20:21:52'),
(6,	1,	'Buy Instagram Views',	'buy-instagram-views',	NULL,	'▶️',	'Increase your video views',	'▶️',	'Boost your video reach',	'Fast Delivery',	'',	'[\"Real video views\", \"Instant delivery\", \"Boosts algorithm ranking\", \"No password required\"]',	7200,	'30 min',	1,	3,	3,	1,	'Buy Instagram Views to Go Viral 🚀',	'Boost your Instagram video views and reach with our premium service.',	NULL,	NULL,	1,	'2026-02-08 19:37:30',	'2026-02-09 20:21:52'),
(7,	1,	'Buy Instagram Reels',	'buy-instagram-reels',	NULL,	'🎬',	'Boost your Reels performance',	'🎬',	'Likes & Views for Reels',	'Trending',	'trending',	'[\"Real Reels engagement\", \"Go viral faster\", \"Reach Explore page\", \"Safe & secure delivery\"]',	5800,	'30 min',	1,	4,	4,	1,	'Buy Instagram Reels Views & Likes 🎬',	'Increase your Instagram Reels engagement and reach with our targeted service.',	NULL,	NULL,	0,	'2026-02-08 19:37:30',	'2026-02-09 20:21:52'),
(8,	2,	'Buy TikTok Followers',	'buy-tiktok-followers',	NULL,	'👥',	'Grow your TikTok following',	'🎵',	'Go viral on TikTok',	'Creator Pick',	'creator',	'[\"Quality TikTok followers\", \"Helps you hit the For You page\", \"100 to 50,000+ followers\", \"Natural-looking growth\"]',	6200,	'30 min',	1,	5,	1,	1,	'Buy TikTok Followers 🎵',	'Get real TikTok followers to boost your profile and reach.',	NULL,	NULL,	1,	'2026-02-08 19:37:30',	'2026-02-09 20:21:52'),
(9,	2,	'Buy TikTok Likes',	'buy-tiktok-likes',	NULL,	'❤️',	'Get likes on your TikTok videos',	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'30 min',	0,	0,	2,	1,	'Buy TikTok Likes 💖',	'Increase engagement on your TikTok videos with real likes.',	NULL,	NULL,	0,	'2026-02-08 19:37:30',	'2026-02-08 19:37:30'),
(10,	2,	'Buy TikTok Views',	'buy-tiktok-views',	NULL,	'👀',	'Boost your TikTok video views',	'👀',	'Get your videos seen',	'',	'',	'[\"Real people watching\", \"Helps with TikTok SEO\", \"1,000 to 1M+ views\", \"Increases your watch time\"]',	5500,	'30 min',	1,	6,	3,	1,	'Buy TikTok Views 👀',	'Get more views on your TikTok videos and increase your visibility.',	NULL,	NULL,	0,	'2026-02-08 19:37:30',	'2026-02-09 20:21:52'),
(11,	3,	'Buy Facebook Post Likes',	'buy-facebook-post-likes',	NULL,	'💖',	'Get likes on your Facebook posts',	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'30 min',	0,	0,	1,	1,	'Buy Facebook Post Likes',	'Boost your Facebook post engagement with real likes.',	NULL,	NULL,	0,	'2026-02-08 19:37:30',	'2026-02-08 19:37:30'),
(12,	3,	'Buy Facebook Page Likes',	'buy-facebook-page-likes',	NULL,	'👍',	'Grow your Facebook page',	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'30 min',	0,	0,	2,	1,	'Buy Facebook Page Likes',	'Increase your Facebook page followers and credibility.',	NULL,	NULL,	0,	'2026-02-08 19:37:30',	'2026-02-08 19:37:30');

DROP TABLE IF EXISTS `si_testimonials`;
CREATE TABLE `si_testimonials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint NOT NULL DEFAULT '5',
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  `featured` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `idx_active` (`active`),
  KEY `idx_featured` (`featured`),
  KEY `idx_rating` (`rating`),
  CONSTRAINT `si_testimonials_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `si_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_testimonials` (`id`, `user_id`, `name`, `email`, `service_type`, `rating`, `title`, `content`, `avatar_url`, `active`, `featured`, `created_at`, `updated_at`) VALUES
(1,	NULL,	'David Smith',	'david.smith@example.com',	'instagram_likes',	5,	'Real Quality Likes',	'Real quality likes in real quick time. I will definitely go with Famoid again in future. 100% recommended.',	'https://i.pravatar.cc/96?img=12',	1,	1,	'2024-10-21 14:30:00',	'2024-10-21 14:30:00'),
(2,	NULL,	'Janae Stofer.',	'janae.stofer@example.com',	'youtube_views',	5,	'Amazing YouTube Promotion',	'Famoid has promoted a number of my YouTube videos and always delivers the results I need. Amazing service!',	'https://i.pravatar.cc/96?img=47',	1,	1,	'2024-10-17 16:45:00',	'2024-10-17 16:45:00'),
(3,	NULL,	'Pamela Keefer',	'pamela.keefer@example.com',	'instagram_followers',	5,	'Great Results for My Profile',	'I was confused about Famoid service. But I can see the result now. They did great job for my profile. My profile was getting 70 to 150 new followers daily.',	'https://i.pravatar.cc/96?img=32',	0,	1,	'2024-10-15 10:20:00',	'2026-02-06 10:26:52'),
(4,	NULL,	'Junior Dala',	'junior.dala@example.com',	'instagram_followers',	5,	'Repeat Customer - Exceeded Expectations',	'2nd time buying from them. I\'m happy to work with them and would highly recommend their product. Both purchases exceeded expectations!',	'https://i.pravatar.cc/96?img=68',	0,	1,	'2024-10-09 12:15:00',	'2026-02-06 10:26:52'),
(5,	NULL,	'Sarah Mitchell',	'sarah.mitchell@example.com',	'instagram_followers',	5,	'Amazing Service - Fast Delivery',	'Amazing service! Got my Instagram followers within hours. The quality is outstanding and customer support was very helpful throughout.',	'https://i.pravatar.cc/96?img=23',	0,	1,	'2024-10-05 08:30:00',	'2026-02-06 10:26:52'),
(6,	NULL,	'Marcus Johnson',	'marcus.johnson@example.com',	'instagram_followers',	5,	'Best Investment for My Brand',	'Best investment I made for my brand. Famoid delivered exactly what they promised with real quality followers. Will order again!',	'https://i.pravatar.cc/96?img=53',	0,	1,	'2024-09-28 19:45:00',	'2026-02-06 10:26:52'),
(7,	NULL,	'Emily Chen',	'emily.chen@example.com',	'instagram_followers',	5,	'Super Fast Delivery',	'Super fast delivery and great quality followers. My engagement rate has improved significantly since using Famoid. Highly recommend!',	'https://i.pravatar.cc/96?img=44',	0,	1,	'2024-09-22 11:20:00',	'2026-02-06 10:26:52'),
(8,	NULL,	'Sarah M.',	'sarah.m@example.com',	'instagram_followers',	5,	'Unmatched Quality',	'Famoid helped me grow from 5K to 50K followers. The quality is unmatched!',	'https://i.pravatar.cc/48?img=12',	0,	0,	'2024-09-15 14:20:00',	'2026-02-06 10:26:52'),
(9,	NULL,	'James R.',	'james.r@example.com',	'instagram_engagement',	5,	'Dramatic Business Growth',	'Fast delivery and real engagement. My business visibility increased dramatically.',	'https://i.pravatar.cc/48?img=33',	0,	0,	'2024-09-10 16:30:00',	'2026-02-06 10:26:52'),
(10,	NULL,	'Emma L.',	'emma.l@example.com',	'instagram_followers',	5,	'Best Investment Ever',	'Best investment for my social media presence. Highly recommend!',	'https://i.pravatar.cc/48?img=45',	0,	0,	'2024-09-08 13:45:00',	'2026-02-06 10:26:52'),
(11,	NULL,	'Michael Rodriguez',	'michael.rodriguez@example.com',	'tiktok_followers',	5,	'TikTok Growth Success',	'Famoid helped me break through on TikTok. My follower count tripled in just two weeks!',	'https://i.pravatar.cc/96?img=15',	0,	1,	'2024-09-05 09:15:00',	'2026-02-06 10:26:52'),
(12,	NULL,	'Lisa Thompson',	'lisa.thompson@example.com',	'instagram_views',	5,	'Amazing Video Views',	'My Instagram reels started getting thousands of views after using Famoid. The algorithm boost is real!',	'https://i.pravatar.cc/96?img=28',	0,	1,	'2024-08-30 17:20:00',	'2026-02-06 10:26:52'),
(13,	NULL,	'Alex Kim',	'alex.kim@example.com',	'tiktok_likes',	5,	'Viral TikTok Success',	'My TikToks started going viral after getting likes from Famoid. The engagement feels completely natural.',	'https://i.pravatar.cc/96?img=36',	0,	0,	'2024-08-25 20:10:00',	'2026-02-06 10:26:52'),
(14,	NULL,	'Rachel Green',	'rachel.green@example.com',	'instagram_likes',	4,	'Good Service',	'Solid service for Instagram likes. Delivery was as promised and the likes look natural.',	'https://i.pravatar.cc/96?img=19',	0,	0,	'2024-08-20 11:40:00',	'2026-02-06 10:26:52'),
(15,	NULL,	'Daniel Park',	'daniel.park@example.com',	'instagram_followers',	5,	'Influencer Growth',	'Famoid helped me reach influencer status! From 2K to 25K followers in a month. Professional service.',	'https://i.pravatar.cc/96?img=42',	0,	1,	'2024-08-15 15:25:00',	'2026-02-06 10:26:52'),
(16,	NULL,	'Janae Stofer',	'janae.stofer@example.com',	'youtube_views',	5,	'Amazing YouTube Promotion',	'Famoid has promoted a number of my YouTube videos and always delivers the results I need. Amazing service!',	'https://i.pravatar.cc/96?img=47',	1,	1,	'2024-10-17 16:45:00',	'2024-10-17 16:45:00');

DROP TABLE IF EXISTS `si_users`;
CREATE TABLE `si_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `email_verified` tinyint(1) DEFAULT '0',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email` (`email`),
  KEY `idx_active` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `si_users` (`id`, `name`, `username`, `role`, `email`, `password`, `phone`, `country`, `status`, `email_verified`, `last_login`, `created_at`, `updated_at`) VALUES
(1,	NULL,	'guest_8e21d8e967',	'customer',	'asda@s.comq',	'$2y$10$p1wujxfmip6WUThEPS.dhuHzPq0n1QoBt4vLwWLVyPLTcwLqFHLHq',	NULL,	NULL,	'active',	0,	NULL,	'2026-02-09 13:01:45',	'2026-02-09 13:01:45'),
(2,	NULL,	'guest_d590824192',	'customer',	'sads@s.com',	'$2y$10$e1v4.itQMRY8/O6YnuGo8e/a9MoEsNX6JwA0XhICi8Xk9936.qmRW',	NULL,	NULL,	'active',	0,	NULL,	'2026-02-09 13:22:55',	'2026-02-09 13:22:55'),
(3,	NULL,	'gSs90a',	'customer',	'gSs90a@s.com',	'$2y$10$RCGs0O27H3MHQ9eHo.8VBen/sDANDBCnYiTnGouDoEzkCQy03qWWq',	NULL,	NULL,	'active',	0,	'2026-02-09 19:56:21',	'2026-02-09 19:07:50',	'2026-02-09 19:56:21'),
(4,	NULL,	'guest_6bd69d018a',	'customer',	'das@s.com',	'$2y$10$yBowkd1/Fc8qyGu/uTsY9eeOaBlZE8JfWWPkN8cK0TIuLqUqblbRa',	NULL,	NULL,	'active',	0,	NULL,	'2026-02-09 20:58:30',	'2026-02-09 20:58:30');

-- 2026-02-09 21:49:07
