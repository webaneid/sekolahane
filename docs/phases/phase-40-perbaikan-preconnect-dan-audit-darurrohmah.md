# Fase 40 — Perbaikan Preconnect (> 4 Koneksi), Defer jQuery, Optimasi Gambar Responsive, & Aksesibilitas (`darurrohmah.com`)

**Status:** Done

## 1. Tujuan & Masalah yang Ditemukan pada Laporan PageSpeed `darurrohmah.com` (`v3.3.3`)

Berdasarkan analisis laporan Google PageSpeed Insights (`https://pagespeed.web.dev/analysis/https-www-darurrohmah-com/us1umxw0ar?form_factor=mobile`):
- **Desktop:** Performance `90` (FCP `0.4s`, LCP `1.0s`, CLS `0.002`), Accessibility `98`, Best Practices `100`, SEO `100`.
- **Mobile:** Performance `73` (FCP `1.3s`, LCP `4.6s`, CLS `0.005`, `lcp-discovery-insight` score=`1`), Accessibility `96`, Best Practices `100`, SEO `100`.

Temuan spesifik yang diperbaiki di Fase 40:
1. **Peringatan `Hierarki dependensi jaringan: Ditemukan lebih dari 4 koneksi preconnect` (`[network-dependency-tree-insight]`):**
   - Terdapat **5 tag `<link rel="preconnect">`** di `<head>` karena duplikasi antara [`header.php`](../../header.php) (2 tag hardcoded `fonts.googleapis.com` & `fonts.gstatic.com`) dan [`sekolahane_seo_resource_hints()`](../../inc/seo.php) (3 tag: `fonts.googleapis.com`, `fonts.gstatic.com`, dan `cdnjs.cloudflare.com`).
   - **Solusi:** Hapus `<link rel="preconnect">` hardcoded di `header.php`. Pada `sekolahane_seo_resource_hints()`, batasi `preconnect` hanya untuk 2 origin terpenting (`https://fonts.googleapis.com` dan `https://fonts.gstatic.com` dengan `crossorigin`) dan pindahkan `https://cdnjs.cloudflare.com` ke `dns-prefetch`.
2. **Render-Blocking `jquery.min.js` & `jquery-migrate.min.js` (`[render-blocking-insight]` — hemat `1.470 ms` Mobile / `1.000 ms` Desktop):**
   - Seluruh script frontend theme (`OwlCarousel`, `magnific`, `sekolahane-js`) sudah menggunakan `defer` dan tidak ada inline `<script>` di template yang memanggil `jQuery` sebelum `DOMContentLoaded`.
   - **Solusi:** Tambahkan `'jquery-core'` dan `'jquery-migrate'` ke daftar `$defer_handles` pada [`sekolahane_defer_frontend_scripts()`](../../inc/sekolahane.php) (hanya di frontend `! is_admin()`).
3. **Optimasi Pengiriman Gambar (`[image-delivery-insight]`):**
   - **Hero Slider (`tp/section/big-slider.php` & `sekolahane_preload_lcp_image()`):** Atribut `sizes="100vw"` pada layar mobile ber-DPR tinggi (`412px × 2.625 = 1081px`) menyebabkan browser mengunduh kandidat `1000w` (`1000x563`) alih-alih `700w` (`700x394`) padahal ukuran tampil di mobile hanya `382x215` CSS px (`669x376` physical px). Ubah menjadi `sizes="(max-width: 767px) 240px, 100vw"` (dan `imagesizes` yang identik pada preload).
   - **Section Call to Action (`tp/section/calltoaction.php`):** Gaya `bento` dan `glass` masih memakai inline `style="background-image: url(...)"` dengan URL gambar asli (`Foto-bersama-2023-scaled.jpg`, `241 KB`) yang diunduh secara eager meskipun berada di bawah fold. Ubah menjadi elemen `<img class="ane-cta-bg" ... loading="lazy" decoding="async">` dengan resolusi ukuran responsif (`thumbnail` di mobile, `large` di desktop) + `srcset`.
   - **Kartu Berita List Kecil (`tp/content-list.php`):** Thumbnail berukuran `98x82` px (desktop) / `86x74` px (mobile) masih memuat ukuran `'kotak'` (`400x400`, `160.000` piksel) tanpa `srcset`/`sizes`. Ubah ke ukuran `'thumbnail'` (`400x225`, `90.000` piksel, hemat 44% piksel dengan `object-fit: cover`) dilengkapi `srcset` dan `sizes="(max-width: 767px) 86px, 98px"`, serta turunkan `SEKOLAHANE_WEBP_QUALITY` default dari `82` ke `78` untuk kompresi WebP unggahan baru yang lebih optimal.
4. **Aksesibilitas Desktop (`98` → `100`) & Mobile (`96` → `100`):**
   - **`[heading-order]` di Desktop (`footer.php`):** Elemen `<h3>` di dalam `<footer id="footer" class="ane-footer">` muncul tanpa didahului `<h2>`. Tambahkan `<h2 class="screen-reader-text">` di awal `<footer>`.
   - **`[color-contrast]` di Mobile (`css/main.css`):** Badge `.landing-page .home-title h2 span` dengan background `--ane-warna-utama` (`#c98b49`) dan teks `--ane-warna-terang` (`#ede7db`) hanya memiliki rasio kontras `2.34:1`. Gelapkan background menggunakan `color-mix(in srgb, var(--ane-warna-utama) 55%, var(--ane-warna-gelap))` dengan teks `--ane-warna-putih` (kontras `> 4.8:1`).

## 2. Daftar File yang Diubah
- `header.php`
- `inc/seo.php`
- `inc/sekolahane.php`
- `inc/webp-converter.php`
- `tp/section/big-slider.php`
- `tp/section/calltoaction.php`
- `tp/content-list.php`
- `footer.php`
- `css/main.css` & `css/main.min.css`
- `docs/PROGRESS.md`
