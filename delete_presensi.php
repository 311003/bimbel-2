<?php
session_start();
include 'config.php';

if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    if ($id > 0) {
        $sql = "DELETE FROM presensi WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Presensi berhasil dihapus!'); window.location.href='presensi.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus presensi!');</script>";
        }
    }
}
?>
