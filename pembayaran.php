<?php
session_start();
include 'config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $nama_siswa = $conn->real_escape_string($_POST['nama_siswa']);
    $tanggal_bayar = $conn->real_escape_string($_POST['tanggal_bayar']);
    $jumlah_bayar = $conn->real_escape_string($_POST['jumlah_bayar']);
    $metode_bayar = $conn->real_escape_string($_POST['metode_bayar']);

    $sql = "INSERT INTO pembayaran (nama_siswa, tanggal_bayar, jumlah_bayar, metode_bayar) 
            VALUES ('$nama_siswa', '$tanggal_bayar', '$jumlah_bayar', '$metode_bayar')";
    if ($conn->query($sql) === TRUE) {
        $message = "Pembayaran berhasil ditambahkan.";
    } else {
        $error = "Gagal menambahkan pembayaran: " . $conn->error;
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $sql = "DELETE FROM pembayaran WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $message = "Pembayaran berhasil dihapus.";
    } else {
        $error = "Gagal menghapus pembayaran: " . $conn->error;
    }
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $nama_siswa = $conn->real_escape_string($_POST['nama_siswa']);
    $tanggal_bayar = $conn->real_escape_string($_POST['tanggal_bayar']);
    $jumlah_bayar = $conn->real_escape_string($_POST['jumlah_bayar']);
    $metode_bayar = $conn->real_escape_string($_POST['metode_bayar']);

    $sql = "UPDATE pembayaran 
            SET nama_siswa = '$nama_siswa', tanggal_bayar = '$tanggal_bayar', jumlah_bayar = '$jumlah_bayar', metode_bayar = '$metode_bayar'
            WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $message = "Pembayaran berhasil diupdate.";
    } else {
        $error = "Gagal mengupdate pembayaran: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Pembayaran</title>
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
        .form-group input {
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
        <h1>CRUD Pembayaran</h1>
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Form Create -->
        <h2>Tambah Pembayaran Baru</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_siswa">Nama Siswa:</label>
                <input type="text" id="nama_siswa" name="nama_siswa" required>
            </div>
            <div class="form-group">
                <label for="tanggal_bayar">Tanggal Bayar:</label>
                <input type="date" id="tanggal_bayar" name="tanggal_bayar" required>
            </div>
            <div class="form-group">
                <label for="jumlah_bayar">Jumlah Bayar:</label>
                <input type="number" id="jumlah_bayar" name="jumlah_bayar" required>
            </div>
            <div class="form-group">
                <label for="metode_bayar">Metode Bayar:</label>
                <input type="text" id="metode_bayar" name="metode_bayar" required>
            </div>
            <button type="submit" name="create">Tambah</button>
        </form>

        <!-- Table Read -->
        <h2>Daftar Pembayaran</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Siswa</th>
                    <th>Tanggal Bayar</th>
                    <th>Jumlah Bayar</th>
                    <th>Metode Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM pembayaran";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nama_siswa'] . "</td>";
                    echo "<td>" . $row['tanggal_bayar'] . "</td>";
                    echo "<td>" . $row['jumlah_bayar'] . "</td>";
                    echo "<td>" . $row['metode_bayar'] . "</td>";
                    echo "<td>
                        <a href='?delete_id=" . $row['id'] . "'>Hapus</a> |
                        <a href='?edit_id=" . $row['id'] . "'>Edit</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Form Update -->
        <?php if (isset($_GET['edit_id'])):
            $edit_id = intval($_GET['edit_id']);
            $sql = "SELECT * FROM pembayaran WHERE id = $edit_id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        ?>
        <h2>Edit Pembayaran</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="nama_siswa">Nama Siswa:</label>
                <input type="text" id="nama_siswa" name="nama_siswa" value="<?php echo $row['nama_siswa']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal_bayar">Tanggal Bayar:</label>
                <input type="date" id="tanggal_bayar" name="tanggal_bayar" value="<?php echo $row['tanggal_bayar']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jumlah_bayar">Jumlah Bayar:</label>
                <input type="number" id="jumlah_bayar" name="jumlah_bayar" value="<?php echo $row['jumlah_bayar']; ?>" required>
            </div>
            <div class="form-group">
                <label for="metode_bayar">Metode Bayar:</label>
                <input type="text" id="metode_bayar" name="metode_bayar" value="<?php echo $row['metode_bayar']; ?>" required>
            </div>
            <button type="submit" name="update">Update</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
