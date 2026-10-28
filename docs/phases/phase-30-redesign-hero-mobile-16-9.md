# Fase 30 — Redesign Section Hero Mobile: Rasio 16:9, Padding Kiri-Kanan 15px, Border-Radius Konsisten, & Tanpa Masking Putih

- **Status:** Done
- **Tanggal:** 2026-10-29

## Tujuan
Menyeragamkan seluruh desain section Hero di perangkat mobile (`@media (max-width: 767px)`) agar konsisten dengan komponen mobile app-style lainnya:
1. **Tanpa Masking Putih di Bawah:** Menyembunyikan elemen lengkungan putih `.pemanis-slider` ketika dibuka di mobile (`display: none`).
2. **Padding Kiri-Kanan 15px & Border-Radius Konsisten:** Memberikan ruang kiri-kanan `15px` seperti section mobile lainnya serta `border-radius: 16px` yang konsisten dengan kartu `.section-featured` dan `.msingle-media-frame`.
3. **Rasio 16:9 Konsisten:** Menggunakan `aspect-ratio: 16 / 9` pada seluruh variasi Hero di mobile (`.home-slider`, `.ane-page-profil .entry-header`, dan `.ane-page-default .entry-header`) lengkap dengan penyesuaian tipografi judul, deskripsi, tombol CTA, dan posisi `.owl-dots` agar tetap rapi di dalam kartu 16:9.

## File yang Diubah
- `css/main.css` & `css/main.min.css` — Pembaruan aturan `@media (max-width: 767px)` pada Section `[07]` (`.home-slider`) dan Section `[10]` (`.ane-page-default .entry-header`, `.ane-page-profil .entry-header`).
- `docs/PROGRESS.md` & `docs/phases/phase-30-redesign-hero-mobile-16-9.md` — Dokumentasi fase sesuai SOP.

## Verifikasi SOP & Security Review
- `python3 bin/css-audit.py`: **LOLOS** (`0 dead CSS rules`, `css/main.min.css` ter-generate `129.2 KB`).
- `vendor/bin/phpstan analyse`: **LOLOS** (`[OK] No errors`).
- `bash bin/security-scan.sh`: **LOLOS**.
- `bash bin/check-dist.sh`: **LOLOS**.
