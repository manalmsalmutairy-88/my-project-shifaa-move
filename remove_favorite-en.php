<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login-en.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Remove Exercise */
if (isset($_GET['video_id'])) {
    $video_id = (int)$_GET['video_id'];

    mysqli_query($conn, "DELETE FROM favorites 
        WHERE user_id='$user_id' AND video_id='$video_id'");

    $_SESSION['flash_msg'] = "Exercise removed from favorites 💔";
}

/* Remove Tool */
if (isset($_GET['tool_id'])) {
    $tool_id = (int)$_GET['tool_id'];

    mysqli_query($conn, "DELETE FROM favorites 
        WHERE user_id='$user_id' AND tool_id='$tool_id'");

    $_SESSION['flash_msg'] = "Tool removed from favorites 💔";
}

// Drops the user back onto the English favorites page
header("Location: favorites-en.php");
exit();
?>