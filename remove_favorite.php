<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* حذف تمرين */
if (isset($_GET['video_id'])) {
    $video_id = (int)$_GET['video_id'];

    mysqli_query($conn, "DELETE FROM favorites 
        WHERE user_id='$user_id' AND video_id='$video_id'");

    $_SESSION['flash_msg'] = "تم حذف التمرين من المفضلة 💔";
}

/* حذف أداة */
if (isset($_GET['tool_id'])) {
    $tool_id = (int)$_GET['tool_id'];

    mysqli_query($conn, "DELETE FROM favorites 
        WHERE user_id='$user_id' AND tool_id='$tool_id'");

    $_SESSION['flash_msg'] = "تم حذف الأداة من المفضلة 💔";
}

header("Location: favorites.php");
exit();
?>