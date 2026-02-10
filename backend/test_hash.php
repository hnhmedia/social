<?php
/**
 * Quick Password Hash Test
 */

echo "<h2>🔍 Password Hash Quick Test</h2>";
echo "<hr>";

// The password and hash you mentioned
$password = 'admin@123';
$hash_from_db = '$2y$12$LQv3c1yycY2bvrXf4h4Qz.8WXKe7D9xwZJE4rKPqADvHlF8FGnXGq';

echo "<h3>Testing Your Current Hash</h3>";
echo "<p><strong>Password:</strong> $password</p>";
echo "<p><strong>Hash from DB:</strong> $hash_from_db</p>";
echo "<p><strong>Hash Length:</strong> " . strlen($hash_from_db) . " characters</p>";
echo "<hr>";

// Test 1: Verify the hash from DB
echo "<h3>Test 1: Verify with current hash</h3>";
$result1 = password_verify($password, $hash_from_db);
echo "<p><strong>Result:</strong> " . ($result1 ? "✅ TRUE (Works!)" : "❌ FALSE (Doesn't work)") . "</p>";
echo "<hr>";

// Test 2: Generate a fresh hash
echo "<h3>Test 2: Generate fresh hash</h3>";
$fresh_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
echo "<p><strong>Fresh Hash:</strong> $fresh_hash</p>";
echo "<p><strong>Hash Length:</strong> " . strlen($fresh_hash) . " characters</p>";

$result2 = password_verify($password, $fresh_hash);
echo "<p><strong>Verification:</strong> " . ($result2 ? "✅ TRUE (Works!)" : "❌ FALSE (Doesn't work)") . "</p>";
echo "<hr>";

// Test 3: Compare hashes
echo "<h3>Test 3: Compare hashes</h3>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
echo "<tr><th>Property</th><th>DB Hash</th><th>Fresh Hash</th></tr>";
echo "<tr><td>Full Hash</td><td><code>$hash_from_db</code></td><td><code>$fresh_hash</code></td></tr>";
echo "<tr><td>Length</td><td>" . strlen($hash_from_db) . "</td><td>" . strlen($fresh_hash) . "</td></tr>";
echo "<tr><td>Verifies</td><td>" . ($result1 ? "✅" : "❌") . "</td><td>" . ($result2 ? "✅" : "❌") . "</td></tr>";
echo "</table>";
echo "<hr>";

// Test 4: Different password variations
echo "<h3>Test 4: Testing password variations</h3>";
$variations = [
    'admin@123',
    'Admin@123',
    'admin@123 ',  // with trailing space
    ' admin@123',  // with leading space
];

foreach ($variations as $var) {
    $test = password_verify($var, $hash_from_db);
    echo "<p>Password: '<strong>" . htmlspecialchars($var) . "</strong>' → " . ($test ? "✅ Works" : "❌ Doesn't work") . "</p>";
}
echo "<hr>";

// Recommendation
echo "<h3>📋 Recommendation</h3>";
if (!$result1 && $result2) {
    echo "<p style='color: orange; font-size: 1.2rem;'>⚠️ <strong>The hash in your database is incorrect!</strong></p>";
    echo "<p>Use this new hash to update your database:</p>";
    echo "<div style='background: #f8fafc; padding: 1rem; border-radius: 8px; margin: 1rem 0;'>";
    echo "<p><strong>Run this SQL:</strong></p>";
    echo "<pre style='background: #1e293b; color: #10b981; padding: 1rem; border-radius: 8px; overflow-x: auto;'>";
    echo "UPDATE si_admin_users \nSET password = '$fresh_hash',\n    updated_at = NOW()\nWHERE username = 'admin';";
    echo "</pre>";
    echo "</div>";
    echo "<p><strong>OR</strong> run the automatic fix:</p>";
    echo "<p><a href='fix_password.php' style='display: inline-block; padding: 1rem 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 10px; font-weight: 600;'>Run Auto Fix</a></p>";
} elseif ($result1 && $result2) {
    echo "<p style='color: green;'>✅ Everything is working correctly!</p>";
} else {
    echo "<p style='color: red;'>❌ There's a server configuration issue with password_hash/password_verify!</p>";
}

echo "<hr>";
echo "<p style='color: #64748b;'><small>Generated: " . date('Y-m-d H:i:s') . "</small></p>";
?>
