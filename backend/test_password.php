<?php
/**
 * Password Verification Debug Script
 * Test if password verification is working correctly
 */

require_once 'includes/db.php';

echo "<h2>🔐 Password Verification Debug</h2>";
echo "<hr>";

// Test credentials
$test_username = 'admin';
$test_password = 'admin@123';

echo "<h3>Testing Credentials:</h3>";
echo "<p><strong>Username:</strong> $test_username</p>";
echo "<p><strong>Password:</strong> $test_password</p>";
echo "<hr>";

// Check if table exists
echo "<h3>Step 1: Check if table exists</h3>";
$result = $db->rawQuery("SHOW TABLES LIKE 'si_admin_users'");
if (count($result) > 0) {
    echo "<p>✅ Table 'si_admin_users' exists</p>";
} else {
    echo "<p>❌ Table 'si_admin_users' does NOT exist</p>";
    echo "<p><a href='setup.php'>Run Setup First</a></p>";
    exit;
}
echo "<hr>";

// Get admin user
echo "<h3>Step 2: Query for admin user</h3>";
$admin = $db->where('username', $test_username)
            ->where('status', 'active')
            ->getOne('admin_users');

echo "<p><strong>SQL Query:</strong><br><code>" . $db->getLastQuery() . "</code></p>";

if ($admin) {
    echo "<p>✅ Admin user found!</p>";
    echo "<pre>";
    echo "ID: " . $admin['id'] . "\n";
    echo "Username: " . $admin['username'] . "\n";
    echo "Name: " . $admin['name'] . "\n";
    echo "Email: " . $admin['email'] . "\n";
    echo "Role: " . $admin['role'] . "\n";
    echo "Status: " . $admin['status'] . "\n";
    echo "Password Hash: " . substr($admin['password'], 0, 30) . "...\n";
    echo "</pre>";
} else {
    echo "<p>❌ Admin user NOT found!</p>";
    echo "<p>Possible issues:</p>";
    echo "<ul>";
    echo "<li>Username is incorrect</li>";
    echo "<li>User status is 'inactive'</li>";
    echo "<li>User doesn't exist in database</li>";
    echo "</ul>";
    exit;
}
echo "<hr>";

// Test password verification
echo "<h3>Step 3: Verify password</h3>";
$verify_result = password_verify($test_password, $admin['password']);

if ($verify_result) {
    echo "<p style='color: green; font-size: 1.5rem;'>✅ <strong>PASSWORD VERIFICATION SUCCESSFUL!</strong></p>";
    echo "<p>The password '<strong>$test_password</strong>' matches the stored hash.</p>";
} else {
    echo "<p style='color: red; font-size: 1.5rem;'>❌ <strong>PASSWORD VERIFICATION FAILED!</strong></p>";
    echo "<p>The password '<strong>$test_password</strong>' does NOT match the stored hash.</p>";
    echo "<p><strong>Troubleshooting:</strong></p>";
    echo "<ul>";
    echo "<li>Check if the password hash in database is correct</li>";
    echo "<li>Try running setup.php again to recreate the user</li>";
    echo "<li>Check if password was manually changed in database</li>";
    echo "</ul>";
}
echo "<hr>";

// Additional password tests
echo "<h3>Step 4: Generate test hash for comparison</h3>";
$new_hash = password_hash($test_password, PASSWORD_BCRYPT, ['cost' => 12]);
echo "<p><strong>New hash generated for '$test_password':</strong><br><code>$new_hash</code></p>";
echo "<p><strong>Database hash:</strong><br><code>{$admin['password']}</code></p>";

$verify_new = password_verify($test_password, $new_hash);
echo "<p>Verification with new hash: " . ($verify_new ? "✅ Works" : "❌ Failed") . "</p>";
echo "<hr>";

// Summary
echo "<h3>📊 Summary</h3>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr><th>Check</th><th>Status</th></tr>";
echo "<tr><td>Table exists</td><td>" . (count($result) > 0 ? "✅ Yes" : "❌ No") . "</td></tr>";
echo "<tr><td>User found</td><td>" . ($admin ? "✅ Yes" : "❌ No") . "</td></tr>";
echo "<tr><td>Password verified</td><td>" . ($verify_result ? "✅ Yes" : "❌ No") . "</td></tr>";
echo "</table>";

if ($verify_result) {
    echo "<h3 style='color: green;'>✅ Everything is working correctly!</h3>";
    echo "<p><a href='login.php'>Go to Login Page</a></p>";
} else {
    echo "<h3 style='color: red;'>❌ Password verification is not working!</h3>";
    echo "<p><a href='setup.php'>Run Setup Again</a></p>";
}
?>
