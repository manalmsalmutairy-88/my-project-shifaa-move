<?php
$email = $_GET['email'];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<title>تغيير كلمة المرور</title>
<link rel="stylesheet" href="login.css">
</head>

<body>

<div class="container">
<div class="card">

<h2>تغيير كلمة المرور</h2>

<form action="update_password.php" method="POST">

<input type="hidden" name="email" value="<?php echo $email; ?>">

<input type="password" name="new_password" placeholder="كلمة المرور الجديدة" required>

<button type="submit" class="main-btn">تحديث كلمة المرور</button>

</form>

</div>
</div>

</body>
</html>