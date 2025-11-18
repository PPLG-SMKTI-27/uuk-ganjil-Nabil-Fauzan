-- Database: buku_tamu_digital

CREATE DATABASE IF NOT EXISTS buku_tamu;
USE buku_tamu_digital;

-- Table: users 
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: tamu
CREATE TABLE tamu (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telepon VARCHAR(15),
    instansi VARCHAR(100),
    keperluan TEXT,
    kategori ENUM('orang_tua', 'calon_siswa', 'mahasiswa', 'lainnya') NOT NULL,
    tanggal_kunjungan DATE NOT NULL,
    waktu_masuk TIME,
    waktu_keluar TIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@example.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DRjk38', 'admin'),
('staff', 'staff@example.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DRjk38', 'staff');