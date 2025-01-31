<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_siswa = trim($_POST['nama_siswa']);
    $tanggal = trim($_POST['tanggal']);
    $status_kehadiran = trim($_POST['status_kehadiran']);

    if (!empty($nama_siswa) && !empty($tanggal) && !empty($status_kehadiran)) {
        $sql = $conn->prepare("INSERT INTO presensi (nama_siswa, tanggal, status_kehadiran) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $nama_siswa, $tanggal, $status_kehadiran);

        if ($sql->execute()) {
            echo "<script>alert('Presensi berhasil ditambahkan!'); window.location.href='presensi.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan presensi!');</script>";
        }
    } else {
        echo "<script>alert('Semua field harus diisi!');</script>";
    }
}
?>
