# Fase 08 — Migrasi Icon `FontAne` ke Inline SVG & Penghapusan Font Icon Lokal

**Status:** Done
**Jenis:** Optimasi Performa (`perf(icons)`)
**Mulai:** 2026-10-24
**Selesai:** 2026-10-24

## Tujuan
Menghapus ketergantungan pada font icon lokal `FontAne` (`fonts/FontAne.*` sebesar **250 KB** dan 508 baris CSS `.ane-*`) yang di seluruh theme hanya dipakai untuk **15 icon**, lalu menggantinya dengan **Inline SVG super ringan** melalui fungsi helper `sekolahane_icon()`.

## Scope
- [x] **Buat Helper `sekolahane_icon( string $name ): string` di `inc/sekolahane.php`:**
  - Sediakan 15 icon SVG yang benar-benar dipakai di theme:
    1. `lokasi` (`footer.php`)
    2. `telepon` (`footer.php`)
    3. `handphone` (`footer.php`)
    4. `email` (`footer.php`)
    5. `laptop` (`footer.php`)
    6. `buku` (`header.php`)
    7. `search` (`searchform.php`)
    8. `whatsapp` (`tp/content-sosmed.php`)
    9. `facebook` (`tp/content-sosmed.php`)
    10. `twitter` (`tp/content-sosmed.php`)
    11. `youtube` (`tp/content-sosmed.php`)
    12. `instagram` (`tp/content-sosmed.php`)
    13. `chevron-right-alt-2` (`tp/news/sliding.php`, `tp/news/classic.php`, `tp/news/column.php`, `tp/news/default.php`)
    14. `chevron-left` (`js/sekolahane.js`)
    15. `chevron-right` (`js/sekolahane.js`)
  - Bungkus `<svg class="ane-svg" ...>` di dalam `<i class="ane-icon" aria-hidden="true">...</i>` agar 100% kompatibel dengan seluruh selector CSS existing di `css/main.css` yang menargetkan elemen `i` (posisi, warna `currentColor`, ukuran `1em`, dan efek hover).
- [x] **Update Template PHP & `js/sekolahane.js`:**
  - Ganti `<i class="ane-..."></i>` di `header.php`, `footer.php`, `searchform.php`, `tp/content-sosmed.php`, `tp/news/sliding.php`, `tp/news/classic.php`, `tp/news/column.php`, `tp/news/default.php`, dan `js/sekolahane.js` dengan SVG.
- [x] **Hapus Font `FontAne` & CSS-nya:**
  - Hapus seluruh blok `@font-face` `FontAne` dan 120 class `.ane-*:before` dari `css/main.css` & `css/main.min.css`, ganti dengan 1 rule ringan `.ane-svg`.
  - Hapus seluruh folder `fonts/` (`FontAne.eot`, `FontAne.svg`, `FontAne.ttf`, `FontAne.woff` — total **250 KB**).

## Di Luar Scope
- Mengubah icon FontAwesome (`fa fa-*`) yang dipilih dinamis oleh user melalui field ACF (`ane_icon`) di `tp/section/angka.php` dan `tp/mobile/menu-*.php`.

## Referensi
- `inc/sekolahane.php` (`sekolahane_icon`)
- `header.php`, `footer.php`, `searchform.php`, `tp/content-sosmed.php`, `tp/news/*.php`, `js/sekolahane.js`
- `css/main.css`, `css/main.min.css`

## Keputusan Kecil Selama Eksekusi
- Mempertahankan wrapper `<i class="ane-icon" aria-hidden="true"><svg class="ane-svg" ...>...</svg></i>` supaya puluhan selector CSS existing seperti `.ane-footer .atas .isi-v2 ul li i`, `.ane-sosmed ul li a i`, `.section-title a.lainnya i`, dan `.owl-nav .owl-prev i` tetap bekerja tanpa perlu mengubah struktur selector CSS theme.

## Checklist Penutupan (SOP)
- [x] Folder `fonts/` terhapus sepenuhnya
- [x] `composer security:scan` lolos
- [x] `composer lint:changed` lolos pada baris perubahan
- [x] `composer analyse` lolos (0 error PHPStan)
- [x] `composer dist:check` lolos
- [x] Security Review dijalankan & dilaporkan
- [x] `PROGRESS.md` diupdate

## Known Limitations
- Tidak ada.

## Ringkasan Hasil
- **Folder `fonts/` (250 KB) dihapus 100%:** `FontAne.eot` (37 KB), `FontAne.svg` (139 KB), `FontAne.ttf` (37 KB), dan `FontAne.woff` (37 KB) tidak lagi membebani paket theme maupun browser pengunjung.
- **508 baris CSS `FontAne` dihapus dari `css/main.css` & `css/main.min.css`:** Ukuran `css/main.min.css` turun lagi dari `89.7 KB` menjadi **`84.8 KB`** (`~82.8 KB`).
- **0 HTTP Request untuk Font Icon Lokal:** Seluruh 15 icon kini di-render instan sebagai Inline SVG (`fill="currentColor"`, `width: 1em`, `height: 1em`) tanpa *Flash of Invisible Text* (FOIT) atau kotak kosong saat koneksi lambat.

### Hasil Security Review
| Kategori | Status | Catatan |
|---|---|---|
| Output Escaping / XSS | Lolos | `sekolahane_icon()` menggunakan whitelist array statis `$paths` (`isset( $paths[ $name ] )`) tanpa menginterpolasi input user ke dalam atribut/tag SVG. |
| Input Sanitization | N/A | Tidak ada input request baru. |
| Accessibility | Lolos | Elemen icon diberi `aria-hidden="true"` dan `focusable="false"`, serta tombol search di `searchform.php` dilengkapi `aria-label`. |
| Clean Release (`dist:check`) | Lolos | Folder `fonts/` bersih dari paket rilis. |
