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
    $message = trim($_POST['messag'] ?? '');

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $subject === '') {
        $msg = "الرجاء تعبئة البيانات بشكل صحيح";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO contact_messages (full_name, email, subject, message) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);

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
                    <h3>رسالة جديدة من الموقع</h3>
                    <b>الاسم:</b> $name <br>
                    <b>الإيميل:</b> $email <br>
                    <b>الموضوع:</b> $subject <br><br>
                    <b>الرسالة:</b><br>
                    $message
                ";

                $mail->send();

                $msg = "تم إرسال رسالتك بنجاح! سنتواصل معك قريباً";

            } catch (Exception $e) {
                $msg = "تم حفظ الرسالة، لكن لم يتم إرسالها على الإيميل";
            }

        } else {
            $msg = "حدث خطأ أثناء الإرسال";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تواصل معنا | SHIFAA MOVE</title>
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
      <a href="index.php" class="nav-btn">الصفحة الرئيسية</a>
      <a href="contact_us-en.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">English</a>
    </nav>
  </div>
</header>

<h2 class="contact-heading">يسعدنا تواصلكم معنا لأي استفسار أرسل رسالتك هنا</h2>

<?php if($msg !== '') echo "<p style='text-align:center;color:#0C4B53;font-weight:bold;'>".htmlspecialchars($msg)."</p>"; ?>

<div class="contact-wrapper">

  <div class="contact-info">
    <h3>معلومات التواصل</h3>
    <div class="info-box">📧 shifaamove@gmail.com</div>
    <div class="info-box">📱 0512345678</div>
  </div>

  <form class="contact-form" method="POST" action="contact_us.php">
    <h3>أرسل رسالتك هنا</h3>
    <input type="text" name="full_name" placeholder="الاسم الثلاثي" required>
    <input type="email" name="email" placeholder="البريد الإلكتروني" required>
    <input type="text" name="subject" placeholder="الموضوع" required>
    <textarea name="messag" placeholder="محتوى الرسالة" required></textarea>
    <button type="submit" class="btn-send">إرسال الرسالة</button>
  </form>

</div>

<footer>
    <div class="footer-links">
        <a href="about.php">من نحن</a>
        <a href="contact_us.php">تواصل معنا</a>
        <a href="teerms.php">سياسة الخصوصية والشروط والأحكام</a>
        <a href="faq.php">الأسئلة الشائعة</a>
    </div>
</footer>

<script src="chatbot.js"></script>
</body>
</html>