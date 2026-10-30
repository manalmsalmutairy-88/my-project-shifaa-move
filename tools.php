<?php
include 'db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
// get user's saved tools from database
$savedTools = [];
$res = mysqli_query($conn, "SELECT tool_id FROM favorites WHERE user_id='$user_id' AND tool_id IS NOT NULL");
while ($row = mysqli_fetch_assoc($res)) {
    $savedTools[] = $row['tool_id'];
}

$sections = [
    [
        'title' => '1. أدوات اليد والمعصم',
        'products' => [
            ['id' => 1, 'label' => 'دعامة الإبهام والمعصم', 'img' => 't1.jpeg', 'shop' => 'https://shortlink.uk/1uxHK'],
            ['id' => 2, 'label' => 'شبكة تمارين اليد والأصابع', 'img' => 't2.jpeg', 'shop' => 'https://shop.tiriaqq.com/ar/dbEOwKj'],
            ['id' => 3, 'label' => 'فلكس بار', 'img' => 't3.jpeg', 'shop' => 'https://shop.tiriaqq.com/ar/Yggnbog'],
        ]
    ],
    [
        'title' => '2. أدوات التأهيل والتقليب',
        'products' => [
            ['id' => 4, 'label' => 'لوحة التوازن للتأهيل', 'img' => 't4.jpeg', 'shop' => 'https://shop.tiriaqq.com/ar/OqrYAYD'],
            ['id' => 5, 'label' => 'ملاءة نقل طبي بمقابض', 'img' => 't5.jpeg', 'shop' => 'https://shortlink.uk/1uxI0'],
            ['id' => 6, 'label' => 'ملاءة انزلاق لنقل المرضى', 'img' => 't6.jpeg', 'shop' => 'https://shortlink.uk/1uxId'],
        ]
    ],
    [
        'title' => '3. أدوات الحركة والدعم',
        'products' => [
            ['id' => 7, 'label' => 'كرسي متحرك كهربائي قابل للطي', 'img' => 't7.jpeg', 'shop' => 'https://shortlink.uk/1uxIx'],
            ['id' => 8, 'label' => 'إطار مشي (عكاز) ألومنيوم قابل للطي', 'img' => 't8.jpeg', 'shop' => 'https://shortlink.uk/1pd1C'],
            ['id' => 9, 'label' => 'حامل ذراع طبي', 'img' => 't9.jpeg', 'shop' => 'https://shortlink.uk/1pd1S'],
        ]
    ],
    [
        'title' => '4. دعامات الظهر والقدم',
        'products' => [
            ['id' => 10, 'label' => 'جبيرة قدم ليلية', 'img' => 't10.jpeg', 'shop' => 'https://shortlink.uk/1uxJI'],
            ['id' => 11, 'label' => 'حذاء مشي هوائي للكاحل والقدم', 'img' => 't11.jpeg', 'shop' => 'https://goo.su/f3nzT'],
            ['id' => 12, 'label' => 'دعامة الظهر لتصحيح القوام', 'img' => 't12.jpeg', 'shop' => 'https://shortlink.uk/1uxfr']
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>شفاء موف – الأدوات الطبية</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="tools.css">

<style>

.fav-btn {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: #f0f0f0;
    color: #333;
    border: none;
    border-radius: 5px;
    padding: 5px 15px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    z-index: 10;
    font-family: 'Cairo', sans-serif;
    transition: 0.3s;
}

.fav-btn:hover {
    background-color: #e0e0e0;
    transform: translateY(-2px);
}
/* toast appears at bottom right after add/remove */
.toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #3e6b66;
    color: white;
    padding: 10px 15px;
    border-radius: 8px;
    display: none;
    z-index: 1000;
}

.section-title {
    background: #3e6b66;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    margin: 30px 0 15px 0;
    font-size: 20px;
    font-weight: bold;
}
/* horizontal scrollable row */
.product-grid {
    display: flex !important;
    overflow-x: auto !important;
    gap: 20px;
    margin-bottom: 30px;
    padding-bottom: 15px;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
}

.product-grid::-webkit-scrollbar {
    height: 6px;
}
.product-grid::-webkit-scrollbar-thumb {
    background: #3e6b66;
    border-radius: 10px;
}
/* flex: 0 0 prevents card from shrinking */
.product-card {
    flex: 0 0 280px;
    position: relative;
    background: white;
    border-radius: 15px;
    padding: 15px;
    border: 1px solid #e0e0e0;
    text-align: center;
    transition: 0.3s;
}

.product-card img {
    width: 100%;
    height: 180px;
    object-fit: contain;
    background: #fdfdfd;
    border-radius: 10px;
}

.product-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.shop-btn {
    display: block;
    margin: 10px auto 0;
    padding: 8px 18px;
    background: #3e6b66;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    transition: 0.2s;
}

.shop-btn:hover {
    opacity: 0.9;
}
</style>

<script>
    // toggle add/remove from favorites without page reload
function toggleFav(btn, toolId) {
    fetch("add_favorite.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "tool_id=" + toolId
    })
    .then(res => res.text())
    .then(data => {
        let toast = document.getElementById("toast");
        if (data.trim() === "added") {
            btn.innerHTML = "❤️";
            toast.innerHTML = "تمت الإضافة للمفضلة ❤️";
        } else {
            btn.innerHTML = "🤍";
            toast.innerHTML = "تمت الإزالة من المفضلة 💔";
        }
        toast.style.display = "block";
        setTimeout(() => toast.style.display = "none", 2000);
    });
}
</script>
</head>

<body>
<header>
  <div class="logo">
    <img src="img_2.png" alt="SHIFAA MOVE">
  </div>
  <nav class="header-nav" style="display: flex; gap: 10px; align-items: center;">
    <button class="nav-btn-home" onclick="location.href='userpage.php'">الرجوع إلى الرئيسية</button>
    <a href="favorites.php" class="nav-btn-home" style="text-decoration: none;">المفضلة</a>
    <a href="tools-en.php" class="nav-btn-home" style="text-decoration: none;">English</a>
  </nav>
</header>

<section class="hero">
  <h1>الأدوات <span class="accent">الطبية والحركية</span></h1>
  <p>دليلك الشامل للأدوات التي تساعد على الحركة، التأهيل، والراحة اليومية للمرضى.</p>
</section>

<main class="container" style="max-width: 1200px; margin: auto; padding: 20px;">
    <?php foreach ($sections as $section): ?>
        <div class="section-title"><?php echo $section['title']; ?></div>
        
        <div class="product-grid">
            <?php foreach ($section['products'] as $product): ?>
                <?php $isFav = in_array($product['id'], $savedTools) ? '❤️' : '🤍'; ?>
                <div class="product-card">
                    <button class="fav-btn" onclick="toggleFav(this, <?php echo $product['id']; ?>)">
                        <?php echo $isFav; ?>
                    </button>
                    <img src="<?php echo $product['img']; ?>" alt="<?php echo $product['label']; ?>">
                    <div class="card-label" style="margin-top: 12px; font-weight: bold; color: #444;">
                        <?php echo $product['label']; ?>
                    </div>
                    <a href="<?php echo $product['shop']; ?>" target="_blank" class="shop-btn">🛒 رابط الشراء</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</main>

<footer>
  <div class="footer-links">
    <a href="about.php">من نحن</a>
    <a href="contact_us.php">تواصل معنا</a>
    <a href="teerms.php">>سياسة الخصوصية والشروط والأحكام</a>
    <a href="FAQ.php">الأسئلة الشائعة</a>
    </a>
  </div>
</footer>

<div class="toast" id="toast"></div>
</body>
</html>