<?php
// ===== ANGGOTA 2 : READ (Tampil Data) | branch: read =====
// Halaman utama. Tombol Tambah, Ubah, dan Hapus sudah disiapkan
// dan mengarah ke file milik Anggota 1, 3, dan 4.
require 'koneksi.php';

// --- Ambil semua data mahasiswa ---
$result = mysqli_query($koneksi, 'SELECT * FROM mahasiswa ORDER BY id DESC');

// --- Pesan notifikasi dari halaman lain ---
$daftarPesan = [
    'tambah' => 'Data berhasil ditambahkan.',
    'ubah'   => 'Data berhasil diubah.',
    'hapus'  => 'Data berhasil dihapus.',
];
$pesan = $daftarPesan[$_GET['status'] ?? ''] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
</head>
<body>

    <h1>Data Mahasiswa</h1>

    <p><a href="tambah.php">+ Tambah Mahasiswa</a></p>

    <?php if ($pesan !== ''): ?>
        <p><b><?= e($pesan) ?></b></p>
    <?php endif; ?>

    <table border="1" cellpadding="6" cellspacing="0">
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Angkatan</th>
            <th>Aksi</th>
        </tr>

        <?php if (mysqli_num_rows($result) === 0): ?>
            <tr>
                <td colspan="6">Belum ada data.</td>
            </tr>
        <?php endif; ?>

        <?php $no = 1; ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= e($row['nim']) ?></td>
                <td><?= e($row['nama']) ?></td>
                <td><?= e($row['jurusan']) ?></td>
                <td><?= e($row['angkatan']) ?></td>
                <td>
                    <a href="ubah.php?id=<?= (int) $row['id'] ?>">Ubah</a>

                    <form action="hapus.php" method="post" style="display:inline"
                          onsubmit="return confirm('Yakin hapus data ini?');">
                        <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
