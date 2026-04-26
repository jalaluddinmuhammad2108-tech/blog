-- ============================================================
-- EKSPOR DATABASE: db_blog
-- Sistem Manajemen Blog (CMS)
-- UTS Pemrograman Web - Semester Genap 2025/2026
-- ============================================================

-- Membuat database
CREATE DATABASE IF NOT EXISTS db_blog
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Menggunakan database
USE db_blog;

-- ============================================================
-- Tabel: penulis
-- ============================================================
CREATE TABLE IF NOT EXISTS penulis (
  id            INT          NOT NULL AUTO_INCREMENT,
  nama_depan    VARCHAR(100) NOT NULL,
  nama_belakang VARCHAR(100) NOT NULL,
  user_name     VARCHAR(50)  NOT NULL,
  password      VARCHAR(255) NOT NULL,
  foto          VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_user_name (user_name)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ============================================================
-- Tabel: kategori_artikel
-- ============================================================
CREATE TABLE IF NOT EXISTS kategori_artikel (
  id             INT          NOT NULL AUTO_INCREMENT,
  nama_kategori  VARCHAR(100) NOT NULL,
  keterangan     TEXT,
  PRIMARY KEY (id),
  UNIQUE KEY uq_nama_kategori (nama_kategori)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ============================================================
-- Tabel: artikel
-- ============================================================
CREATE TABLE IF NOT EXISTS artikel (
  id           INT          NOT NULL AUTO_INCREMENT,
  id_penulis   INT          NOT NULL,
  id_kategori  INT          NOT NULL,
  judul        VARCHAR(255) NOT NULL,
  isi          TEXT         NOT NULL,
  gambar       VARCHAR(255) NOT NULL,
  hari_tanggal VARCHAR(50)  NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_artikel_penulis
    FOREIGN KEY (id_penulis)
    REFERENCES penulis (id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT fk_artikel_kategori
    FOREIGN KEY (id_kategori)
    REFERENCES kategori_artikel (id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- ============================================================
-- Data Contoh: penulis
-- (password: password123 - di-hash dengan bcrypt)
-- ============================================================
INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES
('Ahmad',  'Fauzi',   'ahmad_f', '$2y$10$YourHashedPasswordHere1234567890', 'default.png'),
('Siti',   'Rahayu',  'siti_r',  '$2y$10$YourHashedPasswordHere1234567890', 'default.png'),
('Budi',   'Santoso', 'budi_s',  '$2y$10$YourHashedPasswordHere1234567890', 'default.png');

-- ============================================================
-- Data Contoh: kategori_artikel
-- ============================================================
INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES
('Tutorial',   'Artikel panduan langkah demi langkah'),
('Database',   'Artikel seputar pengelolaan database'),
('Web Design', 'Artikel tentang desain antarmuka web');

-- ============================================================
-- Data Contoh: artikel
-- ============================================================
INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES
(1, 1, 'Pengenalan PHP 8', 'PHP 8 membawa banyak fitur baru yang memudahkan pengembangan web modern.', 'default_artikel.png', 'Senin, 13 April 2026 | 09:00'),
(2, 2, 'Belajar MySQL Dasar', 'MySQL adalah sistem manajemen database relasional yang sangat populer.', 'default_artikel.png', 'Selasa, 14 April 2026 | 10:30');
