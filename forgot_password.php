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

        header("Location: reset_password.php?email=$email");
        exit();

    } else {

        $message = "❌ البريد الإلكتروني غير موجود";

    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<title>نسيت كلمة المرور</title>
<link rel="stylesheet" href="login.css">
</head>

<body>

<div class="container">
<div class="card">

<h2>استعادة كلمة المرور</h2>

<?php if($message != "") echo "<p class='error'>$message</p>"; ?>

<form method="POST">

<input type="email" name="email" placeholder="البريد الإلكتروني" required>

<button type="submit" class="main-btn">التالي</button>

</form>

</div>
</div>

</body>
</html>