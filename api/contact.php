
<?php
// Start output buffering to prevent headers issue
ob_start();

// Disable error display for production
error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', 0);

// Include PHPMailer
require_once __DIR__ . '/src/PHPMailer.php';
require_once __DIR__ . '/src/SMTP.php';
require_once __DIR__ . '/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Prevent direct access to this file
if (empty($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /contactme.html');
    exit;
}

// Initialize variables
$name = $email = $subject = $phone = $message = '';
$error = $success = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get and sanitize form data
    $name = filter_var($_POST['formname'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['formemail'] ?? '', FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    // Validate form data
    if (empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)) {
        $error = "All fields are required!";
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
            $mail->Password = 'your_app_password'; // Replace with your Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress('maviajabbar460@gmail.com'); // Your email
            $mail->addReplyTo($email', $name);

            // Content
            $mail->isHTML(false);
            $mail->Subject = $subject ? "New Contact Form Submission: $subject" : "New Contact Form Submission";
            $mail->Body = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage:\n$message";

            // Send email
            $mail->send();
            $success = "Thank you, $name! Your message has been sent.";
        } catch (Exception $e) {
            $error = "Failed to send the message. Error: {$e->getMessage()}";
        }
    }

    // Redirect back to contactme.html with success or error message
    $status = $success ? urlencode($success) : urlencode($error);
    header("Location: /contactme.html?status=$status");
    exit;
}

// Clean up output buffer
ob_end_flush();
?>
```

