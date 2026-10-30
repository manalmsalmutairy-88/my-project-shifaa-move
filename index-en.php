<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIFAA MOVE</title>
    <link rel="icon" type="image/png" href="img_2.png">
    <link rel="stylesheet" type="text/css" media="screen" href="styleindex.css">
    
    <link rel="stylesheet" href="chatbot.css">
    
    <script src="script-index.js" defer></script>
</head>
<body>

<header>
    <div class="logo">
        <img src="img_2.png" alt="logo">
    </div>

    <div class="header-right">
      
        <a href="pageAfterLogin-en.php" class="nav-btn">Exercises</a>
        <a href="tools-en.php" class="nav-btn">Medical Tools</a>
        <a href="centers-en.php" class="nav-btn">Centers</a>

        <a href="snigup-en.php" class="nav-btn" id="signup-btn">Register</a>
        <a href="login-en.php" class="nav-btn" id="login-btn">Login</a>

        <button class="nav-btn" id="logout-btn" style="display:none;" onclick="logout()">Logout</button>
        <a href="index.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">العربية</a>
    </div>
</header>

<section class="hero" aria-label="Description and Name">
    <div class="brand">
        <main>
            <h2>Shifaa Move</h2>
            <p>Your guide to physiotherapy and rehabilitation</p>
            <p>A free Arabic platform providing guided physiotherapy exercises and assistive tools</p>
            <p>And a directory of physiotherapy centers to support recovery and improve quality of life from home</p>
        </main>
        <div class="hero-inner"></div>
    </div>
</section>

<div class="section-title-wrapper">
    <h2 class="section-title">Services</h2>
</div>

<div class="cards" role="list">
    <article class="card" role="listitem">
        <h3>Exercises</h3>
        <p>Video physiotherapy exercises for the elderly and rehabilitation after injuries or surgeries.</p>
    </article>

    <article class="card" role="listitem">
        <h3>Medical Tools</h3>
        <p>Browse assistive tools and devices with purchase links from trusted sources.</p>
    </article>

    <article class="card" role="listitem">
        <h3>Centers</h3>
        <p>Find nearby physiotherapy centers with contact information and addresses.</p>
    </article>
</div>

<div class="cta-wrapper">
    <h2 class="cta-title">Start Your Recovery Journey Today</h2>
</div>

<div class="cta-buttons">
    <a href="snigup-en.php" class="cta-pill">Register</a>
    <a href="login-en.php" class="cta-pill">Login</a>
</div>

<footer>
    <div class="footer-links">
        <a href="about-en.php">About Us</a>
        <a href="contact_us-en.php">Contact Us</a>
        <a href="teerms-en.php">Privacy Policy & Terms</a>
        <a href="faq-en.php">FAQ</a>
    </div>
</footer>

<div id="chatbot-container"></div>

<script>
function logout() {
    localStorage.removeItem("isLoggedIn");
    window.location.href = "index-en.php";
}
</script>

<script src="chatbot-en.js"></script>

</body>
</html>