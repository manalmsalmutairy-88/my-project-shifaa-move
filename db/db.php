<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Project_db"; // تأكدي أن هذا الاسم مطابق لاسم القاعدة في phpMyAdmin

// إنشاء الاتصال
$conn = mysqli_connect($servername, $username, $password, $dbname);

// فحص الاتصال
if (!$conn) {
    die("فشل الاتصال: " . mysqli_connect_error());
}
?>