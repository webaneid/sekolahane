# Retrofit Gaps — Sekolah Ane

> Daftar lengkap kesenjangan antara kode `sekolahane` (`v3.2.1`, baseline
> `3e538b6`) dan standar Webane (`AGENTS.md` + `architecture-security.md`).
> Setiap item memiliki ID unik (`GAP-XX`) agar mudah dirujuk di commit dan
> phase doc. Jangan perbaiki di luar fase yang ditugaskan.

## Ringkasan Per Tingkat Keparahan

| Level | Jumlah | Status | Target Fase |
|---|---|---|---|
| 🔴 **Critical** | 1 | ✅ Selesai (1/1) | Fase 03 |
| 🟠 **High** | 3 | ✅ Selesai (3/3) | Fase 03 |
| 🟡 **Medium** | 10 | ✅ Selesai (10/10) | Fase 03 & Fase 04 |
| 🔵 **Low / Clean-up** | 7 | ✅ Selesai (5/7) — sisa `GAP-20` & `GAP-21` (opsional) | Fase 04 |

---

## A. Keamanan (Security)

### GAP-01 — ✅ Selesai di Fase 03: Hardcoded Google Maps API Key di Kode Theme
- **Lokasi:** `inc/sekolahane.php`
- **Fix:** Hardcoded key dihapus; diganti `sekolahane_get_google_maps_api_key()` (konstanta `SEKOLAHANE_GMAPS_API_KEY` atau ACF option `ane_google_maps_api_key`). Script Google Maps hanya di-enqueue jika key tersedia dan hanya di halaman kontak.

### GAP-02 — ✅ Selesai di Fase 03: Output Escaping & Tutup Celah Stored XSS
- **Lokasi:** `header.php`, `footer.php`, `author.php`, `search.php`, `searchform.php`, `inc/sekolahane.php`, `inc/widgets.php`, `inc/color.php`, `inc/single-iklan.php`, dan `tp/**/*.php`.
- **Fix:** Seluruh output dinamis di-escape (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`), dan `remove_filter( 'pre_user_description', 'wp_filter_kses' )` dihapus.

### GAP-03 — ✅ Selesai di Fase 03: Guard `ABSPATH` di Seluruh File PHP & Anti-Webshell Scanner
- **Lokasi:** Seluruh 84 file PHP (`inc/*.php`, root `*.php`, `tp/**/*.php`) + `bin/security-scan.sh`.
- **Fix:** Dipasang `defined( 'ABSPATH' ) || exit;` di 100% file PHP theme dan diverifikasi otomatis oleh `composer security:scan` di CI.

### GAP-04 — ✅ Selesai di Fase 03: Hapus Deregister jQuery WP & Samakan Versi Bootstrap
- **Lokasi:** `inc/sekolahane.php` (`ane_load_css_and_js`).
- **Fix:** `wp_deregister_script( 'jquery' )` dihapus sehingga theme memakai jQuery aman bawaan WordPress; versi Bootstrap CSS & JS diseragamkan ke `4.4.1`.

### GAP-05 — ✅ Selesai di Fase 03: Validasi Post Status pada Endpoint AJAX `nopriv` Post Views
- **Lokasi:** `inc/sekolahane.php` (`musi_increment_views`).
- **Fix:** Menggunakan `absint( wp_unslash( $_GET['postviews_id'] ) )` dan mengecek `'publish' === get_post_status( $post_id )` sebelum menulis post meta `musi_views`.

### GAP-06 — ✅ Selesai di Fase 03: Facebook App ID via Option & Perbaikan `$appid`
- **Lokasi:** `header.php` dan `inc/sekolahane.php` (`fungsi_komen_facebook_webane`).
- **Fix:** Menggunakan helper `sekolahane_get_fb_app_id()` (konstanta `SEKOLAHANE_FB_APP_ID` atau ACF option `ane_fb_app_id`), di-escape dengan `rawurlencode()` + `esc_url()`.

---

## B. Bug & Logic Error (Tertangkap PHPStan Level 3 — Kini 0 Error!)

### GAP-07 — ✅ Selesai di Fase 03: Pemanggilan `get_the_terms()` dengan 3 Argumen
- **Lokasi:** `tp/single-guru.php`
- **Fix:** Dihapus argumen ke-3 yang tidak valid dan ditambahkan pengecekan `is_array()` sebelum `foreach` dan `wp_list_pluck()`.

### GAP-08 — ✅ Selesai di Fase 03: Variabel Tidak Terdefinisi di Template & Helper
- **Lokasi:** `inc/sekolahane.php`, `inc/widgets.php`, `footer.php`, `tp/page-contact.php`, `tp/section/guru-v2.php`, `tp/single-guru.php`.
- **Fix:** Semua variabel diinisialisasi dengan aman; `extract()` di `inc/widgets.php` diganti `wp_parse_args( (array) $instance, $this->get_default_instance() )`.

### GAP-09 — ✅ Selesai di Fase 03: Pemanggilan Fungsi & Template Part yang Tidak Ada
- **Lokasi:** `tp/page-contact.php`, `tp/content-none.php`.
- **Fix:** Dibuat `tp/content-none.php` dan diganti `panggil_sosial_media()` menjadi `get_template_part( 'tp/content', 'sosmed' )`.

### GAP-10 — ✅ Selesai di Fase 03: Properti `WP_Term::$cat_name`, `sprintf()` Tanpa Placeholder, & TypeError PHP 8
- **Lokasi:** `tp/content*.php`, `tp/single*.php`, `inc/sekolahane.php`, `inc/widgets.php`, `inc/Mobile_Detect.php`.
- **Fix:** Seluruh 36 error di `phpstan-baseline.neon` telah diperbaiki hingga baseline kosong (`ignoreErrors: []`).

---

## C. Performa & Database

### GAP-11 — ✅ Selesai di Fase 02: `update_option()` ×9 Dijalankan di Setiap Request
- **Lokasi:** `functions.php:16-24` (di dalam `after_setup_theme`).
- **Fix:** Dipindahkan ke fungsi `sekolahane_configure_image_sizes()` pada hook `after_switch_theme`.

### GAP-12 — ✅ Selesai di Fase 03: Cache Transient Query `$wpdb` Tahun Copyright & HTTPS di Admin
- **Lokasi:** `inc/sekolahane.php` (`webane_load_dynamic_copyright_year`, `dashboard_custom_feed_output`).
- **Fix:** Hasil query disimpan di transient `sekolahane_copyright_year` (`DAY_IN_SECONDS`) dan di-clear saat `save_post`; URL feed dashboard diubah ke `https://`.

---

## D. Kode Mati, Duplikasi, & Standar (Maintainability)

### GAP-13 — ✅ Selesai di Fase 04: Hapus File & Fungsi Duplikat/Menggantung
- **Fix:** Dihapus `inc/post-view.php`, `inc/option.php`, `inc/related.php`, `inc/single-iklan.php`, `inc/customizer.php`, `inc/color.php`, `breadcrumbs.php`, `tp/page-contact.php`, `tp/home-categories.php`, `tp/content-sliders.php`, `tp/mobile/landinpage.php`, `tp/mobile/landingpage-menu.php`, dan `tp/mobile/home.php`. Fungsi ganda `ane_dummy_tumbnail()` dikonsolidasikan ke `sekolahane_dummy_tumbnail()`.

### GAP-14 — ✅ Selesai di Fase 02: Belum Ada Mekanisme Auto-Update & CI Release
- **Lokasi:** `inc/updater.php`, `.github/workflows/ci.yml`, `.github/workflows/release.yml`, `.releaserc.json`.
- **Fix:** Dipasang sesuai ADR-0002 dan ADR-0003.

### GAP-15 — ✅ Selesai di Fase 04: Seragamkan Seluruh Text Domain ke `'sekolahane'`
- **Fix:** Seluruh pemanggilan `__()`, `_e()`, `esc_html__()`, `esc_html_e()`, `_n()`, `esc_attr_x()` kini menggunakan `'sekolahane'`.

### GAP-16 — ✅ Selesai di Fase 03: Versi Enqueue `main.min.css` & `sekolahane.js` Menggunakan `SEKOLAHANE_VERSION`
- **Lokasi:** `inc/sekolahane.php` (`ane_load_css_and_js`).
- **Fix:** Menggunakan konstanta `SEKOLAHANE_VERSION` agar cache browser otomatis di-bust setiap kali rilis versi baru.

### GAP-17 — ✅ Selesai di Fase 04: Penggunaan `wp_reset_postdata()` Setelah `WP_Query`
- **Fix:** Seluruh `new WP_Query()` kini menggunakan `wp_reset_postdata()`.

### GAP-18 — ✅ Selesai di Fase 04: Hapus File JS Tidak Terpakai di `js/`
- **Fix:** Dihapus `js/anekabar.js`, `js/bootstrap.min.js`, `js/gmap.js`, dan `js/plugins.js`.

### GAP-19 — ✅ Selesai di Fase 04: Hapus `inc/Mobile_Detect.php` & Gunakan `wp_is_mobile()`
- **Fix:** Dihapus `inc/Mobile_Detect.php` (1.475 baris) dan diganti seluruh pemanggilannya dengan fungsi bawaan WordPress `wp_is_mobile()`.

### GAP-20 — 🔵 Low: Definisi Field ACF Belum Disimpan di Repo (`acf-json/`)
- **Lokasi:** Tidak ada folder `acf-json/`.
- **Masalah:** Struktur field group ACF hanya ada di database situs, tidak ter-version control.
- **Rencana Fix (Fase 04+):** Tambahkan folder `acf-json/` atau registrasi via `acf_add_local_field_group()` supaya skema ACF ikut ter-version di Git.

### GAP-21 — 🔵 Low: Format Kode Belum Sesuai WPCS (7.452 Pelanggaran Whitespace/Format)
- **Lokasi:** 83 file PHP.
- **Rencana Fix (Fase 04):** Jalankan `composer lint:fix` (`phpcbf`) di commit terpisah khusus formatting agar diff fitur/security tidak tercampur perubahan spasi.
