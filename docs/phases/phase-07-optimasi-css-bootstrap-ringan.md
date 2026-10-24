# Fase 07 — Optimasi CSS: Bootstrap Super Ringan & Konsolidasi Stylesheet

**Status:** Done
**Jenis:** Optimasi Performa (`perf(css)`)
**Mulai:** 2026-10-24
**Selesai:** 2026-10-24

## Tujuan
Menghapus ketergantungan pada file penuh `bootstrap.min.css` CDN (~160 KB) yang 95% isinya tidak terpakai, menggantinya dengan subset Bootstrap super ringan (Reboot + 12-Column Grid + Utility yang dipakai di template, hanya ~8.4 KB minified), serta menggabungkan `css/FontAne.css` ke dalam satu file CSS utama (`css/main.min.css`).

## Scope
- [x] **Bangun Subset Bootstrap Super Ringan (Purged Bootstrap 4/5 Grid & Utilities):**
  - Sertakan Bootstrap Reboot esensial, sistem Grid 12 kolom responsif (`.container`, `.container-fluid`, `.row`, `.no-gutters`, `.col-*`, `.col-xs-6`, `.col-sm-*`, `.col-md-*`, `.col-lg-*`, `.col-xl-*`), `.form-control`, `.sticky-top`, serta utility class yang dipakai di template (`.d-flex`, `.align-items-*`, `.justify-content-*`, `.text-*`, `.p-0`, `.py-4`, `.pt-15`, `.pb-15`, `.mb-0`, `.mt-20`, `.mb-20`, `.mb-40`, `.ms-4`, `.fw-bold`, `.lh-1`, `.img-100`).
- [x] **Konsolidasi CSS Lokal Menjadi 1 File Produksi (`css/main.min.css`):**
  - Gabungkan `css/FontAne.css` ke dalam `css/main.css` & `css/main.min.css` (sekaligus memperbaiki bug path relatif `url('fonts/FontAne.woff')` → `url('../fonts/FontAne.woff')` dan mengubah `font-display: block` menjadi `font-display: swap`).
  - Hapus file `css/FontAne.css`, `css/main.css.map`, dan `css/main.min.css.map`.
  - Tambahkan `css/main.css` (file sumber untuk developer) ke `.distignore` agar di paket rilis ZIP pelanggan folder `css/` **hanya berisi 1 file: `css/main.min.css`**.
- [x] **Optimasi Enqueue CSS di `inc/sekolahane.php` (`ane_load_css_and_js`):**
  - Hapus `wp_enqueue_style( 'bootstrap', ... )` (~160 KB CDN).
  - Hapus `wp_enqueue_style( 'FontAne', ... )` (1 HTTP request lokal).
  - Tambahkan `&display=swap` pada Google Fonts `Poppins` untuk mencegah *Flash of Invisible Text* (FOIT).

## Di Luar Scope
- Mengubah desain visual, warna, atau struktur HTML di template PHP.

## Referensi
- `inc/sekolahane.php` (`ane_load_css_and_js`)
- `css/main.css`, `css/main.min.css`
- `.distignore`

## Keputusan Kecil Selama Eksekusi
- Menyertakan seluruh variasi kolom `.col-1` s/d `.col-12` pada setiap breakpoint (`sm`, `md`, `lg`, `xl`) di subset Bootstrap (~8.4 KB termasuk Reboot & Utilities) agar jika pelanggan membuat halaman/widget dengan kolom Bootstrap apa pun, layout tetap 100% kompatibel.
- Menyertakan class utility `.ms-4`, `.fw-bold`, `.lh-1` (gaya Bootstrap 5 yang dipakai di `tp/section/angka.php`) sekaligus `.mt-20`, `.mb-20`, `.mb-40`, `.pt-15`, `.pb-15`, `.img-100` yang dipakai di template arsip dan konten.

## Checklist Penutupan (SOP)
- [x] `composer security:scan` lolos
- [x] `composer lint:changed` lolos
- [x] `composer analyse` lolos (0 error PHPStan)
- [x] `composer dist:check` lolos (ZIP rilis hanya memuat `css/main.min.css`)
- [x] Security Review dijalankan & dilaporkan
- [x] `PROGRESS.md` diupdate

## Known Limitations
- Tidak ada.

## Ringkasan Hasil
- **Eliminasi `bootstrap.min.css` CDN (~160 KB):** Digantikan oleh subset Bootstrap super ringan (**8.4 KB** minified — **hemat hampir 95% ukuran Bootstrap!**) yang sudah terbundel langsung di dalam `css/main.min.css`.
- **Konsolidasi `FontAne.css` + Fix Path Font:** `FontAne.css` (5.0 KB minified) digabungkan langsung ke `css/main.min.css`, path `../fonts/FontAne.woff` dan `../fonts/FontAne.svg` yang sebelumnya salah (`fonts/FontAne.woff`) diperbaiki, dan `font-display: swap` diaktifkan.
- **Hanya 1 File CSS Lokal di Paket Rilis (`css/main.min.css`, ~87 KB total sudah termasuk FontAne + Bootstrap Grid/Utilities + seluruh style theme):**
  - Sebelum Fase 07: `bootstrap.min.css` (160 KB) + `FontAne.css` (6.5 KB) + `main.min.css` (74 KB) + `.map` (72 KB) = **~240.5 KB CSS aktif** across 3 file.
  - Sesudah Fase 07: Hanya **1 file `css/main.min.css` (~87.6 KB)** = **hemat ~153 KB CSS (>63% lebih ringan)** dan mengurangi 2 HTTP request render-blocking!

### Hasil Security Review
| Kategori | Status | Catatan |
|---|---|---|
| Output Escaping | N/A | Tidak ada perubahan output variabel di template. |
| Input Sanitization | N/A | Tidak ada input request baru. |
| Asset Integrity | Lolos | Mengurangi ketergantungan pihak ketiga (`stackpath.bootstrapcdn.com` untuk Bootstrap dihapus). |
| Clean Release (`dist:check`) | Lolos | Hanya `css/main.min.css` yang masuk ke paket rilis pelanggan; `css/main.css` & `.map` bersih. |
