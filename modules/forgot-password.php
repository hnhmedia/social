<?php error_reporting(E_ALL);ini_set('display_errors', 1);

/**
 * Forgot Password Page
 * Request password reset link
 */

session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /sgi/dashboard");
    exit;
}

// Include required files
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/EmailHelper.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    
    // Validate
    if (empty($email)) {
        $error = 'Please enter your email address';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } else {
        try {
            $db = Database::getConnection();
            
            // Check if user exists
            $user = $db->where('email', $email)->getOne('si_users', 'id, username, email, status');
            
            if ($user) {
                // Check if account is active
                if ($user['status'] !== 'active') {
                    $error = 'Your account is not active. Please contact support.';
                } else {
                    // Generate reset token
                    $token = bin2hex(random_bytes(32));
                    $expires = date('Y-m-d H:i:s', time() + 3600); // 1 hour expiration
                    
                    // Save token to database
                    $tokenData = [
                        'user_id' => $user['id'],
                        'token' => hash('sha256', $token),
                        'expires_at' => $expires,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    
                    // Delete any existing tokens for this user
                    $db->where('user_id', $user['id'])->delete('si_password_resets');
                    
                    // Insert new token
                    $inserted = $db->insert('si_password_resets', $tokenData);
                    
                    if ($inserted) {
                        // Build reset link
                        $resetLink = 'https://betabd.zodiaccdn.com/sgi/reset-password/' . $token;
                        
                        // Send email
                        $emailHelper = new EmailHelper();
                        $emailSent = $emailHelper->sendPasswordResetEmail(
                            $user['email'],
                            $user['username'],
                            $resetLink
                        );
                        
                        if ($emailSent) {
                            $success = 'Password reset instructions have been sent to your email address.';
                        } else {
                            // Even if email fails, don't reveal user exists
                            $success = 'If an account exists with this email, you will receive password reset instructions.';
                            error_log("Failed to send password reset email to: " . $email);
                        }
                    } else {
                        $error = 'An error occurred. Please try again.';
                    }
                }
            } else {
                // Don't reveal if user exists or not (security)
                $success = 'If an account exists with this email, you will receive password reset instructions.';
            }
        } catch (Exception $e) {
            error_log("Forgot password error: " . $e->getMessage());
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
    <title>Forgot Password - Genuine Socials</title>
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
        
        .forgot-container {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .forgot-header {
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
        
        .forgot-body {
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
        
        .info-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #1e40af;
            line-height: 1.6;
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
            margin: 0 1rem;
        }
        
        .link:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 480px) {
            .forgot-container {
                border-radius: 10px;
            }
            
            .forgot-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .title {
                font-size: 1.5rem;
            }
            
            .forgot-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <div class="forgot-header">
            <div class="icon">🔑</div>
            <div class="title">Forgot Password?</div>
            <div class="subtitle">No worries, we'll send you reset instructions</div>
        </div>
        
        <div class="forgot-body">
            <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
            <div class="info-box">
                <strong>Check your email!</strong><br>
                If an account exists, you'll receive an email with instructions to reset your password. 
                The link will expire in 1 hour.
            </div>
            <?php else: ?>
            <div class="info-box">
                Enter the email address associated with your account and we'll send you a link to reset your password.
            </div>
            
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
                        autofocus
                    >
                </div>
                
                <button type="submit" class="btn-submit">Send Reset Link</button>
            </form>
            <?php endif; ?>
            
            <div class="links">
                <a href="/sgi/login" class="link">← Back to Login</a>
                <a href="/sgi/" class="link">Home</a>
            </div>
        </div>
    </div>
</body>
</html>
