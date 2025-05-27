<?php
// Disable error display for production (remove warnings from output)
error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', 0);

// Include PHPMailer
require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';
require __DIR__ . '/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize variables
$name = $email = $subject = $phone = $message = "";
$error = $success = "";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $message = filter_var($_POST['message'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    // Validate form data
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        $error = "Name, email, phone, and message are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Set up PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings (Gmail SMTP)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'maviajabbar460@gmail.com'; // Your Gmail address
            $mail->Password = 'ifuf fddo iaun mnqe'; // Replace with your Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress('maviajabbar460@gmail.com'); // Your email for submissions
            $mail->addReplyTo($email, $name);

            // Content
            $mail->isHTML(false);
            $mail->Subject = $subject ? "New Contact Form Submission: $subject" : "New Contact Form Submission";
            $mail->Body = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage:\n$message";

            // Send email
            $mail->send();
            $success = "Thank you, $name! Your message has been sent.";
        } catch (Exception $e) {
            $error = "Failed to send the message. Error: {$mail->ErrorInfo}";
        }
    }
    // Redirect back to contactme.html with success or error message
    $status = $success ? urlencode($success) : urlencode($error);
    header("Location: /contactme.html?status=$status");
    exit;
}
?>