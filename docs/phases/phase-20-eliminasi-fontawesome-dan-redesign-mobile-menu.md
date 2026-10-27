# Fase 20 — Eliminasi Total FontAwesome ke Inline SVG & Redesign Mobile Bottom Bar (`#footer-bar`)

**Status:** Done
**Jenis:** Optimasi & Redesign (`inc/sekolahane.php`, `tp/mobile/menu-footer.php`, `footer.php`, `inc/acf-json/field-groups.json`, `css/main.css`)
**Mulai:** 2026-10-27
**Selesai:** 2026-10-27

## Tujuan
1. **Eliminasi Total FontAwesome 4.7 (`FontsAwsome` CDN):**
   - Menghapus pemuatan stylesheet eksternal `font-awesome.min.css` di `inc/sekolahane.php` agar performa mobile & desktop jauh lebih ringan dan bebas render-blocking font pihak ketiga.
   - Memigrasikan seluruh penggunaan icon `fa-*` di template PHP (`inc/sekolahane.php`, `tp/single.php`, `tp/single-video.php`, `tp/section/angka.php`, `tp/mobile/menu-lembaga.php`, `tp/mobile/kategori-menu.php`) serta 4 aturan pseudo-element `font-family: FontAwesome` di `css/main.css` menjadi **Inline SVG** (`sekolahane_icon()`) yang tajam dan konsisten.
   - Menambahkan dukungan kompatibilitas mundur pada `sekolahane_icon()` sehingga nilai icon lama berformat `fa-*` di database pelanggan otomatis dipetakan ke SVG yang sesuai.
   - Menambahkan filter `wp_kses_allowed_html` (`sekolahane_allow_svg_in_kses()`) agar fungsi yang di-escape dengan `wp_kses_post()` (seperti `ane_load_times_ago()` dan `ane_post_pagination()`) tetap mempertahankan elemen `<svg>` dan `<path>` secara aman.
2. **Standarisasi 5 Menu Default pada ACF `Mobile Footer Menu` (`acf-options-mobile-menu`):**
   - Mengatur repeater `ane_mobile_menu` (`group_618965e831bd4`) dengan `min: 5` dan `max: 5` sehingga 5 baris menu langsung terbuka secara otomatis saat admin membuka halaman pengaturan **Mobile Menu**.
   - Mengubah sub-field `ane_icon` menjadi pilihan dropdown (`select`) dengan 5 icon utama yang sudah dipetakan (`profile`, `news`, `home`, `ppdb`, `contact`) serta opsi tambahan (`prestasi`, `ekstra`, `galeri`, `calendar`) dan inisialisasi nilai default otomatis (`sekolahane_init_default_mobile_menu()`), sehingga pengguna cukup memilih/mengisi URL tujuan tanpa perlu mencari kode FontAwesome.
3. **Rombak Total Mobile Bottom Navigation Bar (`#footer-bar` di `tp/mobile/menu-footer.php`, `footer.php`, & `css/main.css` Bagian `[12]`):**
   - Memanggil `tp/mobile/menu-footer` di `footer.php` agar tampil konsisten di seluruh halaman pada layar mobile (`<= 767px`).
   - Merombak tampilan `#footer-bar` menjadi *modern native mobile app bottom navigation dock* dengan 5 menu utama (**Profile**, **News**, **Home** di tengah, **PPDB**, **Contact**).
   - Mendesain item tengah (**Home**) dengan *elevated floating button* yang sedikit menonjol ke atas (`overflow`) dan dibungkus efek *masked cutout ring* yang menyatu elegan dengan bilah navigasi bawah.

## Scope
- [x] `inc/sekolahane.php`: Hapus `wp_enqueue_style( 'FontsAwsome', ... )`, perluas `sekolahane_icon()` dengan mapping SVG lengkap + fallback legacy `fa-*`, tambahkan `sekolahane_allow_svg_in_kses()`, tambahkan `sekolahane_init_default_mobile_menu()`, dan ganti markup `<i class="fa ...">` di fungsi helper.
- [x] `tp/single.php`, `tp/single-video.php`, `tp/section/angka.php`, `tp/mobile/menu-lembaga.php`, `tp/mobile/kategori-menu.php`: Ganti `<i class="fa ...">` dengan `sekolahane_icon()`.
- [x] `inc/acf-json/field-groups.json`: Perbarui `group_618965e831bd4` (`min: 5, max: 5` & dropdown SVG icon) serta perbarui instruksi icon pada field group terkait.
- [x] `tp/mobile/menu-footer.php` & `footer.php`: Rombak struktur 5 menu mobile dock dengan tombol **Home** di tengah dan fallback cerdas.
- [x] `css/main.css` & `css/main.min.css`: Hapus seluruh referensi `FontAwesome` dan rombak blok `#footer-bar` di bagian `[12]` (`0 dead CSS rules`).
- [x] Verifikasi `composer lint`, `composer analyse`, `composer css:check`, `composer security:scan`, dan `composer dist:check`.

## Laporan Security Review (Langkah 4 SOP)

| # | Area | Status | Catatan |
|---|---|---|---|
| 1 | Output Escaping | **PASS** | Seluruh URL, target, dan judul pada `tp/mobile/menu-footer.php`, `tp/single.php`, `tp/single-video.php` di-escape dengan `esc_url()`, `esc_attr()`, dan `esc_html()`. |
| 2 | Safe Inline SVG (`wp_kses`) | **PASS** | `sekolahane_allow_svg_in_kses()` hanya mengizinkan tag `<svg>` dan `<path>` dengan atribut terukur (`class`, `xmlns`, `viewbox`, `fill`, `focusable`, `aria-hidden`, `width`, `height`, `d`). |
| 3 | Guard `ABSPATH` & Anti-Webshell | **PASS** | `bin/security-scan.sh` lolos tanpa pelanggaran. |

## Checklist Penutupan (SOP)
- [x] `python3 bin/css-audit.py` lolos (`0 dead CSS rules`)
- [x] `bash bin/security-scan.sh` lolos
- [x] `bash bin/check-dist.sh` lolos
- [x] PHPCS & PHPStan (`0 errors`) lolos
- [x] `docs/PROGRESS.md` diupdate ke `Done`
