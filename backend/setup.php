<?php
/**
 * Admin Panel Setup Script
 * Creates si_admin_users table and initial admin user
 */

// Include database
require_once __DIR__ . '/includes/db.php';

$message = '';
$error = '';
$setupComplete = false;

// Check if setup is needed
$tableExists = adminTableExists();
$needsSetup = !$tableExists;

// Handle setup submission
if (isset($_POST['run_setup'])) {
    try {
        // Create admin users table
        if (!$tableExists) {
            $createTableSQL = "
                CREATE TABLE IF NOT EXISTS `si_admin_users` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `username` varchar(50) NOT NULL,
                  `password` varchar(255) NOT NULL,
                  `name` varchar(100) NOT NULL,
                  `email` varchar(100) NOT NULL,
                  `role` enum('admin','super_admin') DEFAULT 'admin',
                  `status` enum('active','inactive') DEFAULT 'active',
                  `last_login` datetime DEFAULT NULL,
                  `created_at` datetime NOT NULL,
                  `updated_at` datetime DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `username` (`username`),
                  UNIQUE KEY `email` (`email`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ";
            
            $db->rawQuery($createTableSQL);
            $message .= "✅ Table 'si_admin_users' created successfully!<br>";
        }
        
        // Create default admin user
        $defaultUsername = 'admin';
        $defaultPassword = 'admin@123';
        $defaultName = 'Administrator';
        $defaultEmail = 'admin@genuinesocials.com';
        
        // Check if admin already exists
        $existingAdmin = $db->where('username', $defaultUsername)->getOne('admin_users');
        
        if (!$existingAdmin) {
            $adminId = createAdminUser($defaultUsername, $defaultPassword, $defaultName, $defaultEmail, 'super_admin');
            
            if ($adminId) {
                $message .= "✅ Default admin user created successfully!<br>";
                $message .= "<br><strong>Login Credentials:</strong><br>";
                $message .= "Username: <code>admin</code><br>";
                $message .= "Password: <code>admin@123</code><br>";
                $setupComplete = true;
            } else {
                $error = "Failed to create default admin user!";
            }
        } else {
            $message .= "⚠️ Admin user already exists. No new user created.<br>";
            $setupComplete = true;
        }
        
    } catch (Exception $e) {
        $error = "Setup failed: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Setup - Genuine Socials</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box" style="max-width: 600px;">
            <h2>🔧 Admin Panel Setup</h2>
            <p>Initialize the admin authentication system</p>
            
            <?php if ($message): ?>
                <div class="alert alert-success" style="text-align: left;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!$setupComplete): ?>
                <div style="background: #f8fafc; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; text-align: left;">
                    <h3 style="margin-bottom: 1rem; color: #1e293b;">Setup will:</h3>
                    <ul style="color: #64748b; line-height: 1.8;">
                        <li>✅ Create <code>si_admin_users</code> table</li>
                        <li>✅ Create default admin user</li>
                        <li>✅ Enable database-driven authentication</li>
                        <li>✅ Enable password encryption (bcrypt)</li>
                    </ul>
                </div>
                
                <div style="background: #fef3c7; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; text-align: left;">
                    <h3 style="margin-bottom: 1rem; color: #92400e;">⚠️ Default Credentials</h3>
                    <p style="color: #78350f; margin: 0;">
                        <strong>Username:</strong> admin<br>
                        <strong>Password:</strong> admin@123<br>
                        <strong>Email:</strong> admin@genuinesocials.com
                    </p>
                    <p style="color: #78350f; margin-top: 1rem; font-size: 0.875rem;">
                        ⚠️ Change the password after first login!
                    </p>
                </div>
                
                <form method="POST" action="">
                    <button type="submit" name="run_setup" class="btn">
                        🚀 Run Setup
                    </button>
                </form>
            <?php else: ?>
                <div style="text-align: center; margin-top: 2rem;">
                    <p style="color: #059669; font-size: 1.125rem; margin-bottom: 1.5rem;">
                        ✅ Setup completed successfully!
                    </p>
                    <a href="login.php" class="btn">
                        Go to Login Page
                    </a>
                </div>
            <?php endif; ?>
            
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; text-align: center; color: #64748b; font-size: 0.875rem;">
                <p><strong>Security Features:</strong></p>
                <ul style="list-style: none; padding: 0; margin: 1rem 0 0 0;">
                    <li>🔒 Bcrypt password hashing (cost: 12)</li>
                    <li>🔐 Session-based authentication</li>
                    <li>✅ Active/Inactive user status</li>
                    <li>📊 Last login tracking</li>
                    <li>🎯 Table prefix support (si_)</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
