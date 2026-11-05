CREATE DATABASE IF NOT EXISTS marketplace
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE marketplace;

CREATE TABLE IF NOT EXISTS kategori (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_kategori VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS produk (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_produk VARCHAR(150) NOT NULL,
  deskripsi TEXT,
  harga DECIMAL(12,2) NOT NULL DEFAULT 0,
  stok INT NOT NULL DEFAULT 0,
  gambar VARCHAR(255) DEFAULT NULL,
  id_kategori INT DEFAULT NULL,
  CONSTRAINT fk_produk_kategori FOREIGN KEY (id_kategori) REFERENCES kategori(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS pesanan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_pelanggan VARCHAR(150) NOT NULL,
  alamat TEXT NOT NULL,
  total DECIMAL(14,2) NOT NULL DEFAULT 0,
  tanggal_pesanan DATETIME NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS detail_pesanan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pesanan_id INT NOT NULL,
  produk_id INT NOT NULL,
  jumlah INT NOT NULL,
  harga_satuan DECIMAL(12,2) NOT NULL,
  subtotal DECIMAL(14,2) NOT NULL,
  CONSTRAINT fk_detail_pesanan FOREIGN KEY (pesanan_id) REFERENCES pesanan(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_detail_produk FOREIGN KEY (produk_id) REFERENCES produk(id)
) ENGINE=InnoDB;

INSERT INTO kategori (nama_kategori) VALUES
('Elektronik'), ('Fashion'), ('Aksesoris');

INSERT INTO produk (nama_produk, deskripsi, harga, stok, gambar, id_kategori) VALUES
('Mouse Wireless', 'Mouse nirkabel untuk komputer dan laptop.', 85000, 25, 'mouse.jpg', 1),
('Kaos Polos', 'Kaos katun nyaman untuk aktivitas sehari-hari.', 65000, 40, 'kaos.jpg', 2),
('Headset', 'Headset dengan mikrofon untuk belajar dan bekerja.', 150000, 15, 'headset.jpg', 1);
