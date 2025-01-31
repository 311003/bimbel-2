-- Tabel Registrasi Murid
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Penjadwalan
CREATE TABLE IF NOT EXISTS jadwal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hari ENUM('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu') NOT NULL,
    jam TIME NOT NULL,
    mata_pelajaran VARCHAR(255) NOT NULL,
    pengajar VARCHAR(255) NOT NULL
);

-- Tabel Presensi
CREATE TABLE IF NOT EXISTS presensi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    tanggal DATE NOT NULL,
    status_kehadiran ENUM('Hadir', 'Tidak Hadir') NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel Pembayaran
CREATE TABLE IF NOT EXISTS pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    jumlah_pembayaran DECIMAL(10, 2) NOT NULL,
    tanggal_pembayaran DATE NOT NULL,
    status_pembayaran ENUM('Lunas', 'Belum Lunas') NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
);
