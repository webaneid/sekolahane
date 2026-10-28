# Fase 35 — Redesign Total `.ane-content` (Body Artikel `the_content()`) & Gutenberg Blocks

- **Status:** Done
- **Tanggal:** 2026-10-29

## Tujuan
Satu set CSS re-usable untuk semua output `the_content()` (post, page, ekstrakurikuler, guru, video, kelembagaan, profil, kontak, mobile `single-universal`) — semuanya dibungkus `.ane-content`.

1. **Tipografi:** `h2` (aksen bar kiri brand), `h3`, `h4`, `h5/h6` dengan skala & ritme jarak konsisten; `p` `16px` / `line-height: 1.8`; link, `code`, `pre`, `hr`/separator.
2. **List `ul`/`ol`:** marker warna brand, jarak antar item `8px`, nested list rapi.
3. **Quote & Pullquote:** card editorial (`--ane-warna-terang`, bar kiri brand, watermark kutip, `cite`).
4. **Image/Figure/Cover:** `border-radius: 16px`; di mobile **tanpa negative margin `-15px`** sehingga jarak kiri-kanan 15px konsisten.
5. **Gallery:** dukung `has-nested-images` (WP 5.9+) & `blocks-gallery-grid` lama; gap 12px, hover zoom, caption overlay. Kompatibel lightbox native WP ("Perbesar saat diklik") & Magnific Popup.
6. **Embed:** video/YouTube `aspect-ratio: 16/9` + radius 16px; embed sosmed (IG/TikTok/X) rata tengah tanpa dipaksa 16:9.
7. **Tabel:** desktop header gradasi brand + zebra + hover; mobile (`<=767px`) jadi **card listing vertikal** per baris dengan label kolom otomatis (`data-label` dari `thead th` via JS).
8. **Button & File Download:** pill button brand (+ varian outline); `.wp-block-file` jadi card unduh dokumen.
9. **Accordion FAQ:** `details`/`.wp-block-details` (native) & Yoast FAQ (`.schema-faq-section`) jadi accordion slide naik-turun (JS, item pertama terbuka, aksesibel keyboard + `aria-expanded`).
10. **Callout `.has-background`:** radius 16px & padding proporsional.

## File yang Diubah
- `css/main.css` & `css/main.min.css` — Bagian `[09]` ditulis ulang (sub-bagian 9.1–9.10); override duplikat `.msingle-body` (font/gambar) di bagian mobile single dihapus karena sudah ditangani `[09]`.
- `js/sekolahane.js` — helper `data-label` tabel & accordion Yoast FAQ (hanya jalan jika ada `.ane-content`).
- `inc/sekolahane.php` — `webane_popup_gallery()`: tambah `.webp`, lewati konten yang memakai lightbox native WP, dan tidak menggandakan class `gallery-popup`.
- `bin/css-audit.py` — whitelist class block WP Core/Yoast baru.

## Verifikasi SOP & Security Review
- `python3 bin/css-audit.py`: **LOLOS** (0 dead CSS rules, `css/main.min.css` 159.1 KB).
- `vendor/bin/phpcs inc/sekolahane.php`: 0 error; warning yang tersisa baseline lama (bukan baris yang diubah).
- `vendor/bin/phpstan analyse`: **LOLOS**.
- `bin/security-scan.sh` & `bin/check-dist.sh`: **LOLOS**.
- Tidak ada warna hardcode baru (semua `var(--ane-warna-*)`). JS hanya membaca teks `th` lewat `.text()` & `.attr()` (tanpa HTML injection).
- Perlu cek manual di situs lokal (desktop + mobile).
