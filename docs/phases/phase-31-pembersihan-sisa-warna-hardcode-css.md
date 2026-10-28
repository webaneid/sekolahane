# Fase 31 — Pembersihan Total Sisa Warna Hardcoded ke CSS Variables (`:root`) di Seluruh Section & Komponen (`css/main.css`)

- **Status:** Done
- **Tanggal:** 2026-10-29

## Tujuan
Menghapus seluruh sisa warna hardcoded (`#hex` dan `rgba(...)` non-variabel) pada section Landing Page maupun komponen halaman dalam/sidebar agar 100% mengikuti pengaturan dinamis **Webane Settings → Warna Web**:
1. **Landing Page Sections (`[06]`, `[07]`, `[11]`):**
   - Overlay Hero Slider (`.home-slider-item.has-overlay::before` desktop & mobile) → `rgba(var(--ane-warna-gelap-rgb), ...)`.
   - Subjudul & deskripsi pada `.section-featured` (Default & Flat) dan `.home-ekstrakurikuler` (Bento & Split) → `rgba(var(--ane-warna-text-rgb), 0.78)`.
   - Panah navigasi `.home-testimoni .owl-nav i` (`var(--ane-warna-gelap)`) dan teks kutipan `.ane-konten-testimoni .ane-testi-text` (`var(--ane-warna-text)`).
2. **Halaman Dalam, Sidebar & Komponen Global (`[03]`, `[08]`, `[09]`, `[10]`, `[11]`, `[12]`):**
   - Overlay Hero `.ane-page-default`, `.ane-page-profil`, dan `.ane-page-kelembagaan` → `rgba(var(--ane-warna-gelap-rgb), ...)`.
   - Tag Cloud Sidebar (`.right-sidebar .ane-sidebar .tagcloud a` & `:hover`) → `var(--ane-warna-gelap)` dan hover `var(--ane-warna-utama)` / `var(--ane-warna-putih)`.
   - Teks meta/caption/body pada `.ane-mobile-single`, `.ane-page-kontak`, `.cc-contactpop`, `.post-tags`, `.wp-block-file__button`, dan elemen `select` → menggunakan variabel `--ane-warna-text`, `--ane-warna-terang`, `--ane-warna-utama`, dan `--ane-warna-putih`.

## File yang Diubah
- `css/main.css` & `css/main.min.css` — Konversi seluruh sisa warna hardcoded tema ke CSS Custom Properties.
- `docs/PROGRESS.md` & `docs/phases/phase-31-pembersihan-sisa-warna-hardcode-css.md` — Dokumentasi fase sesuai SOP.

## Verifikasi SOP & Security Review
- `python3 bin/css-audit.py`: **LOLOS** (`0 dead CSS rules`, `css/main.min.css` ter-generate `129.8 KB`).
- `vendor/bin/phpstan analyse`: **LOLOS** (`[OK] No errors`).
- `bash bin/security-scan.sh`: **LOLOS**.
- `bash bin/check-dist.sh`: **LOLOS**.
