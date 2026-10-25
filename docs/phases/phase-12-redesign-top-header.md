# Fase 12 — Redesign Top Header & Navigasi (`header.php`)

**Status:** Done
**Jenis:** Fitur & Redesign UI (`feat(header)`)
**Mulai:** 2026-10-25
**Selesai:** 2026-10-25

## Tujuan
Meredesign **Top Header (`.ane-header .atas`)** dan **Header Utama (`.ane-header`)** agar jauh lebih informatif, bersih, dan fungsional untuk website sekolah:
1. Menghapus deretan ikon sosial media dari Top Header (sosial media tetap ada di Footer).
2. Menampilkan **Tanggal Hari Ini** (otomatis dalam format lokal WordPress `wp_date( 'l, j F Y' )` lengkap dengan ikon kalender SVG) pada sisi kiri Top Header agar tidak pernah kosong.
3. Menampilkan **Tombol/Link Nomor WhatsApp** di sisi kanan Top Header yang otomatis mengambil nomor tersimpan dari pengaturan (`sosmed_ane -> sosmed_wa` dengan fallback `contact_ane -> kontak_handphone`).
4. Menampilkan **Tombol Link Pendaftaran / PPDB (`ane_link_header`)** di sisi kanan Top Header (serta memperjelas label & instruksi field `ane_link_header` di `inc/acf-json/field-groups.json` untuk link pendaftaran/PPDB).
5. Merapikan CSS Bagian `[05]` (`css/main.css`) secara langsung dan memastikan `0 dead CSS rules`.

## Scope
- [x] **Tambah Icon `calendar` di `sekolahane_icon()` (`inc/sekolahane.php`)**:
  - Tambahkan path SVG `calendar` untuk mendampingi tanggal di Top Header.
- [x] **Perjelas Skema ACF `Top Header Link` (`group_5e3f0c06ee00f`) di `inc/acf-json/field-groups.json`**:
  - Perbarui label & instruksi `ane_link_header` menjadi **"Link Pendaftaran / Tombol Aksi Top Header (PPDB)"** dengan tetap mempertahankan nama field `ane_link_header` (kompatibilitas mundur 100%).
- [x] **Redesign Markup Top Header di `header.php`**:
  - Sisi Kiri (`.kiri`): Tampilkan tanggal hari ini (`wp_date( 'l, j F Y' )`) dengan ikon `calendar`.
  - Sisi Kanan (`.kanan`): Ambil nomor WhatsApp tersimpan (`sosmed_wa` dari `sosmed_ane`, fallback ke `kontak_handphone` dari `contact_ane`) dan tampilkan link klik WA (`.ane-top-wa`) + tombol utama `ane_link_header` (`.ane-topbutton` untuk Pendaftaran/PPDB).
  - Hapus pemanggilan `get_template_part( 'tp/content', 'sosmed' )` dari Top Header.
- [x] **Redesign CSS Bagian `[05]` (`.ane-header`) di `css/main.css` & Compile `css/main.min.css`**:
  - Ganti langsung styling `.ane-header .atas` dan `.ane-header .bawah` agar proporsional, modern, dan rapi.
  - Pastikan `composer css:check` lolos (`0 dead CSS rules`).

## Di Luar Scope
- Mengubah struktur menu mobile bawah (`tp/mobile/menu-footer.php`).

## Referensi
- `header.php`
- `inc/sekolahane.php`
- `inc/acf-json/field-groups.json`
- `css/main.css` (Bagian `[05]`), `css/main.min.css`

## Keputusan Kecil Selama Eksekusi
- Tetap menggunakan field name `ane_link_header` yang sudah ada di DB agar situs sekolah yang sudah mengisi link tombol tidak kehilangan datanya, sembari memperjelas label dan instruksi di ACF JSON menjadi Link Pendaftaran / PPDB.
- Mengambil nomor WhatsApp secara otomatis dari `sosmed_ane['sosmed_wa']` (dan jika kosong, fallback ke `contact_ane['kontak_handphone']`), serta menormalisasi awalan `08...` menjadi `628...` untuk tautan `https://wa.me/`.

## Checklist Penutupan (SOP)
- [x] `composer security:scan` lolos
- [x] `composer lint:changed` lolos (0 error/warning PHPCS)
- [x] `composer analyse` lolos (0 error PHPStan)
- [x] `composer css:check` lolos (0 dead CSS rules)
- [x] `composer dist:check` lolos
- [x] Security Review dijalankan & dilaporkan
- [x] `PROGRESS.md` diupdate

## Known Limitations
- Tidak ada.

## Ringkasan Hasil
- **Top Header Lebih Informatif & Fungsional (`header.php`):**
  - Sisi Kiri (`.kiri`): Menampilkan tanggal hari ini secara otomatis sesuai bahasa situs (`wp_date( 'l, j F Y' )`) didampingi inline SVG `sekolahane_icon( 'calendar' )`.
  - Sisi Kanan (`.kanan`): Menghapus deretan sosial media dan menggantinya dengan tombol WhatsApp cepat (`.ane-top-wa`, otomatis diambil dari nomor WA yang tersimpan di `sosmed_ane` / `contact_ane`) serta tombol Pendaftaran / PPDB (`.ane-topbutton`, dari `ane_link_header`).
- **Auto-Sync ACF JSON (`inc/acf-json/field-groups.json`):** Memperjelas judul grup & instruksi `ane_link_header` menjadi **Pengaturan Tombol Pendaftaran / Top Header**.
- **CSS Modern & Bersih (`css/main.css` Bagian `[05]`):** Mengganti langsung CSS `.ane-header .atas` dengan Flexbox modern, pill button transparan untuk WA, dan tombol kontras untuk Pendaftaran (`0 dead CSS rules`).
