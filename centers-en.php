<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    // Redirects English users to the English login page
    header("Location: login-en.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<title>Centers</title>
<link rel="stylesheet" href="centers.css">
</head>

<body class="centers-page">

<!--HEADER -->
<header style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px;">
     <div class="logo">
        <img src="img_2.png" alt="logo">
    </div>
    
    <div style="display: flex; gap: 10px; align-items: center;">
        <a href="userpage-en.php" class="back-btn">Back to Home</a>
        <a href="centers.php" class="back-btn" style="font-weight: bold; background-color: #f1f1f1; color: #0e4a43;">العربية</a>
    </div>
</header>

<h1 class="title">Centers Directory</h1>

<!--Transparent Box -->
<div class="centers-container">

<div class="centers-row">

    <!--Center 1 -->
    <div class="center">
        <a href="https://elajicenter.com/" target="_blank">
            <div class="logo-box">
                <img src="center4.jpg" alt="Center 1">
            </div>
        </a>

        <a href="https://elajicenter.com/" target="_blank" class="center-btn">
            Elaji Integrated Center
        </a>

        <div class="pin">📍</div>
        <p>Riyadh</p>
    </div>

    <!-- Center 2 -->
    <div class="center">
        <a href="https://www.ameen.care/" target="_blank">
            <div class="logo-box">
                <img src="center3.jpg" alt="Center 2">
            </div>
        </a>

        <a href="https://www.ameen.care/" target="_blank" class="center-btn">
            Ameen Care
        </a>

        <div class="pin">📍</div>
        <p>Riyadh</p>
    </div>

    <!-- Center 3 -->
    <div class="center">
        <a href="https://smartcare.pw/" target="_blank">
            <div class="logo-box">
                <img src="center2.jpg" alt="Center 3">
            </div>
        </a>

        <a href="https://smartcare.pw/" target="_blank" class="center-btn">
            Smart Care
        </a>

        <div class="pin">📍</div>
        <p>Riyadh</p>
    </div>

    <!-- Center 4 -->
    <div class="center">
        <a href="https://physiotherabia.com/ar/" target="_blank">
            <div class="logo-box">
                <img src="center1.jpg" alt="Center 4">
            </div>
        </a>

        <a href="https://physiotherabia.com/ar/" target="_blank" class="center-btn">
            Physiotherabia
        </a>

        <div class="pin">📍</div>
        <p>Riyadh, Eastern Province, Jeddah, Medina, Tabuk</p>
    </div>
    
    <!-- Center 5 -->
    <div class="center">
        <a href="https://share.google/uoJAFlArSoICCpKtS" target="_blank">
            <div class="logo-box">
                <img src="center5.jpg.jpeg" alt="Center 5">
            </div>
        </a>

        <a href="https://share.google/uoJAFlArSoICCpKtS" target="_blank" class="center-btn">
            Tareeq Al-Tadawi
        </a>

        <div class="pin">📍</div>
        <p>Unaizah</p>
    </div>

</div>

</div>

<!--FOOTER -->
 <footer>
    <div class="footer-links">
        <a href="about-en.php">About Us</a>
        <a href="contact_us-en.php">Contact Us</a>
        <a href="teerms-en.php">Privacy Policy & Terms</a>
        <a href="faq-en.php">FAQ</a>
    </div>
</footer>

</body>
</html>