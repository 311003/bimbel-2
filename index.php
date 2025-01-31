<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Pastikan username tersedia di session
$nama_user = isset($_SESSION['username']) ? $_SESSION['username'] : 'Pengguna';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bimbel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Header dan tombol profil */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2c3e50;
            color: white;
            padding: 10px 20px;
        }
        .header .profile-button {
            background-color: #3498db;
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .header .profile-button:hover {
            background-color: #2980b9;
        }
        .dashboard-container {
            display: flex;
        }
        .sidebar {
            width: 20%;
            background-color: #34495e;
            color: white;
            height: 100vh;
            padding: 20px;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div>Selamat Datang, <?php echo htmlspecialchars($nama_user); ?>!</div>
        <button class="profile-button" onclick="loadPage('profile.php')">Edit Profil</button>
    </div>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Bimbel Dashboard</h2>
            <ul>
                <li><a href="#" onclick="loadPage('register.php')">Registrasi Siswa</a></li>
                <li><a href="#" onclick="loadPage('jadwal.php')">Jadwal Bimbel</a></li>
                <li><a href="#" onclick="loadPage('pembayaran.php')">Pembayaran</a></li>
                <li><a href="#" onclick="loadPage('presensi.php')">Presensi</a></li>
                <li><a href="#" onclick="loadPage('forgot_password.php')">Lupa Password</a></li>
            </ul>
            <div class="logout">
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <h1>Dashboard Statistik</h1>
            <div class="stats">
                <div class="card">
                    <h3>Total Siswa</h3>
                    <p>150</p>
                </div>
                <div class="card">
                    <h3>Jadwal Tersedia</h3>
                    <p>20</p>
                </div>
                <div class="card">
                    <h3>Transaksi Pembayaran</h3>
                    <p>75</p>
                </div>
                <div class="card">
                    <h3>Presensi</h3>
                    <p>500</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk memuat halaman dengan AJAX
        function loadPage(page) {
            const mainContent = document.getElementById('main-content');
            const xhr = new XMLHttpRequest();
            xhr.open('GET', page, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    mainContent.innerHTML = xhr.responseText;
                } else {
                    mainContent.innerHTML = '<h2>Error: Halaman tidak dapat dimuat.</h2>';
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
