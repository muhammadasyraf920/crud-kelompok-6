<?php
require 'koneksi.php';

$error = '';
$input = ['nim' => '', 'nama' => '', 'jurusan' => '', 'angkatan' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($input as $kolom => $nilai) {
        $input[$kolom] = trim($_POST[$kolom] ?? '');
    }

    if (in_array('', $input, true)) {
        $error = 'Semua kolom wajib diisi.';
    } else {

        try {
            $sql  = 'INSERT INTO mahasiswa (nim, nama, jurusan, angkatan) VALUES (?, ?, ?, ?)';
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param(
                $stmt,
                'sssi',
                $input['nim'],
                $input['nama'],
                $input['jurusan'],
                $input['angkatan']
            );
            mysqli_stmt_execute($stmt);

            header('Location: index.php?status=tambah');
            exit;
        } catch (mysqli_sql_exception $ex) {
            $error = 'Gagal menyimpan. NIM mungkin sudah terdaftar.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa</title>
</head>
<body>

    <h1>Form Tambah Mahasiswa</h1>

    <?php if ($error !== ''): ?>
        <p><b><?= e($error) ?></b></p>
    <?php endif; ?>

    <form method="post">
        <label for="nim">NIM</label><br>
        <input type="text" id="nim" name="nim" value="<?= e($input['nim']) ?>" required><br>

        <label for="nama">Nama</label><br>
        <input type="text" id="nama" name="nama" value="<?= e($input['nama']) ?>" required><br>

        <label for="jurusan">Jurusan</label><br>
        <input type="text" id="jurusan" name="jurusan" value="<?= e($input['jurusan']) ?>" required><br>

        <label for="angkatan">Angkatan</label><br>
        <input type="number" id="angkatan" name="angkatan" min="2000" max="2100"
               value="<?= e($input['angkatan']) ?>" required><br>
        <br>

        <button type="submit">Simpan</button>
        <a href="index.php">Batal</a>
    </form>

</body>
</html>
