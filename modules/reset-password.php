<?php error_reporting(E_ALL);ini_set('display_errors', 1);
/**
 * Reset Password Page
 * Set new password with token validation
 */

session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /sgi/dashboard");
    exit;
}

// Include required files
require_once __DIR__ . '/../includes/Database.php';

// Get token from URL
$token = isset($_GET['token']) ? trim($_GET['token']) : '';

$error = '';
$success = '';
$tokenValid = false;
$user = null;

// Validate token
if (empty($token)) {
    $error = 'Invalid or missing reset token';
} else {
    try {
        $db = Database::getConnection();
        
        // Get token from database
        $hashedToken = hash('sha256', $token);
        $db->where('token', $hashedToken);
        $db->where('expires_at', date('Y-m-d H:i:s'), '>=');
        $resetToken = $db->getOne('si_password_resets', 'user_id, expires_at');
        
        if ($resetToken) {
            // Token is valid, get user
            $user = $db->where('id', $resetToken['user_id'])->getOne('si_users', 'id, username, email');
            
            if ($user) {
                $tokenValid = true;
            } else {
                $error = 'User account not found';
            }
        } else {
            $error = 'This password reset link has expired or is invalid. Please request a new one.';
        }
    } catch (Exception $e) {
        error_log("Reset password error: " . $e->getMessage());
        $error = 'An error occurred. Please try again.';
    }
}

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $tokenValid) {
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    
    // Validate
    if (empty($password) || empty($confirmPassword)) {
        $error = 'Please enter and confirm your new password';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } else {
        try {
            $db = Database::getConnection();
            
            // Update password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $db->where('id', $user['id']);
            $updated = $db->update('si_users', ['password' => $hashedPassword]);
            
            if ($updated) {
                // Delete used token
                $db->where('user_id', $user['id'])->delete('si_password_resets');
                
                // Set success message in session
                $_SESSION['register_success'] = 'Your password has been reset successfully! You can now login.';
                
                // Redirect to login
                header("Location: /sgi/login");
                exit;
            } else {
                $error = 'Failed to update password. Please try again.';
            }
        } catch (Exception $e) {
            error_log("Password update error: " . $e->getMessage());
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
    <title>Reset Password - Genuine Socials</title>
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
        
        .reset-container {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .reset-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 3rem 2rem 2rem;
            text-align: center;
            color: white;
        }
        
        .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .reset-body {
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
        
        .user-info {
            background: #f9fafb;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .user-info strong {
            color: #374151;
            font-size: 1.1rem;
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
        
        .btn-submit {
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
        
        .btn-submit:hover {
            transform: translateY(-2px);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }
        
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .links {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
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
        
        @media (max-width: 480px) {
            .reset-container {
                border-radius: 10px;
            }
            
            .reset-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .title {
                font-size: 1.5rem;
            }
            
            .reset-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="reset-header">
            <div class="icon">🔐</div>
            <div class="title">Reset Password</div>
            <div class="subtitle">Enter your new password</div>
        </div>
        
        <div class="reset-body">
            <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <?php if ($tokenValid && $user): ?>
            <div class="user-info">
                Resetting password for:<br>
                <strong><?php echo htmlspecialchars($user['email']); ?></strong>
            </div>
            
            <form method="POST" action="" id="resetForm">
                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Enter new password"
                        minlength="6"
                        required
                        autofocus
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
                        placeholder="Confirm new password"
                        minlength="6"
                        required
                    >
                </div>
                
                <button type="submit" class="btn-submit" id="submitBtn">Reset Password</button>
            </form>
            <?php endif; ?>
            
            <div class="links">
                <a href="/sgi/login" class="link">← Back to Login</a>
            </div>
        </div>
    </div>
    
    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthFill = document.getElementById('strengthFill');
        
        if (passwordInput && strengthFill) {
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
        }
        
        // Password match validation
        const confirmPassword = document.getElementById('confirm_password');
        const form = document.getElementById('resetForm');
        
        if (confirmPassword && form) {
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
        }
    </script>
</body>
</html>
