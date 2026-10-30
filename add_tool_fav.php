<?php
include 'db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$video_id = isset($_POST["video_id"]) ? (int)$_POST["video_id"] : null;
$tool_id  = isset($_POST["tool_id"]) ? (int)$_POST["tool_id"] : null;

/* التمارين */
if ($video_id) {
    $check = mysqli_query($conn, "SELECT * FROM favorites 
        WHERE user_id='$user_id' AND video_id='$video_id'");

    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO favorites (user_id, video_id)
            VALUES ('$user_id', '$video_id')");
        $_SESSION['flash_msg'] = "تم الحفظ بالمفضلة ❤️";
    } else {
        $_SESSION['flash_msg'] = "هذا التمرين موجود بالمفضلة مسبقًا ❤️";
    }
}

/* الأدوات */
if ($tool_id) {
    $check = mysqli_query($conn, "SELECT * FROM favorites 
        WHERE user_id='$user_id' AND tool_id='$tool_id'");

    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO favorites (user_id, tool_id)
            VALUES ('$user_id', '$tool_id')");
        $_SESSION['flash_msg'] = "تم حفظ الأداة بالمفضلة ❤️";
    } else {
        $_SESSION['flash_msg'] = "الأداة موجودة بالمفضلة مسبقًا ❤️";
    }
}

header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'userpage.php'));
exit();
?>