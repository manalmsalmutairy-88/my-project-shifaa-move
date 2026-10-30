<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login-en.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
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
        <a href="userpage-en.php" class="nav-btn">Back to Home</a>
      
        <!--Language button linking back to Arabic -->
        <a href="pageAfterLogin.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">العربية</a>
    </nav>

</header>

<!--Cards (Links point to English exercise pages) -->
<section class="main">

    <a href="MuscleToningExercises-en.php" class="box">
       <h3>Muscle Spasms Exercises</h3>  
       <img src="images/injury.png" alt="lock">
    </a>

    <a href="PostOperativeExercises-en.php" class="box">
        <h3>Post-Operative Exercises</h3>
        <img src="images/Post-op.png" alt="lock">
    </a>

    <a href="SeniorsExercises-en.php" class="box">
       <h3>Exercises for Seniors</h3>
       <img src="images/Seniors.png" alt="lock">
    </a>

</section>

<!--Footer -->
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