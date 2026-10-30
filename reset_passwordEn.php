<?php
$email = $_GET['email'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
<meta charset="UTF-8">
<title>Reset Password</title>
<link rel="stylesheet" href="login.css">
</head>

<body>

<div class="container">
<div class="card">

<h2>Reset Password</h2>

<form action="update_passwordEN.php" method="POST">

<input type="hidden" name="email" value="<?php echo $email; ?>">

<input type="password" name="new_password" placeholder="New Password" required>

<button type="submit" class="main-btn">Update Password</button>

</form>

</div>
</div>

</body>
</html>