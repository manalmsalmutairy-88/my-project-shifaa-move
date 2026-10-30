<?php
include 'db.php';
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = trim($_POST['password'] ?? '');

    if ($email === '' || $pass === '') {
        $error = "❌ Please enter your email and password";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, email, password, role FROM users WHERE email=? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            $stored = $user['password'];
            $ok = password_verify($pass, $stored) || $pass === $stored;

            if ($ok) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                // Redirects English users to the English user page
                header("Location: userpage-en.php");
                exit();
            }
        }
        $error = "❌ Incorrect email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<header>
    <div class="logo">
        <img src="img_2.png" alt="logo">
    </div>

    <nav style="display: flex; gap: 15px; align-items: center;">
        <a href="index-en.php" class="nav-btn">Home</a>
      
        <!--Language button linking back to Arabic -->
        <a href="login.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">العربية</a>
    </nav>
</header>

<div class="container">
    <div class="card">
        <h2>Login</h2>

        <?php if($error != "") echo "<p class='error'>$error</p>"; ?>

        <!--Action points to the English file -->
        <form method="POST" action="login-en.php">
            <input type="email" name="email" id="email" placeholder="Email Address" required>
            <p id="email-error" class="error"></p>

            <input type="password" name="password" id="password" placeholder="Password" required>
            <p id="password-error" class="error"></p>

            <button type="submit" class="main-btn">Login</button>
            <div class="forgot-container">
        <a href="forgot_passwordEn.php" class="forgot-link">
           ?forget passwoed
        </a>
    </div>
        </form>


       <a href="snigup-en.php" class="secondary-btn">Create Account</a>
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