<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $nama_siswa = trim($_POST['nama_siswa']);
    $tanggal = trim($_POST['tanggal']);
    $status_kehadiran = trim($_POST['status_kehadiran']);

    $sql = $conn->prepare("UPDATE presensi SET nama_siswa = ?, tanggal = ?, status_kehadiran = ? WHERE id = ?");
    $sql->bind_param("sssi", $nama_siswa, $tanggal, $status_kehadiran, $id);

    if ($sql->execute()) {
        echo "<script>alert('Presensi berhasil diperbarui!'); window.location.href='presensi.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui presensi!');</script>";
    }
}
?>
