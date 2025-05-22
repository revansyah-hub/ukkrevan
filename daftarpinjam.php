<?php
include("koneksi.php");
$result = mysqli_query($koneksi, "SELECT * FROM pinjaman");
?>

<h2>Daftar Pinjaman</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nama Peminjam</th>
        <th>No Buku</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nama_peminjam'] ?></td>
            <td><?= $row['no_buku'] ?></td>
            <td><?= $row['tanggal_pinjam'] ?></td>
            <td><?= $row['tanggal_kembali'] ?? '-' ?></td>
            <td>
                <?php if (!$row['tanggal_kembali']) { ?>
                    <a href="kembali.php?id=<?= $row['id'] ?>">Tandai Kembali</a>
                <?php } else {
                    echo "Selesai";
                } ?>
            </td>
        </tr>
    <?php } ?>
</table>