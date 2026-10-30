<?php
include 'db.php';
session_start();

$error_msg = "";
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($name === '' || $email === '' || $password === '') {
        $error_msg = "❌ الرجاء تعبئة جميع الحقول";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "❌ صيغة البريد الإلكتروني غير صحيحة";
    } else {
        $messages = [];
        if (strlen($password) < 8) $messages[] = "• 8 أحرف على الأقل";
        if (!preg_match('/[A-Z]/', $password)) $messages[] = "• حرف كبير واحد على الأقل";
        if (!preg_match('/[0-9]/', $password)) $messages[] = "• رقم واحد على الأقل";
        if (!preg_match('/[!@#$%^&*]/', $password)) $messages[] = "• رمز خاص واحد على الأقل";

        if (!empty($messages)) {
            $error_msg = "❌ كلمة المرور يجب أن تحتوي على:<br>" . implode("<br>", $messages);
        } else {
            $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email=? LIMIT 1");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $check = mysqli_stmt_get_result($stmt);

            if ($check && mysqli_num_rows($check) > 0) {
                $error_msg = "❌ البريد الإلكتروني مستخدم مسبقًا";
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($conn, "INSERT INTO users (user_name, email, password, role) VALUES (?, ?, ?, 'user')");
                mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed);
                if (mysqli_stmt_execute($stmt)) {
                    $success_msg = "✅ تم إنشاء الحساب بنجاح! تقدرين تسجلين دخول الآن";
                } else {
                    $error_msg = "❌ صار خطأ أثناء إنشاء الحساب";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب</title>
    <link rel="stylesheet" href="snigup.css">
</head>
<body>

    <header>
        <div class="logo">
    <img src="img_2.png" alt="logo">
</div>

        <nav style="display: flex; gap: 15px; align-items: center;">
            <a href="index.php" class="nav-btn">الصفحة الرئيسية</a>
           
            <!--Language button linking to English -->
            <a href="snigup-en.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">English</a>
        </nav>
    </header>

    <div class="container">
        <div class="card">
            <h2>إنشاء حساب جديد</h2>
            <form method="POST" action="snigup.php">
                <input type="text" name="name" id="name" placeholder="الاسم الكامل" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                <p class="error" id="name-error"></p>

                <input type="email" name="email" id="email" placeholder="البريد الإلكتروني" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                <p class="error" id="email-error"></p>

                <input type="password" name="password" id="password" placeholder="كلمة المرور">
                <p class="error" id="password-error"></p>

                <?php if($error_msg != "") echo "<p id='error-msg' class='error'>$error_msg</p>"; ?>

                <ul class="rules">
                    <li>يجب أن تحتوي على 8 أحرف على الأقل</li>
                    <li>يجب أن تحتوي على حرف كبير واحد</li>
                    <li>يجب أن تحتوي على رقم واحد</li>
                    <li>يجب أن تحتوي على رمز خاص</li>
                </ul>

                <button type="submit" class="main-btn">إنشاء حساب</button>
                <?php if($success_msg != "") echo "<p id='success-msg' class='success'>$success_msg</p>"; ?>
            </form>
            <a href="login.php" class="secondary-btn">تسجيل الدخول</a>
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