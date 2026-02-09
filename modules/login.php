<?php
/**
 * Login Page
 * User authentication
 */

session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /sgi/dashboard");
    exit;
}

// Include database
require_once __DIR__ . '/../includes/Database.php';

// Handle login form submission
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $remember = isset($_POST['remember']) ? true : false;
    
    // Validate
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } else {
        try {
            $db = Database::getConnection();
            
            // Get user by email
            $user = $db->where('email', $email)->getOne('users');
            
            if ($user && password_verify($password, $user['password'])) {
                // Check if user is active
                if ($user['status'] !== 'active') {
                    $error = 'Your account is not active. Please contact support.';
                } else {
                    // Login successful
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    
                    // Remember me
                    if ($remember) {
                        $token = bin2hex(random_bytes(32));
                        setcookie('remember_token', $token, time() + (86400 * 30), '/'); // 30 days
                        
                        // Save token to database (you'll need to add a remember_token column)
                        // $db->where('id', $user['id'])->update('si_users', ['remember_token' => $token]);
                    }
                    
                    // Update last login
                    $db->where('id', $user['id'])->update('users', [
                        'last_login' => date('Y-m-d H:i:s')
                    ]);
                    
                    // Redirect to dashboard or intended page
                    $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '/sgi/dashboard';
                    header("Location: $redirect");
                    exit;
                }
            } else {
                $error = 'Invalid email or password';
            }
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            $error = 'An error occurred. Please try again.';
        }
    }
}

// Check for success messages
if (isset($_SESSION['register_success'])) {
    $success = $_SESSION['register_success'];
    unset($_SESSION['register_success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SocialIG</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .login-container {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 3rem 2rem 2rem;
            text-align: center;
            color: white;
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        
        .logo-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .form-checkbox {
            margin-right: 0.5rem;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        .checkbox-label {
            font-size: 0.9rem;
            color: #6b7280;
            cursor: pointer;
            user-select: none;
        }
        
        .btn-login {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
        }
        
        .divider-text {
            background: white;
            padding: 0 1rem;
            position: relative;
            color: #9ca3af;
            font-size: 0.875rem;
        }
        
        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
            font-size: 0.875rem;
        }
        
        .link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .link:hover {
            text-decoration: underline;
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .register-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 480px) {
            .login-container {
                border-radius: 10px;
            }
            
            .login-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .logo {
                font-size: 2rem;
            }
            
            .login-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo">SocialIG</div>
            <div class="logo-subtitle">Welcome back! Sign in to your account</div>
        </div>
        
        <div class="login-body">
            <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="Enter your email"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        required
                    >
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Enter your password"
                        required
                    >
                </div>
                
                <div class="form-checkbox-group">
                    <input type="checkbox" id="remember" name="remember" class="form-checkbox">
                    <label for="remember" class="checkbox-label">Remember me for 30 days</label>
                </div>
                
                <button type="submit" class="btn-login">Sign In</button>
                
                <div class="links">
                    <a href="/sgi/forgot-password" class="link">Forgot password?</a>
                    <a href="/sgi/" class="link">Back to home</a>
                </div>
            </form>
            
            <div class="register-link">
                Don't have an account? <a href="/sgi/register">Create one now</a>
            </div>
        </div>
    </div>
</body>
</html>
