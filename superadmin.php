<?php
session_start();
include('koneksi.php');

if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    mysqli_query($koneksi, "INSERT INTO user(username, password, role)
    VALUES ('$username', '$password', '$role')");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contoh</title>
</head>
<style>


</style>

<body>
    <form action="admin.php" method="post">
        <input type="text" name="username" placeholder="username" required>
        <input type="text" name="password" placeholder="password" required>
        <select name="role">
            <option value="user">user</option>
            <option value="admin">admin</option>
            <option value="superadmin">superadmin</option>
        </select>
        <input type="submit" name="tambah" value="TAMBAH">
    </form>
</body>

</html>