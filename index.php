<?php
session_start();
include("koneksi.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
    <style>

    </style>
</head>

<body>
    <h1>DATA BUKU<br>SMK Telkom Lampung<br>Tahun 2024-2025</h1>

    <table border="1">
        <thead>
            <tr>
                <th>kode buku</th>
                <th>no buku</th>
                <th>judul buku</th>
                <th>tahun terbit</th>
                <th>stok</th>
                <th>penulis</th>
                <th>penerbit</th>
                <th>jumlah halaman</th>
                <th>harga</th>
                <th>gambar buku</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM buku";
            $row = mysqli_query($koneksi, $sql);
            while ($data = mysqli_fetch_array($row)) {
            ?>
                <tr>
                    <td><?= htmlspecialchars($data['kode_buku']) ?></td>
                    <td><?= htmlspecialchars($data['no_buku']) ?></td>
                    <td><?= htmlspecialchars($data['judul_buku']) ?></td>
                    <td><?= htmlspecialchars($data['tahun_terbit']) ?></td>
                    <td><?= htmlspecialchars($data['stok']) ?></td>
                    <td><?= htmlspecialchars($data['penulis']) ?></td>
                    <td><?= htmlspecialchars($data['penerbit']) ?></td>
                    <td><?= htmlspecialchars($data['jumlah_halaman']) ?></td>
                    <td><?= htmlspecialchars($data['harga']) ?></td>
                    <td>
                        <?php if (!empty($data['gambar_buku'])) { ?>
                            <img src="<?= htmlspecialchars($data['gambar_buku']) ?>" alt="Gambar Buku">
                        <?php } else {
                            echo "Tidak ada gambar";
                        } ?>
                    </td>
                    <td class="action-buttons">
                        <a href="pinjam.php?kode_buku=<?= urlencode($data['kode_buku']) ?>" class="borrow-btn">Pinjam</a>
                        <a href="kembalikan.php?kode_buku=<?= urlencode($data['kode_buku']) ?>" class="return-btn">Kembalikan</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>