# Fase 18 — Redesign Total Footer Modern Glassmorphism (`footer.php`, `css/main.css`)

- **Status:** `Done`
- **Tanggal:** 2026-10-27

## Tujuan
1. **Redesign Visual `.ane-footer` dengan Luxury Dark-Gold Gradient & Glassmorphism:**
   - Mengganti background datar `#160e06` dan bar bawah ungu `rgba(19, 12, 47, 0.8)` menjadi gradasi gelap-emas berlapis (`linear-gradient(155deg, #110c07 0%, #1c130b 52%, #2b1d10 100%)`) dengan *ambient glow orbs* (`::before` & `::after`) yang terkurung rapi (`overflow: hidden`).
   - Mengubah kartu profil sekolah di kolom pertama (`.ane-footer .atas .isi`) menjadi **Frosted Glass Card** (`backdrop-filter: blur(18px)`, `border-radius: 22px`, border tipis berkilau, dan badge slogan berbentuk *pill* emas tanpa tanda kutip kasar `"..."`).
   - Merombak kolom **Link Penting** dan **Hubungi Kami** (`.isi-v2`):
     - Judul kolom rata kiri dengan garis aksen emas modern.
     - Menghapus garis putus-putus (`1px dotted`) kuno.
     - Menampilkan ikon kontak (`lokasi`, `telepon`, `handphone`, `email`, `laptop`) di dalam *badge* kaca keemasan (`32x32px`, `border-radius: 9px`) yang sejajar rapi menggunakan Flexbox.
     - Mempercantik tombol sosial media (`.ane-sosmed`) di footer dengan efek kaca (*glass button* `border-radius: 12px`) dan animasi angkat saat *hover*.
   - Merombak bar **Copyright** (`.ane-footer .bawah`) dengan *frosted glass bar* yang serasi.
2. **Standarisasi Kode `footer.php`:**
   - Merapikan variabel lokal dengan prefix `$sekolahane_` dan memastikan seluruh output telah di-escape sesuai standar WPCS & PHPStan.

## File yang Diubah
- `docs/PROGRESS.md`
- `docs/phases/phase-18-redesign-footer.md`
- `footer.php`
- `css/main.css`
- `css/main.min.css`

## Checklist Verifikasi
- [x] `python3 bin/css-audit.py` -> `0 dead CSS rules`
- [x] `bash bin/security-scan.sh` -> Lolos
- [x] `bash bin/check-dist.sh` -> Lolos
- [x] PHPCS (`footer.php`) & PHPStan -> `0 errors`
