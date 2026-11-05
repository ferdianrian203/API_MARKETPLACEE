<?php
require_once __DIR__ . "/../config/response.php";
require_once __DIR__ . "/../config/database.php";

require_method("GET");
$result = $conn->query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
if (!$result) {
    send_json(500, ["success" => false, "message" => "Gagal mengambil data kategori."]);
}
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
send_json(200, ["success" => true, "message" => "Daftar kategori berhasil diambil.", "total" => count($data), "data" => $data]);
