# Lessons Learned

> Format: tanggal, masalah, root cause, fix, pencegahan. Entri terbaru di atas.
> Wajib diisi setelah debugging signifikan atau hotfix production.

---

## 2026-11-24 — Teks & Slide Hero Bertumpuk Saat Transisi OwlCarousel (`animateOut`/`animateIn` Tanpa `animate.css`)
**Masalah:** Ketika Hero Slider (`.home-big-slider`) berpindah ke slide berikutnya, teks dari slide pertama tidak hilang melainkan bertumpuk dengan teks slide berikutnya.
**Root cause:** Di `js/sekolahane.js`, inisialisasi `.home-big-slider` masih menyertakan `animateOut: 'fadeOut'` dan `animateIn: 'fadeIn'`, sedangkan library `animate.css` sudah dihapus saat konsolidasi CSS. Pada OwlCarousel2, fitur `animateOut` mengunci posisi `.owl-item` lama dengan inline `style="left: ...px"` di atas slide baru dan menunggu event CSS `animationend` untuk menghapusnya. Karena class `.fadeOut` tidak memiliki animasi CSS, event `animationend` tidak pernah terpanggil sehingga slide lama tetap menempel dan bertumpuk.
**Fix:** Menghapus `animateOut: 'fadeOut'` dan `animateIn: 'fadeIn'` pada `.home-big-slider` di `js/sekolahane.js` dan menggantinya dengan `smartSpeed: 700` (sama seperti fix `0a56ba9` di `makhadane`).
**Pencegahan:** Saat menghapus `animate.css` pada konsolidasi aset theme, wajib hapus seluruh opsi `animateOut` dan `animateIn` pada konfigurasi OwlCarousel di file JS.

---

## 2026-11-10 — Optimasi PageSpeed Core Web Vitals (`webane-pagespeed-cwv`): Zero-CLS OwlCarousel, Batas `preconnect <= 4`, & DPR-Aware `sizes`
**Masalah:**
1. Saat script `OwlCarousel` di-defer untuk menghilangkan render-blocking, CLS melonjak ke `0.47–0.53` karena `.owl-carousel` memiliki `display: none` sampai JS selesai dieksekusi.
2. Muncul peringatan Lighthouse `Ditemukan lebih dari 4 koneksi preconnect` karena `<link rel="preconnect">` ditulis ganda di `header.php` dan `wp_resource_hints` (`inc/seo.php`).
3. Pada layar mobile ber-DPR tinggi (`412px × 2.625 DPR = 1081px`), `sizes="100vw"` pada gambar Hero Slider memicu browser mengunduh kandidat `1000w` (`1000x563`) alih-alih `700w` (`700x394`), dan inline `background-image` di section bawah fold (`calltoaction.php`) memicu unduhan eager file `-scaled.jpg` (`241 KB`).
**Root cause:**
1. Default CSS OwlCarousel menyembunyikan seluruh slider sebelum inisialisasi JS.
2. Duplikasi resource hints antara template `header.php` dan fungsi PHP `wp_resource_hints`.
3. Perhitungan `sizes="100vw"` dikalikan DPR perangkat oleh browser saat memilih kandidat `srcset`, dan CSS `background-image` inline tidak mendukung `loading="lazy"` maupun `srcset`.
**Fix:**
1. Menambahkan `.home-big-slider.owl-carousel { display: block; }` dan `.home-big-slider.owl-carousel:not(.owl-loaded) > *:not(:first-child) { display: none; }` di `css/main.css` sehingga CLS turun ke **`0.002` (Desktop) / `0.005` (Mobile)**.
2. Menghapus `<link rel="preconnect">` di `header.php`, membatasi `preconnect` di `wp_resource_hints` hanya untuk 2 origin (`fonts.googleapis.com` & `fonts.gstatic.com`), dan memindahkan `cdnjs.cloudflare.com` ke `dns-prefetch`.
3. Mengganti seluruh inline `background-image` konten dengan `<img>` (`object-fit: cover`), menyamakan `imagesizes`/`sizes="(max-width: 767px) 240px, 100vw"` pada Hero Slider, menggunakan ukuran `'thumbnail'` (`400x225`) pada `tp/content-list.php`, serta men-defer `'jquery-core'` dan `'jquery-migrate'` di frontend.
**Pencegahan:** Selalu jalankan skill global `webane-pagespeed-cwv` (`"Jalankan optimasi pagespeed webane"` / `"Terapkan standar speed test webane"`) saat membangun atau mengaudit theme WordPress Webane.

---

## 2026-10-26 — `get_sub_field()` pada Flexible Content Layout Harus Dipanggil Sebelum `have_rows()` Repeater Anak
**Masalah:** Pengaturan level layout (`ane_featured_position`, `ane_featured_style`) pada blok Flexible Content `home_featured` selalu menghasilkan string kosong `""` di `tp/section/featured.php` meskipun sudah dipilih `Di Bawah Hero` dan disimpan di WP Admin.
**Root cause:** `get_sub_field( 'ane_featured_position' )` dipanggil di dalam blok `if ( have_rows( 'ane_featured' ) )`. Pada ACF Pro, memanggil `have_rows( 'ane_featured' )` langsung menggeser pointer `acf_get_loop( 'active' )` ke repeater anak (`ane_featured`), sehingga `get_sub_field()` mencari field di dalam repeater anak, bukan di layout induk (`home_featured`).
**Fix:** Memindahkan pembacaan `get_sub_field( 'ane_featured_position' )` dan `get_sub_field( 'ane_featured_style' )` ke atas sebelum `if ( have_rows( 'ane_featured' ) )`.
**Pencegahan:** Selalu baca dan simpan semua `get_sub_field()` milik layout Flexible Content ke variabel sebelum memanggil `have_rows()` pada sub-repeater di dalamnya.

---

## 2026-10-23 — Celah Stored XSS & Fatal Error PHP 8.x pada Kode Theme Lama
**Masalah:**
1. Ditemukan `remove_filter( 'pre_user_description', 'wp_filter_kses' );` di `inc/sekolahane.php` ditambah output bio penulis tanpa escaping di `inc/sekolahane.php` dan `author.php` (Stored XSS).
2. Di PHP 8.0+, `@number_format( $count )` ketika post meta `musi_views` masih kosong (`''`) melempar `TypeError` yang tidak bisa diredam operator `@` (Fatal Error).
3. Di PHP 8.4, parameter opsional bertipe class/array dengan default `null` tanpa tanda `?` (`WP_Query $wp_query = null`, `array $headers = null`) memicu `Deprecated: Implicitly marking parameter as nullable is deprecated`.
**Root cause:** Kode warisan PHP 5/7 yang mematikan filter keamanan inti WordPress demi kemudahan input HTML di bio dan mengandalkan error suppression `@` serta tipe parameter implisit.
**Fix:**
1. Menghapus `remove_filter( 'pre_user_description', 'wp_filter_kses' )` dan membungkus output bio dengan `wp_kses_post()`.
2. Mengubah perhitungan views ke `(int) $raw_count` + `number_format_i18n()`.
3. Menambahkan eksplisit nullable `?WP_Query` dan `?array`, serta mengosongkan `phpstan-baseline.neon` hingga 0 error.
**Pencegahan:** Wajib jalankan `composer security:scan`, `composer lint:syntax` (PHP 8.4), dan `composer analyse` (PHPStan tanpa baseline) di setiap perubahan sebelum commit.

---

## 2026-10-23 — Folder theme production tanpa version control
**Masalah:** Theme sekolahane (v3.2.1, terpasang di situs pelanggan) tidak
berada di git; tidak ada riwayat perubahan, tidak bisa rollback, tidak ada CI.
**Root cause:** Theme dikembangkan langsung di folder situs lokal sejak 2019.
**Fix:** `git init` + commit baseline `3e538b6` sebelum perubahan apa pun.
**Pencegahan:** Theme baru WAJIB dimulai dari repo (template `master-wordpress`).

---

## 2026-10-29 — Notice `_load_textdomain_just_in_time` domain `acf`
**Masalah:** `debug.log` menampilkan notice terjemahan domain `acf` dimuat terlalu dini (WP 6.7+).
**Root cause:** `acf_add_options_page()` / `acf_add_options_sub_page()` dipanggil di scope file `inc/sekolahane.php`, sebelum `init`.
**Fix:** Dibungkus `sekolahane_register_options_pages()` dan di-hook ke `acf/init`.
**Pencegahan:** Fungsi ACF (`acf_add_*`, `get_field`) tidak boleh dipanggil di scope file; selalu lewat hook `acf/init` atau `init`+.

---

## [Tanggal] — [Judul]
**Masalah:**
**Root cause:**
**Fix:**
**Pencegahan:**
