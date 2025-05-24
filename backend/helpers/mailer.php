<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


function sendResetEmail($email, $token) {
    $mail = new PHPMailer(true);

    try {
        // SMTP server configuration
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAILER_HOST']; 
        $mail->SMTPAuth   = filter_var($_ENV['MAILER_SMTPAUTH'], FILTER_VALIDATE_BOOLEAN);
        $mail->Username   = $_ENV['MAILER_USERNAME']; 
        $mail->Password   = $_ENV['MAILER_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAILER_SMTPSECURE']; // 'tls' or 'ssl'
        $mail->Port       = (int) $_ENV['MAILER_PORT']; 

        // Sender and recipient
        $mail->setFrom($_ENV['MAILER_USERNAME'], 'UNILORIN Recruitment Portal');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';

        $resetLink =  $_ENV['DOMAIN'] . "reset-password.php?display=reset_password&token=" . urlencode($token) . "&email=" . urlencode($email);
        $mail->Body = "
            <h3>Password Reset Request</h3>
            <p>We received a request to reset your password.</p>
            <p>Click the link below to reset it:</p>
            <a href='{$resetLink}'>Reset Password</a>
            <p>If you didn’t request this, please ignore this email.</p>
        ";

        $mail->AltBody = "To reset your password, visit this link: $resetLink";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo); // log error
        echo json_encode([
            'message' => $mail->ErrorInfo,  
        ]);
        return false;
    }
}
