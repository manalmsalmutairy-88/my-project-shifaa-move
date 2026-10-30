<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$user_name = "المستخدم";

$stmt = mysqli_prepare($conn, "SELECT user_name FROM users WHERE id=? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $user_name = $row['user_name'];
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة المستخدم - SHIFAA MOVE</title>
    <link rel="stylesheet" href="userpage.css">
</head>

<body>

<header>
    <div class="header-right">
        <div class="user-profile">
            <img src="userpage 22.png" alt="User" class="avatar">
            <span><?php echo htmlspecialchars($user_name); ?></span>
        </div>

        <nav>
            <a href="index.php" class="nav-btn">الصفحة الرئيسية</a>
            <a href="favorites.php" class="nav-btn">المفضلة</a>
        </nav>
    </div>

    <div class="header-center">
        <div class="search-box">
            <input type="text" id="userSearch" placeholder="البحث">
            <span class="search-icon">🔍</span>
        </div>
    </div>

    <div class="header-left">
        <!-- 🔥 Functional Language button replacing the old placeholder -->
        <a href="userpage-en.php" style="font-weight: bold; color: #0e4a43; text-decoration: none; padding: 5px 10px;">English</a>

       <a class="nav-btn" id="logout-btn" href="logout.php">تسجيل الخروج</a>

        <div class="logo">
            <img src="img_2.png" alt="SHIFAA MOVE">
        </div>
    </div>
</header>

<section class="welcome-banner">
    <h1>مرحبًا بعودتك، <?php echo htmlspecialchars($user_name); ?> 👋</h1>
    <p>ابدأ رحلتك نحو التعافي وتحسين الحركة اليوم</p>
</section>

<main class="container">
    
    <div class="card">
        <div class="card-title">التمارين</div>
        <div class="card-images">
            <img src="userpage 7.png" alt="تمرين 1">
            <img src="userpage 7-1.png" alt="تمرين 2">
            <img src="userpage 7-2.png" alt="تمرين 3">
        </div>
        <a href="pageAfterLogin.php" class="action-btn">عرض التمارين</a>
    </div>

    <div class="card">
        <div class="card-title">الأدوات الطبية</div>
        <div class="card-images tools-images">
            <img src="userpage 21.png" alt="أداة 1">
            <img src="userpage 21-1.png" alt="أداة 2">
            <img src="userpage 21-2.png" alt="أداة 3">
        </div>
        <a href="tools.php" class="action-btn">عرض الادوات</a>
    </div>

    <div class="card">
        <div class="card-title">المراكز</div>
        <div class="card-images centers-images">
            <img src="userpage 16.png" alt="مركز 1">
            <img src="userpage 16-1.png" alt="مركز 2">
            <img src="userpage 16-2.png" alt="مركز 3">
        </div>
        <a href="centers.php" class="action-btn">عرض المراكز</a>
    </div>

    <p id="noResult" style="display:none; text-align:center; color:#0e4a43; font-weight:bold; width:100%;">
        لا توجد نتائج مطابقة
    </p>

</main>

<footer>
    <div class="footer-links">
        <a href="about.php">من نحن</a>
        <a href="contact_us.php">تواصل معنا</a>
        <a href="teerms.php">سياسة الخصوصية والشروط والأحكام</a>
        <a href="faq.php">الأسئلة الشائعة</a>
    </div>
</footer>

<script>
const userSearch = document.getElementById("userSearch");
const cards = document.querySelectorAll(".card");
const noResult = document.getElementById("noResult");

userSearch.addEventListener("input", function () {
    const value = this.value.trim().toLowerCase();
    let found = false;

    cards.forEach(card => {
        const text = card.innerText.toLowerCase();

        if (text.includes(value) || value === "") {
            card.style.display = "";
            found = true;
        } else {
            card.style.display = "none";
        }
    });

    noResult.style.display = found ? "none" : "block";
});
</script>

</body>
</html>