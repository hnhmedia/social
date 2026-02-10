<?php
/**
 * Fix Password Hash Issue
 * Regenerates the admin password hash and updates the database
 */

require_once 'includes/db.php';

echo "<h2>🔧 Fixing Password Hash Issue</h2>";
echo "<hr>";

// Step 1: Check current password field structure
echo "<h3>Step 1: Checking password field in database</h3>";
$result = $db->rawQuery("SHOW COLUMNS FROM si_admin_users WHERE Field = 'password'");

if ($result) {
    echo "<p>✅ Password field info:</p>";
    echo "<pre>";
    print_r($result[0]);
    echo "</pre>";
    
    $fieldType = $result[0]['Type'];
    echo "<p><strong>Field Type:</strong> $fieldType</p>";
    
    if (stripos($fieldType, 'varchar') !== false) {
        preg_match('/varchar\((\d+)\)/', $fieldType, $matches);
        $length = $matches[1] ?? 'unknown';
        echo "<p><strong>Field Length:</strong> $length characters</p>";
        
        if ($length < 255) {
            echo "<p style='color: red;'>⚠️ <strong>WARNING:</strong> Password field is too short! Should be VARCHAR(255)</p>";
            echo "<p>Attempting to fix...</p>";
            
            $db->rawQuery("ALTER TABLE si_admin_users MODIFY password VARCHAR(255) NOT NULL");
            echo "<p>✅ Password field updated to VARCHAR(255)</p>";
        } else {
            echo "<p>✅ Password field length is correct (255 characters)</p>";
        }
    }
} else {
    echo "<p>❌ Could not check password field</p>";
}
echo "<hr>";

// Step 2: Get current admin user
echo "<h3>Step 2: Getting admin user</h3>";
$admin = $db->where('username', 'admin')->getOne('admin_users');

if (!$admin) {
    echo "<p>❌ Admin user not found!</p>";
    echo "<p><a href='setup.php'>Run Setup</a></p>";
    exit;
}

echo "<p>✅ Admin user found:</p>";
echo "<pre>";
echo "ID: " . $admin['id'] . "\n";
echo "Username: " . $admin['username'] . "\n";
echo "Name: " . $admin['name'] . "\n";
echo "Email: " . $admin['email'] . "\n";
echo "Current Hash: " . $admin['password'] . "\n";
echo "Hash Length: " . strlen($admin['password']) . " characters\n";
echo "</pre>";

if (strlen($admin['password']) < 60) {
    echo "<p style='color: red;'>⚠️ <strong>WARNING:</strong> Password hash is too short! Should be 60 characters.</p>";
}
echo "<hr>";

// Step 3: Generate new password hash
echo "<h3>Step 3: Generating new password hash</h3>";
$new_password = 'admin@123';
$new_hash = password_hash($new_password, PASSWORD_BCRYPT, ['cost' => 12]);

echo "<p><strong>Plain Password:</strong> $new_password</p>";
echo "<p><strong>New Hash:</strong> $new_hash</p>";
echo "<p><strong>New Hash Length:</strong> " . strlen($new_hash) . " characters</p>";
echo "<hr>";

// Step 4: Test the new hash
echo "<h3>Step 4: Testing new hash BEFORE saving</h3>";
$test_verify = password_verify($new_password, $new_hash);

if ($test_verify) {
    echo "<p style='color: green;'>✅ <strong>New hash verification WORKS!</strong></p>";
} else {
    echo "<p style='color: red;'>❌ <strong>New hash verification FAILED!</strong></p>";
    echo "<p>This is a server configuration issue. Contact your hosting provider.</p>";
    exit;
}
echo "<hr>";

// Step 5: Update database
echo "<h3>Step 5: Updating password in database</h3>";
$data = [
    'password' => $new_hash,
    'updated_at' => date('Y-m-d H:i:s')
];

$db->where('id', $admin['id']);
$update_result = $db->update('admin_users', $data);

if ($update_result) {
    echo "<p>✅ <strong>Password updated successfully!</strong></p>";
    echo "<p><strong>SQL Query:</strong><br><code>" . $db->getLastQuery() . "</code></p>";
} else {
    echo "<p>❌ <strong>Failed to update password!</strong></p>";
    echo "<p>Error: " . $db->getLastError() . "</p>";
    exit;
}
echo "<hr>";

// Step 6: Verify the update
echo "<h3>Step 6: Verifying database update</h3>";
$updated_admin = $db->where('username', 'admin')->getOne('admin_users');

echo "<p><strong>Updated Hash from DB:</strong> " . $updated_admin['password'] . "</p>";
echo "<p><strong>Hash Length:</strong> " . strlen($updated_admin['password']) . " characters</p>";

if (strlen($updated_admin['password']) < 60) {
    echo "<p style='color: red;'>❌ <strong>Hash is STILL truncated in database!</strong></p>";
    echo "<p>Your database field is still too short. Run this SQL manually:</p>";
    echo "<pre>ALTER TABLE si_admin_users MODIFY password VARCHAR(255) NOT NULL;</pre>";
    exit;
}
echo "<hr>";

// Step 7: Final verification test
echo "<h3>Step 7: Final password verification test</h3>";
$final_verify = password_verify($new_password, $updated_admin['password']);

if ($final_verify) {
    echo "<p style='color: green; font-size: 1.5rem;'>✅ <strong>SUCCESS! Password verification is now working!</strong></p>";
    echo "<hr>";
    echo "<h3>✅ All Fixed!</h3>";
    echo "<p>You can now login with:</p>";
    echo "<ul>";
    echo "<li><strong>Username:</strong> admin</li>";
    echo "<li><strong>Password:</strong> admin@123</li>";
    echo "</ul>";
    echo "<p><a href='login.php' style='display: inline-block; padding: 1rem 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 10px; font-weight: 600;'>Go to Login Page</a></p>";
    echo "<p style='color: #64748b; margin-top: 2rem;'><small>⚠️ Delete this file (fix_password.php) after testing for security!</small></p>";
} else {
    echo "<p style='color: red; font-size: 1.5rem;'>❌ <strong>STILL NOT WORKING!</strong></p>";
    echo "<p>There is a deeper issue. Please check:</p>";
    echo "<ul>";
    echo "<li>PHP version (must be 5.5+)</li>";
    echo "<li>Bcrypt support enabled</li>";
    echo "<li>Database character encoding (should be utf8mb4)</li>";
    echo "</ul>";
}
?>
