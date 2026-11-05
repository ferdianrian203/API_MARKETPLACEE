# LAPORAN PENGUJIAN REST API MARKETPLACE

**Nama:** ........................................  
**NPM:** ........................................  
**Mata Kuliah:** ........................................

## 1. Tujuan
Pengujian dilakukan untuk memastikan REST API marketplace dapat menerima request HTTP, mengambil dan menyimpan data pada MySQL, serta mengirimkan response dalam format JSON.

## 2. Rancangan endpoint
| No. | Method | Endpoint | Keterangan |
|---|---|---|---|
| 1 | GET | `/api/produk.php` | Mengambil seluruh produk |
| 2 | GET | `/api/produk.php?id=1` | Mengambil detail produk |
| 3 | GET | `/api/kategori.php` | Mengambil seluruh kategori |
| 4 | POST | `/api/pesanan.php` | Membuat pesanan baru |

## 3. Lingkungan pengujian
- Sistem operasi: ........................................
- XAMPP/PHP: ........................................
- MySQL: ........................................
- Postman: ........................................
- Database: `marketplace`

## 4. Hasil pengujian
Isi berdasarkan hasil aktual setelah menjalankan aplikasi. Tempel screenshot pada setiap bagian.

### 4.1 GET seluruh produk
URL: `http://localhost/REST_API_Marketplace/api/produk.php`  
Status HTTP: ........  
Hasil: Berhasil / Gagal  
Screenshot: **[Tempel screenshot browser/Postman di sini]**

### 4.2 GET detail produk
URL: `http://localhost/REST_API_Marketplace/api/produk.php?id=1`  
Status HTTP: ........  
Hasil: Berhasil / Gagal  
Screenshot: **[Tempel screenshot di sini]**

### 4.3 GET kategori
URL: `http://localhost/REST_API_Marketplace/api/kategori.php`  
Status HTTP: ........  
Hasil: Berhasil / Gagal  
Screenshot: **[Tempel screenshot di sini]**

### 4.4 POST pesanan
URL: `http://localhost/REST_API_Marketplace/api/pesanan.php`  
Method: POST  
Body: JSON  
Status HTTP: ........  
Hasil: Berhasil / Gagal  
Screenshot request dan response Postman: **[Tempel screenshot di sini]**

### 4.5 Verifikasi database
Lampirkan screenshot phpMyAdmin yang menunjukkan data pada tabel `pesanan` dan `detail_pesanan` setelah POST berhasil.  
Screenshot: **[Tempel screenshot di sini]**

## 5. Analisis
Jelaskan apakah setiap endpoint berjalan sesuai fungsi. Jika terdapat kesalahan, tuliskan penyebab dan langkah perbaikannya. Pastikan analisis sesuai hasil pengujian nyata.

## 6. Kesimpulan
REST API dinyatakan berhasil apabila endpoint GET dapat membaca data dari MySQL dan endpoint POST dapat menyimpan pesanan beserta detailnya. Lengkapi kesimpulan berdasarkan pengujian yang benar-benar dilakukan.

## 7. Repository GitHub
URL repository: ........................................
