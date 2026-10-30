<?php
include 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        header("Location: reset_passwordEN.php?email=$email");
        exit();
    } else {
        $message = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>
<link rel="stylesheet" href="login.css">
</head>

<body>

<div class="container">
<div class="card">

<h2>Forgot Password</h2>

<?php if($message != "") echo "<p class='error'>$message</p>"; ?>

<form method="POST">

<input type="email" name="email" placeholder="Email Address" required>

<button type="submit" class="main-btn">Next</button>

</form>

</div>
</div>

</body>
</html>