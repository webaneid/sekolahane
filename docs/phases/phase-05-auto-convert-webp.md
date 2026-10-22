# Fase 05 — Auto-Convert Upload Gambar ke WebP & Auto-Crop Sub-Sizes

**Status:** Done
**Jenis:** Fitur Baru (`feat(media)`)
**Mulai:** 2026-10-23
**Selesai:** 2026-10-23

## Tujuan
Mengonversi secara otomatis setiap gambar (`.jpg`, `.jpeg`, `.png`) yang diunggah
ke WordPress menjadi format `.webp`, menghapus file asli non-WebP (`.jpg`/`.png`),
menyimpan ukuran original dalam format `.webp`, dan memastikan seluruh ukuran
potongan gambar (`thumbnail` 400×225, `medium` 700×394, `large` 1000×563, `kotak`
400×400, dst.) terpotong otomatis dalam format `.webp`.

## Scope
- [x] Buat ADR `docs/decisions/adr-0004-auto-convert-webp.md`.
- [x] Buat modul `inc/webp-converter.php` dengan prefix `sekolahane_`:
  - Hook ke `wp_handle_upload` dan `wp_handle_sideload`.
  - Cek dukungan `wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) )` (fallback aman jika hosting belum mendukung WebP).
  - Konversi `image/jpeg` dan `image/png` (termasuk fallback `sekolahane_convert_palette_png_to_webp()` untuk PNG 8-bit palette → truecolor + alpha transparency agar tidak gagal di PHP GD).
  - Gunakan `wp_unique_filename()` untuk mencegah bentrok nama file `.webp`.
  - Pastikan file `.webp` berhasil dibuat dan ukurannya `> 0` byte sebelum menghapus file `.jpg`/`.png` asli menggunakan `wp_delete_file()`.
  - Set kualitas kompresi WebP (`82`) via `wp_editor_set_quality` untuk file original maupun seluruh potongan sub-size (`thumbnail`, `medium`, `large`, `kotak`, dll).
- [x] Hubungkan `inc/webp-converter.php` di `functions.php` dan tambahkan `sekolahane_maybe_upgrade_image_sizes()` (`admin_init` satu kali per versi) agar ukuran crop gambar (`thumbnail` 400×225, `medium` 700×394, `large` 1000×563, `kotak` 400×400) tetap terjaga saat theme di-auto-update tanpa ganti theme.

## Di Luar Scope
- Konversi massal (bulk regeneration) gambar lama yang sudah diunggah di masa lalu (berisiko memutus URL gambar yang sudah tertanam di konten HTML post lama).

## Referensi
- `docs/decisions/adr-0004-auto-convert-webp.md`
- `functions.php` (ukuran gambar: `kotak` 400×400, `thumbnail` 400×225, `medium` 700×394, `large` 1000×563)

## Keputusan Kecil Selama Eksekusi
- Konversi dilakukan pada tahap `wp_handle_upload` & `wp_handle_sideload` sehingga `wp_generate_attachment_metadata()` yang berjalan sesudahnya otomatis memotong seluruh sub-size (`thumbnail`, `medium`, `large`, `kotak`) langsung dari master `.webp` ke sub-size `.webp` dalam satu siklus.

## Laporan Security Review (Langkah 4 SOP)

| # | Area | Status | Catatan |
|---|---|---|---|
| 1 | Validasi MIME & File | **PASS** | Hanya memproses MIME yang diizinkan (`image/jpeg`, `image/jpg`, `image/png`) setelah lolos validasi upload inti WordPress (`empty( $upload['error'] )`, `file_exists`, `is_readable`). |
| 2 | Keamanan Path & Nama File | **PASS** | Menggunakan `wp_unique_filename( $dir, $base_name . '.webp' )` dan `wp_delete_file()` bawaan WordPress; tidak ada input user mentah yang dieksekusi di shell. |
| 3 | Guard `ABSPATH` & WPCS | **PASS** | `inc/webp-converter.php` memiliki `defined( 'ABSPATH' ) || exit;`, lolos `composer lint:changed` (100% WPCS), `composer analyse` (0 error PHPStan), dan `composer security:scan`. |

## Checklist Penutupan (SOP)
- [x] `composer security:scan` lolos
- [x] `composer lint:changed` lolos (0 error WPCS pada `functions.php` dan `inc/webp-converter.php`)
- [x] `composer analyse` lolos (0 error PHPStan)
- [x] `composer dist:check` lolos
- [x] Security Review dijalankan & dilaporkan
- [x] `PROGRESS.md` diupdate

## Known Limitations
- Hanya mengonversi gambar yang diunggah sejak fitur ini aktif (gambar lama tidak diubah agar URL lama di konten artikel tidak rusak).

## Ringkasan Hasil
- Menambahkan `inc/webp-converter.php` yang otomatis mengubah setiap upload `.jpg`/`.jpeg`/`.png` menjadi `.webp` (ukuran original dipertahankan dalam `.webp`, seluruh ukuran potongan `thumbnail`, `medium`, `large`, `kotak` otomatis terpotong dalam `.webp`, dan file `.jpg`/`.png` asli dihapus dari server).
