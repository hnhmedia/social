<?php
session_start(); require_once 'includes/auth.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
   
    if ($username && $password) {  
     //   print_R(verifyLogin($username, $password));exit;
        if (verifyLogin($username, $password)) {
            loginAdmin($username); exit;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid username or password!';
        }
    } else {
        $error = 'Please enter both username and password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SocialIG</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <h2>SocialIG Admin</h2>
            <p>Login to access the admin panel</p>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn">Login</button>
            </form>
            
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; text-align: center; color: #64748b; font-size: 0.875rem;">
                <p>🔒 Secure database authentication with encrypted passwords</p>
                <p style="margin-top: 0.5rem;">
                    <a href="setup.php" style="color: #7c3aed; text-decoration: none;">First time? Run setup →</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
