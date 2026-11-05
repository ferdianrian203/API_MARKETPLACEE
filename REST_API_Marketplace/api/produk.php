<?php
require_once __DIR__ . "/../config/response.php";
require_once __DIR__ . "/../config/database.php";

require_method("GET");

if (isset($_GET["id"])) {
    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);
    if (!$id || $id < 1) {
        send_json(400, ["success" => false, "message" => "Parameter id harus berupa bilangan bulat positif."]);
    }

    $stmt = $conn->prepare(
        "SELECT p.id, p.nama_produk, p.deskripsi, p.harga, p.stok, p.gambar, p.id_kategori, k.nama_kategori
         FROM produk p LEFT JOIN kategori k ON p.id_kategori = k.id
         WHERE p.id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produk = $result->fetch_assoc();

    if (!$produk) {
        send_json(404, ["success" => false, "message" => "Produk tidak ditemukan."]);
    }
    send_json(200, ["success" => true, "message" => "Detail produk berhasil diambil.", "data" => $produk]);
}

$result = $conn->query(
    "SELECT p.id, p.nama_produk, p.deskripsi, p.harga, p.stok, p.gambar, p.id_kategori, k.nama_kategori
     FROM produk p LEFT JOIN kategori k ON p.id_kategori = k.id
     ORDER BY p.id DESC"
);
if (!$result) {
    send_json(500, ["success" => false, "message" => "Gagal mengambil data produk."]);
}
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
send_json(200, ["success" => true, "message" => "Daftar produk berhasil diambil.", "total" => count($data), "data" => $data]);
