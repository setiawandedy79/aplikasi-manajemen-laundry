<?php
// Tes koneksi database langsung (tanpa CI)
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'medikalaundry';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ Koneksi GAGAL: " . $conn->connect_error);
}
echo "✅ Koneksi database BERHASIL!<br>";

// Cek tabel users
$result = $conn->query("SELECT * FROM users LIMIT 1");
if ($result && $result->num_rows > 0) {
    echo "✅ Tabel users ADA dan ada datanya<br>";
    while($row = $result->fetch_assoc()) {
        echo "Username: <strong>{$row['username']}</strong><br>";
        echo "Password hash: <code>{$row['password']}</code><br>";
        echo "Role: {$row['role']}<br>";
    }
} else {
    echo "❌ Tabel users KOSONG atau tidak ada<br>";
}
$conn->close();
?>