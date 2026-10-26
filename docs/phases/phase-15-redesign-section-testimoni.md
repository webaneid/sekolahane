# Fase 15 — Redesign Section & Kartu Testimoni (`tp/section/testimoni.php`, `tp/content-testimoni.php`)

- **Status:** `Done`
- **Tanggal:** 2026-10-26

## Tujuan
1. **Opsi Margin Bawah Section (`ane_testimoni_margin`):**
   - Menambahkan pengaturan di ACF (`home_testimoni` pada Template Home & Profil Lembaga) untuk memilih apakah section Testimoni menggunakan margin bawah (`Pakai Margin Bawah` / `80px`) atau menempel langsung (`Tanpa Margin Bawah` / `0px`) agar estetika tetap terjaga ketika section di bawahnya memiliki background berwarna (seperti CTA atau Footer).
2. **Redesign Kartu Testimoni & Pilihan Gaya (`ane_testimoni_style`):**
   - Memperbaiki struktur HTML `tp/content-testimoni.php` (menghapus ketergantungan pseudo-element `FontAwesome` `\f10d` yang sudah dihapus di Fase 08, memperbaiki bug posisi negatif `top: -48px`, menambahkan fallback avatar SVG jika tidak ada foto, serta menggunakan `get_post_type_archive_link( 'testimoni' )`).
   - Menyediakan 2 pilihan desain kartu Testimoni:
     1. **Modern Editorial Card (`modern` - Default):** Kartu putih bersih (`#ffffff`) dengan sudut membulat (`20px`), badge ikon tanda kutip emas SVG di bagian atas, isi kutipan yang nyaman dibaca, garis pemisah halus, dan footer profil horizontal di bagian bawah (foto bulat `52x52px` + nama & jabatan/status). Otomatis juga menjadi tampilan default pada halaman arsip `/testimoni`.
     2. **Classic Glass Speech (`bubble`):** Kartu kutipan bergaya balon/glassmorphism (`rgba(255, 255, 255, 0.58)`, `backdrop-filter: blur(10px)`) rata tengah dengan kutip dekoratif SVG serta foto profil bulat terpusat di bawah kartu.

## File yang Diubah
- `docs/PROGRESS.md`
- `docs/phases/phase-15-redesign-section-testimoni.md`
- `inc/acf-json/field-groups.json`
- `tp/section/testimoni.php`
- `tp/content-testimoni.php`
- `css/main.css`
- `css/main.min.css`

## Checklist Verifikasi
- [x] `python3 bin/css-audit.py` -> `0 dead CSS rules`
- [x] `bash bin/security-scan.sh` -> Lolos
- [x] `bash bin/check-dist.sh` -> Lolos
- [x] PHPCS (`tp/section/testimoni.php`, `tp/content-testimoni.php`) & PHPStan -> `0 errors`
