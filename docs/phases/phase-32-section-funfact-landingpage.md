# Fase 32 — Section Baru Landing Page: `section-funfact` (ACF Flexible Content, Repeater 4 Item, 3 Pilihan Warna Brand, & 2x2 Mobile Grid)

- **Status:** Done
- **Tanggal:** 2026-10-29

## Tujuan
Menambahkan blok baru **Funfact** (`home_funfact` / `.section-funfact`) pada ACF Flexible Content (`home_content` di Landing Page dan `profil_content` di Page Profil Lembaga) sesuai standar SOP:
1. **Struktur Field ACF (`Funfact` / `home_funfact`):**
   - **Gaya Warna Section (`sekolahane_funfact_style`):** Pilihan `putih` (Putih Bersih), `terang` (Terang / Soft Brand), atau `gelap` (Gelap / Dark Brand).
   - **Margin Bawah (`sekolahane_funfact_margin`):** Pilihan `yes` (Pakai Margin Bawah) atau `no` (Tanpa Margin Bawah / Menempel).
   - **Judul Section (`ane_title` - opsional)** & **Deskripsi (`ane_deskripsi` - opsional):** Hanya dirender bila diisi oleh admin.
   - **Repeater Item Funfact (`sekolahane_funfact_items`, maksimal 4 item):**
     - `sekolahane_number` (*Number*, contoh: `2`, `45`, `1200`)
     - `sekolahane_prefix` (*Prefix / Tambahan Teks*, contoh: `thn+`, `+`, `%`, `A`)
     - `sekolahane_label` (*Label*, contoh: `Pengalaman`, `Guru & Staf`, `Alumni Sukses`)
2. **Desain & Responsivitas (`.section-funfact` di `tp/section/funfact.php` & `css/main.css` Section `[06]`):**
   - **Desktop:** Grid 4 kolom sejajar (`grid-template-columns: repeat(4, 1fr)`), kartu modern dengan aksen warna brand, angka utama (`sekolahane_number`) + aksen (`sekolahane_prefix`) terintegrasi rapi, dan label di bawahnya.
   - **Mobile (`<= 767px`):** Grid 2 kolom (`grid-template-columns: repeat(2, 1fr)`), padding kiri-kanan konsisten `15px`, kartu `border-radius: 16px`, dengan ukuran angka yang tegas, besar, dan proporsional.

## File yang Diubah
- `inc/acf-json/field-groups.json` — Penambahan layout `home_funfact` (`Funfact`) pada `group_5dbeefc248e7f` (Landing Page Content) dan `group_628554343579d` (Page Profil Lembaga).
- `tp/section/funfact.php` — Template part baru untuk merender `.section-funfact`.
- `tp/pages/home-desktop.php`, `tp/pages/home-mobile.php`, & `tp/pages/profil.php` — Integrasi pemanggilan `get_template_part( 'tp/section/funfact' )` saat `get_row_layout() === 'home_funfact'`.
- `css/main.css` & `css/main.min.css` — Styling `.section-funfact` (3 varian warna brand + responsif 4 kolom desktop & 2 kolom mobile) di Section `[06]`.
- `docs/PROGRESS.md` & `docs/phases/phase-32-section-funfact-landingpage.md` — Dokumentasi fase sesuai SOP.

## Verifikasi SOP & Security Review
- `php -l` & `vendor/bin/phpcs tp/section/funfact.php`: **LOLOS** (0 error, 0 warning).
- `vendor/bin/phpstan analyse`: **LOLOS** (`[OK] No errors`).
- `python3 bin/css-audit.py`: **LOLOS** (`0 dead CSS rules`, `css/main.min.css` ter-generate `134.4 KB`).
- `bash bin/security-scan.sh`: **LOLOS**.
- `bash bin/check-dist.sh`: **LOLOS**.
