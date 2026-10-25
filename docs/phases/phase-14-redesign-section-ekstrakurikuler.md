# Fase 14 — Redesign Section & Kartu Ekstrakurikuler (`tp/section/ekstra.php`, `tp/content-ekstrakurikuler.php`)

**Status:** Done
**Jenis:** Fitur & Redesign UI (`feat(ekstrakurikuler)`)
**Mulai:** 2026-10-26
**Selesai:** 2026-10-26

## Tujuan
Meredesign total section **Ekstrakurikuler (`.home-ekstrakurikuler`)** beserta kartu itemnya (`tp/content-ekstrakurikuler.php`) agar tampil modern, bersih, proporsional, dan *app-like* di mobile, serta menambahkan tombol **"Semua Ekstrakurikuler"** yang mengarah langsung ke halaman arsip ekstrakurikuler (`get_post_type_archive_link( 'ekstrakurikuler' )`).

## Masalah Desain Lama
1. `tp/content-ekstrakurikuler.php` memakai `<header class="entry-header">` yang **tidak pernah ditutup (`</header>` hilang)** sehingga merusak struktur DOM.
2. Desain kartu hanya kotak gambar kaku dengan teks judul di tengah bawah tanpa interaksi visual atau penanda aksi.
3. Jarak judul section `.home-title` terlalu jauh (`margin-bottom: 80px`), dan di mobile deskripsi disembunyikan begitu saja.
4. Tidak ada tombol/link untuk melihat seluruh daftar ekstrakurikuler (`archive-ekstrakurikuler.php`).

## Konsep UI Baru
1. **Header Section Modern (`.home-ekstrakurikuler`):**
   - Judul & deskripsi di kiri, dan tombol *pill* **"Semua Ekstrakurikuler"** (dengan ikon panah SVG) di kanan yang mengarah ke `get_post_type_archive_link( 'ekstrakurikuler' )`.
2. **Kartu Ekstrakurikuler Baru (`tp/content-ekstrakurikuler.php` — `.ane-ekstra-card`):**
   - Seluruh permukaan kartu bisa diklik (`<a class="ane-ekstra-link">`) dengan sudut membulat lembut (`border-radius: 16px`) dan efek *zoom* halus pada foto saat di-hover.
   - Menggunakan layer foto (`<div class="ane-ekstra-thumb">`) terpisah sehingga animasi zoom bekerja mulus, dilengkapi gradasi halus di bagian bawah.
   - Panel konten bawah berupa **Floating Glass Pill / Bar** (`backdrop-filter: blur(12px)`) yang menampilkan nama ekstrakurikuler di kiri dan tombol bulat ikon panah (`chevron-right`) di kanan yang berubah warna saat di-hover.
   - Ikut memperbarui tampilan kartu di halaman **Arsip Ekstrakurikuler (`archive-ekstrakurikuler.php`)** karena sama-sama memanggil `tp/content-ekstrakurikuler.php`.

## Scope
- [x] **Refactor `tp/content-ekstrakurikuler.php`**:
  - Perbaiki bug tag `<header>` yang tidak ditutup, ganti dengan struktur kartu modern `.ane-ekstra-card` yang membungkus link utuh, layer foto `.ane-ekstra-thumb`, judul `.post-title`, dan badge ikon panah `.ane-ekstra-arrow`.
- [x] **Redesign `tp/section/ekstra.php`**:
  - Rapikan struktur header section dan tambahkan tombol **Semua Ekstrakurikuler** (`get_post_type_archive_link( 'ekstrakurikuler' )`).
- [x] **Redesign CSS `.home-ekstrakurikuler` & `.ane-ekstra-card` di Bagian `[06]` `css/main.css` & Compile `css/main.min.css`**:
  - Ganti langsung CSS `.home-ekstrakurikuler` di Bagian `[06]` dan tambahkan styling `.ane-ekstra-card`.
  - Pastikan `composer css:check` lolos (`0 dead CSS rules`).

## Di Luar Scope
- Section lain di luar Ekstrakurikuler.

## Referensi
- `tp/section/ekstra.php`
- `tp/content-ekstrakurikuler.php`
- `css/main.css` (Bagian `[06]`), `css/main.min.css`

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
- **UI Baru Section Ekstrakurikuler (`tp/section/ekstra.php`):** Header section kini menggunakan Flexbox dengan judul + deskripsi di kiri dan tombol *pill* **"Semua Ekstrakurikuler"** di kanan (mengarah ke `get_post_type_archive_link( 'ekstrakurikuler' )`).
- **UI Baru Kartu Ekstrakurikuler (`tp/content-ekstrakurikuler.php` & `css/main.css` Bagian `[06]`):**
  - Memperbaiki bug `<header>` yang tidak pernah ditutup di versi lama.
  - Seluruh kartu (`.ane-ekstra-card`) dapat diklik penuh, memiliki foto dengan animasi *smooth zoom* saat di-hover, serta *Floating Glass Bar* (`.ane-ekstra-body`) di bagian bawah berisi judul ekstrakurikuler dan ikon panah bulat (`.ane-ekstra-arrow`).
