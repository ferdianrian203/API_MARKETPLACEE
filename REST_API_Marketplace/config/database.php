<?php
// Ubah konfigurasi ini sesuai MySQL XAMPP Anda.
// Jangan unggah kredensial asli ke repository publik.
$host = "localhost";
$user = "root";
$password = ""; // default XAMPP biasanya kosong
$database = "marketplace";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    http_response_code(500);
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode([
        "success" => false,
        "message" => "Koneksi database gagal."
    ], JSON_PRETTY_PRINT);
    exit;
}
$conn->set_charset("utf8mb4");
