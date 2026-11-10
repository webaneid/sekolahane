# Fase 39 — Penerapan Standar `webane-pagespeed-cwv` (Standar Speed Test Jalawarta)

**Status:** Done
**Jenis:** Normal
**Mulai:** 2026-11-10
**Selesai:** 2026-11-10

## Tujuan
Menerapkan seluruh standar optimasi **PageSpeed Insights & Core Web Vitals (`webane-pagespeed-cwv`)** yang terbukti sukses pada theme `jalawarta` ke dalam `sekolahane` untuk memaksimalkan skor **Mobile** & **Desktop**:
1. **Gambar Overlay & Ekstrakurikuler (`<img class="ane-overlay-bg">` + Ukuran Mobile `'thumbnail'` `400x225` + `srcset`):**
   - Menghapus inline `style="background-image:url(...)"` pada `tp/content-overlay.php` dan `tp/content-ekstrakurikuler.php`, diganti dengan elemen `<img>` asli (`width`, `height`, `srcset`, `sizes="(max-width: 767px) 400px, 700px"`, `loading="lazy"`, `decoding="async"`).
   - Menggunakan ukuran `'thumbnail'` (`400x225`, ~15–25 KB) saat mobile (`wp_is_mobile()`) dan `'medium'` (`700x394`) saat desktop.
2. **Optimasi Gambar Hero Slider & Single Mobile (`srcset` + Ukuran Mobile Ringan):**
   - Pada `tp/section/big-slider.php`: resolusi ID attachment dari URL `ane_background` agar di layar mobile menyajikan ukuran `'medium'`/`'thumbnail'` beserta `srcset` dan dimensi eksplisit (`width`/`height`), `fetchpriority="high"` pada slide ke-1, dan `loading="lazy" fetchpriority="low"` pada slide ke-2 dst.
   - Pada `tp/mobile/single-universal.php` dan `tp/single.php`: gunakan `'thumbnail'` (`400x225`) di mobile (dan `'large'` di desktop) lengkap dengan `srcset`, `sizes`, `width`, `height`, serta `fetchpriority="high" decoding="async"`.
3. **Preload Gambar LCP di `<head>` (`wp_head` Prioritas `1`):**
   - Menyuntikkan `<link rel="preload" as="image" href="..." imagesrcset="..." imagesizes="..." fetchpriority="high">` pada `wp_head` prioritas `1` untuk slide pertama beranda (`is_front_page()`) dan featured image artikel tunggal (`is_singular()`).
4. **Async Non-Critical CSS, Conditional `OwlCarousel`, & `defer` Script Frontend (`inc/sekolahane.php`):**
   - Memuat stylesheet `Google-Fonts` dan `magnific-popup` secara asinkron (`media="print" onload="this.media='all'"` + `<noscript>`) via filter `style_loader_tag`.
   - Memuat `OwlCarousel` hanya pada halaman yang menggunakan slider.
   - Menambahkan atribut `defer` pada script frontend (`OwlCarousel`, `magnific`, `sekolahane-js`).
5. **`content-visibility: auto` pada Seksi Below-the-Fold (`css/main.css`):**
   - Menambahkan `content-visibility: auto; contain-intrinsic-size: auto 500px;` pada seksi-seksi beranda di bawah lipatan layar dan footer.

## Scope
- [x] `inc/sekolahane.php`: Helper gambar responsif (`sekolahane_get_attachment_id_from_url()`), Preload LCP di `wp_head` prioritas `1`, async CSS `style_loader_tag`, conditional `OwlCarousel`, dan `defer` script frontend.
- [x] `tp/content-overlay.php` & `tp/content-ekstrakurikuler.php`: Ganti `background-image` menjadi `<img class="ane-overlay-bg">` / `<img class="ane-ekstra-thumb">` dengan ukuran `'thumbnail'` di mobile + `srcset`.
- [x] `tp/section/big-slider.php`: Tambahkan `srcset`, `sizes`, `width`, `height`, dan `fetchpriority="low"` pada slide ke-2 dst.
- [x] `tp/mobile/single-universal.php`, `tp/single.php`, & `tp/content-list.php`: Gunakan ukuran `'thumbnail'` di mobile + `srcset` + `fetchpriority="high"` pada LCP image dan dimensi eksplisit pada list thumbnail.
- [x] `css/main.css` & `bin/css-audit.py`: Tambahkan aturan `.ane-overlay-bg`, sesuaikan `.ane-ekstra-thumb` untuk `<img>`, dan terapkan `content-visibility: auto` pada seksi below-the-fold.

## Checklist Penutupan (SOP)
- [x] `composer lint:changed` — nol pelanggaran baru
- [x] `composer analyse` — nol error PHPStan
- [x] `composer css:check` — `0 dead CSS rules` & `css/main.min.css` ter-update
- [x] Security Review (`esc_url`, `esc_attr`, `absint`)
- [x] `PROGRESS.md` diupdate
- [x] Commit & push sesuai Conventional Commits
