<?php
include 'db.php';
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle AJAX delete request
if (isset($_GET['ajax_remove'])) {
    if (isset($_GET['video_id'])) {
        $video_id = (int)$_GET['video_id'];
        mysqli_query($conn, "DELETE FROM favorites WHERE user_id=$user_id AND video_id=$video_id");
        echo "removed_video";
        exit();
    }
    if (isset($_GET['tool_id'])) {
        $tool_id = (int)$_GET['tool_id'];
        mysqli_query($conn, "DELETE FROM favorites WHERE user_id=$user_id AND tool_id=$tool_id");
        echo "removed_tool";
        exit();
    }
    echo "no_data";
    exit();
}
// List of available videos [name, file path]
$videos = [
    2  => ["رفع الساق",                   "Vid/video_2.mp4"],
    3  => ["شد العضلة الأمامية",           "Vid/video_3.mp4"],
    4  => ["رفع الكعبين",                  "Vid/video_4.mp4"],
    5  => ["تثبيت الجسم (Plank)",          "Vid/video_5.mp4"],
    6  => ["سكوات بسيط",                   "Vid/video_6.mp4"],
    7  => ["مشي سريع",                     "Vid/video_7.mp4"],
    8  => ["رفع سلبي باليد السليمة",       "Vid/video_8.mp4"],
    9  => ["سحب لوح الكتف",                "Vid/video_9.mp4"],
    10 => ["شد عضلة الفخذ الأمامية",       "Vid/video_10.mp4"],
    11 => ["تمرين التأرجح",                "Vid/video_11.mp4"],
    12 => ["رفع الساق مستقيمة للأعلى",     "Vid/video_12.mp4"],
    13 => ["إمالة الرأس يمين ويسار",       "Vid/video_13.mp4"],
    14 => ["شد الرقبة الجانبي",            "Vid/video_14.mp4"],
    15 => ["سحب الذقن للداخل",             "Vid/video_15.mp4"],
    16 => ["ثني وفرد الركبة",              "Vid/video_16.mp4"],
    17 => ["Knee to chest",                "Vid/video_17.mp4"],
    18 => ["Child pose",                   "Vid/video_18.mp4"],
    19 => ["Cat-Cow",                      "Vid/video_19.mp4"],
    20 => ["إطالة خلف الفخذ",              "Vid/video_20.mp4"],
    21 => ["شد عضلة الساق الخلفية",        "Vid/video_21.mp4"],
    22 => ["إطالة الأمامية للفخذ",         "Vid/video_22.mp4"],
];
// Get user's favorite videos from database
$fav_videos = mysqli_query($conn, "SELECT video_id FROM favorites WHERE user_id=$user_id AND video_id IS NOT NULL");
if (!$fav_videos) die("خطأ: " . mysqli_error($conn));

// List of available tools [name, image path]
$tools = [
    1  => ["دعامة الإبهام والمعصم",                    "t1.jpeg"],
    2  => ["شبكة تمارين اليد والأصابع",                "t2.jpeg"],
    3  => ["سباكير فلكس بار مطاطي لتمارين اليد",       "t3.jpeg"],
    4  => ["لوحة التوازن",                              "t4.jpeg"],
    5  => ["ملاءة سحب طبية بمقابض",                    "t5.jpeg"],
    6  => ["ملاءة تسهيل نقل المرضى",                   "t6.jpeg"],
    7  => ["كرسي متحرك كهربائي قابل للطي",              "t7.jpeg"],
    8  => ["عكاز ألومنيوم قابل للطي",                   "t8.jpeg"],
    9  => ["حامل يد",                                   "t9.jpeg"],
    10 => ["دعامة قدم ليلية",                           "t10.jpeg"],
    11 => ["دعامة هوائية للكاحل والقدم",                "t11.jpeg"],
    12 => ["دعامة الظهر لعلاج تقوس العمود الفقري",      "t12.jpeg"],
];
// Get user's favorite tools from database
$fav_tools = mysqli_query($conn, "SELECT tool_id FROM favorites WHERE user_id=$user_id AND tool_id IS NOT NULL");
if (!$fav_tools) die("خطأ: " . mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>SHIFAA MOVE – المفضلة</title>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="favorites.css">
<link rel="stylesheet" href="chatbot.css">
<style>
  /* Video popup overlay */
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
    /* Close button */
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
    /* Watch button */
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
    /* Remove from favorites button */
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
    <div class="header-nav" style="display:flex; gap:15px; align-items:center;">
      <a href="pageAfterLogin.php" class="nav-btn">قائمة التمارين الرئيسية</a>
      <a href="tools.php" class="nav-btn">الأدوات</a>
      <a href="userpage.php" class="nav-btn">الرجوع الى الصفحة الرئيسية</a>
      <a href="favorites-en.php" class="nav-btn" style="font-weight:bold; color:#0e4a43;">English</a>
    </div>
  </div>
</header>

<main>
<!-- Favorite exercises section -->
  <div class="section-block">
    <div class="section-label-row">
      <span class="section-label">التمارين المفضلة</span>
    </div>
    <div class="cards-row" id="videosRow">
      <?php if (mysqli_num_rows($fav_videos) == 0): ?>
        <div class="empty-row">لا توجد تمارين مفضلة ❤️</div>
      <?php else: ?>
        <?php while ($row = mysqli_fetch_assoc($fav_videos)):
          $v_id = $row['video_id'];
          if (!isset($videos[$v_id])) continue;
        ?>
          <div class="card" style="padding:15px; text-align:center;">
            <h3><?php echo htmlspecialchars($videos[$v_id][0]); ?></h3>
            <button class="watch-btn" onclick="openVideo('<?php echo $videos[$v_id][1]; ?>')">
              ▶ مشاهدة
            </button>
            <br>
            <button class="remove-btn" onclick="removeFavorite('video', <?php echo $v_id; ?>, this)">
              💔 إزالة
            </button>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>
<!-- Favorite tools section -->
  <div class="section-block">
    <div class="section-label-row">
      <span class="section-label">الأدوات المفضلة</span>
    </div>
    <div class="cards-row" id="toolsRow">
      <?php if (mysqli_num_rows($fav_tools) == 0): ?>
        <div class="empty-row">لا توجد أدوات مفضلة ❤️</div>
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
              💔 إزالة
            </button>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>

</main>

<!-- Video popup -->
<div class="popup" id="videoPopup">
  <div class="popup-content">
    <button class="popup-close" onclick="closeVideo()">✖</button>
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

<script>
  // Open video popup and play the video
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
// Close popup when clicking outside the video
document.getElementById("videoPopup").addEventListener("click", function(e) {
    if (e.target === this) closeVideo();
});
// Remove item from favorites without reloading the page
function removeFavorite(type, id, btn) {
    let url = "favorites.php?ajax_remove=1&";
    url += type === "video" ? "video_id=" + id : "tool_id=" + id;

    fetch(url)
        .then(res => res.text())
        .then(result => {
            result = result.trim();
            if (result === "removed_video" || result === "removed_tool") {
                btn.closest(".card").remove();
                if (type === "video") {
                    showMessage("تمت إزالة التمرين من المفضلة 💔");
                    checkEmpty("videosRow", "لا توجد تمارين مفضلة ❤️");
                } else {
                    showMessage("تمت إزالة الأداة من المفضلة 💔");
                    checkEmpty("toolsRow", "لا توجد أدوات مفضلة ❤️");
                }
            } else {
                showMessage("حدث خطأ، جربي مرة ثانية ⚠️");
            }
        });
}
// Show empty message if no cards are left
function checkEmpty(rowId, text) {
    const row = document.getElementById(rowId);
    if (row.querySelectorAll(".card").length === 0) {
        row.innerHTML = `<div class="empty-row">${text}</div>`;
    }
}
// Show a temporary status message
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
    // Hide message after 2.5 seconds
    setTimeout(() => { msg.style.display = "none"; }, 2500);
}
</script>

</body>
</html>