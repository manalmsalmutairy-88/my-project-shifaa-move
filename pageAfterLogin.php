<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>SHIFAA MOVE</title>
<link rel="stylesheet" href="pageAfterLogin.css">
<link rel="stylesheet" href="chatbot.css">
</head>

<body>

<!--HEADER -->
<header class="header">

    <div class="logo">
        <img src="images/logo.png" alt="logo">
    </div>

    <nav style="display: flex; gap: 15px; align-items: center;">
        <a href="userpage.php" class="nav-btn">الرجوع الى الرئيسية</a>
      
        <!--Language button linking to English -->
        <a href="pageAfterLogin-en.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">English</a>
    </nav>

</header>

<!--الكروت -->
<section class="main">

    <a href="MuscleToningExercises.php" class="box">
       <h3>تمارين الشدود العضلية</h3>  
       <img src="images/injury.png" alt="lock">
    </a>

    <a href="PostOperativeExercises.php" class="box">
        <h3>تمارين مابعد العمليات</h3>
        <img src="images/Post-op.png" alt="lock">
    </a>

    <a href="SeniorsExercises.php" class="box">
       <h3>تمارين لكبار السن</h3>
       <img src="images/Seniors.png" alt="lock">
    </a>

</section>

<!--الفوتر -->
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