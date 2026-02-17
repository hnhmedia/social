-- Genuine Socials Admin Users Table
-- Database-driven authentication with encrypted passwords
-- Table name: si_admin_users (with prefix)

CREATE TABLE IF NOT EXISTS `si_admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','super_admin','seo_manager') DEFAULT 'admin',
  `status` enum('active','inactive') DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user
-- Username: admin
-- Password: admin@123 (encrypted with bcrypt)
INSERT INTO `si_admin_users` (`username`, `password`, `name`, `email`, `role`, `status`, `created_at`) 
VALUES (
  'admin', 
  '$2y$12$LQv3c1yycY2bvrXf4h4Qz.8WXKe7D9xwZJE4rKPqADvHlF8FGnXGq', 
  'Administrator', 
  'admin@Genuine Socials.com', 
  'super_admin', 
  'active', 
  NOW()
);

-- Note: The password hash above is for 'admin@123'
-- You can generate new hashes using PHP:
-- password_hash('your_password', PASSWORD_BCRYPT, ['cost' => 12]);
