<?php
include 'db.php';
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = trim($_POST['password'] ?? '');

    if ($email === '' || $pass === '') {
        $error = "❌ الرجاء إدخال البريد وكلمة المرور";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, email, password, role FROM users WHERE email=? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            $stored = $user['password'];
            $ok = password_verify($pass, $stored) || $pass === $stored;

            if ($ok) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                header("Location: userpage.php");
                exit();
            }
        }
        $error = "❌ البريد أو كلمة المرور غير صحيحة";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<header>
    <div class="logo">
        <img src="img_2.png" alt="logo">
    </div>

    <nav style="display: flex; gap: 15px; align-items: center;">
        <a href="index.php" class="nav-btn">الصفحة الرئيسية</a>
       
        <!-- 🔥 Language button linking to English -->
        <a href="login-en.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">English</a>
    </nav>
</header>

<div class="container">
    <div class="card">
        <h2>تسجيل الدخول</h2>

        <?php if($error != "") echo "<p class='error'>$error</p>"; ?>

        <form method="POST" action="login.php">

    <input type="email" name="email" id="email" placeholder="البريد الإلكتروني" required>
    <p id="email-error" class="error"></p>

    <input type="password" name="password" id="password" placeholder="كلمة المرور" required>
    <p id="password-error" class="error"></p>

   

    <button type="submit" class="main-btn">تسجيل الدخول</button>
 <div class="forgot-container">
        <a href="forgot_password.php" class="forgot-link">
            نسيت كلمة المرور؟
        </a>
    </div>
</form>

       

       <a href="snigup.php" class="secondary-btn">إنشاء حساب</a>
    </div>
</div>

 <footer>
    <div class="footer-links">
        <a href="about.php">من نحن</a>
        <a href="contact_us.php">تواصل معنا</a>
        <a href="teerms.php">سياسة الخصوصية والشروط والأحكام</a>
        <a href="faq.php">الأسئلة الشائعة</a>
    </div>
</footer>
</body>
</html>