<?php
session_start();
include('koneksi.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>DAFTAR PINJAM</h2>
    <table border="1">
        <tr>
            <th>KODE BUKU</th>
            <th>NO BUKU</th>
            <th>JUDUL BUKU</th>
            <th>TAHUN TERBIT</th>
            <th>STOK</th>
            <th>NAMA PENULIS</th>
            <th>PENERBIT</th>
            <th>JUMLAH HALAMAN</th>
            <th>HARGA</th>
            <th>GAMBAR</th>
        </tr>


        <?php
        $sql = mysqli_query($koneksi, "SELECT * FROM buku");
        while ($data = mysqli_fetch_array($sql)) {

        ?>
            <tr>
                <td><?= $data['kode_buku'] ?></td>
                <td><?= $data['no_buku'] ?></td>
                <td><?= $data['judul'] ?></td>
                <td><?= $data['tahun_terbit'] ?></td>
                <td><?= $data['stok'] ?></td>
                <td><?= $data['nama_penulis'] ?></td>
                <td><?= $data['penerbit'] ?></td>
                <td><?= $data['isi_halaman'] ?></td>
                <td><?= $data['harga'] ?></td>
                <td>
                    <img src="<?= $data['gambar_buku'] ?> " alt="cover" width="80px">
                </td>
                <td class="action-buttons">
                    <a href="pinjam.php?kode_buku=<?= urlencode($data['kode_buku']) ?>" class="borrow-btn">Pinjam</a>
                    <a href="kembalikan.php?kode_buku=<?= urlencode($data['kode_buku']) ?>" class="return-btn">Kembalikan</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>