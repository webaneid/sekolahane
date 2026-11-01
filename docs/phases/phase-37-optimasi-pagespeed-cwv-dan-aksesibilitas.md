# Fase 37 — Optimasi Core Web Vitals (LCP & CLS), Eliminasi Render-Blocking, & Aksesibilitas PageSpeed

**Status:** Done
**Jenis:** Normal
**Mulai:** 2026-11-02
**Selesai:** 2026-11-02

## Tujuan
Menindaklanjuti audit Google PageSpeed Insights pada situs pelanggan (`pmbaitussalam.com` & `ppm.alhadi.or.id`) untuk meningkatkan skor **Performance** (mengatasi CLS `0.526`/`0.471` di Desktop dan LCP `5.0s`/`3.6s` di Mobile), **Accessibility** (dari `86` ke `95–100`), dan **Best Practices** (`96` ke `100`).

## Scope
- [x] **Hero Slider LCP & Zero-CLS (`tp/section/big-slider.php`, `css/main.css`):**
  - Stabilisasi `.home-slider .home-big-slider` sebelum JS OwlCarousel dieksekusi (`display: block` dan sembunyikan `.home-slider-item:not(:first-child)` saat `:not(.owl-loaded)`) agar tidak terjadi lonjakan tinggi dari `0px` ke `680px+` (penyebab utama CLS `0.526`).
  - Ganti CSS `background-image` pada `.home-slider-item` menjadi elemen `<img class="home-slider-bg">` dengan `fetchpriority="high" decoding="async"` pada slide pertama (mengatasi kegagalan `lcp-discovery-insight` dan memangkas *Resource Load Delay* 875 ms + *Element Render Delay* 1.424 ms).
- [x] **Eliminasi Render-Blocking CSS & Preconnect Font (`inc/sekolahane.php`, `header.php`, `css/main.css`):**
  - Satukan CSS struktural inti OwlCarousel (1,6 KB) ke dalam `css/main.css` (Bagian `[03]`) dan hapus request eksternal `owl.carousel.min.css` dari `cdnjs.cloudflare.com`.
  - Batasi pemuatan `magnific-popup.min.css` dan `jquery.magnific-popup.min.js` hanya pada halaman artikel/konten tunggal (`! is_front_page()` dan bukan template landing/kontak/arsip) agar tidak membebani Homepage.
  - Tambahkan `<link rel="preconnect" href="https://fonts.googleapis.com">` & `<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>` di `header.php`, serta rampingkan varian Google Fonts `Poppins`.
- [x] **Perbaikan Aksesibilitas & Best Practices (`tp/content-sosmed.php`, `tp/section/featured.php`, `inc/sekolahane.php`, `footer.php`, `css/main.css`):**
  - `[link-name]`: Tambahkan `aria-label` pada seluruh link ikon sosial media di `tp/content-sosmed.php` dan tambahkan `<span class="screen-reader-text">` pada tombol `prev`/`next` di `ane_post_pagination()` (`inc/sekolahane.php`).
  - `[agent-accessibility-tree]`: Ubah `<header class="kelapa" role="button">` di `footer.php` menjadi `<div class="kelapa" role="button">` agar sesuai spesifikasi ARIA.
  - `[heading-order]`: Tambahkan `<h2 class="screen-reader-text">` pada `.section-featured` dan ubah judul item dari `<h4>` ke `<h3>` di `tp/section/featured.php` agar urutan heading berjenjang (`h1` → `h2` → `h3`).
  - `[target-size]`: Naikkan ukuran sentuh minimum `.ane-konten-overlay .ane-meta ul li a.post-cat` menjadi `min-height: 24px` (`display: inline-flex; align-items: center;`).
  - `[color-contrast]`: Perbaiki rasio kontras teks pada `.ane-ekstra-badge`, `.ane-sub-badge`, dan `.ane-konten-lis .content-category a` menggunakan `color-mix(in srgb, var(--ane-warna-utama) 38%, var(--ane-warna-gelap))` (fallback `var(--ane-warna-gelap)`) agar selalu lolos rasio WCAG AA `>= 4.5:1` di semua kombinasi warna pelanggan.
  - `[unsized-images]`: Tambahkan atribut eksplisit `width="52" height="52"` pada ikon `<img>` di `tp/section/featured.php` dan dimensi logo fallback di `header.php`.

## Di Luar Scope
- Konversi ulang gambar artikel lama pelanggan (tahun 2019–2021) yang diunggah sebelum fitur auto-WebP aktif.
- Konfigurasi header `Cache-Control` tingkat web server/LiteSpeed pelanggan.

## Referensi
- `docs/SOP.md`
- `docs/architecture/architecture-css.md`
- `docs/architecture/architecture-security.md`

## Keputusan Kecil Selama Eksekusi
- Menggabungkan 45 baris CSS inti OwlCarousel ke `css/main.css` Bagian `[03]` lebih aman dan hemat 1 round-trip CDN dibanding memuat file 1,6 KB terpisah dari `cdnjs.cloudflare.com`.
- Slide pertama `.home-slider-item` menggunakan `<img class="home-slider-bg" fetchpriority="high" decoding="async">` tanpa `loading="lazy"`, sedangkan slide ke-2 dst menggunakan `loading="lazy" decoding="async"` agar bandwidth awal fokus ke LCP.

## Checklist Penutupan (SOP)
- [x] `composer lint:changed` — nol pelanggaran baru di file yang diubah
- [x] `composer analyse` — nol error baru
- [x] `composer css:check` — `0 dead CSS rules` & `css/main.min.css` ter-update
- [x] Security Review dijalankan (`architecture-security.md`)
- [x] `PROGRESS.md` diupdate
- [x] Commit sesuai Conventional Commits

## Known Limitations
- Skor cache TTL pada PageSpeed bergantung pada konfigurasi `.htaccess`/server masing-masing pelanggan.

## Ringkasan Hasil
- Mengatasi akar masalah CLS Desktop (`0.526`/`0.471`) dan LCP Mobile (`5.0s`/`3.6s`) dengan menstabilkan `.home-big-slider` sebelum JS OwlCarousel berjalan serta mengganti `background-image` Hero menjadi elemen `<img class="home-slider-bg" fetchpriority="high" decoding="async">` pada slide pertama.
- Mengeliminasi request CSS eksternal render-blocking (`owl.carousel.min.css` disatukan ke `css/main.css`, `magnific-popup` dibatasi hanya untuk halaman artikel tunggal) serta menambahkan `preconnect` Google Fonts.
- Menyelesaikan seluruh temuan Accessibility & Best Practices Lighthouse (`[link-name]`, `[agent-accessibility-tree]`, `[heading-order]`, `[target-size]`, `[color-contrast]`, dan `[unsized-images]`).
