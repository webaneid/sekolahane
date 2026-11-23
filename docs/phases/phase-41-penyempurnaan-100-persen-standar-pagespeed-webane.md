# Fase 41 — Penyempurnaan 100% Standar `webane-pagespeed-cwv` pada Seluruh Template Sekunder, CPT, & Section Pendukung

**Status:** Done

## 1. Tujuan & Cakupan
Menuntaskan ~15% sisa temuan audit kepatuhan terhadap standar [`webane-pagespeed-cwv`](file:///Users/webane/.gemini/config/skills/webane-pagespeed-cwv/SKILL.md) di seluruh halaman statis, Custom Post Type (CPT), format post, dan section beranda pendukung:

1. **Konversi 4 Template Header Halaman/CPT dari Inline `background-image` ke `<img class="ane-overlay-bg" fetchpriority="high">`:**
   - [`tp/content-page.php`](../../tp/content-page.php) (Halaman statis `page.php` desktop)
   - [`tp/single-ekstrakurikuler.php`](../../tp/single-ekstrakurikuler.php) (Halaman detail CPT Ekstrakurikuler)
   - [`tp/pages/profil.php`](../../tp/pages/profil.php) (Template halaman Profil)
   - [`tp/pages/kelembagaan.php`](../../tp/pages/kelembagaan.php) (Template halaman Kelembagaan)
   - Menyesuaikan [`sekolahane_preload_lcp_image()`](../../inc/sekolahane.php) agar template `page-kelembagaan.php` dan `page-aneprofil.php` yang menggunakan Featured Image halaman (bukan `home_box_slider`) juga di-preload dengan benar.
2. **Standarisasi Dimensi Eksplisit (`width` & `height`), `srcset`/`sizes`, `loading="lazy"`, `decoding="async"`, & Late Escaping pada Seluruh `<img>` Sekunder:**
   - Kartu Berita & Format Post: [`tp/content-klasik.php`](../../tp/content-klasik.php), [`tp/content.php`](../../tp/content.php), [`tp/content-gallery.php`](../../tp/content-gallery.php), [`tp/content-video.php`](../../tp/content-video.php), [`tp/single-video.php`](../../tp/single-video.php).
   - CPT Guru & Testimoni: [`tp/content-guru.php`](../../tp/content-guru.php), [`tp/single-guru.php`](../../tp/single-guru.php), [`tp/content-testimoni.php`](../../tp/content-testimoni.php).
   - Section Beranda Pendukung: [`tp/section/general-info.php`](../../tp/section/general-info.php), [`tp/section/banner.php`](../../tp/section/banner.php), [`tp/section/content.php`](../../tp/section/content.php).
   - Avatar Floating WhatsApp & Navigasi Prev/Next Artikel: [`footer.php`](../../footer.php), [`tp/content-page-kontak.php`](../../tp/content-page-kontak.php), [`inc/sekolahane.php`](../../inc/sekolahane.php).
3. **`content-visibility: auto` pada Seluruh Section Beranda di Bawah Fold (`css/main.css`):**
   - Menambahkan `content-visibility: auto; contain-intrinsic-size: auto 480px;` pada `.home-klasik`, `.home-column`, `.home-sliding`, `.home-ekstrakurikuler`, `.home-testimoni`, `.home-guru`, `.section-funfact`, dan `.section-general-info`.
   - Menambahkan dukungan `.ane-page-default .entry-header .ane-overlay-bg` dan `.ane-page-profil .entry-header .ane-overlay-bg` di Section `[10]` [`css/main.css`](../../css/main.css).

## 2. Daftar File yang Diubah
- `tp/content-page.php`
- `tp/single-ekstrakurikuler.php`
- `tp/pages/profil.php`
- `tp/pages/kelembagaan.php`
- `tp/content-klasik.php`
- `tp/content.php`
- `tp/content-gallery.php`
- `tp/content-video.php`
- `tp/single-video.php`
- `tp/content-guru.php`
- `tp/single-guru.php`
- `tp/content-testimoni.php`
- `tp/section/general-info.php`
- `tp/section/banner.php`
- `tp/section/content.php`
- `tp/content-page-kontak.php`
- `footer.php`
- `inc/sekolahane.php`
- `css/main.css` & `css/main.min.css`
- `docs/PROGRESS.md`
