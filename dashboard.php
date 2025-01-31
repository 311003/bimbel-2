<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

echo "Selamat datang, " . $_SESSION['nama'] . "! <a href='logout.php'>Logout</a>";
?>
