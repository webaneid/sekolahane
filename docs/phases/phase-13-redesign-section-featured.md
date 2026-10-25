# Fase 13 — Redesign Fitur Sekolah (`tp/section/featured.php`) dengan Pilihan Posisi & Gaya Desain

**Status:** Done
**Jenis:** Fitur & Redesign UI (`feat(featured)`)
**Mulai:** 2026-10-26
**Selesai:** 2026-10-26

## Tujuan
Meredesign section **Fitur Sekolah (`.section-featured`, `tp/section/featured.php` & Bagian `[07]` `css/main.css`)** dengan 2 pengaturan fleksibel (menghasilkan 4 kombinasi tampilan):
1. **Posisi terhadap Hero (`ane_featured_position`):**
   - `overlap` → **Menempel di Hero** (default, kartu naik di atas bagian bawah Hero dengan efek *Morphic Glass*).
   - `below` → **Di Bawah Hero** (terpisah di bawah Hero di atas background terang dengan border tipis cantik).
2. **Gaya Desain (`ane_featured_style`):**
   - `default` → **Default (Icon di Atas, Teks Tengah, Kartu ke-1 Highlight Emas)**:
     - Saat `overlap`: Kartu ke-1 gradasi warna utama, kartu ke-2 dst *Morphic Glass*.
     - Saat `below`: Kartu ke-1 gradasi warna utama, kartu ke-2 dst background putih dengan border tipis cantik.
   - `flat` → **Flat Design (Icon Kecil di Kiri dengan Background Warna Utama, Teks Rata Kiri)**:
     - Saat `overlap`: Semua kartu memakai background *Morphic Glass* (`backdrop-filter: blur(16px)` + border kaca putih), icon di sebelah kiri dalam badge kecil warna utama (`#c98b49`, icon putih), teks di kanan rata kiri.
     - Saat `below`: Semua kartu background putih bersih dengan border tipis cantik, icon di sebelah kiri dalam badge kecil warna utama (`#c98b49`, icon putih), teks di kanan rata kiri.
3. Memperbaiki bug nested `<a>` di dalam `<a>` pada `tp/section/featured.php`, memastikan sanitasi/escaping penuh, serta memastikan tampilan mobile super responsif dan `0 dead CSS rules`.

## Scope
- [x] **Update Skema ACF `home_featured` di `inc/acf-json/field-groups.json`**:
  - Tambahkan field `ane_featured_position` (`overlap` Menempel di Hero, `below` Di Bawah Hero; default `overlap`) dan `ane_featured_style` (`default` Default, `flat` Flat Design; default `default`) pada layout `home_featured` di Template Home (`group_5dbeefc248e7f`) dan Template Profil Lembaga (`group_628554343579d`).
- [x] **Refactor Markup `tp/section/featured.php`**:
  - Baca `ane_featured_position` dan `ane_featured_style` dengan whitelist map eksplisit (`featured-pos-overlap`, `featured-pos-below`, `featured-style-default`, `featured-style-flat`).
  - Hapus nested `<a>` di dalam `<a>` (HTML tidak valid).
  - Sanitize & escape seluruh output (`ane_icon`, `ane_title`, `ane_deskripsi`, `ane_link`).
- [x] **Redesign CSS `.section-featured` di Bagian `[07]` `css/main.css` & Compile `css/main.min.css`**:
  - Ganti langsung blok `.section-featured` di Bagian `[07]` untuk mendukung ke-4 kombinasi (`overlap + default`, `below + default`, `overlap + flat`, `below + flat`) serta tampilan mobile responsif.
  - Pastikan `composer css:check` lolos (`0 dead CSS rules`).

## Di Luar Scope
- Section lain di luar `tp/section/featured.php`.

## Referensi
- `tp/section/featured.php`
- `inc/acf-json/field-groups.json`
- `css/main.css` (Bagian `[07]`), `css/main.min.css`

## Keputusan Kecil Selama Eksekusi
- Menggunakan array map eksplisit untuk class `featured-pos-overlap`, `featured-pos-below`, `featured-style-default`, `featured-style-flat` agar tervalidasi 100% oleh `bin/css-audit.py`.

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
- **Opsi Posisi & Gaya Desain di Block Fitur Sekolah (`inc/acf-json/field-groups.json`):** Menambahkan 2 tombol pilihan di atas repeater `ane_featured` pada Template Home & Template Profil Lembaga: **Posisi terhadap Hero** (`Menempel di Hero` / `Di Bawah Hero`) dan **Gaya Desain Fitur** (`Default` / `Flat Design`).
- **Markup Bersih & Aman (`tp/section/featured.php`):** Menghapus nested `<a>` di dalam `<a>` yang tidak valid, men-sanitize teks (`wp_strip_all_tags` + `trim`), dan meng-escape semua output (`esc_url`, `esc_attr`, `esc_html`).
- **4 Variasi Visual & Morphic Glass (`css/main.css` Bagian `[07]`):**
  - `overlap + default`: Kartu ke-1 gradasi warna utama, kartu ke-2 dst *Morphic Glass* (`backdrop-filter: blur(14px)`).
  - `below + default`: Terpisah di bawah Hero, kartu ke-1 gradasi warna utama, kartu ke-2 dst putih dengan border tipis cantik (`rgba(201, 139, 73, 0.24)`).
  - `overlap + flat`: Menempel di Hero dengan background *Morphic Glass* (`backdrop-filter: blur(16px)`), icon kecil di sebelah kiri dalam badge warna utama, dan seluruh teks rata kiri.
  - `below + flat`: Terpisah di bawah Hero dengan kartu putih berborder tipis, icon kecil di sebelah kiri dalam badge warna utama, dan seluruh teks rata kiri.
