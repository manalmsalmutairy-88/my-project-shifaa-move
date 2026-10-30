<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
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
       
        <a href="pageAfterLogin.php" class="nav-btn">التمارين</a>
        <a href="tools.php" class="nav-btn">الأدوات الطبية</a>
        <a href="centers.php" class="nav-btn">المراكز</a>

        <a href="snigup.php" class="nav-btn" id="signup-btn">إنشاء حساب</a>
        <a href="login.php" class="nav-btn" id="login-btn">تسجيل دخول</a>

        <button class="nav-btn" id="logout-btn" style="display:none;" onclick="logout()">تسجيل الخروج</button>
        <a href="index-en.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">English</a>
    </div>
</header>

<section class="hero" aria-label="الوصف والاسم">
    <div class="brand">
        <main>
            <h2>Shifaa Move</h2>
            <p>دليلك للعلاج الطبيعي وإعادة التأهيل</p>
            <p>منصة عربية مجانية توفر تمارين علاج طبيعي موجهة وأدوات مساعدة</p>
            <p>ودليل لمراكز العلاج الطبيعي لدعم التعافي وتحسين جودة الحياة من المنزل</p>
        </main>
        <div class="hero-inner"></div>
    </div>
</section>

<div class="section-title-wrapper">
    <h2 class="section-title">الخدمات</h2>
</div>

<div class="cards" role="list">
    <article class="card" role="listitem">
        <h3>التمارين</h3>
        <p>تمارين علاج طبيعي بالفيديو لكبار السن وإعادة التأهيل بعد الإصابات أو العمليات.</p>
    </article>

    <article class="card" role="listitem">
        <h3>الأدوات الطبية</h3>
        <p>استعرض الأدوات والأجهزة المساندة مع روابط شراء من مصادر موثوقة.</p>
    </article>

    <article class="card" role="listitem">
        <h3>المراكز</h3>
        <p>ابحث عن مراكز العلاج الطبيعي القريبة منك مع معلومات التواصل والعناوين.</p>
    </article>
</div>

<div class="cta-wrapper">
    <h2 class="cta-title">ابدأ رحلة التعافي اليوم</h2>
</div>

<div class="cta-buttons">
    <a href="snigup.php" class="cta-pill">إنشاء حساب</a>
    <a href="login.php" class="cta-pill">تسجيل الدخول</a>
</div>

<footer>
    <div class="footer-links">
        <a href="about.php">من نحن</a>
        <a href="contact_us.php">تواصل معنا</a>
        <a href="teerms.php">سياسة الخصوصية والشروط والأحكام</a>
        <a href="faq.php">الأسئلة الشائعة</a>
    </div>
</footer>

<div id="chatbot-container"></div>

<script>
window.onload = function () {
    let isLoggedIn = localStorage.getItem("isLoggedIn");
    if (isLoggedIn === "true") {
        document.getElementById("login-btn").style.display = "none";
        document.getElementById("signup-btn").style.display = "none";
        document.getElementById("logout-btn").style.display = "inline-block";
    }
};

function logout() {
    localStorage.removeItem("isLoggedIn");
    window.location.href = "index.php";
}
</script>

<script src="chatbot.js"></script>

</body>
</html>