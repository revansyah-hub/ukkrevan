<?php
include "koneksi.php";

// Proses pengembalian
if (isset($_GET['kembalikan'])) {
    $id = (int)$_GET['kembalikan'];
    $tanggal_kembali = date("Y-m-d");

    // Ambil no_buku dari pinjaman
    $result = mysqli_query($koneksi, "SELECT no_buku FROM pinjaman WHERE id = $id AND tanggal_kembali IS NULL");
    $pinjam = mysqli_fetch_assoc($result);

    if ($pinjam) {
        $no_buku = $pinjam['no_buku'];

        // Update tanggal kembali
        mysqli_query($koneksi, "UPDATE pinjaman SET tanggal_kembali = '$tanggal_kembali' WHERE id = $id");

        // Tambah stok
        mysqli_query($koneksi, "UPDATE buku SET stok = stok + 1 WHERE no_buku = $no_buku");

        echo "<script>alert('Buku berhasil dikembalikan'); window.location='back.php';</script>";
    } else {
        echo "<script>alert('Data tidak valid atau sudah dikembalikan');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pengembalian Buku</title>
    <style>

    </style>
</head>

<body>
    <h2>Daftar Buku yang Dipinjam</h2>
    <table>
        <tr>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Aksi</th>
        </tr>
        <?php
        $query = mysqli_query($koneksi, "
            SELECT p.id, p.nama_peminjam, p.tanggal_pinjam, k.judul
            FROM pinjaman p 
            JOIN buku k ON p.no_buku = k.no_buku 
            WHERE p.tanggal_kembali IS NULL
        ");
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr>
                <td>{$row['nama_peminjam']}</td>
                <td>{$row['judul_buku']}</td>
                <td>{$row['tanggal_pinjam']}</td>
                <td><a href='kembalikan.php?kembalikan={$row['id']}' class='kembali-btn'>Kembalikan</a></td>
            </tr>";
        }
        ?>
    </table>
</body>

</html>