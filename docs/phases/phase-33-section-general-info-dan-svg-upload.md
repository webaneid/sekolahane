# Fase 33 — Section Baru Landing Page: `section-general-info` (Foto 3:4, 3 Pilihan Desain Layout, Repeater Listing + Izin Upload SVG Aman, CTA Link, & Urutan Mobile Konsisten)

- **Status:** Done
- **Tanggal:** 2026-10-29

## Tujuan
Menambahkan blok baru **General Info** (`home_general_info` / `.section-general-info`) pada ACF Flexible Content (`home_content` di Landing Page dan `profil_content` di Page Profil Lembaga), dilengkapi dukungan izin upload file SVG yang disanitasi secara aman:
1. **Izin Upload SVG Aman (`inc/sekolahane.php`):**
   - Menambahkan icon `shield` ke `sekolahane_icon()`.
   - Mengizinkan upload file `.svg` (`image/svg+xml`) melalui filter `upload_mimes` dan `wp_check_filetype_and_ext` khusus bagi user berhak (`current_user_can( 'upload_files' )`).
   - Melakukan sanitasi keamanan otomatis saat upload (`wp_handle_upload_prefilter`) untuk menghapus `<script>`, `<foreignObject>`, event handler `on*`, dan URI `javascript:`/`data:text/html` sebelum file disimpan ke Media Library.
2. **Struktur Field ACF (`General Info` / `home_general_info`):**
   - **Tata Letak Desain (`sekolahane_ginfo_layout`):**
     - `left` — Default (2 Kolom: Gambar 3:4 di Kiri, Teks & Listing di Kanan, vertikal rata tengah).
     - `right` — Gambar di Kanan (2 Kolom: Teks & Listing di Kiri, Gambar 3:4 di Kanan, vertikal rata tengah).
     - `center` — Gambar di Tengah (Header Judul & Deskripsi di Atas, diikuti 3 Kolom: Listing Kiri `01–02`, Gambar 3:4 di Tengah, Listing Kanan `03–04`, maksimal 4 listing).
   - **Gaya Warna Section (`sekolahane_ginfo_style`):** `putih` (Putih Bersih), `terang` (Terang / Soft Brand), atau `gelap` (Gelap / Dark Brand).
   - **Margin Bawah (`sekolahane_ginfo_margin`):** `yes` (Pakai Margin Bawah) atau `no` (Tanpa Margin Bawah).
   - **Foto Utama Rasio 3:4 (`sekolahane_ginfo_image`)**: Field gambar ACF.
   - **Judul (`ane_title`), Deskripsi (`ane_deskripsi`), & Tombol CTA Opsional (`ane_link` - ACF Link pemilih halaman/URL).**
   - **Repeater Listing (`sekolahane_ginfo_items`):**
     - `sekolahane_icon_type`: `check` (Checklist SVG), `star` (Bintang SVG), `shield` (Perisai SVG), `number` (Nomor Urut `01`, `02`, dst.), atau `custom` (Upload Custom SVG/Icon).
     - `sekolahane_custom_svg`: Field upload gambar/SVG (tampil otomatis bila memilih `custom`).
     - `sekolahane_item_title`: Judul item listing.
     - `sekolahane_item_desc`: Deskripsi item listing.
3. **Urutan & Responsivitas Mobile (`<= 767px`):**
   - Urutan tampilan di mobile 100% konsisten untuk ketiga desain: **1. Image (rasio 3:4, padding kiri-kanan 15px, border-radius 16px) → 2. Judul → 3. Deskripsi → 4. Listing (jika ada) → 5. Tombol CTA (jika ada)**.
   - Seluruh warna menggunakan CSS Custom Properties (`--ane-warna-*`) tanpa hardcode warna.

## File yang Diubah
- `inc/sekolahane.php` — Penambahan icon `shield` dan dukungan upload + sanitasi keamanan SVG (`sekolahane_allow_svg_upload_mimes()`, `sekolahane_fix_svg_filetype_check()`, `sekolahane_sanitize_svg_upload()`).
- `inc/acf-json/field-groups.json` — Penambahan layout `home_general_info` (`General Info`) pada `group_5dbeefc248e7f` dan `group_628554343579d`.
- `tp/section/general-info.php` — Template part baru untuk `.section-general-info`.
- `tp/pages/home-desktop.php`, `tp/pages/home-mobile.php`, & `tp/pages/profil.php` — Integrasi pemanggilan `get_template_part( 'tp/section/general-info' )`.
- `css/main.css` & `css/main.min.css` — Styling `.section-general-info` (3 layout, 3 varian warna brand, foto 3:4, dan urutan mobile konsisten) di Section `[06]`.
- `docs/PROGRESS.md` & `docs/phases/phase-33-section-general-info-dan-svg-upload.md` — Dokumentasi fase sesuai SOP.

## Verifikasi SOP & Security Review
- `php -l` & `vendor/bin/phpcs tp/section/general-info.php`: **LOLOS** (0 error, 0 warning).
- `vendor/bin/phpstan analyse`: **LOLOS** (`[OK] No errors`).
- `python3 bin/css-audit.py`: **LOLOS** (`0 dead CSS rules`, `css/main.min.css` ter-generate `142.4 KB`).
- `bash bin/security-scan.sh`: **LOLOS**.
- `bash bin/check-dist.sh`: **LOLOS**.
