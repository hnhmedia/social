<?php ob_start(); session_start(); require_once 'includes/auth.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid session. Please refresh and try again.';
    }

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
   
    if (!$error && $username && $password) {  
     //   print_R(verifyLogin($username, $password));exit;
        if (verifyLogin($username, $password)) {
            loginAdmin($username);
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid username or password!';
        }
    } else {
        $error = $error ?: 'Please enter both username and password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Genuine Socials</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <h2>Genuine Socials Admin</h2>
            <p>Login to access the admin panel</p>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrfToken()); ?>">
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
            
        
        </div>
    </div>
</body>
</html>
