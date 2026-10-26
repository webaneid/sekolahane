# Fase 17 — Redesign Section Berita `home-default` & Kartu `content-overlay` / `content-list`

- **Status:** `Done`
- **Tanggal:** 2026-10-27

## Tujuan
1. **Rombak Total `tp/news/default.php` (`home-default`):**
   - Menghapus kolom **Populer** (`.konten-populer`) yang redundan (karena mengulang berita dari kategori yang sama dan membuat layout terjepit menjadi 3 kolom sempit).
   - Menambahkan opsi ACF `ane_default_style` pada layout `home_default` (di Template Home & Page Newslist) dengan 2 pilihan tata letak modern:
     - **1. Modern Split Magazine (`split` — Default):** Kolom kiri (50%) menampilkan 1 Berita Sorotan Utama (`content-overlay`) berukuran lega & proporsional (`height: 460px`), sedangkan kolom kanan (50%) menampilkan 4 Berita Terbaru (`content-list`) yang tersusun rapi dengan jarak dan ruang baca yang lega.
     - **2. Bento News Grid (`bento`):** Baris atas menampilkan 2 Berita Sorotan (`content-overlay`) berdampingan (2 kolom), diikuti baris bawah berisi 4 Berita Terbaru (`content-list`) dalam grid 2 kolom bergaya kartu.
   - Memastikan penanganan aman ketika objek kategori (`pilih_kategori`) belum dipilih atau kosong (fallback ke seluruh post terbaru).
2. **Modernisasi Kartu `tp/content-overlay.php` & `tp/content-list.php`:**
   - Menambahkan fallback gambar otomatis (`sekolahane_dummy_tumbnail()`) apabila artikel belum memiliki Featured Image.
   - Memperbarui desain `.ane-konten-overlay`, `.ane-konten-lis`, dan `.section-title` di `css/main.css` (Bagian `[03]`, `[06]`, dan `[08]`) serta menghapus CSS lama `.konten-populer` dan `.ane-col-73` agar `0 dead CSS rules`.

## File yang Diubah
- `docs/PROGRESS.md`
- `docs/phases/phase-17-redesign-news-default-dan-kartu-berita.md`
- `inc/acf-json/field-groups.json`
- `tp/news/default.php`
- `tp/content-overlay.php`
- `tp/content-list.php`
- `css/main.css`
- `css/main.min.css`

## Checklist Verifikasi
- [x] `python3 bin/css-audit.py` -> `0 dead CSS rules`
- [x] `bash bin/security-scan.sh` -> Lolos
- [x] `bash bin/check-dist.sh` -> Lolos
- [x] PHPCS (`tp/news/default.php`, `tp/content-overlay.php`, `tp/content-list.php`) & PHPStan -> `0 errors`
