<?php 
//استدعاء ملف االاتصال
include 'db.php'; 

// 2. كود معالجة البيانات (المحرك)
if(isset($_POST['send'])){
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $msg = $_POST['messag'];

    $sql = "INSERT INTO contact_messages (full_name, email, messag) VALUES ('$name', '$email', '$msg')";

    if(mysqli_query($conn, $sql)){
        echo "<script>alert('تم إرسال رسالتك بنجاح!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تواصل معنا</title>
</head>
<body>
    <form action="contact_us.php" method="POST">
        <input type="text" name="full_name" required>
        <input type="email" name="email" required>
        <textarea name="messag" required></textarea>
        <button type="submit" name="send">إرسال</button>
    </form>
</body>
</html>