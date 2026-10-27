# Fase 21 — Redesign Total Menu Utama Mobile (`mean-nav` & `.primary-mobile-menu`)

**Status:** Done
**Jenis:** Redesign & Optimasi UI/UX Mobile (`js/sekolahane.js`, `css/main.css`)
**Mulai:** 2026-10-27
**Selesai:** 2026-10-27

## Tujuan
Merombak total tampilan **Menu Utama Mobile (`.primary-mobile-menu` & `.mean-nav`)** yang sebelumnya kaku seperti blok warna lama (kotak oranye kaku, teks kapital semua, tombol `+` kecil tanpa animasi, dan hamburger 3 balok hitam) menjadi **Modern Floating Glass Drawer** yang elegan, halus, dan responsif untuk layar tablet & smartphone (`<= 991px`):
1. **Top Mobile Navbar Modern (`.primary-mobile-menu`):**
   - Bilah atas *frosted glass* putih bersih (`backdrop-filter: blur(16px)`), bayangan lembut, dan aksen border tipis.
   - Tombol **Hamburger / Close (`a.meanmenu-reveal`)** berbentuk tombol *squircle* modern (`42x42px`, `border-radius: 12px`) dengan 3 garis proporsional yang berubah menjadi ikon silang (`×`) SVG dengan transisi mulus saat menu dibuka (`.meanclose`).
2. **Floating Glass Menu Card (`.mean-nav`):**
   - Mengambang di bawah navbar (`width: calc(100% - 24px)`, `margin: 72px auto 0`, `border-radius: 20px`) dengan latar *dark-espresso glassmorphism* (`linear-gradient(165deg, rgba(22, 14, 7, 0.97) 0%, rgba(36, 24, 12, 0.98) 100%)`), border emas halus (`rgba(231, 173, 87, 0.28)`), dan kedalaman bayangan premium (`0 24px 54px rgba(10, 6, 3, 0.42)`).
   - Dilengkapi scroll mandiri (`max-height: calc(100vh - 92px)`, `overflow-y: auto`) agar menu panjang dengan banyak sub-menu tetap nyaman di-scroll di HP.
3. **Tipografi & Hierarki Sub-Menu Modern:**
   - Teks menu *Title Case* bersih (`font-size: 14.5px`, `font-weight: 600`, warna `rgba(255, 255, 255, 0.92)`), tidak lagi `UPPERCASE` kaku, dan tanpa `border-bottom: 5px solid #00a859` yang merusak estetika.
   - Tombol pembuka sub-menu (**`.mean-expand`**) menggunakan **ikon SVG Chevron** di dalam tombol *squircle* kaca (`32x32px`) yang berputar `180deg` secara mulus (`transform: rotate(180deg)`) saat diklik (`.mean-clicked`), tanpa mengubah teks `+`/`-` yang kaku.
   - Sub-menu bertingkat (`ul li ul`) tampil di dalam kontainer dengan garis aksen emas vertikal (`border-left: 2px solid rgba(231, 173, 87, 0.32)`) sehingga hierarki level 2 & level 3 terlihat jelas dan rapi.

## Scope
- [x] `js/sekolahane.js`: Perbarui konfigurasi & perilaku `meanmenu` (ikon SVG close & chevron SVG pada `.mean-expand` dengan animasi rotasi CSS tanpa menimpa HTML dengan teks `+`/`-`).
- [x] `css/main.css` & `css/main.min.css`: Rombak langsung blok `.primary-mobile-menu` dan `.mean-container` pada bagian `[05]` (cakupan `@media (max-width: 991px)`), hapus selector warisan yang tidak terpakai, dan pastikan `0 dead CSS rules`.
- [x] Verifikasi `composer lint`, `composer analyse`, `composer css:check`, `composer security:scan`, dan `composer dist:check`.

## Laporan Security Review (Langkah 4 SOP)

| # | Area | Status | Catatan |
|---|---|---|---|
| 1 | DOM Manipulation (`js/sekolahane.js`) | **PASS** | Hanya merender markup SVG statis internal untuk ikon tombol tutup dan chevron sub-menu tanpa interpolasi input pengguna. |
| 2 | Guard `ABSPATH` & Anti-Webshell | **PASS** | `bash bin/security-scan.sh` lolos tanpa temuan. |

## Checklist Penutupan (SOP)
- [x] `python3 bin/css-audit.py` lolos (`0 dead CSS rules`)
- [x] `bash bin/security-scan.sh` lolos
- [x] `bash bin/check-dist.sh` lolos
- [x] `docs/PROGRESS.md` diupdate ke `Done`
