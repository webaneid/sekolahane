# Retrofit Gaps — Sekolah Ane

> Daftar lengkap kesenjangan antara kode `sekolahane` (`v3.2.1`, baseline
> `3e538b6`) dan standar Webane (`AGENTS.md` + `architecture-security.md`).
> Setiap item memiliki ID unik (`GAP-XX`) agar mudah dirujuk di commit dan
> phase doc. Jangan perbaiki di luar fase yang ditugaskan.

## Ringkasan Per Tingkat Keparahan

| Level | Jumlah | Target Fase |
|---|---|---|
| 🔴 **Critical** | 1 | Fase 03 |
| 🟠 **High** | 3 | Fase 03 |
| 🟡 **Medium** | 10 | Fase 03 & Fase 04 |
| 🔵 **Low / Clean-up** | 7 | Fase 04 |

---

## A. Keamanan (Security)

### GAP-01 — 🔴 Critical: Hardcoded Google Maps API Key di Kode Theme
- **Lokasi:** `inc/sekolahane.php:19` (URL enqueue `googlemap`) dan `inc/sekolahane.php:28` (`acf_update_setting('google_api_key', ...)`).
- **Masalah:** API key Google Maps tertulis langsung di source code dan diekspos ke semua situs pelanggan.
- **Rencana Fix (Fase 03):** Baca key dari konstanta `SEKOLAHANE_GMAPS_API_KEY` atau ACF option (mis. `ane_gmaps_api_key`). Hanya enqueue script Google Maps jika key tersedia (dan idealnya hanya di halaman yang membutuhkan peta).

### GAP-02 — 🟠 High: Output Tidak Di-escape (322 titik menurut PHPCS)
- **Lokasi:** Tersebar di template root, `tp/`, `header.php`, `footer.php`, `inc/sekolahane.php`, dan `inc/widgets.php`.
- **Contoh nyata:**
  - `header.php:22`: `echo $link['url']` dan `echo $link['title']` dari ACF option tanpa `esc_url()` / `esc_html()`.
  - `inc/widgets.php:54-86, 147-208`: variabel widget (`$title`, `$post_tag`, `$number`) di-echo mentah di atribut `<input value="...">`.
  - `inc/sekolahane.php:808`: `$avatar = '<img alt="' . $alt . '" src="' . $avatar_url . '" ...'` tanpa `esc_attr()` / `esc_url()`.
- **Rencana Fix (Fase 03):** Escape seluruh output di `header.php`, `footer.php`, `inc/`, dan template utama sesuai tabel di `architecture-security.md`.

### GAP-03 — 🟠 High: Tidak Ada Guard `ABSPATH` di File `inc/`
- **Lokasi:** Seluruh file di `inc/*.php` (`sekolahane.php`, `custompost.php`, `widgets.php`, dll) kecuali sepotong cek di tengah `inc/widgets.php:51`.
- **Masalah:** Jika file diakses langsung via HTTP, PHP akan mengeksekusi fungsi seperti `add_action()` di luar konteks WordPress dan membocorkan path server lewat pesan fatal error.
- **Rencana Fix (Fase 03):** Tambahkan `defined( 'ABSPATH' ) || exit;` di baris paling atas setiap file `inc/*.php`.

### GAP-04 — 🟡 Medium: Deregister jQuery Bawaan WP & Ganti dengan jQuery 3.3.1 CDN Tanpa SRI
- **Lokasi:** `inc/sekolahane.php:12-14` (`wp_deregister_script('jquery')` → Cloudflare CDN jQuery 3.3.1).
- **Masalah:**
  1. jQuery 3.3.1 memiliki CVE XSS yang sudah diperbaiki di jQuery ≥ 3.5.0 (yang sudah dibawa WordPress 6.0+).
  2. Mengganti jQuery inti WordPress sering merusak kompatibilitas plugin.
  3. Seluruh aset CDN (`inc/sekolahane.php:5-18`) dimuat tanpa atribut Subresource Integrity (SRI) dan versi Bootstrap CSS (4.4.1) tidak sama dengan JS-nya (4.3.1).
- **Rencana Fix (Fase 03/04):** Gunakan jQuery bawaan WordPress atau bundel lokal/SRI, dan samakan versi Bootstrap.

### GAP-05 — 🟡 Medium: Endpoint AJAX `nopriv` Post Views Tanpa Validasi Status Post
- **Lokasi:** `inc/sekolahane.php:882-903` (`musi_increment_views`).
- **Masalah:** Meskipun `$_GET['postviews_id']` sudah di-cast dengan `intval()`, handler tidak mengecek apakah post tersebut benar-benar ada dan berstatus `publish`, sehingga sembarang angka `postviews_id` akan membuat baris post meta `musi_views` baru di tabel `wp_postmeta`.
- **Rencana Fix (Fase 03):** Cek `get_post_status( $post_id ) === 'publish'` sebelum menulis meta, dan gunakan `absint( wp_unslash( $_GET['postviews_id'] ) )`.

### GAP-06 — 🟡 Medium: Hardcoded Facebook App ID & Duplikasi `<script>` SDK Mentah
- **Lokasi:** `header.php:12` dan `inc/sekolahane.php:382-391` (`fungsi_komen_facebook_webane`).
- **Masalah:** SDK Facebook dimuat dua kali dengan `<script>` mentah, App ID di-hardcode, dan di `inc/sekolahane.php:388` terdapat bug `Undefined variable: $appid` (lihat GAP-08).
- **Rencana Fix (Fase 03):** Pindahkan App ID ke ACF option (opsional), muat hanya jika fitur komentar FB diaktifkan, dan perbaiki variabel `$appid`.

---

## B. Bug & Logic Error (Tertangkap PHPStan Level 3)

### GAP-07 — 🟠 High: Pemanggilan `get_the_terms()` dengan 3 Argumen (Signature Salah)
- **Lokasi:** `tp/single-guru.php:61` dan `tp/single-guru.php:92`.
- **Masalah:** `get_the_terms( $post->ID, 'pelajaran', ', ' )` — fungsi WordPress `get_the_terms()` hanya menerima 2 parameter (`$post`, `$taxonomy`). Argumen ketiga diabaikan dan menunjukkan niat awal memakai `get_the_term_list()`.
- **Rencana Fix (Fase 03):** Perbaiki pemanggilan sesuai fungsi yang dimaksud tanpa mengubah output HTML.

### GAP-08 — 🟡 Medium: Variabel Tidak Terdefinisi di Beberapa Template & Helper
- **Lokasi (tercatat di `phpstan-baseline.neon`):**
  - `inc/sekolahane.php:388` — `Undefined variable: $appid` di `fungsi_komen_facebook_webane()`.
  - `inc/sekolahane.php:414,416` — `$author_details` diappend dengan `.=` sebelum diinisialisasi (`$author_details = ''`).
  - `inc/sekolahane.php:593,598` — `$month_name` di breadcrumbs arsip bulan tidak diinisialisasi jika kondisi bulan tidak cocok.
  - `footer.php:96` — `$judul` mungkin tidak terdefinisi.
  - `tp/page-contact.php:28` (`$gambar`), `tp/section/guru-v2.php:20` (`$urlhome`), `tp/single-guru.php:10` (`$imgurl`), dan `inc/widgets.php` (variabel `$instance` tidak diberi nilai default ketika kosong).
- **Rencana Fix (Fase 03):** Inisialisasi seluruh variabel dengan nilai default yang aman sebelum dipakai (menghilangkan PHP Warning di PHP 8.x).

### GAP-09 — 🟡 Medium: Pemanggilan Fungsi & Template Part yang Tidak Ada
- **Lokasi:**
  - `tp/page-contact.php:58`: memanggil `panggil_sosial_media()` yang tidak pernah didefinisikan di mana pun (fatal error jika `tp/page-contact.php` dipakai).
  - `functions.php:3`: `require get_template_directory() . '/inc/back-compat.php'` — file tidak ada.
  - `get_template_part( 'tp/content', 'none' )` dipanggil di 9 file archive/search/tag/category/index, tetapi `tp/content-none.php` tidak ada (WordPress gagal diam-diam dan menampilkan halaman kosong saat tidak ada post).
  - `get_template_part( 'tp/home', 'client' )` dipanggil di `tp/section/testimoni.php:35`, tetapi `tp/home-client.php` tidak ada.
- **Rencana Fix (Fase 03/04):** Buat `tp/content-none.php` sederhana, bersihkan/amankan referensi ke file/fungsi yang tidak ada.

### GAP-10 — 🟡 Medium: Properti `WP_Term::$cat_name` dan `sprintf()` Tanpa Placeholder
- **Lokasi (`phpstan-baseline.neon`):**
  - 8 template (`tp/content*.php`, `tp/single*.php`) mengakses `$category[0]->cat_name` pada hasil `get_the_terms()` (yang mengembalikan `WP_Term` dengan properti `->name`, bukan `->cat_name`; `cat_name` hanya ada di `get_the_category()`).
  - 9 template memanggil `sprintf( esc_html__( '...', 'sekolahane' ), ... )` dengan string terjemahan tanpa placeholder `%s`.
  - `inc/sekolahane.php:856`: `remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 )` memakai 4 parameter (seharusnya maksimal 3).
  - `inc/widgets.php:211`: `Webane_Posts_Widget::form()` tidak mengembalikan nilai.
- **Rencana Fix (Fase 04):** Rapikan semua item di atas dan hapus dari `phpstan-baseline.neon`.

---

## C. Performa & Database

### GAP-11 — ✅ Selesai di Fase 02: `update_option()` ×9 Dijalankan di Setiap Request
- **Lokasi:** `functions.php:16-24` (di dalam `after_setup_theme`).
- **Fix:** Dipindahkan ke fungsi `sekolahane_configure_image_sizes()` pada hook `after_switch_theme`.

### GAP-12 — 🟡 Medium: Query `$wpdb` Tahun Copyright Tanpa Cache & Aset Eksternal HTTP di Admin
- **Lokasi:**
  - `inc/sekolahane.php:747-766`: `webane_load_dynamic_copyright_year()` menjalankan query `SELECT YEAR(min(post_date_gmt))...` setiap kali dipanggil tanpa transient.
  - `inc/sekolahane.php:674, 713, 731`: Halaman login & dashboard admin memuat gambar dari `4.bp.blogspot.com` dan RSS feed `http://webane.com/feed/` (HTTP non-TLS, memperlambat loading wp-admin).
- **Rencana Fix (Fase 04):** Simpan hasil tahun copyright di transient (di-clear saat `save_post`), dan bersihkan aset eksternal lawas di admin.

---

## D. Kode Mati, Duplikasi, & Standar (Maintainability)

### GAP-13 — 🟡 Medium: 6 File di `inc/` Tidak Di-require (Duplikat / Menggantung)
- **Lokasi:**
  - `inc/post-view.php` & `inc/option.php` — 100% duplikat dari kode yang sudah ada di akhir `inc/sekolahane.php`.
  - `inc/related.php` & `inc/single-iklan.php` — fitur lama yang tidak di-load.
  - `inc/customizer.php` & `inc/color.php` — setting Customizer tidak di-load sementara sebagian `get_theme_mod()` masih dipanggil di template.
- **Rencana Fix (Fase 04):** Hapus file yang murni duplikat (`post-view.php`, `option.php`) atau pisahkan modul `inc/sekolahane.php` yang terlalu besar (935 baris) ke file-file `inc/` yang jelas tanggung jawabnya; konfirmasi ke user apakah `customizer.php`/`color.php`/`single-iklan.php` masih ingin diaktifkan atau dipensiunkan.

### GAP-14 — ✅ Selesai di Fase 02: Belum Ada Mekanisme Auto-Update & CI Release
- **Lokasi:** `inc/updater.php`, `.github/workflows/ci.yml`, `.github/workflows/release.yml`, `.releaserc.json`.
- **Fix:** Dipasang sesuai ADR-0002 dan ADR-0003.

### GAP-15 — 🔵 Low: Text Domain Campur Aduk (8 Text Domain Berbeda)
- **Lokasi:** Tersebar di template dan `inc/` (`sekolahane`, `anekabar`, `kabarane`, `anelogistik`, `rentcarane`, `roots`, `twentysixteen`, `webane-master`, `webane`).
- **Rencana Fix (Fase 04):** Seragamkan seluruh fungsi terjemahan ke `'sekolahane'`.

### GAP-16 — 🔵 Low: Versi Enqueue `main.min.css` Hardcoded `'1.0.6'` & `sekolahane.js` Tanpa Versi
- **Lokasi:** `inc/sekolahane.php:10, 20`.
- **Masalah:** Ketika theme diupdate ke versi baru, browser pengunjung tetap menyimpan cache CSS/JS lama.
- **Rencana Fix (Fase 04):** Gunakan konstanta `SEKOLAHANE_VERSION` atau `filemtime()` seperti di `jalawarta`.

### GAP-17 — 🔵 Low: Penggunaan `wp_reset_query()` Setelah `WP_Query`
- **Lokasi:** `inc/sekolahane.php:196, 220`, `tp/single-guru.php:84, 115`, `tp/single-ekstrakurikuler.php:54`.
- **Masalah:** `wp_reset_query()` ditujukan untuk `query_posts()`; untuk `new WP_Query()` seharusnya menggunakan `wp_reset_postdata()`.
- **Rencana Fix (Fase 04):** Ganti ke `wp_reset_postdata()`.

### GAP-18 — 🔵 Low: File JS di `js/` yang Tidak Pernah Di-enqueue
- **Lokasi:** `js/anekabar.js`, `js/bootstrap.min.js`, `js/gmap.js`, `js/plugins.js`.
- **Rencana Fix (Fase 04):** Verifikasi apakah masih dibutuhkan; hapus atau gunakan sebagai pengganti CDN.

### GAP-19 — 🔵 Low: `inc/Mobile_Detect.php` Versi Lama Dibundel Manual
- **Lokasi:** `inc/Mobile_Detect.php` + 22 pemanggilan `new Mobile_Detect()` berulang kali dalam satu request.
- **Rencana Fix (Fase 04):** Bungkus dalam satu helper function `sekolahane_is_mobile()` dengan static cache per request agar tidak menginstansiasi objek berulang-ulang di dalam loop.

### GAP-20 — 🔵 Low: Definisi Field ACF Belum Disimpan di Repo (`acf-json/`)
- **Lokasi:** Tidak ada folder `acf-json/`.
- **Masalah:** Struktur field group ACF hanya ada di database situs, tidak ter-version control.
- **Rencana Fix (Fase 04+):** Tambahkan folder `acf-json/` atau registrasi via `acf_add_local_field_group()` supaya skema ACF ikut ter-version di Git.

### GAP-21 — 🔵 Low: Format Kode Belum Sesuai WPCS (7.452 Pelanggaran Whitespace/Format)
- **Lokasi:** 83 file PHP.
- **Rencana Fix (Fase 04):** Jalankan `composer lint:fix` (`phpcbf`) di commit terpisah khusus formatting agar diff fitur/security tidak tercampur perubahan spasi.
