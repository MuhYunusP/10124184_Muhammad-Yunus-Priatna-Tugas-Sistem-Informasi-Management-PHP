-- =========================================================
-- SIM Data Mahasiswa - Struktur Database
-- =========================================================

CREATE DATABASE IF NOT EXISTS `db_simplesis`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_simplesis`;

-- ---------------------------------------------------------
-- Tabel: users
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id`           INT AUTO_INCREMENT PRIMARY KEY,
  `username`     VARCHAR(50)  NOT NULL UNIQUE,
  `password`     VARCHAR(255) NOT NULL,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Tabel: mahasiswa
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `mahasiswa`;
CREATE TABLE `mahasiswa` (
  `id`         INT AUTO_INCREMENT PRIMARY KEY,
  `nim`        VARCHAR(20)  NOT NULL UNIQUE,
  `nama`       VARCHAR(100) NOT NULL,
  `jurusan`    VARCHAR(100) NOT NULL,
  `angkatan`   INT          NOT NULL,
  `email`      VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Data contoh mahasiswa
-- ---------------------------------------------------------
INSERT INTO `mahasiswa` (`nim`, `nama`, `jurusan`, `angkatan`, `email`) VALUES
('20230001', 'Andi Pratama',  'Informatika',      2023, 'andi@example.com'),
('20230002', 'Budi Santoso',  'Sistem Informasi', 2023, 'budi@example.com'),
('20220003', 'Citra Lestari', 'Teknik Komputer',  2022, 'citra@example.com');

-- ---------------------------------------------------------
-- Akun Admin Default (Username: admin, Password: admin123)
-- Hash di bawah ini menggunakan bcrypt dan sudah diverifikasi
-- ---------------------------------------------------------
INSERT INTO `users` (`username`, `password`, `nama_lengkap`) VALUES
('admin', '$2y$10$Mv4Q9824OQEIYyA5AKJW4eAJdBZKOnYi3s0KThBfjGoeLreoXgLkG', 'Administrator');