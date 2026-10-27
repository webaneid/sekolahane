# Fase 24 — Redesign Total Halaman Kontak (`page-kontak.php`, `tp/content-page-kontak.php`), Contact Form 7, & Customer Care Mobile

**Status:** Done
**Jenis:** Redesign & Responsif (`page-kontak.php`, `tp/content-page-kontak.php`, `css/main.css`)
**Mulai:** 2026-10-27
**Selesai:** 2026-10-27

## Tujuan
Merombak total halaman **Contact Us (`page-kontak.php` & `tp/content-page-kontak.php`)** baik versi Desktop maupun Mobile agar tampil modern, super responsif, dan konsisten dengan sistem desain tema:
1. **Header & Bento Contact Info Cards (`.kontak-konten`):**
   - Menampilkan judul halaman dengan sub-badge elegan (`.kontak-badge`) serta kartu informasi lembaga (`.kontak-bento-grid`):
     - Kartu kiri beraksen *dark-espresso gold* (`.kontak-card-alamat`) dengan ikon SVG `lokasi`, Nama Lembaga, dan Alamat lengkap.
     - Kartu kanan (`.kontak-card-channels`) dengan saluran Telepon (`tel:`), Handphone/WhatsApp (`tel:`), dan Email (`mailto:`) ber-ikon SVG `telepon`, `handphone`, `email` yang interaktif dan bisa diklik langsung.
2. **Customer Care Mobile (`.kontak-cs-mobile`):**
   - Karena tombol mengambang `.cc-contactpop` disembunyikan pada layar mobile (`<= 767px`), daftar Customer Care muncul khusus di mobile tepat di bawah info kontak menggunakan komponen kartu agen modern yang sama dengan `.cc-agent-item` (`.cc-agent-avatar`, `.cc-agent-fallback`, `.cc-agent-status`, `.cc-agent-meta`, `.cc-agent-name`, `.cc-agent-role`, `.cc-agent-action`) sehingga sangat hemat CSS dan konsisten.
   - Memperbaiki bug markup HTML lama (`<a><li><a>` bersarang yang tidak valid) menjadi `<li><a class="cc-agent-item">` dan menormalisasi nomor WhatsApp (`08...` → `628...`).
3. **Modernisasi Contact Form 7 (`.wpcf7-form` & `.wpcf7-submit`) & Peta Lokasi (`.kontak-map` / `.acf-map`):**
   - Merombak input `.wpcf7-form` (`text`, `email`, `tel`, `url`, `number`, `date`, `select`, `textarea`) menjadi *modern input field* (`border-radius: 14px`, transisi focus ring emas `#c98b49`, label rapi) dan tombol `.wpcf7-submit` menjadi tombol *rounded* gradasi emas modern.
   - Membungkus `.acf-map` di dalam kartu `.kontak-map` dengan sudut membulat `16px` dan tombol petunjuk arah (`.kontak-map-btn` "Buka Petunjuk Arah di Google Maps") berikon lokasi di bawah peta.

## Scope
- [x] `page-kontak.php` & `tp/content-page-kontak.php`: Rombak struktur HTML halaman kontak, perbaiki markup `.kontak-cs-mobile` dengan class kartu agen `.cc-agent-*`, dan rapikan tampilan peta & form.
- [x] `css/main.css` & `css/main.min.css`: Ganti langsung aturan `.acf-map`, `.wpcf7-form`, `.wpcf7-submit` di bagian `[03]`, izinkan `.cc-agent-*` dibagi antara `.cc-contactpop` dan `.kontak-cs-mobile` di bagian `[12]`, serta ganti blok `.ane-page-kontak` di bagian `[10]` (hapus CSS lama, `0 dead CSS rules`).
- [x] Verifikasi `composer lint`, `composer analyse`, `composer css:check`, `composer security:scan`, dan `composer dist:check`.

## Security Review
| Item | Status | Keterangan |
|---|---|---|
| Guard `defined( 'ABSPATH' ) \|\| exit;` | ✅ | Sudah tersedia di `page-kontak.php` dan `tp/content-page-kontak.php` |
| Late escaping output (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`) | ✅ | Seluruh field ACF (`ane_com_name`, `ane_Option_alamat`, `ane_telepon`, `ane_handphone`, `ane_email`, repeater `ane_whatsapp`, dan koordinat `ane_gmap`) di-escape dengan ketat |
| Kompatibilitas mundur ACF & CF7 | ✅ | Seluruh nama field ACF Option dan class Contact Form 7 (`.wpcf7-form`, `.wpcf7-submit`, `.acf-map`) tetap utuh |

## Checklist Penutupan SOP
- [x] `composer lint` (PHPCS) — Lolos `0 errors, 0 warnings` pada `page-kontak.php` & `tp/content-page-kontak.php`
- [x] `composer analyse` (PHPStan) — Lolos `[OK] No errors`
- [x] `composer css:check` (`bin/css-audit.py`) — Lolos `0 dead CSS rules` (`css/main.min.css` 118.1 KB)
- [x] `composer security:scan` & `composer dist:check` — Lolos
