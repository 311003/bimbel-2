<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Koneksi database
include 'config.php';

// Pastikan username dan email tersedia
$userId = $_SESSION['user_id'];
$query = "SELECT username, email FROM users WHERE id = '$userId'";
$result = mysqli_query($conn, $query);
$userData = mysqli_fetch_assoc($result);

$username = $userData['username'] ?? 'Pengguna';
$email = $userData['email'] ?? '';

// Simpan perubahan profil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];

    // Validasi dan update ke database
    $updateQuery = "UPDATE users SET username = '$newUsername', email = '$newEmail' WHERE id = '$userId'";
    mysqli_query($conn, $updateQuery);

    // Update session
    $_SESSION['username'] = $newUsername;

    echo "<p>Profil berhasil diperbarui!</p>";
}
?>

<h2>Edit Profil</h2>
<form method="POST">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>
    
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

    <button type="submit">Simpan Perubahan</button>
</form>
