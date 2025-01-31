<?php
include 'config.php';

// Proses Tambah Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['input_siswa'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $kelas = $conn->real_escape_string($_POST['kelas']);
    $tanggal_daftar = date('Y-m-d');

    $sql = "INSERT INTO siswa (nama, kelas, tanggal_daftar) VALUES ('$nama', '$kelas', '$tanggal_daftar')";
    if ($conn->query($sql) === TRUE) {
        echo "Data siswa berhasil ditambahkan.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Proses Hapus Data
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM siswa WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        echo "Data siswa berhasil dihapus.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_siswa'])) {
    $id = intval($_POST['id']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $kelas = $conn->real_escape_string($_POST['kelas']);

    $sql = "UPDATE siswa SET nama = '$nama', kelas = '$kelas' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Data siswa berhasil diupdate.";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Siswa</title>
</head>
<body>
    <h1>Input Data Siswa</h1>
    <form method="POST" action="">
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="kelas">Kelas:</label><br>
        <input type="text" id="kelas" name="kelas" required><br><br>

        <button type="submit" name="input_siswa">Submit</button>
    </form>

    <h1>Daftar Siswa</h1>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tanggal Daftar</th>
            <th>Aksi</th>
        </tr>
        <?php
        $sql = "SELECT * FROM siswa";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['nama'] . "</td>";
            echo "<td>" . $row['kelas'] . "</td>";
            echo "<td>" . $row['tanggal_daftar'] . "</td>";
            echo "<td>
                <a href='?delete_id=" . $row['id'] . "'>Hapus</a> |
                <a href='?edit_id=" . $row['id'] . "'>Edit</a>
            </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    if (isset($_GET['edit_id'])) {
        $edit_id = intval($_GET['edit_id']);
        $sql = "SELECT * FROM siswa WHERE id = $edit_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
    <h1>Edit Data Siswa</h1>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required><br><br>

        <label for="kelas">Kelas:</label><br>
        <input type="text" id="kelas" name="kelas" value="<?php echo $row['kelas']; ?>" required><br><br>

        <button type="submit" name="update_siswa">Update</button>
    </form>
    <?php
        }
    }
    ?>
</body>
</html>
