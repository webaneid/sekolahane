# Fase 03 — Security Hardening (Anti-Webshell/XSS/Secret) & Perbaikan Bug PHP 8.x

**Status:** Done
**Jenis:** Berisiko (menyentuh kode inti theme — wajib nol regresi visual & kompatibilitas mundur penuh)
**Mulai:** 2026-10-23
**Selesai:** 2026-10-23

## Tujuan
Menutup seluruh celah keamanan kategori **Critical** dan **High** (serta Medium
yang berkaitan langsung), memasang perisai anti-direct-access (`ABSPATH`) dan
scanner otomatis anti-webshell/backdoor (`bin/security-scan.sh`), serta
memperbaiki seluruh bug PHP 8.x yang tercatat di `phpstan-baseline.neon`.

## Scope
- [x] **Guard Anti-Webshell & Direct Access (`GAP-03`):**
  - Pasang `defined( 'ABSPATH' ) || exit;` di **seluruh** 84 file PHP theme (`inc/*.php`, template root `*.php`, dan `tp/**/*.php`) agar tidak ada satu pun file PHP di theme yang bisa dieksekusi langsung lewat URL oleh bot/scanner.
  - Buat `bin/security-scan.sh` (`composer security:scan`) yang otomatis menggagalkan CI/rilis jika ditemukan:
    1. File `.php`/`.phtml`/`.phar`/executable di dalam folder aset (`img/`, `css/`, `js/`, `fonts/`).
    2. Fungsi eksekusi/obfuscation khas webshell (`eval`, `base64_decode`, `gzinflate`, `shell_exec`, `passthru`, `system`, `proc_open`, `popen`, `create_function`, `move_uploaded_file`, dll).
    3. File PHP theme tanpa guard `ABSPATH`.
    4. Hardcoded Google Maps API key (`AIza...`), AWS key (`AKIA...`), atau GitHub token (`ghp_...`, `github_pat_...`).
- [x] **Hapus Hardcoded Google Maps API Key (`GAP-01` — Critical):**
  - Ganti hardcoded key di `inc/sekolahane.php` dengan `sekolahane_get_google_maps_api_key()` (prioritas: konstanta `SEKOLAHANE_GMAPS_API_KEY` → ACF option `ane_google_maps_api_key`).
  - Tambahkan tab **API Keys** (`group_sekolahane_api_keys`) di halaman General Settings ACF (input tipe `password` untuk Google Maps API Key dan text untuk Facebook App ID).
- [x] **Keamanan Aset & jQuery (`GAP-04`, `GAP-16`):**
  - Hapus `wp_deregister_script( 'jquery' )` yang memaksa jQuery 3.3.1 CDN (rentan CVE XSS); gunakan jQuery bawaan WordPress.
  - Samakan versi Bootstrap CSS & JS (`4.4.1`) dan gunakan `SEKOLAHANE_VERSION` pada `main.min.css` & `sekolahane.js`.
- [x] **Hardening AJAX Post Views (`GAP-05`):**
  - Validasi `absint( wp_unslash( $_GET['postviews_id'] ) )` dan pastikan `'publish' === get_post_status( $post_id )` sebelum menulis post meta `musi_views`.
- [x] **Facebook SDK & Bug `$appid` (`GAP-06`, `GAP-08`):**
  - Baca Facebook App ID dari konstanta `SEKOLAHANE_FB_APP_ID` atau ACF option (`ane_fb_app_id`), escape dengan `esc_url()`/`rawurlencode()`, dan jangan muat script di `<head>` jika App ID tidak diset.
- [x] **Tutup Celah Stored XSS di Bio Penulis:**
  - Hapus `remove_filter( 'pre_user_description', 'wp_filter_kses' );` di `inc/sekolahane.php` dan bungkus bio penulis di `inc/sekolahane.php` serta `author.php` dengan `wp_kses_post()`.
- [x] **Perbaikan Seluruh Bug PHP 8.x di Baseline PHPStan (`GAP-07`, `GAP-08`, `GAP-09`, `GAP-10`, `GAP-12`):**
  - Perbaiki `get_the_terms()` 3 argumen di `tp/single-guru.php` dan tambahkan pengecekan `is_array()` sebelum `foreach`/`wp_list_pluck()` (mencegah Fatal Error PHP 8.0+).
  - Perbaiki `@number_format( $count )` pada string kosong di `get_views()` (mencegah uncatchable `TypeError` di PHP 8.0+).
  - Inisialisasi variabel yang belum terdefinisi di `inc/sekolahane.php`, `inc/widgets.php` (hapus `extract()`, tambah `get_default_instance()` + `wp_parse_args()`), `footer.php`, `tp/page-contact.php`, `tp/section/guru-v2.php`, `tp/single-guru.php`.
  - Perbaiki akses `$category[0]->cat_name` pada `WP_Term` (gunakan fallback `$category[0]->name ?? $category[0]->cat_name`).
  - Perbaiki pemanggilan `sprintf()` tanpa placeholder di 9 file `tp/`.
  - Ganti pemanggilan fungsi tak terdefinisi `panggil_sosial_media()` di `tp/page-contact.php` menjadi `get_template_part( 'tp/content', 'sosmed' )`.
  - Buat `tp/content-none.php` yang dipanggil oleh 14 template archive/search/single.
  - Perbaiki deprecation PHP 8.4 `?WP_Query $wp_query = null` di `ane_post_pagination()` dan `?array $headers = null` di `inc/Mobile_Detect.php`.
  - Perbaiki `add_action( 'the_content', ... )` → `add_filter( 'the_content', ... )`, `wpexplorer_remove_footer_admin()` return string pada filter `admin_footer_text`, dan `echo ane_related_post()` / `echo ane_newest_posts()` (void return) di `tp/single.php` & `tp/single-video.php`.
  - Tambahkan transient caching `sekolahane_copyright_year` pada query `$wpdb` di `webane_load_dynamic_copyright_year()` (`GAP-12`).
- [x] **Output Escaping (`GAP-02`)** pada `header.php`, `footer.php`, `author.php`, `search.php`, `searchform.php`, `inc/sekolahane.php`, `inc/widgets.php`, `inc/color.php`, `inc/customizer.php`, `inc/single-iklan.php`, `tp/section/*.php`, `tp/news/*.php`, `tp/mobile/*.php`, `tp/pages/*.php`, dan `tp/content-*.php`.

## Di Luar Scope
- Penghapusan file `inc/` yang tidak aktif (`color.php`, `customizer.php`, `post-view.php`, `option.php`, dll) — tetap di Fase 04 setelah konfirmasi.

## Referensi
- `docs/RETROFIT-GAPS.md` (`GAP-01` s/d `GAP-10`, `GAP-12`, `GAP-16`)
- `docs/architecture/architecture-security.md`

## Keputusan Kecil Selama Eksekusi
- Guard `defined( 'ABSPATH' ) || exit;` dipasang di **seluruh 84 file PHP theme** (root, `inc/`, `tp/`) dan ditegakkan otomatis oleh `bin/security-scan.sh` (`composer security:scan`).
- Seluruh 36 error yang sebelumnya dicatat di `phpstan-baseline.neon` berhasil diperbaiki hingga tuntas, sehingga `phpstan-baseline.neon` kini **0 error** (`ignoreErrors: []`).

## Laporan Security Review (Langkah 4 SOP)

| # | Area | Status | Catatan |
|---|---|---|---|
| 1 | Output Escaping (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`) | **PASS** | Seluruh output dinamis di `header.php`, `footer.php`, `author.php`, `search.php`, `searchform.php`, `inc/sekolahane.php`, `inc/widgets.php`, `inc/color.php`, `inc/single-iklan.php`, dan `tp/**/*.php` telah di-escape sesuai konteks. Filter `pre_user_description` (`wp_filter_kses`) dipulihkan untuk menutup Stored XSS. |
| 2 | Input Sanitization (`wp_unslash`, `absint`, `sanitize_text_field`) | **PASS** | `$_GET['postviews_id']` di `musi_increment_views()` menggunakan `absint( wp_unslash( $_GET['postviews_id'] ) )` dan memvalidasi `get_post_status( $post_id ) === 'publish'`. `Webane_Posts_Widget::update()` men-sanitize seluruh field (`sanitize_text_field`, `absint`). Customizer settings (`footer_link_title`, `footer_contact_title`) memiliki `sanitize_callback => 'sanitize_text_field'` pada `add_setting()`. |
| 3 | Nonce & Capability Check | **PASS** | Endpoint admin Force Check di `inc/updater.php` dilindungi `check_admin_referer` + `current_user_can( 'update_themes' )`. Endpoint publik `postviews` hanya menginkremen counter integer pada post berstatus `publish`. |
| 4 | Database / SQL | **PASS** | Satu-satunya query `$wpdb` di `webane_load_dynamic_copyright_year()` adalah query statis tanpa input user dan kini disimpan dalam transient `sekolahane_copyright_year` selama 1 hari (dan di-flush saat `save_post`). |
| 5 | File Security & Anti-Webshell (`ABSPATH`) | **PASS** | `composer security:scan` memverifikasi 84/84 file PHP memiliki `defined( 'ABSPATH' ) || exit;`, 0 file PHP di folder aset (`css/`, `js/`, `img/`, `fonts/`), dan 0 pemanggilan fungsi berbahaya (`eval`, `base64_decode`, `shell_exec`, dll). |
| 6 | Secrets & Enqueue | **PASS** | Hardcoded Google Maps API Key telah dihapus (`GAP-01`) dan diganti `sekolahane_get_google_maps_api_key()`. jQuery 3.3.1 CDN dihapus (`GAP-04`) dan diganti jQuery bawaan WordPress. |

## Checklist Penutupan (SOP)
- [x] `composer security:scan` lolos (4/4 pemeriksaan keamanan lulus)
- [x] `composer lint:syntax` lolos tanpa warning/deprecation di PHP 8.4
- [x] `composer analyse` lolos dengan `phpstan-baseline.neon` = 0 error!
- [x] `composer dist:check` lolos (paket ZIP rilis bersih dari `.md`, `docs/`, AI folder, dan dev tooling)
- [x] Security Review dijalankan & dilaporkan
- [x] `PROGRESS.md` & `RETROFIT-GAPS.md` diupdate

## Known Limitations
- Enam file di `inc/` (`post-view.php`, `option.php`, `related.php`, `single-iklan.php`, `customizer.php`, `color.php`) sudah diamankan dengan guard `ABSPATH` dan escaping, namun status aktif/pensiunnya akan dirapikan pada Fase 04 (`GAP-13`).

## Ringkasan Hasil
- Menutup seluruh celah keamanan Critical, High, dan Medium (`GAP-01` s/d `GAP-10`, `GAP-12`, `GAP-16`), termasuk menghapus hardcoded Google Maps API key, menutup Stored XSS di bio penulis, memulihkan jQuery bawaan WordPress, dan memasang guard `defined( 'ABSPATH' ) || exit;` di seluruh 84 file PHP theme.
- Menambahkan scanner otomatis anti-webshell & secret (`bin/security-scan.sh` / `composer security:scan`) ke workflow lokal dan GitHub Actions CI.
- Memperbaiki seluruh 36 bug PHP 8.x yang sebelumnya ada di baseline PHPStan hingga `phpstan-baseline.neon` mencapai **0 error**.
