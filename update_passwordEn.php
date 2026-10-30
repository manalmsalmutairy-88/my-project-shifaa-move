<?php
include 'db.php';

$email = $_POST['email'];

$new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn, "UPDATE users SET password=? WHERE email=?");
mysqli_stmt_bind_param($stmt, "ss", $new_password, $email);

$success = mysqli_stmt_execute($stmt);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
<meta charset="UTF-8">
<title>Password Update</title>

<link rel="stylesheet" href="login.css">

<meta http-equiv="refresh" content="3;url=login-en.php">
</head>

<body>

<div class="container">
<div class="card">

<?php if($success){ ?>

<h2>✅ Password Updated Successfully</h2>
<p>You will be redirected to the login page in a few seconds...</p>

<?php } else { ?>

<h2>❌ Error updating password</h2>

<?php } ?>

</div>
</div>

</body>
</html>