<?php
include 'db.php';

$email = $_POST['email'];

$new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn, "UPDATE users SET password=? WHERE email=?");
mysqli_stmt_bind_param($stmt, "ss", $new_password, $email);

$success = mysqli_stmt_execute($stmt);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<title>تحديث كلمة المرور</title>

<link rel="stylesheet" href="login.css">

<meta http-equiv="refresh" content="3;url=login.php">
</head>

<body>

<div class="container">
<div class="card">

<?php if($success){ ?>

<h2>✅ تم تحديث كلمة المرور بنجاح</h2>
<p>سيتم تحويلك لصفحة تسجيل الدخول خلال ثوانٍ...</p>

<?php } else { ?>

<h2>❌ حدث خطأ أثناء تحديث كلمة المرور</h2>

<?php } ?>

</div>
</div>

</body>
</html>