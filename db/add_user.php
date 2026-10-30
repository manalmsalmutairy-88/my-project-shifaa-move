<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>     

    </head>
<body>
    <form method="POST">

<input type="text" name="user">

<input type="password" name="pass">
<input type="submit"  value="Add User" name="add">



    </form>



    </body>
</html>

<?php
if ($_POST['add']) {
$connection =mysqli_connect("localhost", "root", "", "users", "root123","project_db");
   $user = $_POST['user'];
    $pass = sha1(sha1(sha1( $_POST['pass'])));
    $cmd = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
    mysqli_query($connection, $cmd);

}
?>