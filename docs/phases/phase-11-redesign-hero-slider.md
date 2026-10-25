# Fase 11 — Auto-Sync ACF JSON & Redesign Hero Slider (`tp/section/big-slider.php`)

**Status:** Done
**Jenis:** Fitur & Redesign UI (`feat(hero)`)
**Mulai:** 2026-10-25
**Selesai:** 2026-10-25

## Tujuan
1. Memastikan setiap perubahan/penambahan field di `inc/acf-json/field-groups.json` otomatis memperbarui skema Field Group ACF yang sudah terlanjur masuk di database WordPress (tanpa menghapus isi konten pelanggan).
2. Meredesign **Hero Slider (`tp/section/big-slider.php` & Bagian `[07]` `css/main.css`)** agar ringan, modern, dan super responsif (tampilan *app-like* di mobile), lengkap dengan pengaturan di halaman Edit Page (Template Home):
   - Pilihan posisi teks per slide: **Kiri (`left`)**, **Tengah (`center`)**, **Kanan (`right`)**.
   - Pilihan overlay background per slide: **Overlay Gelap (`dark`)** atau **Gambar Asli / Tanpa Overlay (`none`)**.
   - Teks (`Judul`, `Deskripsi`, `Tombol Link`) hanya di-render jika benar-benar diisi (jika semua dikosongkan, kotak teks tidak muncul sama sekali) dan di-sanitize/escape dengan aman.
   - Pengaturan untuk menampilkan atau menyembunyikan **Marking / Lengkungan Bawah Hero (`.pemanis-slider`)** di block Hero (secara default aktif/tampil).

## Scope
- [x] **Auto-Sync Database ACF Saat `inc/acf-json/field-groups.json` Berubah (`inc/acf-importer.php`):**
  - Tambahkan fungsi `sekolahane_maybe_sync_acf_json_on_change()` yang menghitung hash MD5 dari file JSON di `inc/acf-json/`.
  - Jika hash berubah dibanding `get_option( 'sekolahane_acf_json_hash' )` (mis. saat kita menambah field baru di masa redesign atau saat rilis update), otomatis jalankan `sekolahane_import_acf_json_groups( true )` untuk meng-update Field Group di database secara *in-place*.
- [x] **Update Skema ACF `home_box_slider` di `inc/acf-json/field-groups.json`:**
  - Ubah layout repeater `home_slider` dari `table` menjadi `block` agar nyaman diedit.
  - Tambah subfield `ane_text_align` (`Posisi Teks`: `left` Kiri, `center` Tengah, `right` Kanan; default `left`).
  - Tambah subfield `ane_overlay` (`Overlay Background`: `dark` Overlay Gelap, `none` Asli / Tanpa Overlay; default `dark`).
  - Tambah subfield level block `ane_slider_curve` (`Tampilkan Marking Lengkungan Bawah`: `true_false`, default `1` / Tampil).
- [x] **Refactor Markup `tp/section/big-slider.php`:**
  - Sanitize & trim `ane_title`, `ane_deskripsi`, dan `ane_link`.
  - Hanya render blok `.text` jika minimal salah satu dari judul, deskripsi, atau link diisi.
  - Ganti `<a href="..."><button class="btn">...</button></a>` (HTML tidak valid) menjadi `<a href="..." class="btn btn-primary">...</a>`.
  - Terapkan class posisi teks (`text-pos-left`, `text-pos-center`, `text-pos-right`), class overlay (`has-overlay`, `no-overlay`), dan kondisi render `.pemanis-slider`.
- [x] **Redesign CSS Bagian `[07]` (`.home-slider`) di `css/main.css` & Compile `css/main.min.css`:**
  - Ganti langsung blok `.home-slider` di Bagian `[07]` (hapus `display: table` dan `float: right` lama, ganti dengan Flexbox modern, `clamp()` typography, dukungan 3 posisi teks, overlay gradasi halus, dan tampilan mobile *app-like*).
  - Pastikan `composer css:check` lolos (`0 dead CSS rules`).

## Di Luar Scope
- Mengubah section lain di luar Hero Slider (akan dikerjakan bertahap per section).

## Referensi
- `inc/acf-importer.php`
- `inc/acf-json/field-groups.json`
- `tp/section/big-slider.php`
- `css/main.css` (Bagian `[07]`), `css/main.min.css`

## Keputusan Kecil Selama Eksekusi
- Menyimpan hash MD5 JSON di option `sekolahane_acf_json_hash` agar sinkronisasi otomatis ke database hanya berjalan 1 kali setiap kali file `inc/acf-json/field-groups.json` berubah (mematuhi aturan "tidak ada tulis ke DB di setiap request").
- Menggunakan array map eksplisit untuk class `text-pos-left`, `text-pos-center`, `text-pos-right` di `tp/section/big-slider.php` agar tervalidasi langsung oleh static CSS audit (`bin/css-audit.py`).

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
- **Auto-Sync ACF JSON ke Database (`inc/acf-importer.php`):** Menambahkan mekanisme pengecekan hash MD5 (`sekolahane_get_bundled_acf_hash()` & `sekolahane_maybe_sync_acf_json_on_change()` pada hook `acf/init`). Setiap kali `inc/acf-json/field-groups.json` diperbarui, database `acf-field-group` otomatis disinkronkan secara *in-place* tanpa menghapus konten yang sudah diisi pelanggan.
- **Redesign Hero Slider (`tp/section/big-slider.php`, `inc/acf-json/field-groups.json`, `css/main.css`):**
  - Menambahkan opsi **Posisi Teks** (`Kiri`, `Tengah`, `Kanan`), **Overlay Background** (`Overlay Gelap` dengan gradasi yang menyesuaikan arah teks, atau `Asli (Tanpa Overlay)`), serta toggle **Tampilkan Marking Lengkungan Bawah (`.pemanis-slider`)** yang aktif secara default.
  - Teks (`ane_title`, `ane_deskripsi`, `ane_link`) dibersihkan dengan `wp_strip_all_tags()` + `trim()` dan di-escape saat output (`esc_html()`, `esc_url()`, `esc_attr()`). Jika ketiganya kosong, elemen `.container > .text` tidak di-render sama sekali.
  - Tampilan mobile dibuat super responsif dan *app-like* (proporsi tinggi adaptif, tipografi `clamp()`, tombol *pill* nyaman disentuh, dan lengkungan bawah proporsional).
