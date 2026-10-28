# Fase 28 — Redesign Profesional Dashboard Admin, Branding Icon Webane (`img/admin-webane*.svg`), & Penghapusan Banner Lama

**Status:** Done
**Jenis:** Redesign Dashboard Admin & Branding (`inc/sekolahane.php`, `img/admin-webane*.svg`)
**Mulai:** 2026-10-28
**Selesai:** 2026-10-28

## Tujuan
Merombak tampilan halaman utama **Dashboard Admin WordPress (`wp-admin/index.php`)**, skema warna bar/menu admin, dan branding ikon Webane sesuai permintaan:
1. **Hapus Banner Iklan Blogspot Lama:**
   - Menghapus fungsi `webane_ads_on_admin()` (`https://4.bp.blogspot.com/.../webane-indonesia-ads.jpg`) dari `admin_notices`.
2. **Branding Icon Webane (`/img/admin-webane*.svg`):**
   - Mengganti logo WordPress di pojok kiri atas Admin Bar (`#wp-admin-bar-wp-logo`), kartu widget dashboard, dan halaman login (`wp-login.php`) dengan ikon resmi Webane di folder `/img/` (`admin-webane.svg`, `admin-webane-white.svg`, `admin-webane-fullwhite.svg`).
   - Menggunakan `img/admin-webane-fullwhite.svg` sebagai `icon_url` resmi pada menu **Webane Settings** di sidebar admin.
3. **Skema Warna Sidebar & Admin Bar Sesuai Warna Dark Brand (`--ane-warna-gelap` & `--ane-warna-utama`):**
   - Tanpa mengubah struktur/urutan menu, mewarnai `#wpadminbar` dan `#adminmenu` mengikuti warna gelap (`ane-warna-gelap`, default `#160e06`) dan warna aksen utama (`ane-warna-utama`, default `#c98b49` & `ane-warna-utama-2`, default `#e7ad57`) dari pengaturan brand.
4. **Redesign Penuh Halaman Dashboard Utama (`wp-admin/index.php`):**
   - Menampilkan **Hero Welcome Panel & Ringkasan Statistik Sekolah (`sekolahane_render_dashboard_hero()`)**: Nama & slogan sekolah, badge versi tema, 5 kartu statistik real-time (Berita & Artikel, Halaman Statis, Data Guru, Ekstrakurikuler, Testimoni), serta baris pintasan cepat (*+ Tulis Berita*, *+ Tambah Guru*, *+ Tambah Ekskul*, *Warna Web*, *Customer Care*, *Google & Tracking*).
   - Menampilkan 3 kartu widget informasi resmi Webane seperti pada `modernnews` (**Webane Services**, **Cara Edit Themes**, dan **Cara Update Website**) dengan desain kartu modern.
5. **Kredit Footer Admin Baru:**
   - Mengubah teks footer admin (`admin_footer_text`) menjadi: `Powered by WordPress, Designed by Webane Indonesia`.

## Scope
- [x] `inc/sekolahane.php`: Hapus `webane_ads_on_admin()`, perbarui `acf_add_options_page()` dengan `icon_url` Webane, rombak `my_dashboard_widgets()`, `wpexplorer_remove_footer_admin()`, `webane_load_login_form_logo()`, dan tambahkan `sekolahane_admin_brand_styles()` + `sekolahane_render_dashboard_hero()`.
- [x] Verifikasi `composer lint`, `composer analyse`, `composer css:check`, `composer security:scan`, dan `composer dist:check`.

## Security Review
| Item | Status | Keterangan |
|---|---|---|
| Sanitasi warna & URL | ✅ | Seluruh warna diambil melalui `sanitize_hex_color()` di `sekolahane_get_admin_brand_colors()` dan seluruh URL/atribut di-escape dengan `esc_url()`, `esc_attr()`, dan `esc_html()` |
| Penghapusan aset eksternal tidak aman | ✅ | URL gambar Blogspot lama pada `admin_notices` dan `wp-login.php` telah dihapus dan digantikan oleh aset SVG lokal di `img/` |

## Checklist Penutupan SOP
- [x] `composer lint` (PHPCS) — Lolos `0 errors` pada `inc/sekolahane.php`
- [x] `composer analyse` (PHPStan) — Lolos `[OK] No errors`
- [x] `composer css:check` (`bin/css-audit.py`) — Lolos `0 dead CSS rules`
- [x] `composer security:scan` & `composer dist:check` — Lolos
