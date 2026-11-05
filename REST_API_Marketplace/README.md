# REST API Marketplace — PHP Native + MySQLi

Paket contoh tugas REST API marketplace untuk dijalankan secara lokal menggunakan XAMPP.

## 1. Struktur folder
- `api/produk.php` — GET daftar produk dan GET detail produk dengan parameter `id`
- `api/kategori.php` — GET daftar kategori
- `api/pesanan.php` — POST membuat pesanan dan detail pesanan
- `config/database.php` — konfigurasi koneksi MySQL
- `config/response.php` — helper response JSON dan validasi metode
- `database/marketplace.sql` — database contoh
- `postman/Marketplace_API.postman_collection.json` — koleksi pengujian Postman

## 2. Instalasi XAMPP
1. Ekstrak folder `REST_API_Marketplace` ke `C:\xampp\htdocs\`.
2. Buka XAMPP Control Panel, jalankan **Apache** dan **MySQL**.
3. Buka `http://localhost/phpmyadmin`.
4. Pilih menu **Import**, pilih file `database/marketplace.sql`, lalu klik **Import/Go**.
5. Pastikan database bernama `marketplace` sudah terbentuk.
6. Periksa `config/database.php`. Default XAMPP umumnya host `localhost`, user `root`, password kosong, database `marketplace`.

## 3. Endpoint
| Method | URL | Fungsi |
|---|---|---|
| GET | `http://localhost/REST_API_Marketplace/api/produk.php` | Daftar produk |
| GET | `http://localhost/REST_API_Marketplace/api/produk.php?id=1` | Detail produk ID 1 |
| GET | `http://localhost/REST_API_Marketplace/api/kategori.php` | Daftar kategori |
| POST | `http://localhost/REST_API_Marketplace/api/pesanan.php` | Membuat pesanan |

### Contoh body POST pesanan
Pilih method **POST**, tab **Body → raw → JSON**, lalu kirim:
```json
{
  "nama_pelanggan": "Budi",
  "alamat": "Medan",
  "items": [
    {"produk_id": 1, "jumlah": 2},
    {"produk_id": 3, "jumlah": 1}
  ]
}
```
API akan memeriksa produk dan stok, menyimpan pesanan beserta detailnya, lalu mengurangi stok produk dalam satu transaksi database.

## 4. Pengujian browser
Buka URL berikut setelah Apache dan MySQL aktif:
- `http://localhost/REST_API_Marketplace/api/produk.php`
- `http://localhost/REST_API_Marketplace/api/produk.php?id=1`
- `http://localhost/REST_API_Marketplace/api/kategori.php`

Browser cocok untuk GET. Gunakan Postman untuk POST.

## 5. Pengujian Postman
1. Buka Postman → **Import**.
2. Pilih `postman/Marketplace_API.postman_collection.json`.
3. Jalankan request GET daftar produk.
4. Jalankan GET detail produk.
5. Jalankan GET kategori.
6. Jalankan POST pesanan dengan body JSON yang tersedia pada koleksi.

## 6. Memeriksa database
Di phpMyAdmin, pilih database `marketplace`:
- Tabel `produk`: data produk dan stok.
- Tabel `pesanan`: pesanan yang berhasil dibuat.
- Tabel `detail_pesanan`: rincian produk tiap pesanan.
Sesudah POST berhasil, refresh tabel `pesanan` dan `detail_pesanan` untuk membuktikan data tersimpan.

## 7. Catatan penting untuk Soal 11
Paket ini menggunakan skema contoh dengan tabel `produk`, `kategori`, `pesanan`, dan `detail_pesanan`. **Jika database Soal 11 milik Anda memiliki nama tabel/kolom berbeda, sesuaikan query SQL di endpoint atau kirim file `.sql` Soal 11 agar dapat disesuaikan secara tepat.** Jangan mengklaim paket ini sudah terhubung ke database Soal 11 sebelum skemanya dicocokkan dan diuji.

## 8. Keamanan dan GitHub
- Jangan unggah password database asli.
- Untuk penggunaan produksi, batasi CORS, tambahkan autentikasi/token, validasi lebih ketat, HTTPS, dan logging.
- File konfigurasi di paket memakai kredensial default lokal XAMPP. Ganti sesuai lingkungan Anda.
- Screenshot harus diambil setelah API benar-benar dijalankan di komputer Anda. Jangan gunakan contoh response dalam laporan sebagai bukti pengujian nyata.

## 9. Rancangan JSON
Daftar produk:
```json
{
  "success": true,
  "message": "Daftar produk berhasil diambil.",
  "total": 1,
  "data": [
    {
      "id": "1",
      "nama_produk": "Mouse Wireless",
      "deskripsi": "Mouse nirkabel untuk komputer dan laptop.",
      "harga": "85000.00",
      "stok": "25",
      "gambar": "mouse.jpg",
      "id_kategori": "1",
      "nama_kategori": "Elektronik"
    }
  ]
}
```
Detail produk:
```json
{
  "success": true,
  "message": "Detail produk berhasil diambil.",
  "data": {
    "id": "1",
    "nama_produk": "Mouse Wireless",
    "harga": "85000.00",
    "stok": "25"
  }
}
```
