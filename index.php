<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Perpustakaan Kel44</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Perpustakaan Sederhana Kel44</h1>
        
        <div class="section">
            <h2>Tambah Buku</h2>
            <form method="POST" action="">
                <input type="text" name="judul" placeholder="Judul Buku" required>
                <input type="text" name="penulis" placeholder="Penulis" required>
                <input type="number" name="halaman" placeholder="Jumlah Halaman" required>
                <button type="submit" name="tambah_buku">Tambah Buku</button>
            </form>
        </div>

        <div class="section">
            <h2>Daftar Buku</h2>
            <ul class="book-list">
                <?php
                session_start();

                if (!isset($_SESSION['buku'])) $_SESSION['buku'] = [];
                if (!isset($_SESSION['peminjaman'])) $_SESSION['peminjaman'] = [];

                if (isset($_POST['tambah_buku'])) {
                    $buku = [
                        'judul' => $_POST['judul'],
                        'penulis' => $_POST['penulis'],
                        'halaman' => $_POST['halaman']
                    ];
                    $_SESSION['buku'][] = $buku;
                }

                if (isset($_POST['hapus_buku'])) {
                    $index = $_POST['hapus_buku'];
                    unset($_SESSION['buku'][$index]);
                    $_SESSION['buku'] = array_values($_SESSION['buku']); 
                }

                if (count($_SESSION['buku']) > 0) {
                    foreach ($_SESSION['buku'] as $index => $buku) {
                        echo "<li><strong>{$buku['judul']}</strong> oleh {$buku['penulis']} - {$buku['halaman']} halaman 
                              <form method='POST' style='display:inline'>
                                <button class='delete-btn' type='submit' name='hapus_buku' value='{$index}'>Hapus</button>
                              </form></li>";
                    }
                } else {
                    echo "<li>Tidak ada buku di perpustakaan.</li>";
                }
                ?>
            </ul>
        </div>

        <div class="section">
            <h2>Peminjaman Buku</h2>
            <form method="POST" action="">
                <select name="judul_buku" required>
                    <option value="" disabled selected>Pilih Buku</option>
                    <?php
                    foreach ($_SESSION['buku'] as $buku) {
                        echo "<option value='{$buku['judul']}'>{$buku['judul']} oleh {$buku['penulis']}</option>";
                    }
                    ?>
                </select>
                <input type="text" name="nama_peminjam" placeholder="Nama Peminjam" required>
                <button type="submit" name="pinjam_buku">Pinjam Buku</button>
            </form>

            <ul class="borrow-list">
                <?php
                if (isset($_POST['pinjam_buku'])) {
                    $peminjaman = [
                        'judul_buku' => $_POST['judul_buku'],
                        'nama_peminjam' => $_POST['nama_peminjam'],
                        'waktu_peminjaman' => date('Y-m-d H:i:s')
                    ];
                    $_SESSION['peminjaman'][] = $peminjaman;
                }

                if (isset($_POST['hapus_peminjaman'])) {
                    $index = $_POST['hapus_peminjaman'];
                    unset($_SESSION['peminjaman'][$index]);
                    $_SESSION['peminjaman'] = array_values($_SESSION['peminjaman']); // Reindex array
                }

                if (count($_SESSION['peminjaman']) > 0) {
                    foreach ($_SESSION['peminjaman'] as $index => $peminjaman) {
                        echo "<li><strong>{$peminjaman['judul_buku']}</strong> dipinjam oleh {$peminjaman['nama_peminjam']} pada {$peminjaman['waktu_peminjaman']}
                              <form method='POST' style='display:inline'>
                                <button class='delete-btn' type='submit' name='hapus_peminjaman' value='{$index}'>Hapus</button>
                              </form></li>";
                    }
                } else {
                    echo "<li>Tidak ada buku yang dipinjam.</li>";
                }
                ?>
            </ul>
            <footer>
            <p>&copy; 2024 CahyokPutra dkk.</p>
        </footer>
        </div>
    </div>
</body>
</html>
