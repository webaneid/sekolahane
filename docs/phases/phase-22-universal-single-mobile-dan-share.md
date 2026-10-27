# Fase 22 — Universal Single Mobile App-Style & Redesign Social Share (+ Copy URL)

**Status:** Done
**Jenis:** Redesign & Optimasi Performa Mobile (`tp/mobile/single-universal.php`, `single.php`, `page.php`, `single-ekstrakurikuler.php`, `single-guru.php`, `tp/single.php`, `tp/single-video.php`, `inc/sekolahane.php`, `js/sekolahane.js`, `css/main.css`)
**Mulai:** 2026-10-27
**Selesai:** 2026-10-27

## Tujuan
1. **Universal Single Mobile App-Style (`tp/mobile/single-universal.php`):**
   - Menyediakan 1 template universal super ringan untuk layar mobile (`wp_is_mobile()`) yang berlaku pada seluruh single post (`single.php`), halaman default (`page.php`), ekstrakurikuler (`single-ekstrakurikuler.php`), dan profil guru (`single-guru.php`).
   - Urutan tampilan layaknya aplikasi mobile modern:
     1. **Header Mobile** di bagian atas.
     2. **Featured Image / Media (`.msingle-media`)** dengan `padding-left: 15px`, `padding-right: 15px`, dan `border-radius: 18px` yang konsisten dan elegan.
     3. **Kategori / Label Badge & Judul Utama (`<h1 class="msingle-title">`)**.
     4. **Meta Info / Deskripsi Kontekstual (`.msingle-meta`)** (Tanggal & Views untuk Post; Jabatan, Pelajaran & Kelas untuk Guru; Tanggal pembaruan untuk Page & Ekstrakurikuler).
     5. **Konten Utama (`.msingle-body.ane-content`)** yang bersih tanpa beban script SDK komentar Facebook di mobile.
     6. **Bagian Bawah: Modern Share Bar + Tombol Salin Tautan (Copy URL)** diikuti konten terkait yang ringkas.
2. **Redesign Total Social Share (`fungsi_share_webane()` di `inc/sekolahane.php` & `.share-this` di `css/main.css`):**
   - Menghapus widget `<div class="fb-like">` yang lambat dan merusak tampilan mobile, diganti dengan tautan langsung **Facebook Share** (`https://www.facebook.com/sharer/sharer.php?u=...`) berikon SVG `facebook`.
   - Menyediakan 5 tombol berbagi modern dengan Inline SVG: **WhatsApp**, **Facebook**, **X / Twitter**, **LinkedIn**, dan tombol interaktif **Salin Link (Copy URL)** dengan feedback visual `"Tersalin!"` (`is-copied`).
   - Memindahkan posisi `.share-this` di desktop (`tp/single.php` & `tp/single-video.php`) ke bagian bawah konten agar konsisten dengan mobile.

## Scope
- [x] `inc/sekolahane.php`: Tambahkan icon SVG `link` & `check` di `sekolahane_icon()` dan rombak `fungsi_share_webane()`.
- [x] `tp/mobile/single-universal.php`: Buat template universal single untuk mobile (`post`, `page`, `ekstrakurikuler`, `guru`).
- [x] `single.php`, `page.php`, `single-ekstrakurikuler.php`, `single-guru.php`: Gunakan `tp/mobile/single-universal` ketika `wp_is_mobile()`.
- [x] `tp/single.php` & `tp/single-video.php`: Pindahkan `.share-this` ke bagian bawah artikel.
- [x] `js/sekolahane.js`: Tambahkan handler klik tombol `.share-copy` (Clipboard API + fallback + state `is-copied`).
- [x] `css/main.css` & `css/main.min.css`: Rombak `.share-this` di bagian `[03]` dan tambahkan styling `.ane-mobile-single` di bagian `[08]` (`0 dead CSS rules`).
- [x] Verifikasi `composer lint`, `composer analyse`, `composer css:check`, `composer security:scan`, dan `composer dist:check`.

## Laporan Security Review (Langkah 4 SOP)

| # | Area | Status | Catatan |
|---|---|---|---|
| 1 | Output Escaping (`tp/mobile/single-universal.php`) | **PASS** | Seluruh output variabel (`$sekolahane_img_url`, `$sekolahane_jabatan`, term link/name, tag list, date, views) di-escape penuh dengan `esc_url()`, `esc_attr()`, `esc_html()`, dan `wp_kses_post()`. |
| 2 | Social Share Links (`fungsi_share_webane()`) | **PASS** | Parameter query di-encode dengan `rawurlencode()` dan atribut `href` serta `data-url` di-escape dengan `esc_url()`. |
| 3 | Guard `ABSPATH` & Anti-Webshell | **PASS** | `bash bin/security-scan.sh` lolos pada seluruh file PHP. |

## Checklist Penutupan (SOP)
- [x] `python3 bin/css-audit.py` lolos (`0 dead CSS rules`)
- [x] `bash bin/security-scan.sh` lolos
- [x] `bash bin/check-dist.sh` lolos
- [x] PHPCS (`0 errors`) & PHPStan (`0 errors`) lolos
- [x] `docs/PROGRESS.md` diupdate ke `Done`
