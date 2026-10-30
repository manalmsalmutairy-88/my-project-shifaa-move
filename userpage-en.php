<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login-en.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$user_name = "User"; // Default English fallback

$stmt = mysqli_prepare($conn, "SELECT user_name FROM users WHERE id=? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $user_name = $row['user_name'];
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - SHIFAA MOVE</title>
    <link rel="stylesheet" href="userpage.css">
</head>

<body>

<header>
    <div class="header-right">
        <div class="user-profile">
            <img src="userpage 22.png" alt="User" class="avatar">
            <span><?php echo htmlspecialchars($user_name); ?></span>
        </div>

        <nav>
            <a href="index-en.php" class="nav-btn">Home</a>
            <a href="favorites-en.php" class="nav-btn">Favorites</a>
        </nav>
    </div>

    <div class="header-center">
        <div class="search-box">
            <input type="text" id="userSearch" placeholder="Search">
            <span class="search-icon">🔍</span>
        </div>
    </div>

    <div class="header-left">
        <!--Functional Language button linking back to Arabic -->
        <a href="userpage.php" style="font-weight: bold; color: #0e4a43; text-decoration: none; padding: 5px 10px;">العربية</a>

       <a class="nav-btn" id="logout-btn" href="logout-en.php">Logout</a>

        <div class="logo">
            <img src="img_2.png" alt="SHIFAA MOVE">
        </div>
    </div>
</header>

<section class="welcome-banner">
    <h1>Welcome back, <?php echo htmlspecialchars($user_name); ?> 👋</h1>
    <p>Start your journey towards recovery and improved mobility today</p>
</section>

<main class="container">
    
    <div class="card">
        <div class="card-title">Exercises</div>
        <div class="card-images">
            <img src="userpage 7.png" alt="Exercise 1">
            <img src="userpage 7-1.png" alt="Exercise 2">
            <img src="userpage 7-2.png" alt="Exercise 3">
        </div>
        <a href="pageAfterLogin-en.php" class="action-btn">View Exercises</a>
    </div>

    <div class="card">
        <div class="card-title">Medical Tools</div>
        <div class="card-images tools-images">
            <img src="userpage 21.png" alt="Tool 1">
            <img src="userpage 21-1.png" alt="Tool 2">
            <img src="userpage 21-2.png" alt="Tool 3">
        </div>
        <a href="tools-en.php" class="action-btn">View Tools</a>
    </div>

    <div class="card">
        <div class="card-title">Centers</div>
        <div class="card-images centers-images">
            <img src="userpage 16.png" alt="Center 1">
            <img src="userpage 16-1.png" alt="Center 2">
            <img src="userpage 16-2.png" alt="Center 3">
        </div>
        <a href="centers-en.php" class="action-btn">View Centers</a>
    </div>

    <p id="noResult" style="display:none; text-align:center; color:#0e4a43; font-weight:bold; width:100%;">
        No matching results found
    </p>

</main>

<footer>
    <div class="footer-links">
        <a href="about-en.php">About Us</a>
        <a href="contact_us-en.php">Contact Us</a>
        <a href="teerms-en.php">Privacy Policy & Terms</a>
        <a href="faq-en.php">FAQ</a>
    </div>
</footer>

<script>
const userSearch = document.getElementById("userSearch");
const cards = document.querySelectorAll(".card");
const noResult = document.getElementById("noResult");

userSearch.addEventListener("input", function () {
    const value = this.value.trim().toLowerCase();
    let found = false;

    cards.forEach(card => {
        const text = card.innerText.toLowerCase();

        if (text.includes(value) || value === "") {
            card.style.display = "";
            found = true;
        } else {
            card.style.display = "none";
        }
    });

    noResult.style.display = found ? "none" : "block";
});
</script>

</body>
</html>