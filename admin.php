<?php
session_start();
include('koneksi.php'); // Pastikan file koneksi.php ada dan berhasil terhubung ke database

if (isset($_POST['tambah'])) {
    // Ambil data dari form POST
    $kode_buku = $_POST['kode_buku'];
    $no_buku = $_POST['no_buku'];
    $judul = $_POST['judul']; // Perhatikan: di form 'judul', di tabel 'judul_buku'
    $tahun_terbit = $_POST['tahun_terbit'];
    $nama_penulis = $_POST['nama_penulis'];
    $penerbit = $_POST['penerbit'];
    $isi_halaman = $_POST['isi_halaman'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Inisialisasi variabel gambar_buku
    $gambar_buku_path = ''; // Gunakan nama variabel berbeda agar tidak bentrok dengan $_POST['gambar_buku'] yang tidak relevan

    // --- File Upload Logic ---
    if (isset($_FILES['gambar_buku']) && $_FILES['gambar_buku']['error'] == 0) {
        $target_dir = "uploads/"; // Direktori tempat gambar akan disimpan
        if (!is_dir($target_dir)) { // Buat direktori jika belum ada
            mkdir($target_dir, 0777, true);
        }

        $file_name = basename($_FILES["gambar_buku"]["name"]);
        // Tambahkan ID unik untuk mencegah penimpaan file dengan nama yang sama
        $target_file = $target_dir . uniqid() . "_" . $file_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file gambar adalah gambar asli
        $check = getimagesize($_FILES["gambar_buku"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<script>alert('File bukan gambar.');</script>";
            $uploadOk = 0;
        }

        // Cek ukuran file (maksimal 5MB)
        if ($_FILES["gambar_buku"]["size"] > 5000000) {
            echo "<script>alert('Maaf, ukuran file Anda terlalu besar (maks 5MB).');</script>";
            $uploadOk = 0;
        }

        // Izinkan hanya format file tertentu
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "<script>alert('Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.');</script>";
            $uploadOk = 0;
        }

        // Cek jika $uploadOk bernilai 0 karena error
        if ($uploadOk == 0) {
            echo "<script>alert('Maaf, file Anda tidak terunggah.');</script>";
        } else {
            // Jika semua cek lolos, coba unggah file
            if (move_uploaded_file($_FILES["gambar_buku"]["tmp_name"], $target_file)) {
                $gambar_buku_path = $target_file; // Simpan path relatif ke web root
            } else {
                echo "<script>alert('Maaf, terjadi kesalahan saat mengunggah file Anda.');</script>";
            }
        }
    }
    // --- End File Upload Logic ---

    // Sanitize input untuk penyisipan ke database
    // Gunakan mysqli_real_escape_string untuk mencegah SQL Injection (walaupun Prepared Statements lebih aman)
    $kode_buku = mysqli_real_escape_string($koneksi, $kode_buku);
    $judul_db = mysqli_real_escape_string($koneksi, $judul); // Sesuaikan dengan nama kolom di DB
    $tahun_terbit = mysqli_real_escape_string($koneksi, $tahun_terbit); // Tanggal perlu di-escape
    $nama_penulis = mysqli_real_escape_string($koneksi, $nama_penulis);
    $penerbit = mysqli_real_escape_string($koneksi, $penerbit);
    $gambar_buku_path_db = mysqli_real_escape_string($koneksi, $gambar_buku_path);

    // Konversi nilai numerik ke integer atau float dan tangani jika kosong
    // Penting: jika kolom di DB adalah INT/DECIMAL, jangan pakai kutip di query SQL
    $no_buku_val = !empty($no_buku) ? (int)$no_buku : 0;
    $stok_val = !empty($stok) ? (int)$stok : 0;
    $isi_halaman_val = !empty($isi_halaman) ? (int)$isi_halaman : 0;
    $harga_val = !empty($harga) ? (float)$harga : 0.00; // Gunakan float jika harga bisa desimal

    // Query INSERT INTO buku
    // PERBAIKAN PADA BAGIAN VALUES, khususnya kutip tunggal pada $penerbit dan nilai numerik
    $sql = "INSERT INTO buku(kode_buku, no_buku, judul, tahun_terbit, nama_penulis, penerbit, isi_halaman, harga, gambar_buku, stok)
            VALUES (
                '$kode_buku',
                $no_buku_val,
                '$judul_db',
                '$tahun_terbit',
                '$nama_penulis',
                '$penerbit',
                $isi_halaman_val,
                $harga_val,
                '$gambar_buku_path_db',
                $stok_val
            )";

    // DEBUGGING: Tampilkan query SQL sebelum dieksekusi (sementara, hapus setelah berhasil)
    echo "<pre>";
    echo "SQL Query: " . htmlspecialchars($sql) . "\n\n";
    echo "POST Data: \n";
    print_r($_POST);
    echo "\nFILES Data: \n";
    print_r($_FILES);
    echo "</pre>";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Buku berhasil ditambahkan!'); window.location.href = 'admin.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PAGE</title>
    <style>

    </style>
</head>

<body>
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <h2>Tambah Buku Baru</h2> <input type="text" name="kode_buku" placeholder="Kode Buku" required>
        <input type="number" name="no_buku" placeholder="Nomor Buku" required>
        <input type="text" name="judul_buku" placeholder="Judul Buku" required>
        <input type="date" name="tahun_terbit" placeholder="Tahun Terbit" required>
        <input type="text" name="stok" placeholder="Stok" required>
        <input type="text" name="penulis" placeholder="Penulis" required>
        <input type="text" name="penerbit" placeholder="Penerbit" required>
        <input type="number" name="jumlah_halaman" placeholder="Jumlah Halaman" required>
        <input type="number" name="harga" placeholder="Harga" required>
        <label for="gambar_buku" style="text-align: left; font-weight: bold; color: #555;">Pilih Gambar Buku:</label>
        <input type="file" name="gambar_buku" id="gambar_buku" accept="image/*" required> <input type="submit" name="tambah" value="TAMBAH BUKU">
    </form>

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
                    <td><?= htmlspecialchars($data['judul']) ?></td>
                    <td><?= htmlspecialchars($data['tahun_terbit']) ?></td>
                    <td><?= htmlspecialchars($data['stok']) ?></td>
                    <td><?= htmlspecialchars($data['nama_penulis']) ?></td>
                    <td><?= htmlspecialchars($data['penerbit']) ?></td>
                    <td><?= htmlspecialchars($data['isi_halaman']) ?></td>
                    <td><?= htmlspecialchars($data['harga']) ?></td>
                    <td>
                        <?php if ($data['gambar_buku']) { ?>
                            <img src="<?= htmlspecialchars($data['gambar_buku']) ?>" alt="Gambar Buku">
                        <?php } else {
                            echo "Tidak ada gambar";
                        } ?>
                    </td>
                    <td>
                        <a href="edit.php?no_buku=<?= htmlspecialchars($data['no_buku']) ?>">Edit</a>
                        <a href="hapus.php?no_buku=<?= htmlspecialchars($data['no_buku']) ?>">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>