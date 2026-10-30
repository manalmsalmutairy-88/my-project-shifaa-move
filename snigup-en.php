<?php
include 'db.php';
session_start();

$error_msg = "";
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($name === '' || $email === '' || $password === '') {
        $error_msg = "❌ Please fill in all fields";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "❌ Invalid email format";
    } else {
        $messages = [];
        if (strlen($password) < 8) $messages[] = "• At least 8 characters";
        if (!preg_match('/[A-Z]/', $password)) $messages[] = "• At least one uppercase letter";
        if (!preg_match('/[0-9]/', $password)) $messages[] = "• At least one number";
        if (!preg_match('/[!@#$%^&*]/', $password)) $messages[] = "• At least one special character";

        if (!empty($messages)) {
            $error_msg = "❌ Password must contain:<br>" . implode("<br>", $messages);
        } else {
            $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email=? LIMIT 1");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $check = mysqli_stmt_get_result($stmt);

            if ($check && mysqli_num_rows($check) > 0) {
                $error_msg = "❌ Email is already in use";
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($conn, "INSERT INTO users (user_name, email, password, role) VALUES (?, ?, ?, 'user')");
                mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed);
                if (mysqli_stmt_execute($stmt)) {
                    $success_msg = "✅ Account created successfully! You can now log in";
                } else {
                    $error_msg = "❌ An error occurred while creating the account";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="snigup.css">
</head>
<body>

    <header>
        <div class="logo">
    <img src="img_2.png" alt="logo">
</div>

        <nav style="display: flex; gap: 15px; align-items: center;">
            <a href="index-en.php" class="nav-btn">Home</a>
           
            <!--Language button linking back to Arabic -->
            <a href="snigup.php" class="nav-btn" style="font-weight: bold; color: #0e4a43;">العربية</a>
        </nav>
    </header>

    <div class="container">
        <div class="card">
            <h2>Create a New Account</h2>
            <form method="POST" action="snigup-en.php">
                <input type="text" name="name" id="name" placeholder="Full Name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                <p class="error" id="name-error"></p>

                <input type="email" name="email" id="email" placeholder="Email Address" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                <p class="error" id="email-error"></p>

                <input type="password" name="password" id="password" placeholder="Password">
                <p class="error" id="password-error"></p>

                <?php if($error_msg != "") echo "<p id='error-msg' class='error'>$error_msg</p>"; ?>

                <ul class="rules">
                    <li>Must be at least 8 characters</li>
                    <li>Must contain one uppercase letter</li>
                    <li>Must contain one number</li>
                    <li>Must contain one special character</li>
                </ul>

                <button type="submit" class="main-btn">Create Account</button>
                <?php if($success_msg != "") echo "<p id='success-msg' class='success'>$success_msg</p>"; ?>
            </form>
            <a href="login-en.php" class="secondary-btn">Login</a>
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