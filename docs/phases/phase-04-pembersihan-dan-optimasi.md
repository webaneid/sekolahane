# Fase 04 — Pembersihan (`wp_is_mobile`, Hapus Fungsi/File Ganda, Text Domain, & Optimasi)

**Status:** Done
**Jenis:** Standar (pembersihan dead code, penghapusan library lawas `Mobile_Detect`, konsolidasi fungsi ganda, penyeragaman text domain)
**Mulai:** 2026-10-23
**Selesai:** 2026-10-23

## Tujuan
Meringankan dan merapikan codebase `sekolahane` dengan mengganti library eksternal `Mobile_Detect` (1.475 baris) ke fungsi bawaan WordPress `wp_is_mobile()`, menghapus fungsi dan file duplikat yang memiliki tujuan sama, menyeragamkan seluruh text domain ke `'sekolahane'`, serta membersihkan pemanggilan query/template yang menggantung.

## Scope
- [x] **Hapus `Mobile_Detect` & Ganti dengan `wp_is_mobile()` (`GAP-19`):**
  - Ganti seluruh instansiasi `new Mobile_Detect()` dan pengecekan `$detect->isMobile()` / `$detect->isTablet()` di `index.php`, `archive.php`, `category.php`, `tag.php`, `author.php`, `search.php`, `page-home.php`, `page-newslist.php`, dan `inc/widgets.php` menjadi `wp_is_mobile()`.
  - Hapus `inc/Mobile_Detect.php`, hapus `require` di `functions.php`, dan bersihkan pengecualian `inc/Mobile_Detect.php` di `phpcs.xml.dist` serta `phpstan.neon.dist`.
- [x] **Hapus Fungsi Ganda & File Duplikat/Mati (`GAP-13`, `GAP-18`):**
  - Konsolidasikan fungsi dummy thumbnail ganda (`ane_dummy_tumbnail()` vs `sekolahane_dummy_tumbnail()`) di `inc/sekolahane.php` menjadi satu fungsi `sekolahane_dummy_tumbnail()`, dan arahkan `tp/content-page.php`, `tp/pages/profil.php`, `tp/pages/kelembagaan.php` ke `sekolahane_dummy_tumbnail()`.
  - Hapus file PHP duplikat/tidak terpakai (total 13 file PHP dihapus):
    - `inc/Mobile_Detect.php` (digantikan `wp_is_mobile()`)
    - `inc/post-view.php` (duplikat dari post views di `inc/sekolahane.php`)
    - `inc/option.php` (duplikat dari ACF option di `inc/sekolahane.php`)
    - `inc/related.php` (duplikat dari `ane_related_post()`)
    - `inc/single-iklan.php`, `inc/customizer.php`, `inc/color.php` (kode warisan `kabarane` yang tidak di-require)
    - `breadcrumbs.php` (duplikat dari `panggil_breadcrumb()`)
    - `tp/page-contact.php` (duplikat dari `tp/content-page-kontak.php`)
    - `tp/home-categories.php`, `tp/content-sliders.php`, `tp/mobile/landinpage.php`, `tp/mobile/landingpage-menu.php`, `tp/mobile/home.php` (template part warisan yang tidak pernah dipanggil)
  - Hapus file JS tidak terpakai di `js/` (`GAP-18`): `js/anekabar.js`, `js/bootstrap.min.js`, `js/gmap.js`, `js/plugins.js`.
- [x] **Bersihkan Referensi Template Tidak Ada & `wp_reset_query()` (`GAP-09`, `GAP-17`):**
  - Hapus panggilan `get_template_part('tp/home','client')` di `tp/section/testimoni.php`, serta `get_template_part('tp/news', 'featured-mobile')` dan `get_template_part('tp/mobile','news-populer')` di `tp/mobile/kategori.php` (file tidak pernah ada).
  - Seluruh `WP_Query` kini konsisten menggunakan `wp_reset_postdata()`.
- [x] **Seragamkan Text Domain ke `'sekolahane'` (`GAP-15`):**
  - Ubah seluruh text domain warisan (`anekabar`, `kabarane`, `anelogistik`, `rentcarane`, `roots`, `twentysixteen`, `webane-master`, `webane`, `musi`) menjadi `'sekolahane'`.

## Di Luar Scope
- Perubahan nama field ACF di database pelanggan (`GAP-20`).

## Referensi
- `docs/RETROFIT-GAPS.md` (`GAP-13`, `GAP-15`, `GAP-17`, `GAP-18`, `GAP-19`)
- `AGENTS.md`

## Keputusan Kecil Selama Eksekusi
- Deteksi perangkat mobile menggunakan fungsi inti WordPress `wp_is_mobile()` sehingga theme tidak lagi memuat class `Mobile_Detect` (hemat ~83 KB / 1.475 baris kode PHP di setiap request).
- Fungsi ganda dengan tujuan sama (`ane_dummy_tumbnail()` vs `sekolahane_dummy_tumbnail()`) disatukan ke `sekolahane_dummy_tumbnail()`.

## Laporan Security Review (Langkah 4 SOP)

| # | Area | Status | Catatan |
|---|---|---|---|
| 1 | Output Escaping | **PASS** | `tp/content-page-kontak.php`, `tp/content-page.php`, `tp/pages/profil.php`, `tp/pages/kelembagaan.php`, dan `tp/single-ekstrakurikuler.php` telah di-escape penuh (`esc_url`, `esc_attr`, `esc_html`, `wp_kses_post`). |
| 2 | Permukaan Serangan (Attack Surface Reduction) | **PASS** | Menghapus 13 file PHP dan 4 file JS warisan yang tidak terpakai mengurangi permukaan serangan (attack surface) secara signifikan. |
| 3 | Guard `ABSPATH` & Anti-Webshell | **PASS** | `composer security:scan` lolos pada seluruh 71 file PHP aktif. |

## Checklist Penutupan (SOP)
- [x] `composer security:scan` lolos
- [x] `composer lint:syntax` lolos
- [x] `composer analyse` lolos (0 error tanpa baseline)
- [x] `composer dist:check` lolos
- [x] Security Review dijalankan & dilaporkan
- [x] `PROGRESS.md` & `RETROFIT-GAPS.md` diupdate

## Known Limitations
- Skema field group utama ACF (Landing Page, Profil, General Settings lama) masih tersimpan di DB situs pelanggan (`GAP-20`); penambahan field baru oleh kode theme (`inc/updater.php` dan `inc/sekolahane.php`) sudah dilakukan secara terprogram via `acf_add_local_field_group()`.

## Ringkasan Hasil
- Mengganti `Mobile_Detect` dengan `wp_is_mobile()` di seluruh template dan menghapus `inc/Mobile_Detect.php`.
- Menghapus fungsi ganda (`ane_dummy_tumbnail`), 13 file PHP duplikat/mati, dan 4 file JS tidak terpakai.
- Menyeragamkan 100% text domain di seluruh codebase ke `'sekolahane'`.
