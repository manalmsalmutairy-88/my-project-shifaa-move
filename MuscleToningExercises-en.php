<?php
include 'db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login-en.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch user's saved exercises
$savedFavs = [];
$favResult = mysqli_query($conn, "SELECT video_id FROM favorites WHERE user_id='$user_id' AND video_id IS NOT NULL");

while ($fav = mysqli_fetch_assoc($favResult)) {
    $savedFavs[] = $fav['video_id'];
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<title>Muscle Toning Exercises</title>
<link rel="stylesheet" href="MuscleToningExercises.css">

<style>
    body {
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
        font-size: 16px;
        text-align: center;
        color: #000;
        min-height: 50px;
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
    }

    .popup { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); justify-content: center; align-items: center; z-index: 999; }
    .popup-content { position: relative; width: 90%; max-width: 300px; }
    .popup video { width: 100%; border-radius: 10px; }
    .close { position: absolute; top: -40px; right: 0; font-size: 35px; color: white; cursor: pointer; }
    
    footer { background: #cce7e7; padding: 15px; text-align: center; margin-top: 50px; width: 100%; box-sizing: border-box; }
    
    .footer-links { display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; }
    .footer-links a { text-decoration: none; color: #666; font-size: 14px; position: relative; padding: 0 10px; }
    
    /*Left EXACTLY as you provided it (with the :::) so it matches your other page perfectly! */
    .footer-links a:not(:last-child):::after { content: "|"; position: absolute; right: -10px; color: #999; }
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
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: data
    })
    .then(res => res.text())
    .then(result => {
        result = result.trim();

        if (result === "added") {
            btn.innerHTML = "❤️";
            showFavMessage("Added to favorites ❤️");
        } else if (result === "removed") {
            btn.innerHTML = "🤍";
            showFavMessage("Removed from favorites 💔");
        } else {
            showFavMessage("An error occurred, please try again");
        }
    });
}

function showFavMessage(text) {
    let msg = document.getElementById("favMessage");

    if (!msg) {
        msg = document.createElement("div");
        msg.id = "favMessage";
        msg.style.position = "fixed";
        msg.style.top = "20px";
        msg.style.left = "50%";
        msg.style.transform = "translateX(-50%)";
        msg.style.background = "#e8fff8";
        msg.style.color = "#0e4a43";
        msg.style.padding = "12px 20px";
        msg.style.borderRadius = "12px";
        msg.style.fontWeight = "bold";
        msg.style.boxShadow = "0 4px 12px rgba(0,0,0,0.15)";
        msg.style.zIndex = "99999";
        document.body.appendChild(msg);
    }

    msg.innerHTML = text;
    msg.style.display = "block";

    setTimeout(() => {
        msg.style.display = "none";
    }, 2000);
}

window.onload = function() {
    const video = document.getElementById("videoPlayer");
    const popup = document.getElementById("videoPopup");

    video.onended = function() {
        closeVideo();
    };

    popup.onclick = function(e) {
        if (e.target.id === "videoPopup") {
            closeVideo();
        }
    };
};
</script>

</head>

<body>

<header class="header">
    <div class="logo">
        <img src="images/logo.png" alt="logo">
    </div>
    <nav style="display: flex; gap: 15px; align-items: center;">
        <a href="userpage-en.php" class="nav-btn">Home</a>
        <a href="pageAfterLogin-en.php" class="nav-btn">Main Exercises List</a>
        <a href="favorites-en.php" class="nav-btn">Favorites</a>
        <a href="MuscleToningExercises.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">العربية</a>
    </nav>
</header>

<h2 class="title">Muscle Spasms: Neck</h2>

<div class="cards">

<div class="card">
<button type="button" class="fav-btn" onclick="toggleFavorite(this, 13, 'video')">
    <?php echo in_array(13, $savedFavs) ? '❤️' : '🤍'; ?>
</button>
<div onclick="openVideo('Vid/video_13.mp4')">
<h3>Neck Stretches</h3>
<video class="video-preview" src="Vid/video_13.mp4#t=0.1" muted></video>
</div>
</div>

<div class="card">
<button type="button" class="fav-btn" onclick="toggleFavorite(this, 15, 'video')">
    <?php echo in_array(15, $savedFavs) ? '❤️' : '🤍'; ?>
</button>
<div onclick="openVideo('Vid/video_15.mp4')">
<h3>Chin Tucks</h3>
<video class="video-preview" src="Vid/video_15.mp4#t=0.1" muted></video>
</div>
</div>

<div class="card">
<button type="button" class="fav-btn" onclick="toggleFavorite(this, 14, 'video')">
    <?php echo in_array(14, $savedFavs) ? '❤️' : '🤍'; ?>
</button>
<div onclick="openVideo('Vid/video_14.mp4')">
<h3>Upper Trap Stretch</h3>
<video class="video-preview" src="Vid/video_14.mp4#t=0.1" muted></video>
</div>
</div>

</div>

<h2 class="title">Lower Back</h2>

<div class="cards">

<div class="card">
<button type="button" class="fav-btn" onclick="toggleFavorite(this, 17, 'video')">
    <?php echo in_array(17, $savedFavs) ? '❤️' : '🤍'; ?>
</button>
<div onclick="openVideo('Vid/video_17.mp4')">
<h3>Knee to Chest</h3>
<video class="video-preview" src="Vid/video_17.mp4#t=0.1" muted></video>
</div>
</div>

<div class="card">
<button type="button" class="fav-btn" onclick="toggleFavorite(this, 19, 'video')">
    <?php echo in_array(19, $savedFavs) ? '❤️' : '🤍'; ?>
</button>
<div onclick="openVideo('Vid/video_19.mp4')">
<h3>Cat-Cow</h3>
<video class="video-preview" src="Vid/video_19.mp4#t=0.1" muted></video>
</div>
</div>

<div class="card">
<button type="button" class="fav-btn" onclick="toggleFavorite(this, 18, 'video')">
    <?php echo in_array(18, $savedFavs) ? '❤️' : '🤍'; ?>
</button>
<div onclick="openVideo('Vid/video_18.mp4')">
<h3>Child Pose</h3>
<video class="video-preview" src="Vid/video_18.mp4#t=0.1" muted></video>
</div>
</div>

</div>

<h2 class="title">Muscle Spasms: Legs</h2>

<div class="cards">

<div class="card">
<button type="button" class="fav-btn" onclick="toggleFavorite(this, 20, 'video')">
    <?php echo in_array(20, $savedFavs) ? '❤️' : '🤍'; ?>
</button>
<div onclick="openVideo('Vid/video_20.mp4')">
<h3>Hamstring Stretch</h3>
<video class="video-preview" src="Vid/video_20.mp4#t=0.1" muted></video>
</div>
</div>

<div class="card">
<button type="button" class="fav-btn" onclick="toggleFavorite(this, 21, 'video')">
    <?php echo in_array(21, $savedFavs) ? '❤️' : '🤍'; ?>
</button>
<div onclick="openVideo('Vid/video_21.mp4')">
<h3>Calf Stretch</h3>
<video class="video-preview" src="Vid/video_21.mp4#t=0.1" muted></video>
</div>
</div>

<div class="card">
<button type="button" class="fav-btn" onclick="toggleFavorite(this, 22, 'video')">
    <?php echo in_array(22, $savedFavs) ? '❤️' : '🤍'; ?>
</button>
<div onclick="openVideo('Vid/video_22.mp4')">
<h3>Quad Stretch</h3>
<video class="video-preview" src="Vid/video_22.mp4#t=0.1" muted></video>
</div>
</div>

</div>

<div id="videoPopup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeVideo()">✖</span>
        <video id="videoPlayer" controls></video>
    </div>
</div>

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