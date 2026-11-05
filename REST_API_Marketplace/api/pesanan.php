<?php
require_once __DIR__ . "/../config/response.php";
require_once __DIR__ . "/../config/database.php";

require_method("POST");
$input = read_json_body();

// Format body: {"nama_pelanggan":"Budi","alamat":"Medan","items":[{"produk_id":1,"jumlah":2}]}
$nama = trim($input["nama_pelanggan"] ?? "");
$alamat = trim($input["alamat"] ?? "");
$items = $input["items"] ?? [];

if ($nama === "" || $alamat === "" || !is_array($items) || count($items) === 0) {
    send_json(400, ["success" => false, "message" => "nama_pelanggan, alamat, dan minimal satu item wajib diisi."]);
}

$conn->begin_transaction();
try {
    $total = 0;
    $validatedItems = [];

    foreach ($items as $item) {
        $produkId = filter_var($item["produk_id"] ?? null, FILTER_VALIDATE_INT);
        $jumlah = filter_var($item["jumlah"] ?? null, FILTER_VALIDATE_INT);
        if (!$produkId || !$jumlah || $produkId < 1 || $jumlah < 1) {
            throw new Exception("Setiap item harus memiliki produk_id dan jumlah berupa bilangan positif.");
        }

        $stmt = $conn->prepare("SELECT id, nama_produk, harga, stok FROM produk WHERE id = ? FOR UPDATE");
        $stmt->bind_param("i", $produkId);
        $stmt->execute();
        $produk = $stmt->get_result()->fetch_assoc();

        if (!$produk) {
            throw new Exception("Produk dengan ID " . $produkId . " tidak ditemukan.");
        }
        if ((int)$produk["stok"] < $jumlah) {
            throw new Exception("Stok produk " . $produk["nama_produk"] . " tidak mencukupi.");
        }

        $subtotal = (float)$produk["harga"] * $jumlah;
        $total += $subtotal;
        $validatedItems[] = [
            "produk_id" => $produkId,
            "jumlah" => $jumlah,
            "harga_satuan" => (float)$produk["harga"],
            "subtotal" => $subtotal
        ];
    }

    $stmt = $conn->prepare("INSERT INTO pesanan (nama_pelanggan, alamat, total, tanggal_pesanan) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("ssd", $nama, $alamat, $total);
    if (!$stmt->execute()) {
        throw new Exception("Pesanan gagal disimpan.");
    }
    $pesananId = $conn->insert_id;

    $detailStmt = $conn->prepare("INSERT INTO detail_pesanan (pesanan_id, produk_id, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)");
    $stockStmt = $conn->prepare("UPDATE produk SET stok = stok - ? WHERE id = ?");
    foreach ($validatedItems as $item) {
        $detailStmt->bind_param("iiidd", $pesananId, $item["produk_id"], $item["jumlah"], $item["harga_satuan"], $item["subtotal"]);
        if (!$detailStmt->execute()) {
            throw new Exception("Detail pesanan gagal disimpan.");
        }
        $stockStmt->bind_param("ii", $item["jumlah"], $item["produk_id"]);
        if (!$stockStmt->execute()) {
            throw new Exception("Stok produk gagal diperbarui.");
        }
    }

    $conn->commit();
    send_json(201, [
        "success" => true,
        "message" => "Pesanan berhasil dibuat.",
        "data" => ["pesanan_id" => $pesananId, "nama_pelanggan" => $nama, "total" => $total, "items" => $validatedItems]
    ]);
} catch (Throwable $e) {
    $conn->rollback();
    send_json(400, ["success" => false, "message" => $e->getMessage()]);
}
