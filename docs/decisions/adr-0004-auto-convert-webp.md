# ADR-0004: Auto-Convert Upload Gambar ke WebP

- **Status:** Accepted
- **Tanggal:** 2026-10-23
- **Pembuat keputusan:** Webane Indonesia

## Konteks
Pengelola website sekolah sering mengunggah foto kegiatan, banner, dan foto guru
berukuran besar langsung dari kamera/ponsel dalam format `.jpg` atau `.png`
(sering kali 2–10 MB per file). Hal ini menyebabkan:
1. Ruang penyimpanan (disk space) hosting pelanggan cepat penuh karena setiap
   upload menghasilkan file asli + 5–7 ukuran potongan (sub-sizes) dalam format
   JPG/PNG.
2. Beban bandwidth dan waktu muat halaman (LCP) menjadi lambat, terutama bagi
   pengunjung mobile.

Kita membutuhkan mekanisme otomatis di level theme (tanpa bergantung pada plugin
berbayar pihak ketiga) yang:
- Mengonversi setiap gambar `.jpg`/`.jpeg`/`.png` yang diunggah menjadi `.webp`.
- Memastikan ukuran original tetap ada dalam format `.webp`, seluruh ukuran
  potongan (`thumbnail`, `medium`, `large`, `kotak`, dst) otomatis terbentuk
  dalam format `.webp`, dan file mentah `.jpg`/`.png` dihapus dari server.

## Opsi yang Dipertimbangkan

### Opsi A — Hook `wp_handle_upload` & `wp_handle_sideload` (Sebelum Metadata Dibuat)
Mengintersepsi file tepat setelah `wp_handle_upload` memindahkan file ke folder
`uploads/`, mengonversinya ke `.webp` via `wp_get_image_editor()`, menghapus
file `.jpg`/`.png` asli, lalu mengembalikan path & MIME `image/webp` ke
WordPress sebelum `wp_insert_attachment()` dan `wp_generate_attachment_metadata()`
dijalankan.
- (+) WordPress secara native mencatat attachment sebagai `image/webp` sejak awal.
- (+) `wp_generate_attachment_metadata()` otomatis memotong semua ukuran gambar
  (`thumbnail`, `medium`, `large`, `kotak`) langsung ke format `.webp` tanpa
  perlu kerja ganda (tidak memotong JPG dulu baru dikonversi satu-satu).
- (+) Saat gambar dihapus dari Media Library (`wp_delete_attachment`), WordPress
  otomatis menghapus file original `.webp` beserta seluruh sub-size `.webp` tanpa
  menyisakan file yatim (orphan files).

### Opsi B — Hook `wp_generate_attachment_metadata` (Setelah Sub-size JPG/PNG Dibuat)
Membiarkan WordPress membuat semua potongan dalam JPG/PNG, lalu mengonversi
file asli + semua potongan satu per satu ke WebP dan menghapus file JPG/PNG.
- (-) Kerja CPU & I/O disk 2× lipat (crop semua ukuran ke JPG dulu, lalu encode
  ulang semua ukuran ke WebP).
- (-) Harus memanipulasi array `$metadata['sizes']` dan `wp_update_post()` untuk
  mengubah `post_mime_type` secara manual.

## Keputusan
Pilih **Opsi A**: Konversi dilakukan pada filter `wp_handle_upload` dan
`wp_handle_sideload` di modul `inc/webp-converter.php` dengan kualitas default
`82` (dapat diubah lewat filter `sekolahane_webp_quality`), disertai penanganan
khusus PNG 8-bit palette (`imagepalettetotruecolor`) dan fallback aman jika
server tidak mendukung WebP.

## Konsekuensi
- **Positif:** Semua file gambar baru di server pelanggan (baik ukuran original
  maupun seluruh ukuran potongan theme) 100% berformat `.webp`, hemat ukuran file
  60–80%, dan 1× kerja CPU saat upload.
- **Negatif / Trade-off:** Gambar lama yang sudah diunggah sebelum fitur ini
  aktif tetap berformat lama (tidak diubah diam-diam agar tidak merusak URL
  gambar lama yang sudah tertanam di konten post).
