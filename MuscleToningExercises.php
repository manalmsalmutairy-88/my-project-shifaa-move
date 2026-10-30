<?php
include 'db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// جلب التمارين المحفوظة للمستخدم
$savedFavs = [];
$favResult = mysqli_query($conn, "SELECT video_id FROM favorites WHERE user_id='$user_id' AND video_id IS NOT NULL");

while ($fav = mysqli_fetch_assoc($favResult)) {
    $savedFavs[] = $fav['video_id'];
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>تمارين الشدود العضلية</title>
<link rel="stylesheet" href="MuscleToningExercises.css">

<style>
    body {
        direction: rtl;
        background-color: #f5f7f8;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .header { 
        width: 100%; 
        box-sizing: border-box;
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        padding: 15px 50px; 
        background: #eef5f6; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.05); 
    }

    .nav-btn { 
        text-decoration: none; 
        padding: 8px 18px; 
        background: #cde5e8; 
        color: #000; 
        border-radius: 20px; 
        font-size: 14px; 
        transition: 0.3s; 
    }

    .title {
        padding: 20px 50px;
        margin-top: 20px;
        color: #0e4a43;
        font-size: 24px;
    }

    .cards {
        display: flex;
        flex-wrap: wrap;
        gap: 25px;
        justify-content: center;
        padding: 20px 50px;
    }

    .card {
        width: 300px;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: 0.3s;
        position: relative;
    }

    .card:hover { transform: translateY(-5px); }

    .card h3 {
        background-color: #cde5e8;
        margin: 0;
        padding: 15px;
        font-size: 15px;
        text-align: center;
        color: #000;
        min-height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .video-preview {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
        background: #000;
    }

    .fav-btn {
        position: absolute;
        top: 10px;
        right: 10px; 
        background: white;
        border: none;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        font-size: 18px;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .popup { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); justify-content: center; align-items: center; z-index: 999; }
    .popup-content { position: relative; width: 90%; max-width: 300px; }
    .popup video { width: 100%; border-radius: 10px; }
    .close { position: absolute; top: -40px; right: 0; font-size: 35px; color: white; cursor: pointer; }
    
    footer { background: #cce7e7; padding: 15px; text-align: center; margin-top: 50px; width: 100%; box-sizing: border-box; }
    
    .footer-links { display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; }
    .footer-links a { text-decoration: none; color: #666; font-size: 14px; position: relative; padding: 0 10px; }
    .footer-links a:not(:last-child)::after { content: "|"; position: absolute; left: -10px; color: #999; }
</style>

<script>
function openVideo(videoSrc) {
    const popup = document.getElementById("videoPopup");
    const video = document.getElementById("videoPlayer");
    video.src = videoSrc;
    popup.style.display = "flex";
    video.play();
}
function closeVideo() {
    const popup = document.getElementById("videoPopup");
    const video = document.getElementById("videoPlayer");
    video.pause();
    video.src = "";
    popup.style.display = "none";
}
function toggleFavorite(btn, id, type) {
    let data = type === "video" ? "video_id=" + id : "tool_id=" + id;
    fetch("add_favorite.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: data
    })
    .then(res => res.text())
    .then(result => {
        result = result.trim();
        if (result === "added") { btn.innerHTML = "❤️"; showFavMessage("تمت الإضافة للمفضلة ❤️"); }
        else if (result === "removed") { btn.innerHTML = "🤍"; showFavMessage("تمت الإزالة من المفضلة 💔"); }
    });
}
function showFavMessage(text) {
    let msg = document.getElementById("favMessage");
    if (!msg) {
        msg = document.createElement("div"); msg.id = "favMessage";
        msg.style = "position:fixed; top:20px; left:50%; transform:translateX(-50%); background:#e8fff8; color:#0e4a43; padding:12px 20px; border-radius:12px; font-weight:bold; box-shadow:0 4px 12px rgba(0,0,0,0.15); z-index:99999;";
        document.body.appendChild(msg);
    }
    msg.innerHTML = text; msg.style.display = "block";
    setTimeout(() => { msg.style.display = "none"; }, 2000);
}
</script>
</head>

<body>

<header class="header">
    <div class="logo">
        <img src="images/logo.png" alt="logo" style="width:140px;">
    </div>
    <nav style="display: flex; gap: 15px; align-items: center;">
        <a href="userpage.php" class="nav-btn">الصفحة الرئيسية</a>
        <a href="pageAfterLogin.php" class="nav-btn">قائمة التمارين الرئيسية</a>
        <a href="favorites.php" class="nav-btn">المفضلة</a>
        <a href="MuscleToningExercises-en.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">English</a>
    </nav>
</header>

<!--قسم الرقبة -->
<h2 class="title">الشدود العضلية: الرقبة</h2>
<div class="cards">
    <?php 
    $neck_videos = [13 => "Neck stretches (جانبي)<br>إمالة الرأس يمين ويسار", 15 => "Chin tucks<br>سحب الذقن للداخل", 14 => "Upper trap stretch<br>شد جانب الرقبة بلطف"];
    foreach($neck_videos as $id => $title): ?>
    <div class="card">
        <button type="button" class="fav-btn" onclick="toggleFavorite(this, <?php echo $id; ?>, 'video')">
            <?php echo in_array($id, $savedFavs) ? '❤️' : '🤍'; ?>
        </button>
        <div onclick="openVideo('Vid/video_<?php echo $id; ?>.mp4')">
            <h3><?php echo $title; ?></h3>
            <video class="video-preview" src="Vid/video_<?php echo $id; ?>.mp4#t=0.1" muted></video>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!--قسم الظهر -->
<h2 class="title">الشدود العضلية: أسفل الظهر</h2>
<div class="cards">
    <?php 
    $back_videos = [17 => "Knee to chest<br>سحب الركبة للصدر", 19 => "Cat-Cow stretch<br>تقوس وفرد الظهر", 18 => "Child’s pose<br>إطالة أسفل الظهر"];
    foreach($back_videos as $id => $title): ?>
    <div class="card">
        <button type="button" class="fav-btn" onclick="toggleFavorite(this, <?php echo $id; ?>, 'video')">
            <?php echo in_array($id, $savedFavs) ? '❤️' : '🤍'; ?>
        </button>
        <div onclick="openVideo('Vid/video_<?php echo $id; ?>.mp4')">
            <h3><?php echo $title; ?></h3>
            <video class="video-preview" src="Vid/video_<?php echo $id; ?>.mp4#t=0.1" muted></video>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!--قسم الأرجل -->
<h2 class="title">الشدود العضلية: الأرجل</h2>
<div class="cards">
    <?php 
    $leg_videos = [20 => "Hamstring stretch<br>إطالة خلف الفخذ", 21 => "Calf stretch<br>شد عضلة الساق الخلفية", 22 => "Quad stretch<br>إطالة الأمامية للفخذ"];
    foreach($leg_videos as $id => $title): ?>
    <div class="card">
        <button type="button" class="fav-btn" onclick="toggleFavorite(this, <?php echo $id; ?>, 'video')">
            <?php echo in_array($id, $savedFavs) ? '❤️' : '🤍'; ?>
        </button>
        <div onclick="openVideo('Vid/video_<?php echo $id; ?>.mp4')">
            <h3><?php echo $title; ?></h3>
            <video class="video-preview" src="Vid/video_<?php echo $id; ?>.mp4#t=0.1" muted></video>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div id="videoPopup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeVideo()">✖</span>
        <video id="videoPlayer" controls></video>
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