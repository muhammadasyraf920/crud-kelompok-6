<?php
// ===== ANGGOTA 3 : UPDATE (Ubah Data) | branch: update =====
require 'koneksi.php';

$id    = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$error = '';

// --- 1. Ambil data lama berdasarkan id ---
$stmt = mysqli_prepare($koneksi, 'SELECT * FROM mahasiswa WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    die('Data tidak ditemukan. <a href="index.php">Kembali</a>');
}

// --- 2. Proses form saat disubmit ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = ['nim' => '', 'nama' => '', 'jurusan' => '', 'angkatan' => ''];

    foreach ($input as $kolom => $nilai) {
        $input[$kolom] = trim($_POST[$kolom] ?? '');
    }

    // Isi form tetap menampilkan input terakhir jika terjadi error
    $data = array_merge($data, $input);

    if (in_array('', $input, true)) {
        $error = 'Semua kolom wajib diisi.';
    } else {

        // --- 3. Simpan perubahan ---
        try {
            $sql  = 'UPDATE mahasiswa SET nim = ?, nama = ?, jurusan = ?, angkatan = ? WHERE id = ?';
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param(
                $stmt,
                'sssii',
                $input['nim'],
                $input['nama'],
                $input['jurusan'],
                $input['angkatan'],
                $id
            );
            mysqli_stmt_execute($stmt);

            header('Location: index.php?status=ubah');
            exit;
        } catch (mysqli_sql_exception $ex) {
            $error = 'Gagal mengubah. NIM mungkin sudah dipakai mahasiswa lain.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Mahasiswa</title>
</head>
<body>

    <h1>Form Ubah Mahasiswa</h1>

    <?php if ($error !== ''): ?>
        <p><b><?= e($error) ?></b></p>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="id" value="<?= $id ?>">

        <label for="nim">NIM</label><br>
        <input type="text" id="nim" name="nim" value="<?= e($data['nim']) ?>" required><br>

        <label for="nama">Nama</label><br>
        <input type="text" id="nama" name="nama" value="<?= e($data['nama']) ?>" required><br>

        <label for="jurusan">Jurusan</label><br>
        <input type="text" id="jurusan" name="jurusan" value="<?= e($data['jurusan']) ?>" required><br>

        <label for="angkatan">Angkatan</label><br>
        <input type="number" id="angkatan" name="angkatan" min="2000" max="2100"
               value="<?= e($data['angkatan']) ?>" required><br>
        <br>

        <button type="submit">Simpan Perubahan</button>
        <a href="index.php">Batal</a>
    </form>

</body>
</html>
