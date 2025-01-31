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
    $hari = $conn->real_escape_string($_POST['hari']);
    $jam = $conn->real_escape_string($_POST['jam']);
    $mata_pelajaran = $conn->real_escape_string($_POST['mata_pelajaran']);
    $pengajar = $conn->real_escape_string($_POST['pengajar']);

    $sql = "INSERT INTO jadwal (hari, jam, mata_pelajaran, pengajar) 
            VALUES ('$hari', '$jam', '$mata_pelajaran', '$pengajar')";
    if ($conn->query($sql) === TRUE) {
        $message = "Jadwal berhasil ditambahkan.";
    } else {
        $error = "Gagal menambahkan jadwal: " . $conn->error;
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $sql = "DELETE FROM jadwal WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $message = "Jadwal berhasil dihapus.";
    } else {
        $error = "Gagal menghapus jadwal: " . $conn->error;
    }
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $hari = $conn->real_escape_string($_POST['hari']);
    $jam = $conn->real_escape_string($_POST['jam']);
    $mata_pelajaran = $conn->real_escape_string($_POST['mata_pelajaran']);
    $pengajar = $conn->real_escape_string($_POST['pengajar']);

    $sql = "UPDATE jadwal 
            SET hari = '$hari', jam = '$jam', mata_pelajaran = '$mata_pelajaran', pengajar = '$pengajar'
            WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $message = "Jadwal berhasil diupdate.";
    } else {
        $error = "Gagal mengupdate jadwal: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Jadwal Bimbel</title>
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
        <h1>CRUD Jadwal Bimbel</h1>
        <?php if (isset($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Form Create -->
        <h2>Tambah Jadwal Baru</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="hari">Hari:</label>
                <input type="text" id="hari" name="hari" required>
            </div>
            <div class="form-group">
                <label for="jam">Jam:</label>
                <input type="text" id="jam" name="jam" required>
            </div>
            <div class="form-group">
                <label for="mata_pelajaran">Mata Pelajaran:</label>
                <input type="text" id="mata_pelajaran" name="mata_pelajaran" required>
            </div>
            <div class="form-group">
                <label for="pengajar">Pengajar:</label>
                <input type="text" id="pengajar" name="pengajar" required>
            </div>
            <button type="submit" name="create">Tambah</button>
        </form>

        <!-- Table Read -->
        <h2>Daftar Jadwal</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Mata Pelajaran</th>
                    <th>Pengajar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM jadwal";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['hari'] . "</td>";
                    echo "<td>" . $row['jam'] . "</td>";
                    echo "<td>" . $row['mata_pelajaran'] . "</td>";
                    echo "<td>" . $row['pengajar'] . "</td>";
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
            $sql = "SELECT * FROM jadwal WHERE id = $edit_id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        ?>
        <h2>Edit Jadwal</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="hari">Hari:</label>
                <input type="text" id="hari" name="hari" value="<?php echo $row['hari']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jam">Jam:</label>
                <input type="text" id="jam" name="jam" value="<?php echo $row['jam']; ?>" required>
            </div>
            <div class="form-group">
                <label for="mata_pelajaran">Mata Pelajaran:</label>
                <input type="text" id="mata_pelajaran" name="mata_pelajaran" value="<?php echo $row['mata_pelajaran']; ?>" required>
            </div>
            <div class="form-group">
                <label for="pengajar">Pengajar:</label>
                <input type="text" id="pengajar" name="pengajar" value="<?php echo $row['pengajar']; ?>" required>
            </div>
            <button type="submit" name="update">Update</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
