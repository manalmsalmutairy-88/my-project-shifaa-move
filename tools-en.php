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
        'title' => '1. Hand & Wrist Tools',
        'products' => [
            ['id' => 1, 'label' => 'Thumb & Wrist Brace', 'img' => 't1.jpeg', 'shop' => 'https://shortlink.uk/1uxHK'],
            ['id' => 2, 'label' => 'Hand & Finger Exercise Web', 'img' => 't2.jpeg', 'shop' => 'https://shop.tiriaqq.com/ar/dbEOwKj'],
            ['id' => 3, 'label' => 'Flex Bar', 'img' => 't3.jpeg', 'shop' => 'https://shop.tiriaqq.com/ar/Yggnbog'],
        ]
    ],
    [
        'title' => '2. Rehabilitation & Transfer Tools',
        'products' => [
            ['id' => 4, 'label' => 'Balance Board for Rehabilitation', 'img' => 't4.jpeg', 'shop' => 'https://shop.tiriaqq.com/ar/OqrYAYD'],
            ['id' => 5, 'label' => 'Medical Transfer Sheet with Handles', 'img' => 't5.jpeg', 'shop' => 'https://shortlink.uk/1uxI0'],
            ['id' => 6, 'label' => 'Sliding Sheet for Patient Transfer', 'img' => 't6.jpeg', 'shop' => 'https://shortlink.uk/1uxId'],
        ]
    ],
    [
        'title' => '3. Mobility & Support Tools',
        'products' => [
            ['id' => 7, 'label' => 'Foldable Electric Wheelchair', 'img' => 't7.jpeg', 'shop' => 'https://shortlink.uk/1uxIx'],
            ['id' => 8, 'label' => 'Foldable Aluminum Walking Frame', 'img' => 't8.jpeg', 'shop' => 'https://shortlink.uk/1pd1C'],
            ['id' => 9, 'label' => 'Medical Arm Support', 'img' => 't9.jpeg', 'shop' => 'https://shortlink.uk/1pd1S'],
        ]
    ],
    [
        'title' => '4. Back & Foot Supports',
        'products' => [
            ['id' => 10, 'label' => 'Night Foot Splint', 'img' => 't10.jpeg', 'shop' => 'https://shortlink.uk/1uxJI'],
            ['id' => 11, 'label' => 'Inflatable Walking Boot for Ankle & Foot', 'img' => 't11.jpeg', 'shop' => 'https://goo.su/f3nzT'],
            ['id' => 12, 'label' => 'Back Brace for Posture Correction', 'img' => 't12.jpeg', 'shop' => 'https://shortlink.uk/1uxfr']
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SHIFAA MOVE – Medical Tools</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="tools.css">

<style>

.fav-btn {
    position: absolute;
    top: 10px;
    left: 10px; 
    background: white;
    border: none;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    font-size: 18px;
    cursor: pointer;
    z-index: 10;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
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
    border: 1px solid #8b6f6f;
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
    background: #3e6b66;
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
            toast.innerHTML = "Added to Favorites ❤️";
        } else {
            btn.innerHTML = "🤍";
            toast.innerHTML = "Removed from Favorites 💔";
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
    <button class="nav-btn-home" onclick="location.href='userpage.php'">Back to Home</button>
    <a href="favorites.php" class="nav-btn-home" style="text-decoration: none;">favorites</a>
    <a href="tools.php" class="nav-btn-home" style="text-decoration: none;">العربية</a>
  </nav>
</header>

<section class="hero">
  <h1>Medical & <span class="accent">Mobility Tools</span></h1>
  <p>Your comprehensive guide to tools that assist movement, rehabilitation, and daily patient comfort.</p>
</section>

<main class="container" style="max-width: 1200px; margin: auto; padding: 20px;">
    <?php foreach ($sections as $section): ?>
        <div class="section-title"><?php echo $section['title']; ?></div>
        
        <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;">
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
                    <a href="<?php echo $product['shop']; ?>" target="_blank" class="shop-btn">🛒 purchase link </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</main>

<footer>
  <div class="footer-links">
    <a href="about.html">About Us</a>
    <a href="contact_us.html">Contact Us</a>
    <a href="teerms.html">Privacy Policy & Terms</a>
    <a href="FAQ.html">FAQ</a>
  </div>
</footer>

<div class="toast" id="toast"></div>
</body>
</html>
