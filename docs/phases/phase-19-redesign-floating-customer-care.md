# Fase 19 — Redesign Floating WhatsApp Customer Care (`.cc-contactpop`)

- **Status:** `Done`
- **Tanggal:** 2026-10-27

## Tujuan
1. **Tombol Floating Bulat WhatsApp Modern (`header.kelapa`):**
   - Mengubah bar kaku `350px` di pojok kanan bawah menjadi **Floating Action Button (FAB) Bulat WhatsApp (`58x58px`)** dengan ikon Inline SVG WhatsApp, indikator titik aktif (*online dot*), serta efek *glow* & *hover* halus.
2. **Kartu Popup & Listing CS/Admin Modern (`.renseignement`):**
   - Menampilkan kartu popup mengambang (`width: 340px`, `border-radius: 20px`) di atas tombol bulat saat diklik.
   - Header popup elegan berisi judul (`ane_cs_label`), pesan sambutan (`ane_cs_welcome`), dan tombol tutup (`×`).
   - Daftar kontak (`ane_cs`) tampil sebagai kartu agen modern:
     - Foto profil bulat (`46x46px`) dengan indikator *online* hijau (dilengkapi avatar fallback SVG jika belum ada foto).
     - Nama & bidang/jabatan (`ane_nama` & `ane_area`) dengan tipografi bersih (tanpa *italic* kuno).
     - Ikon aksi WhatsApp di sisi kanan tiap item.
   - Memastikan nomor WhatsApp berawalan `0` otomatis dinormalisasi menjadi `62` agar tautan `https://wa.me/` selalu valid.
3. **Pembaruan Interaksi di `js/sekolahane.js`:**
   - Mengganti logika lama `$ccPop.find('form, i, p, ul').hide()` (yang menyembunyikan seluruh tag `<i>`) menjadi toggle class `.is-open` yang mulus serta menutup otomatis saat klik tombol tutup atau area luar.

## File yang Diubah
- `docs/PROGRESS.md`
- `docs/phases/phase-19-redesign-floating-customer-care.md`
- `footer.php`
- `js/sekolahane.js`
- `css/main.css`
- `css/main.min.css`

## Checklist Verifikasi
- [x] `python3 bin/css-audit.py` -> `0 dead CSS rules`
- [x] `bash bin/security-scan.sh` -> Lolos
- [x] `bash bin/check-dist.sh` -> Lolos
- [x] PHPCS (`footer.php`) & PHPStan -> `0 errors`
