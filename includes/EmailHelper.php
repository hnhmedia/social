<?php
/**
 * Email Helper Class
 * Handles email sending via SMTP using PHPMailer or PHP mail()
 */

// Try to load PHPMailer
$phpmailerAvailable = false;

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    $phpmailerAvailable = class_exists('PHPMailer\PHPMailer\PHPMailer');
}

class EmailHelper {
    private $config;
    private $phpmailerAvailable;
    
    public function __construct() {
        $configFile = require __DIR__ . '/../config/database.php';
        $this->config = $configFile['smtp'] ?? [];
        
        global $phpmailerAvailable;
        $this->phpmailerAvailable = $phpmailerAvailable;
    }
    
    /**
     * Send email
     * 
     * @param string $to Recipient email
     * @param string $subject Email subject
     * @param string $body Email body (HTML)
     * @param string $altBody Plain text alternative
     * @return bool Success status
     */
    public function send($to, $subject, $body, $altBody = '') {
        // Check if SMTP is enabled
        if (!$this->config['enabled']) {
            error_log("Email not sent: SMTP is disabled in config");
            return false;
        }
        
        // Use PHPMailer if available
        if ($this->phpmailerAvailable) {
            return $this->sendViaPHPMailer($to, $subject, $body, $altBody);
        } else {
            return $this->sendViaPHPMail($to, $subject, $body);
        }
    }
    
    /**
     * Send email via PHPMailer (SMTP)
     */
    private function sendViaPHPMailer($to, $subject, $body, $altBody) {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $this->config['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->config['username'];
            $mail->Password   = $this->config['password'];
            $mail->SMTPSecure = $this->config['encryption'];
            $mail->Port       = $this->config['port'];
            $mail->Timeout    = $this->config['timeout'];
            
            if ($this->config['debug']) {
                $mail->SMTPDebug = 2;
            }
            
            // Recipients
            $mail->setFrom($this->config['from_email'], $this->config['from_name']);
            $mail->addAddress($to);
            $mail->addReplyTo($this->config['from_email'], $this->config['from_name']);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = $altBody ?: strip_tags($body);
            
            $mail->send();
            return true;
        } catch (\Exception $e) {
            error_log("Email send failed: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send email via PHP mail() function
     */
    private function sendViaPHPMail($to, $subject, $body) {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: {$this->config['from_name']} <{$this->config['from_email']}>" . "\r\n";
        $headers .= "Reply-To: {$this->config['from_email']}" . "\r\n";
        
        return mail($to, $subject, $body, $headers);
    }
    
    /**
     * Send password reset email
     */
    public function sendPasswordResetEmail($to, $username, $resetLink) {
        $subject = "Reset Your Password - " . $this->config['templates']['company_name'];
        
        $body = $this->getPasswordResetTemplate($username, $resetLink);
        
        return $this->send($to, $subject, $body);
    }
    
    /**
     * Send welcome email
     */
    public function sendWelcomeEmail($to, $username) {
        $subject = "Welcome to " . $this->config['templates']['company_name'];
        
        $body = $this->getWelcomeTemplate($username);
        
        return $this->send($to, $subject, $body);
    }
    
    /**
     * Get password reset email template
     */
    private function getPasswordResetTemplate($username, $resetLink) {
        $companyName = $this->config['templates']['company_name'];
        $companyUrl = $this->config['templates']['company_url'];
        $primaryColor = $this->config['templates']['primary_color'];
        $supportEmail = $this->config['templates']['support_email'];
        
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 700;">Reset Your Password</h1>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #333333; font-size: 16px; line-height: 1.6; margin: 0 0 20px;">
                                Hi <strong>{$username}</strong>,
                            </p>
                            
                            <p style="color: #333333; font-size: 16px; line-height: 1.6; margin: 0 0 20px;">
                                We received a request to reset your password for your {$companyName} account. 
                                Click the button below to create a new password:
                            </p>
                            
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{$resetLink}" style="display: inline-block; padding: 15px 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">Reset Password</a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="color: #666666; font-size: 14px; line-height: 1.6; margin: 20px 0;">
                                Or copy and paste this link into your browser:
                            </p>
                            
                            <p style="color: #667eea; font-size: 14px; word-break: break-all; background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin: 10px 0 20px;">
                                {$resetLink}
                            </p>
                            
                            <p style="color: #666666; font-size: 14px; line-height: 1.6; margin: 20px 0 0;">
                                <strong>This link will expire in 1 hour.</strong>
                            </p>
                            
                            <p style="color: #666666; font-size: 14px; line-height: 1.6; margin: 20px 0 0;">
                                If you didn't request a password reset, please ignore this email or contact our support team if you have concerns.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9f9f9; padding: 30px; text-align: center; border-top: 1px solid #eeeeee;">
                            <p style="color: #999999; font-size: 12px; line-height: 1.6; margin: 0 0 10px;">
                                {$companyName} &copy; 2026. All rights reserved.
                            </p>
                            <p style="color: #999999; font-size: 12px; line-height: 1.6; margin: 0;">
                                <a href="{$companyUrl}" style="color: #667eea; text-decoration: none;">Visit Website</a> | 
                                <a href="mailto:{$supportEmail}" style="color: #667eea; text-decoration: none;">Contact Support</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
    }
    
    /**
     * Get welcome email template
     */
    private function getWelcomeTemplate($username) {
        $companyName = $this->config['templates']['company_name'];
        $companyUrl = $this->config['templates']['company_url'];
        
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to {$companyName}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 10px;">
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0;">Welcome to {$companyName}!</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #333333; font-size: 16px;">Hi {$username},</p>
                            <p style="color: #333333; font-size: 16px;">
                                Thank you for joining {$companyName}! Your account has been successfully created.
                            </p>
                            <p style="color: #333333; font-size: 16px;">
                                You can now start using our services and enjoy all the benefits of being a member.
                            </p>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{$companyUrl}" style="display: inline-block; padding: 15px 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; border-radius: 8px;">Get Started</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #f9f9f9; padding: 20px; text-align: center; border-top: 1px solid #eeeeee;">
                            <p style="color: #999999; font-size: 12px; margin: 0;">{$companyName} &copy; 2026</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
    }
}
