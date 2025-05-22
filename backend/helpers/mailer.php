<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function sendResetEmail($email, $token) {
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->SMTPAuth   = $_ENV['MAILER_SMTPAUTH'];
        $mail->Username   = $_ENV['MAILER_USERNAME']; 
        $mail->Password   = $_ENV['MAILER_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAILER_SMTPSECURE'];
        $mail->Port       = $_ENV['MAILER_PORT'];
        $mail->Host       = $_ENV['MAILER_HOST']; 

        //Recipients
        $mail->setFrom( $_ENV['MAILER_USERNAME'], 'UNILORIN');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Click the link to reset your password: <a href='https://yourdomain.com/reset-password.php?token=$token&email=$email'>Reset Password</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Handle error
        return false;
    }
}
