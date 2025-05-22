<?php
session_start();
include('koneksi.php');

if (isset($_GET['no_buku'])) {
    $id = $_GET['no_buku'];

    mysqli_query($koneksi, "DELETE FROM buku WHERE no_buku='$id'");
}
header('location: admin.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>

</style>

<body>

</body>

</html>