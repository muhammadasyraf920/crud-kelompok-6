CREATE DATABASE IF NOT EXISTS db_mahasiswa;
USE db_mahasiswa;

CREATE TABLE IF NOT EXISTS mahasiswa (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nim        VARCHAR(20)  NOT NULL UNIQUE,
    nama       VARCHAR(100) NOT NULL,
    jurusan    VARCHAR(100) NOT NULL,
    angkatan   YEAR         NOT NULL,
    created_at TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO mahasiswa (nim, nama, jurusan, angkatan) VALUES
('2455201001', 'Budi Santoso', 'Teknik Informatika', 2024),
('2455201002', 'Siti Aminah',  'Sistem Informasi',   2024);
