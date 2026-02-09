-- Migration: Add display fields for homepage services
-- Date: 2026-02-10
-- Description: Adds fields to si_services table for dynamic homepage service cards
-- Run this SQL to add new fields to si_services table

-- Add display fields to si_services table for homepage cards
ALTER TABLE `si_services` 
ADD COLUMN `emoji` varchar(10) DEFAULT NULL COMMENT 'Emoji for service card' AFTER `description`,
ADD COLUMN `subtitle` varchar(200) DEFAULT NULL COMMENT 'Card subtitle' AFTER `emoji`,
ADD COLUMN `badge` varchar(50) DEFAULT NULL COMMENT 'Badge text: Most Popular, Best Value, etc.' AFTER `subtitle`,
ADD COLUMN `badge_class` varchar(50) DEFAULT NULL COMMENT 'CSS class for badge styling' AFTER `badge`,
ADD COLUMN `features` text DEFAULT NULL COMMENT 'JSON array of feature bullet points' AFTER `badge_class`,
ADD COLUMN `review_count` int DEFAULT 0 COMMENT 'Total review count for display' AFTER `features`,
ADD COLUMN `avg_delivery` varchar(50) DEFAULT '30 min' COMMENT 'Average delivery time display' AFTER `review_count`,
ADD COLUMN `show_on_homepage` tinyint(1) DEFAULT 0 COMMENT 'Display on homepage' AFTER `avg_delivery`,
ADD COLUMN `homepage_order` int DEFAULT 0 COMMENT 'Sort order on homepage' AFTER `show_on_homepage`;

-- Add index for homepage display
ALTER TABLE `si_services`
ADD KEY `idx_homepage_display` (`show_on_homepage`, `homepage_order`);

-- Sample data for Instagram Followers service (assuming service_id = 4)
UPDATE `si_services` 
SET 
  `emoji` = '👥',
  `subtitle` = 'Get real followers fast',
  `badge` = 'Most Popular',
  `badge_class` = '',
  `features` = '["Real followers (not bots)", "Starts in literally 60 seconds", "Choose from 100 to 100,000+", "We never ask for your password"]',
  `review_count` = 10450,
  `avg_delivery` = '30 min',
  `show_on_homepage` = 1,
  `homepage_order` = 1
WHERE `id` = 4;

-- Add more services (you'll need to insert/update these based on your actual service IDs)
-- Instagram Likes
INSERT INTO `si_services` (`name`, `slug`, `description`, `emoji`, `subtitle`, `badge`, `badge_class`, `features`, `review_count`, `avg_delivery`, `show_on_homepage`, `homepage_order`, `is_active`)
VALUES 
('Instagram Likes', 'buy-instagram-likes', 'Buy real Instagram likes', '❤️', 'Make your posts pop', 'Best Value', '', '["Real people, real likes", "Works on posts, reels, videos", "50 to 100,000+ available", "You pick the delivery speed"]', 8700, '30 min', 1, 2, 1),
('Instagram Views', 'buy-instagram-views', 'Buy Instagram video views', '▶️', 'Boost your video reach', 'Fast Delivery', '', '["Real video views", "Instant delivery", "Boosts algorithm ranking", "No password required"]', 7200, '30 min', 1, 3, 1),
('Instagram Reels', 'buy-instagram-reels', 'Likes & Views for Reels', '🎬', 'Likes & Views for Reels', 'Trending', 'trending', '["Real Reels engagement", "Go viral faster", "Reach Explore page", "Safe & secure delivery"]', 5800, '30 min', 1, 4, 1),
('TikTok Followers', 'buy-tiktok-followers', 'Buy TikTok followers', '🎵', 'Go viral on TikTok', 'Creator Pick', 'creator', '["Quality TikTok followers", "Helps you hit the For You page", "100 to 50,000+ followers", "Natural-looking growth"]', 6200, '30 min', 1, 5, 1),
('TikTok Views', 'buy-tiktok-views', 'Buy TikTok video views', '👀', 'Get your videos seen', '', '', '["Real people watching", "Helps with TikTok SEO", "1,000 to 1M+ views", "Increases your watch time"]', 5500, '30 min', 1, 6, 1)
ON DUPLICATE KEY UPDATE
  `emoji` = VALUES(`emoji`),
  `subtitle` = VALUES(`subtitle`),
  `badge` = VALUES(`badge`),
  `badge_class` = VALUES(`badge_class`),
  `features` = VALUES(`features`),
  `review_count` = VALUES(`review_count`),
  `avg_delivery` = VALUES(`avg_delivery`),
  `show_on_homepage` = VALUES(`show_on_homepage`),
  `homepage_order` = VALUES(`homepage_order`);

-- Note: Adjust service IDs and data based on your actual database structure
