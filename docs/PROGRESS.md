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
