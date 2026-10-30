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
<title>المراكز</title>
<link rel="stylesheet" href="centers.css">
</head>

<body class="centers-page">

<!--HEADER -->
<header style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px;">
     <div class="logo">
        <img src="img_2.png" alt="logo">
    </div>
    
    <div style="display: flex; gap: 10px; align-items: center;">
        <a href="userpage.php" class="back-btn">العودة الى الرئيسية</a>
        <!--Language button linking to English -->
        <a href="centers-en.php" class="back-btn" style="font-weight: bold; background-color: #f1f1f1; color: #0e4a43;">English</a>
    </div>
</header>

<h1 class="title">دليل المراكز</h1>

<!--بوكس شفاف -->
<div class="centers-container">

<div class="centers-row">

    <!--مركز 1 -->
    <div class="center">
        <a href="https://elajicenter.com/" target="_blank">
            <div class="logo-box">
                <img src="center4.jpg" alt="Center 1">
            </div>
        </a>

        <a href="https://elajicenter.com/" target="_blank" class="center-btn">
            مركز علاجي المتكامل
        </a>

        <div class="pin">📍</div>
        <p>الرياض</p>
    </div>

    <!--مركز 2 -->
    <div class="center">
        <a href="https://www.ameen.care/" target="_blank">
            <div class="logo-box">
                <img src="center3.jpg" alt="Center 2">
            </div>
        </a>

        <a href="https://www.ameen.care/" target="_blank" class="center-btn">
            رعاية أمين
        </a>

        <div class="pin">📍</div>
        <p>الرياض</p>
    </div>

    <!--مركز 3 -->
    <div class="center">
        <a href="https://smartcare.pw/" target="_blank">
            <div class="logo-box">
                <img src="center2.jpg" alt="Center 3">
            </div>
        </a>

        <a href="https://smartcare.pw/" target="_blank" class="center-btn">
            سمارت كير
        </a>

        <div class="pin">📍</div>
        <p>الرياض</p>
    </div>

    <!-- مركز 4 -->
    <div class="center">
        <a href="https://physiotherabia.com/ar/" target="_blank">
            <div class="logo-box">
                <img src="center1.jpg" alt="Center 4">
            </div>
        </a>

        <a href="https://physiotherabia.com/ar/" target="_blank" class="center-btn">
            فيزيوثيرابيا
        </a>

        <div class="pin">📍</div>
        <p>الرياض ,الشرقية, جدة ,المدينة المنورة,تبوك</p>
    </div>
    
    <!--مركز 5 -->
    <div class="center">
        <a href="https://share.google/uoJAFlArSoICCpKtS" target="_blank">
            <div class="logo-box">
                <img src="center5.jpg.jpeg" alt="Center 5">
            </div>
        </a>
        
        <!--Fixed the missing href="" typo here -->
        <a href="https://share.google/uoJAFlArSoICCpKtS" target="_blank" class="center-btn">
            طريق التداوي 
        </a>

        <div class="pin">📍</div>
        <p>عنيزة</p>
    </div>

</div>

</div>

<!--FOOTER -->
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