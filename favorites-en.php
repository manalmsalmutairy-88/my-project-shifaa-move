<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login-en.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handles delete request without reloading the page
if (isset($_GET['ajax_remove'])) {
    if (isset($_GET['video_id'])) {
        $video_id = (int)$_GET['video_id'];
        mysqli_query($conn, "DELETE FROM favorites WHERE user_id='$user_id' AND video_id='$video_id'");
        echo "removed_video";
        exit();
    }
    if (isset($_GET['tool_id'])) {
        $tool_id = (int)$_GET['tool_id'];
        mysqli_query($conn, "DELETE FROM favorites WHERE user_id='$user_id' AND tool_id='$tool_id'");
        echo "removed_tool";
        exit();
    }
    echo "no_data";
    exit();
}

$videos = [
    2  => ["Straight Leg Raise",                "Vid/video_2.mp4"],
    3  => ["Quad Sets",                         "Vid/video_3.mp4"],
    4  => ["Heel Raises",                       "Vid/video_4.mp4"],
    5  => ["Plank",                             "Vid/video_5.mp4"],
    6  => ["Squats",                            "Vid/video_6.mp4"],
    7  => ["Brisk Walking",                     "Vid/video_7.mp4"],
    8  => ["Passive Shoulder Flexion",          "Vid/video_8.mp4"],
    9  => ["Scapular Retraction",               "Vid/video_9.mp4"],
    10 => ["Quad Sets",                         "Vid/video_10.mp4"],
    11 => ["Pendulum Exercise",                 "Vid/video_11.mp4"],
    12 => ["Straight Leg Raise",                "Vid/video_12.mp4"],
    13 => ["Neck Side Tilt",                    "Vid/video_13.mp4"],
    14 => ["Upper Trap Stretch",                "Vid/video_14.mp4"],
    15 => ["Chin Tucks",                        "Vid/video_15.mp4"],
    16 => ["Heel Slides",                       "Vid/video_16.mp4"],
    17 => ["Knee to Chest",                     "Vid/video_17.mp4"],
    18 => ["Child Pose",                        "Vid/video_18.mp4"],
    19 => ["Cat-Cow",                           "Vid/video_19.mp4"],
    20 => ["Hamstring Stretch",                 "Vid/video_20.mp4"],
    21 => ["Calf Stretch",                      "Vid/video_21.mp4"],
    22 => ["Quadriceps Stretch",                "Vid/video_22.mp4"],
];

$fav_videos = mysqli_query($conn, "SELECT video_id FROM favorites WHERE user_id='$user_id' AND video_id IS NOT NULL");

$tools = [
    1  => ["Thumb & Wrist Brace",                       "t1.jpeg"],
    2  => ["Hand & Finger Exercise Web",                 "t2.jpeg"],
    3  => ["Flex Bar",                                   "t3.jpeg"],
    4  => ["Balance Board for Rehabilitation",           "t4.jpeg"],
    5  => ["Medical Transfer Sheet with Handles",        "t5.jpeg"],
    6  => ["Sliding Sheet for Patient Transfer",         "t6.jpeg"],
    7  => ["Foldable Electric Wheelchair",               "t7.jpeg"],
    8  => ["Foldable Aluminum Walking Frame",            "t8.jpeg"],
    9  => ["Medical Arm Support",                        "t9.jpeg"],
    10 => ["Night Foot Splint",                          "t10.jpeg"],
    11 => ["Inflatable Walking Boot for Ankle & Foot",   "t11.jpeg"],
    12 => ["Back Brace for Posture Correction",          "t12.jpeg"],
];

$fav_tools = mysqli_query($conn, "SELECT tool_id FROM favorites WHERE user_id='$user_id' AND tool_id IS NOT NULL");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<title>SHIFAA MOVE – Favorites</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="favorites.css">
<link rel="stylesheet" href="chatbot.css">
<style>
  
    .popup {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.85);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .popup.active { display: flex; }
    .popup-content {
        position: relative;
        width: 90%;
        max-width: 300px;
    }
    .popup-content video {
        width: 100%;
        border-radius: 15px;
    }
    .popup-close {
        position: absolute;
        top: -40px;
        left: 0;
        font-size: 30px;
        color: white;
        cursor: pointer;
        background: none;
        border: none;
    }
    .watch-btn {
        display: inline-block;
        margin: 10px 0;
        padding: 8px 20px;
        background: #0e4a43;
        color: white;
        border-radius: 20px;
        border: none;
        cursor: pointer;
        font-family: 'Cairo', sans-serif;
        font-size: 14px;
        font-weight: bold;
    }
    .watch-btn:hover { background: #0a3830; }
    .remove-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: red;
        font-size: 14px;
        font-family: 'Cairo', sans-serif;
    }
</style>
</head>

<body>

<header>
  <div class="logo">
    <img src="img_2.png" alt="SHIFAA MOVE">
  </div>
  <div class="header-right">
    <div class="header-nav" style="display: flex; gap: 15px; align-items: center;">
      <a href="pageAfterLogin-en.php" class="nav-btn">Main Exercises List</a>
      <a href="tools-en.php" class="nav-btn">Tools</a>
      <a href="userpage-en.php" class="nav-btn">Back to Home</a>
      <a href="favorites.php" class="nav-btn" style="font-weight: bold; color: #0e4a43; text-decoration: none;">العربية</a>
    </div>
  </div>
</header>

<main>

  <div class="section-block">
    <div class="section-label-row">
      <span class="section-label">Favorite Exercises</span>
    </div>
    <div class="cards-row" id="videosRow">
      <?php if (mysqli_num_rows($fav_videos) == 0): ?>
        <div class="empty-row">No favorite exercises ❤️</div>
      <?php else: ?>
        <?php while ($row = mysqli_fetch_assoc($fav_videos)):
          $v_id = $row['video_id']; 
          // skip if tool ID not in the list
          if (!isset($videos[$v_id])) continue;
        ?>
          <div class="card" style="padding:15px; text-align:center;">
            <h3><?php echo htmlspecialchars($videos[$v_id][0]); ?></h3>
            <button class="watch-btn" onclick="openVideo('<?php echo $videos[$v_id][1]; ?>')">
              ▶ Watch
            </button>
            <br>
            <button class="remove-btn" onclick="removeFavorite('video', <?php echo $v_id; ?>, this)">
              💔 Remove
            </button>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>

  <div class="section-block">
    <div class="section-label-row">
      <span class="section-label">Favorite Tools</span>
    </div>
    <div class="cards-row" id="toolsRow">
      <?php if (mysqli_num_rows($fav_tools) == 0): ?>
        <div class="empty-row">No favorite tools ❤️</div>
      <?php else: ?>
        <?php while ($row = mysqli_fetch_assoc($fav_tools)):
          $tool_id = $row['tool_id'];
          if (!isset($tools[$tool_id])) continue;
        ?>
          <div class="card" style="padding:15px; text-align:center;">
            <img src="<?php echo htmlspecialchars($tools[$tool_id][1]); ?>"
                 style="width:150px; border-radius:10px;"
                 alt="<?php echo htmlspecialchars($tools[$tool_id][0]); ?>">
            <h3 style="font-size:14px; margin:10px 0;">
              <?php echo htmlspecialchars($tools[$tool_id][0]); ?>
            </h3>
            <button class="remove-btn" onclick="removeFavorite('tool', <?php echo $tool_id; ?>, this)">
              💔 Remove
            </button>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>

</main>

<!-- Video Popup -->
<div class="popup" id="videoPopup">
  <div class="popup-content">
    <button class="popup-close" onclick="closeVideo()">✖</button>
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

<script>
function openVideo(src) {
    const popup = document.getElementById("videoPopup");
    const player = document.getElementById("videoPlayer");
    player.src = src;
    popup.classList.add("active");
    player.play();
}

function closeVideo() {
    const popup = document.getElementById("videoPopup");
    const player = document.getElementById("videoPlayer");
    player.pause();
    player.src = "";
    popup.classList.remove("active");
}
// close popup when clicking outside the video
document.getElementById("videoPopup").addEventListener("click", function(e) {
    if (e.target === this) closeVideo();
});
// delete from favorites without page reload
function removeFavorite(type, id, btn) {
    let url = "favorites-en.php?ajax_remove=1&";
    url += type === "video" ? "video_id=" + id : "tool_id=" + id;

    fetch(url)
        .then(res => res.text())
        .then(result => {
            result = result.trim();
            if (result === "removed_video" || result === "removed_tool") {
                btn.closest(".card").remove();
                if (type === "video") {
                    showMessage("Exercise removed from favorites 💔");
                    checkEmpty("videosRow", "No favorite exercises ❤️");
                } else {
                    showMessage("Tool removed from favorites 💔");
                    checkEmpty("toolsRow", "No favorite tools ❤️");
                }
            } else {
                showMessage("An error occurred, please try again ⚠️");
            }
        });
}
// show empty message if no cards left
function checkEmpty(rowId, text) {
    const row = document.getElementById(rowId);
    if (row.querySelectorAll(".card").length === 0) {
        row.innerHTML = `<div class="empty-row">${text}</div>`;
    }
}
// create and show a temporary status message
function showMessage(text) {
    let msg = document.getElementById("favMessage");
    if (!msg) {
        msg = document.createElement("div");
        msg.id = "favMessage";
        Object.assign(msg.style, {
            position: "fixed", top: "20px", left: "50%",
            transform: "translateX(-50%)", background: "#e8fff8",
            color: "#0e4a43", padding: "12px 20px", borderRadius: "12px",
            fontWeight: "bold", boxShadow: "0 4px 12px rgba(0,0,0,0.15)",
            zIndex: "99999", fontFamily: "Cairo, sans-serif"
        });
        document.body.appendChild(msg);
    }
    msg.innerHTML = text;
    msg.style.display = "block";
    setTimeout(() => { msg.style.display = "none"; }, 2500);
}
</script>

</body>
</html>