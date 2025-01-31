<?php
session_start();
include 'config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle Create (Tambah Presensi)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $nama_siswa = trim($_POST['nama_siswa']);
    $tanggal = trim($_POST['tanggal']);
    $status_kehadiran = trim($_POST['status_kehadiran']);

    if (!empty($nama_siswa) && !empty($tanggal) && !empty($status_kehadiran)) {
        $stmt = $conn->prepare("INSERT INTO presensi (nama_siswa, tanggal, status_kehadiran) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama_siswa, $tanggal, $status_kehadiran);

        if ($stmt->execute()) {
            echo "<script>alert('Presensi berhasil ditambahkan!');</script>";
            $sql = "SELECT * FROM presensi ORDER BY id DESC";
            $result = $conn->query($sql);
        } else {
            echo "<script>alert('Gagal menambahkan presensi!');</script>";
        }
    } else {
        echo "<script>alert('Semua field harus diisi!');</script>";
    }
}

// Handle Delete (Hapus Presensi)
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM presensi WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>alert('Presensi berhasil dihapus!');</script>";
            $sql = "SELECT * FROM presensi ORDER BY id DESC";
            $result = $conn->query($sql);
        } else {
            echo "<script>alert('Gagal menghapus presensi!');</script>";
        }
    }
}

// Handle Update (Edit Presensi)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $nama_siswa = trim($_POST['nama_siswa']);
    $tanggal = trim($_POST['tanggal']);
    $status_kehadiran = trim($_POST['status_kehadiran']);

    $stmt = $conn->prepare("UPDATE presensi SET nama_siswa = ?, tanggal = ?, status_kehadiran = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nama_siswa, $tanggal, $status_kehadiran, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Presensi berhasil diperbarui!');</script>";
        $sql = "SELECT * FROM presensi ORDER BY id DESC";
        $result = $conn->query($sql);
    } else {
        echo "<script>alert('Gagal memperbarui presensi!');</script>";
    }
}

// Handle Edit (Edit Presensi)
if (isset($_GET['edit_id'])) {
    $id = intval($_GET['edit_id']);
    $sql = "SELECT * FROM presensi WHERE id = '$id'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();

    ?>
    <h2>Edit Presensi</h2>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <div class="form-group">
            <label for="nama_siswa">Nama Siswa:</label>
            <input type="text" id="nama_siswa" name="nama_siswa" value="<?php echo $data['nama_siswa']; ?>" required>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" value="<?php echo $data['tanggal']; ?>" required>
        </div>
        <div class="form-group">
            <label for="status_kehadiran">Status Kehadiran:</label>
            <select id="status_kehadiran" name="status_kehadiran" required>
                <option value="Hadir" <?php if ($data['status_kehadiran'] == 'Hadir') echo 'selected'; ?>>Hadir</option>
                <option value="Tidak Hadir" <?php if ($data['status_kehadiran'] == 'Tidak Hadir') echo 'selected'; ?>>Tidak Hadir</option>
                <option value="Izin" <?php if ($data['status_kehadiran'] == 'Izin') echo 'selected'; ?>>Izin</option>
                <option value="Sakit" <?php if ($data['status_kehadiran'] == 'Sakit') echo 'selected'; ?>>Sakit</option>
            </select>
        </div>
        <button type="submit" name="update">Update</button>
    </form>
    <?php
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Presensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        .message {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>CRUD Presensi</h1>

        <!-- Form Create -->
        <h2>Tambah Presensi Baru</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_siswa">Nama Siswa:</label>
                <input type="text" id="nama_siswa" name="nama_siswa" required>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" required>
            </div>
            <div class="form-group">
                <label for="status_kehadiran">Status Kehadiran:</label>
                <select id="status_kehadiran" name="status_kehadiran" required>
                    <option value="Hadir">Hadir</option>
                    <option value="Tidak Hadir">Tidak Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                </select>
            </div>
            <button type="submit" name="create">Tambah</button>
        </form>

        <!-- Table Read -->
        <h2>Daftar Presensi</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Siswa</th>
                    <th>Tanggal</th>
                    <th>Status Kehadiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM presensi ORDER BY id DESC";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Kesalahan dalam query: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_siswa']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status_kehadiran']) . "</td>";
                        echo "<td>
                            <a href='presensi.php?delete_id=" . $row['id'] . "' onclick='return confirm(\"Yakin ingin menghapus data ini?\");'>Hapus</a> |
                            <a href='presensi.php?edit_id=" . $row['id'] . "'>Edit</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data presensi yang tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>