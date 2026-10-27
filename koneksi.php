<?php
// FILE BERSAMA - jangan diubah tanpa kabar ke anggota lain.
// Sesuaikan konfigurasi dengan XAMPP/Laragon masing-masing.

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'db_mahasiswa';

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}

// Helper untuk mengamankan teks sebelum ditampilkan ke HTML.
function e($teks)
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}
