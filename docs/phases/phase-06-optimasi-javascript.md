# Fase 06 — Optimasi & Konsolidasi JavaScript (Single File & Conditional Enqueue)

**Status:** Done
**Jenis:** Optimasi Performa (`perf(js)`)
**Mulai:** 2026-10-23
**Selesai:** 2026-10-23

## Tujuan
Menyederhanakan seluruh JavaScript front-end theme menjadi **hanya 1 file lokal (`js/sekolahane.js`)** yang bersih dari kode/plugin mati, serta mengoptimalkan pemuatan library eksternal di `inc/sekolahane.php` agar hanya dimuat saat benar-benar dibutuhkan.

## Scope
- [x] **Konsolidasi Menjadi 1 File JS di `js/`:**
  - Gabungkan logika AJAX `postViewsCache` (`js/postviews-cache.js`) ke dalam `js/sekolahane.js`.
  - Ubah `musi_postview_cache_count_enqueue()` di `inc/sekolahane.php` agar memanggil `wp_localize_script( 'sekolahane-js', 'postViewsCache', ... )` tanpa me-register file JS kedua.
  - Hapus `js/postviews-cache.js` sehingga folder `js/` hanya berisi 1 file: `js/sekolahane.js`.
- [x] **Pangkas Seluruh Kode Mati di `js/sekolahane.js`:**
  - Hapus event listener untuk elemen yang tidak ada di template: `.search-button`, `.search-bar`, `.search-back`, `#search-icon`, `#serach-close-btn`, `.search-box`, `.commrnt-toggle`, `.blog-comment-content-wrap`, dan `#post-block-slider`.
  - Hapus plugin `$.fn.scrollUp` yang tidak pernah dipanggil di mana pun.
  - Rampingkan plugin `$.fn.meanmenu` (hapus hack IE7/IE8, hapus duplikasi listener `$(window).resize`, hapus opsi mati).
  - Rampingkan objek style Google Maps `.acf-map` dan tambahkan guard `typeof google !== 'undefined' && google.maps`.
  - Perbaiki selector `#home-sliding` menjadi `[id="home-sliding"]` agar bila ada lebih dari satu carousel `#home-sliding` di Landing Page (Guru, Ekstrakurikuler, Berita Sliding), semuanya ter-inisialisasi.
  - Proteksi DOM XSS pada `titleSrc` Magnific Popup (`$('<strong/>').text(alt).prop('outerHTML')`).
- [x] **Optimasi Enqueue Script di `inc/sekolahane.php` (`ane_load_css_and_js`):**
  - Hapus enqueue `bootstrap-js` (`bootstrap.min.js` ~60 KB) karena theme hanya memakai CSS Grid/Button Bootstrap dan sama sekali tidak memakai komponen JS Bootstrap (`data-toggle`, modal, dropdown, collapse, tab).
  - Muat `magnific-popup` (CSS & JS) hanya pada halaman artikel/halaman tunggal (`is_singular()`), bukan di beranda/arsip.
  - Muat Google Maps JS API (`googlemap`) hanya pada halaman ber-template Contact Us (`is_page_template( 'page-kontak.php' )`).

## Di Luar Scope
- Mengubah struktur HTML/CSS komponen slider Owl Carousel atau menu mobile.

## Referensi
- `inc/sekolahane.php` (`ane_load_css_and_js`, `musi_postview_cache_count_enqueue`)
- `js/sekolahane.js`

## Keputusan Kecil Selama Eksekusi
- Tetap mempertahankan `$.fn.meanmenu` yang sudah dirampingkan di dalam `js/sekolahane.js` karena CSS menu mobile di `css/main.min.css` bergantung pada class `.mean-container`, `.mean-bar`, `.mean-nav`, dan `.meanmenu-reveal`.
- Menambahkan pengecekan `$.fn.owlCarousel`, `$.fn.magnificPopup`, dan `typeof google !== 'undefined'` di `js/sekolahane.js` agar script tetap aman tanpa error di console saat library eksternal di-enqueue secara kondisional.

## Checklist Penutupan (SOP)
- [x] Hanya ada 1 file di folder `js/` (`js/sekolahane.js`)
- [x] `composer security:scan` lolos
- [x] `composer lint:changed` lolos
- [x] `composer analyse` lolos (0 error PHPStan)
- [x] `composer dist:check` lolos
- [x] Security Review dijalankan & dilaporkan
- [x] `PROGRESS.md` diupdate

## Known Limitations
- Tidak ada.

## Ringkasan Hasil
- **Folder `js/` kini hanya berisi 1 file (`js/sekolahane.js`)** setelah `js/postviews-cache.js` digabungkan dan dihapus.
- **Ukuran `js/sekolahane.js` turun drastis >51%** dari 771 baris (22.7 KB) menjadi 332 baris (11.0 KB), hanya memuat 6 fitur yang benar-benar dipakai di template:
  1. Popup WhatsApp Customer Care (`.cc-contactpop`)
  2. Owl Carousel (`.home-big-slider`, `[id="home-sliding"]`, `.testimoni-slider`)
  3. Magnific Popup (`.gallery-popup`) dengan proteksi DOM XSS pada atribut `alt`
  4. Mobile Menu (`#mobile-menu-active` via MeanMenu yang dirampingkan)
  5. Google Maps ACF (`.acf-map`)
  6. AJAX Post Views Counter (`postViewsCache`)
- **Penghematan request & ukuran payload JS di Front-End:**
  - `bootstrap.min.js` (~60 KB) dihapus sepenuhnya dari `wp_enqueue_scripts`.
  - `magnific-popup` (CSS + JS) hanya dimuat saat `is_singular()`.
  - `googlemap` JS API hanya dimuat saat `is_page_template( 'page-kontak.php' )`.
  - `postviews-cache.js` (1 HTTP request terpisah) dieliminasi dengan menempelkan `wp_localize_script` langsung ke `sekolahane-js`.

### Hasil Security Review
| Kategori | Status | Catatan |
|---|---|---|
| Output Escaping / DOM XSS | Lolos | `titleSrc` Magnific Popup menggunakan `$('<strong/>').text(alt).prop('outerHTML')` sehingga atribut `alt` gambar tidak dieksekusi sebagai HTML mentah. |
| Input Sanitization | N/A | Tidak ada input request baru. |
| Nonce & Capability | N/A | Tidak ada endpoint mutasi baru. |
| SQL & File Security | Lolos | `composer security:scan` lolos 100%. |
| Secret & Debug | Lolos | Tidak ada secret atau `console.log` debug di `js/sekolahane.js`. |
