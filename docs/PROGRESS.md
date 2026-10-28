# Progress

> Satu baris per fase. Status: `Planned` → `In Progress` → `Done`.
> Jangan mulai fase baru sebelum fase sebelumnya `Done` (lihat `SOP.md`).

| Fase | Nama | Status | Doc |
|---|---|---|---|
| 00 | Fondasi: git, SOP, aturan, tooling lint | Done | `phases/phase-00-fondasi.md` |
| 01 | Retrofit audit: overview arsitektur + RETROFIT-GAPS | Done | `phases/phase-01-retrofit-audit.md` |
| 02 | Repo GitHub, CI, rilis otomatis, updater | Done | `phases/phase-02-updater-dan-ci.md` |
| 03 | Security fix Critical/High & bug PHP 8.x | Done | `phases/phase-03-security-dan-bugfix.md` |
| 04 | Pembersihan (`wp_is_mobile`, hapus fungsi/file ganda, text domain) | Done | `phases/phase-04-pembersihan-dan-optimasi.md` |
| 05 | Auto-convert upload gambar ke WebP & auto-crop sub-sizes | Done | `phases/phase-05-auto-convert-webp.md` |
| 06 | Optimasi & konsolidasi JavaScript (1 file `js/sekolahane.js` & conditional enqueue) | Done | `phases/phase-06-optimasi-javascript.md` |
| 07 | Optimasi CSS: Bootstrap super ringan & konsolidasi 1 file `css/main.min.css` | Done | `phases/phase-07-optimasi-css-bootstrap-ringan.md` |
| 08 | Migrasi icon `FontAne` ke Inline SVG & hapus folder `fonts/` (250 KB) | Done | `phases/phase-08-migrasi-icon-svg.md` |
| 09 | Audit, pembersihan dead CSS, & deduplikasi `css/main.css` + `css/main.min.css` | Done | `phases/phase-09-pembersihan-dan-deduplikasi-css.md` |
| 10 | Bundling & importer ACF JSON (`inc/acf-importer.php`) + verifikasi eksklusi `docs/` | Done | `phases/phase-10-acf-json-importer.md` |
| 11 | Auto-sync perubahan ACF JSON ke DB & redesign Hero Slider (`tp/section/big-slider.php`) | Done | `phases/phase-11-redesign-hero-slider.md` |
| 12 | Redesign Top Header: Tanggal, WhatsApp Otomatis & Link Pendaftaran (`header.php`) | Done | `phases/phase-12-redesign-top-header.md` |
| 13 | Redesign Fitur Sekolah: Pilihan Posisi (Menempel / Di Bawah Hero) & Desain (Default / Flat) (`tp/section/featured.php`) | Done | `phases/phase-13-redesign-section-featured.md` |
| 14 | Redesign Section & Kartu Ekstrakurikuler + Tombol Semua Ekstrakurikuler (`tp/section/ekstra.php`, `tp/content-ekstrakurikuler.php`) | Done | `phases/phase-14-redesign-section-ekstrakurikuler.md` |
| 15 | Redesign Section & Kartu Testimoni + Opsi Margin Bawah (`tp/section/testimoni.php`, `tp/content-testimoni.php`) | Done | `phases/phase-15-redesign-section-testimoni.md` |
| 16 | Redesign Section Call to Action: 3 Pilihan Desain, Opsi Margin Bawah & Tombol WA Otomatis (`tp/section/calltoaction.php`) | Done | `phases/phase-16-redesign-section-calltoaction.md` |
| 17 | Redesign Section Berita `home-default` (2 Pilihan Layout, Hapus Populer) & Kartu `content-overlay` / `content-list` | Done | `phases/phase-17-redesign-news-default-dan-kartu-berita.md` |
| 18 | Redesign Total Footer Modern dengan Gradasi Elegan & Glassmorphism (`footer.php`, `css/main.css`) | Done | `phases/phase-18-redesign-footer.md` |
| 19 | Redesign Floating WhatsApp Customer Care (`.cc-contactpop`): Tombol Bulat & Kartu Listing Agen (`footer.php`, `js/sekolahane.js`, `css/main.css`) | Done | `phases/phase-19-redesign-floating-customer-care.md` |
| 20 | Eliminasi Total FontAwesome ke Inline SVG & Redesign Mobile Bottom Bar `#footer-bar` (`inc/sekolahane.php`, `tp/mobile/menu-footer.php`, `footer.php`, `css/main.css`) | Done | `phases/phase-20-eliminasi-fontawesome-dan-redesign-mobile-menu.md` |
| 21 | Redesign Total Menu Utama Mobile (`.primary-mobile-menu` & `.mean-nav`) Modern Floating Glass (`js/sekolahane.js`, `css/main.css`) | Done | `phases/phase-21-redesign-mobile-mean-nav.md` |
| 22 | Universal Single Mobile App-Style (`post`, `page`, `ekstrakurikuler`, `guru`) & Redesign Social Share + Copy URL (`tp/mobile/single-universal.php`, `inc/sekolahane.php`, `css/main.css`) | Done | `phases/phase-22-universal-single-mobile-dan-share.md` |
| 23 | Default Google Maps API Key Terobfuskasi (XOR-Hex) & Fallback Otomatis (`inc/sekolahane.php`) | Done | `phases/phase-23-default-google-maps-key-terenkripsi.md` |
| 24 | Redesign Total Halaman Kontak (`page-kontak.php`, `tp/content-page-kontak.php`), Contact Form 7 & Customer Care Mobile | Done | `phases/phase-24-redesign-halaman-kontak.md` |
| 25 | Mesin SEO Premium Hybrid (Yoast Booster), Google Sitelinks Schema, Tag-to-Keywords, & GEO (`llms.txt`) | Done | `phases/phase-25-seo-premium-dan-geo-engine.md` |
| 26 | Submenu Admin "Google & Tracking" (GTM, GA4, Search Console, Meta/FB Pixel, & TikTok Pixel) | Done | `phases/phase-26-submenu-integrasi-google-dan-pixel.md` |
| 27 | Dinamisasi Warna Tema (`Warna Web`) via ACF Color Picker & CSS Custom Properties (`:root`) | Done | `phases/phase-27-dinamisasi-warna-acf-css-variables.md` |
| 28 | Redesign Profesional Dashboard Admin, Branding Icon Webane (`img/admin-webane*.svg`), & Penghapusan Banner Lama | Done | `phases/phase-28-redesign-dashboard-admin-webane.md` |
| 29 | Redesign Mobile Sliding App-Icons pada `.section-featured.featured-style-flat` (`tp/section/featured.php`, `css/main.css`) | Done | `phases/phase-29-mobile-sliding-icons-section-featured.md` |
| 30 | Redesign Section Hero Mobile: Rasio 16:9, Padding 15px, Border-Radius 16px, & Tanpa Masking Putih (`css/main.css`) | Done | `phases/phase-30-redesign-hero-mobile-16-9.md` |
| 31 | Pembersihan Total Sisa Warna Hardcoded ke CSS Variables (`:root`) pada Section Landing Page & Komponen (`css/main.css`) | Done | `phases/phase-31-pembersihan-sisa-warna-hardcode-css.md` |
| 32 | Section Baru Landing Page: `section-funfact` (ACF Flexible Content, Repeater 4 Item, 3 Varian Warna Brand, & 2 Kolom Mobile) | Done | `phases/phase-32-section-funfact-landingpage.md` |
| 33 | Section Baru Landing Page: `section-general-info` (Foto 3:4, 3 Desain Layout, Repeater Listing + Upload SVG Aman, & CTA Link) | Done | `phases/phase-33-section-general-info-dan-svg-upload.md` |
| 34 | Redesign Total Default Sidebar (`.right-sidebar`, `.ane-sidebar`, Listing & Media Blocks) + Harmonisasi Font `16px` | Done | `phases/phase-34-redesign-sidebar-dan-tipografi-16px.md` |
| 35 | Redesign Total `.ane-content` (Body `the_content()`): Tipografi, Tabel Card Mobile, Quote, Embed 16:9, Gallery, Button, File Download & Accordion FAQ | Done | `phases/phase-35-redesign-ane-content-gutenberg.md` |
