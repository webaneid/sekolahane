# Fase 34 — Redesign Total Default Sidebar (`.right-sidebar`, `.ane-sidebar`) & Harmonisasi Tipografi Global `16px`

- **Status:** Done
- **Tanggal:** 2026-10-29

## Tujuan
1. **Redesign Total Default Sidebar (`.right-sidebar` & `.ane-sidebar`):**
   - Mengubah `.right-sidebar` dari satu kotak besar bergradasi menjadi susunan **Modern Clean Widget Cards** (`.ane-sidebar`) yang terpisah rapi (`gap: 24px`, `border-radius: 20px`, `background: var(--ane-warna-putih)`, border & shadow halus).
   - Memperbarui registrasi `default-sidebar` di `functions.php` menjadi `<div id="%1$s" class="ane-sidebar widget %2$s">` agar mempertahankan kompatibilitas mundur `.ane-sidebar` sekaligus mendukung class widget resmi WordPress (`%2$s`).
   - Meredesain **Header Widget (`h2.widget-title` & `.wp-block-heading`)** yang konsisten dan re-usable dengan aksen bar vertikal gradasi brand (`--ane-warna-utama` → `--ane-warna-utama-2`) dan garis pemisah bawah.
2. **Desain Listing & Block Populer di Sidebar (Ringan & Re-usable):**
   - **Unified Listing:** Menyatukan style listing untuk **Post Terbaru** (`widget_recent_entries`, `wp-block-latest-posts` + `.post-date`), **Komentar Terbaru** (`widget_recent_comments`, `wp-block-latest-comments` + `.comment-author-link`), **Arsip** (`widget_archive`, `wp-block-archives-list`), **Kategori** (`widget_categories`, `wp-block-categories-list` + sub-kategori `.children`), serta **Meta/Halaman/Menu** (`widget_meta`, `widget_pages`, `widget_nav_menu`).
   - **Media Blocks (Image, Gallery, YouTube / Video Embed):**
     - Image (`widget_media_image`, `wp-block-image`) dengan sudut membulat `14px` dan caption rapi.
     - Gallery (`widget_media_gallery`, `wp-block-gallery`, `.gallery`) dengan grid responsif dan `border-radius: 10px`.
     - YouTube / Video (`widget_media_video`, `wp-block-embed`, `iframe`, `video`) dengan rasio responsif `16:9` (`aspect-ratio: 16 / 9`) dan `border-radius: 14px`.
   - **Search, Tag Cloud, Kalender, & Dropdown (`select`):** Pill tag cloud modern (`border-radius: 999px`), form pencarian terintegrasi, dropdown `select` rapi, dan tabel kalender (`#wp-calendar`, `.wp-block-calendar`) mengikuti warna brand.
3. **Harmonisasi Ukuran Font Global `16px` (`[03]` & `[09]`):**
   - Menyesuaikan ukuran font dasar `body`, `p`, `ul li`, dan `.ane-content ul/ol li` ke `16px` (`1rem`) agar seluruh teks artikel, halaman, dan komponen tampil lebih proporsional dan modern.

## File yang Diubah
- `functions.php` — Pembaruan `before_widget` pada `sekolahane_widgets()` menjadi `<div id="%1$s" class="ane-sidebar widget %2$s">`.
- `css/main.css` & `css/main.min.css` — Harmonisasi font dasar `16px` di Bagian `[03]` & `[09]`, serta redesign penuh `.right-sidebar` dan `.ane-sidebar` di Bagian `[11]`.
- `bin/css-audit.py` — Penambahan daftar class standar widget/block WordPress Core ke `ALLOWED_DYNAMIC_CLASSES`.
- `docs/PROGRESS.md` & `docs/phases/phase-34-redesign-sidebar-dan-tipografi-16px.md` — Dokumentasi fase sesuai SOP.

## Verifikasi SOP & Security Review
- `php -l` & `vendor/bin/phpcs functions.php`: **LOLOS** (0 error, 0 warning).
- `vendor/bin/phpstan analyse`: **LOLOS** (`[OK] No errors`).
- `python3 bin/css-audit.py`: **LOLOS** (`0 dead CSS rules`, `css/main.min.css` ter-generate `150.4 KB`).
- `bash bin/security-scan.sh`: **LOLOS**.
- `bash bin/check-dist.sh`: **LOLOS**.
