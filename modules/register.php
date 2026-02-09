<?php
/**
 * Registration Page
 * New user registration (username auto-generated from email)
 */

session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /sgi/dashboard");
    exit;
}

// Include database
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Config.php';

// Handle registration form submission
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $terms = isset($_POST['terms']) ? true : false;
    
    // Validate
    if (empty($email) || empty($password) || empty($confirmPassword)) {
        $error = 'Please fill in all fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } elseif (!$terms) {
        $error = 'Please accept the terms and conditions';
    } else {
        try {
            $db = Database::getConnection();
            
            // Check if email exists
            $existingEmail = $db->where('email', $email)->getOne('users', 'id');
            if ($existingEmail) {
                $error = 'This email is already registered';
            } else {
                // Generate unique username from email
                $emailParts = explode('@', $email);
                $baseUsername = preg_replace('/[^a-zA-Z0-9]/', '', $emailParts[0]);
                
                // Ensure username is unique
                $username = $baseUsername;
                $counter = 1;
                while ($db->where('username', $username)->getOne('users', 'id')) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }
                
                // Create user
                $userData = [
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => 'customer',
                    'status' => 'active',
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                $userId = $db->insert('users', $userData);
                
                if ($userId) {
                    // Registration successful
                    $_SESSION['register_success'] = 'Account created successfully! You can now login.';
                    header("Location: " . Config::baseUrl('login'));
                    exit;
                } else {
                    $error = 'Failed to create account. Please try again.';
                }
            }
        } catch (Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            $error = 'An error occurred. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - <?php echo Config::siteName(); ?></title>
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
        
        .register-container {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .register-header {
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
        
        .register-body {
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
        
        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.8rem;
        }
        
        .strength-bar {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            margin-top: 0.25rem;
            overflow: hidden;
        }
        
        .strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s;
        }
        
        .strength-weak { width: 33%; background: #ef4444; }
        .strength-medium { width: 66%; background: #f59e0b; }
        .strength-strong { width: 100%; background: #10b981; }
        
        .form-checkbox-group {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }
        
        .form-checkbox {
            margin-right: 0.5rem;
            margin-top: 0.25rem;
            width: 18px;
            height: 18px;
            cursor: pointer;
            flex-shrink: 0;
        }
        
        .checkbox-label {
            font-size: 0.85rem;
            color: #6b7280;
            cursor: pointer;
            user-select: none;
            line-height: 1.4;
        }
        
        .checkbox-label a {
            color: #667eea;
            text-decoration: none;
        }
        
        .checkbox-label a:hover {
            text-decoration: underline;
        }
        
        .btn-register {
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
        
        .btn-register:hover {
            transform: translateY(-2px);
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .btn-register:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .login-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .features {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        
        .features-title {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }
        
        .features-list {
            list-style: none;
            padding: 0;
        }
        
        .features-list li {
            padding: 0.5rem 0;
            color: #6b7280;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
        }
        
        .features-list li:before {
            content: '✓';
            color: #10b981;
            font-weight: bold;
            margin-right: 0.5rem;
        }
        
        @media (max-width: 480px) {
            .register-container {
                border-radius: 10px;
            }
            
            .register-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .logo {
                font-size: 2rem;
            }
            
            .register-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="logo"><?php echo Config::siteName(); ?></div>
            <div class="logo-subtitle">Create your free account</div>
        </div>
        
        <div class="register-body">
            <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            
            <form method="POST" action="" id="registerForm">
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
                        autofocus
                    >
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Create a password (min 6 characters)"
                        minlength="6"
                        required
                    >
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        class="form-input" 
                        placeholder="Confirm your password"
                        minlength="6"
                        required
                    >
                </div>
                
                <div class="form-checkbox-group">
                    <input type="checkbox" id="terms" name="terms" class="form-checkbox" required>
                    <label for="terms" class="checkbox-label">
                        I agree to the <a href="<?php echo Config::baseUrl('terms'); ?>" target="_blank">Terms of Service</a> and <a href="<?php echo Config::baseUrl('privacy'); ?>" target="_blank">Privacy Policy</a>
                    </label>
                </div>
                
                <button type="submit" class="btn-register" id="submitBtn">Create Account</button>
            </form>
            
            <div class="login-link">
                Already have an account? <a href="<?php echo Config::baseUrl('login'); ?>">Sign in</a>
            </div>
        </div>
    </div>
    
    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthFill = document.getElementById('strengthFill');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 6) strength++;
            if (password.length >= 10) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            strengthFill.className = 'strength-fill';
            if (strength <= 2) {
                strengthFill.classList.add('strength-weak');
            } else if (strength <= 4) {
                strengthFill.classList.add('strength-medium');
            } else {
                strengthFill.classList.add('strength-strong');
            }
        });
        
        // Password match validation
        const confirmPassword = document.getElementById('confirm_password');
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        
        confirmPassword.addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
        
        passwordInput.addEventListener('input', function() {
            if (confirmPassword.value && confirmPassword.value !== this.value) {
                confirmPassword.setCustomValidity('Passwords do not match');
            } else {
                confirmPassword.setCustomValidity('');
            }
        });
    </script>
</body>
</html>
