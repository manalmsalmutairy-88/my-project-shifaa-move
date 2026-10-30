<?php
include 'db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login-en.php");
    exit();
}

$user_id = $_SESSION["user_id"];

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
<title>Exercises - Post-Operative</title>
<link rel="stylesheet" href="MuscleToningExercises.css">

<style>
.cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding: 20px;
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

.card:hover {
    transform: translateY(-5px);
}

.card h3 {
    background-color: #ddeeee;
    margin: 0;
    padding: 15px;
    font-size: 15px;
    text-align: center;
    min-height: 80px;
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
    left: 10px; /* Kept left for English LTR layout naturally */
    background: white;
    border: none;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    cursor: pointer;
    font-size: 20px;
    z-index: 20;
    box-shadow: 0 3px 8px rgba(0,0,0,0.2);
}

.popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.85);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.popup-content {
    position: relative;
    width: 90%;
    max-width: 300px;
}

.popup video {
    width: 100%;
    border-radius: 10px;
}

.close {
    position: absolute;
    top: -40px;
    right: 0;
    font-size: 35px;
    color: white;
    cursor: pointer;
}
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
        <!--Language button linking back to Arabic -->
        <a href="PostOperativeExercises.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">العربية</a>
    </nav>
</header>

<h2 class="title">Post-Operative Exercises <br> Knee Replacement: </h2>

<div class="cards">

    <div class="card">
        <button type="button" class="fav-btn" onclick="toggleFavorite(this, 16, 'video')">
            <?php echo in_array(16, $savedFavs) ? '❤️' : '🤍'; ?>
        </button>

        <div onclick="openVideo('Vid/video_16.mp4')">
            <h3>Heel Slides<br>Slide your heel toward your buttocks, then slowly straighten</h3>
            <video class="video-preview" src="Vid/video_16.mp4#t=0.001" muted></video>
        </div>
    </div>

    <div class="card">
        <button type="button" class="fav-btn" onclick="toggleFavorite(this, 10, 'video')">
            <?php echo in_array(10, $savedFavs) ? '❤️' : '🤍'; ?>
        </button>

        <div onclick="openVideo('Vid/video_10.mp4')">
            <h3>Quad Sets<br>Tighten the muscle, straighten the knee, and press down for 5–10 seconds</h3>
            <video class="video-preview" src="Vid/video_10.mp4#t=0.001" muted></video>
        </div>
    </div>

    <div class="card">
        <button type="button" class="fav-btn" onclick="toggleFavorite(this, 12, 'video')">
            <?php echo in_array(12, $savedFavs) ? '❤️' : '🤍'; ?>
        </button>

        <div onclick="openVideo('Vid/video_12.mp4')">
            <h3>Straight Leg Raise<br>Lift the straight leg upwards while tightening the front muscle</h3>
            <video class="video-preview" src="Vid/video_12.mp4#t=0.001" muted></video>
        </div>
    </div>

</div>

<h2 class="title">Shoulder Tendons (Post-Operative): </h2>

<div class="cards">

    <div class="card">
        <button type="button" class="fav-btn" onclick="toggleFavorite(this, 11, 'video')">
            <?php echo in_array(11, $savedFavs) ? '❤️' : '🤍'; ?>
        </button>

        <div onclick="openVideo('Vid/video_11.mp4')">
            <h3>Pendulum Exercise<br>Relax the arm and swing it lightly in a circle without using muscles</h3>
            <video class="video-preview" src="Vid/video_11.mp4#t=0.001" muted></video>
        </div>
    </div>

    <div class="card">
        <button type="button" class="fav-btn" onclick="toggleFavorite(this, 8, 'video')">
            <?php echo in_array(8, $savedFavs) ? '❤️' : '🤍'; ?>
        </button>

        <div onclick="openVideo('Vid/video_8.mp4')">
            <h3>Passive Shoulder Flexion<br>Lift the injured arm forward using the other hand or a light stick</h3>
            <video class="video-preview" src="Vid/video_8.mp4#t=0.001" muted></video>
        </div>
    </div>

    <div class="card">
        <button type="button" class="fav-btn" onclick="toggleFavorite(this, 9, 'video')">
            <?php echo in_array(9, $savedFavs) ? '❤️' : '🤍'; ?>
        </button>

        <div onclick="openVideo('Vid/video_9.mp4')">
            <h3>Scapular Retraction<br>Pull the shoulder blade back and down, holding for 5–10 seconds</h3>
            <video class="video-preview" src="Vid/video_9.mp4#t=0.001" muted></video>
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