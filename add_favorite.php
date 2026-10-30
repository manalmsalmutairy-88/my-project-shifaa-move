<?php
include 'db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "error";
    exit();
}

$user_id = $_SESSION['user_id'];

// --- HANDLE EXERCISE (VIDEO) FAVORITES ---
if (isset($_POST['video_id'])) {
    $video_id = (int)$_POST['video_id'];
    
    // Check if it's already favorited
    $check = mysqli_query($conn, "SELECT id FROM favorites WHERE user_id='$user_id' AND video_id='$video_id'");
    
    if (mysqli_num_rows($check) > 0) {
        // If it exists, remove it (Toggle Off)
        mysqli_query($conn, "DELETE FROM favorites WHERE user_id='$user_id' AND video_id='$video_id'");
        echo "removed";
    } else {
        // If it doesn't exist, add it (Toggle On)
        mysqli_query($conn, "INSERT INTO favorites (user_id, video_id) VALUES ('$user_id', '$video_id')");
        echo "added";
    }
    exit();
}

// --- HANDLE TOOL FAVORITES ---
if (isset($_POST['tool_id'])) {
    $tool_id = (int)$_POST['tool_id'];
    
    // Check if it's already favorited
    $check = mysqli_query($conn, "SELECT id FROM favorites WHERE user_id='$user_id' AND tool_id='$tool_id'");
    
    if (mysqli_num_rows($check) > 0) {
        // If it exists, remove it (Toggle Off)
        mysqli_query($conn, "DELETE FROM favorites WHERE user_id='$user_id' AND tool_id='$tool_id'");
        echo "removed";
    } else {
        // If it doesn't exist, add it (Toggle On)
        mysqli_query($conn, "INSERT INTO favorites (user_id, tool_id) VALUES ('$user_id', '$tool_id')");
        echo "added";
    }
    exit();
}

// If neither video_id or tool_id was sent
echo "error";
?>