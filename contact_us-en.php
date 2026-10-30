<?php
include 'db.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $subject === '') {
        $msg = "Please fill out all fields correctly.";
    } else {

        $stmt = mysqli_prepare($conn, "INSERT INTO contact_messages (full_name, email, message) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);

        if (mysqli_stmt_execute($stmt)) {

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'shifaamove@gmail.com';
                $mail->Password = 'rcjx uusr bqkv nvhn';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('shifaamove@gmail.com', 'SHIFAA MOVE');
                $mail->addAddress('shifaamove@gmail.com');
                $mail->addReplyTo($email, $name);

                $mail->isHTML(true);
                $mail->Subject = $subject;

                $mail->Body = "
                    <h3>New message from SHIFAA MOVE website</h3>
                    <b>Name:</b> $name <br>
                    <b>Email:</b> $email <br>
                    <b>Subject:</b> $subject <br><br>
                    <b>Message:</b><br>
                    $message
                ";

                $mail->send();

                $msg = "Your message has been sent successfully! We will contact you soon.";

            } catch (Exception $e) {
                $msg = "The message was saved, but the email was not sent.";
            }

        } else {
            $msg = "An error occurred while sending.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Contact Us | SHIFAA MOVE</title>
  <link rel="icon" type="image/png" href="img_2.png">
  <link rel="stylesheet" href="contact_us.css">
  <link rel="stylesheet" href="chatbot.css">
</head>
<body>

<header style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px;">
  <div>
    <img src="img_2.png" alt="logo">
  </div>
  
  <div class="nav-right" style="display: flex; align-items: center; gap: 15px;">
    <nav style="display: flex; gap: 15px; align-items: center;">
      <a href="index-en.php" class="nav-btn">Home</a>
      <a href="contact_us.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">العربية</a>
    </nav>
  </div>
</header>

<h2 class="contact-heading">We are happy to hear from you. Send your inquiries here.</h2>

<?php if($msg !== '') echo "<p style='text-align:center;color:#0C4B53;font-weight:bold;'>".htmlspecialchars($msg)."</p>"; ?>

<div class="contact-wrapper">

  <div class="contact-info">
    <h3>Contact Information</h3>
    <div class="info-box">📧 shifaamove@gmail.com</div>
    <div class="info-box">📱 0512345678</div>
  </div>

  <form class="contact-form" method="POST" action="contact_us-en.php">
    <h3>Send Your Message Here</h3>
    <input type="text" name="full_name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="text" name="subject" placeholder="Subject" required>
    <textarea name="messag" placeholder="Message Content" required></textarea>
    <button type="submit" class="btn-send">Send Message</button>
  </form>

</div>

<footer>
    <div class="footer-links">
        <a href="about-en.php">About Us</a>
        <a href="contact_us-en.php">Contact Us</a>
        <a href="teerms-en.php">Privacy Policy & Terms</a>
        <a href="faq-en.php">FAQ</a>
    </div>
</footer>

<script src="chatbot-en.js"></script>
</body>
</html>