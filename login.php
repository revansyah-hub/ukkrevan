<?php
session_start();
include('koneksi.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $sql);

    if ($result->num_rows > 0) {
        $data = mysqli_fetch_assoc($result);

        if ($data['role'] == 'user') {
            header('location: index.php');
        } else if ($data['role'] == 'atmin') {
            header('location: admin.php');
        } else {
            header('location: superadmin.php');
        }
    } else {
        echo 'LOGIN GAGAL';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>
<style>


</style>

<body>
    <div>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="username" required>
            <input type="password" name="password" placeholder="password" required>
            <input type="submit" name="login" value="login">
        </form>
    </div>
</body>

</html>