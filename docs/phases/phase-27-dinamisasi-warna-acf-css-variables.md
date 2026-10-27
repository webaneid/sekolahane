# Fase 27 — Dinamisasi Warna Tema (`Warna Web`) via ACF Color Picker & CSS Custom Properties (`:root`)

**Status:** Done
**Jenis:** Fitur Admin ACF & Arsitektur CSS (`inc/sekolahane.php`, `inc/acf-json/field-groups.json`, `css/main.css`, `css/main.min.css`)
**Mulai:** 2026-10-27
**Selesai:** 2026-10-27

## Tujuan
Mengadopsi dan menyempurnakan sistem dinamisasi warna dari `modernnews` (`newsane`) ke dalam `sekolahane` sehingga admin dapat mengubah skema warna seluruh website melalui **Webane Settings → Warna Web (`admin.php?page=acf-options-warna-web`)**:
1. **Submenu Admin `Warna Web` (`acf-options-warna-web`) & 7 ACF Color Picker (`inc/acf-json/field-groups.json`):**
   - `ane-warna-utama`: Warna Utama / Primary Brand (Default `#c98b49`, RGB `201, 139, 73`)
   - `ane-warna-utama-2`: Warna Utama 2 / Gradasi Terang / Secondary (Default `#e7ad57`, RGB `231, 173, 87`)
   - `ane-warna-alternatif`: Warna Alternatif / Kontras (Default `#130c2f`, RGB `19, 12, 47`)
   - `ane-warna-gelap`: Warna Gelap / Header, Footer, Kartu Gelap & Heading (Default `#160e06`, RGB `22, 14, 6`)
   - `ane-warna-terang`: Warna Latar Terang / Soft Surface & Border (Default `#ede7db`, RGB `237, 231, 219`)
   - `ane-warna-text`: Warna Teks Paragraf (Default `#22262a`, RGB `34, 38, 42`)
   - `ane-warna-putih`: Warna Dasar Putih (Default `#ffffff`, RGB `255, 255, 255`)
2. **Generator CSS Variables Dinamis di `wp_head` (`inc/sekolahane.php`):**
   - Menambahkan fungsi `sekolahane_hex2rgb()` dan `sekolahane_render_dynamic_colors_css()` yang mencetak `<style id="ane-colors">:root { --ane-warna-*: ...; --ane-warna-*-rgb: ...; }</style>` dengan validasi `sanitize_hex_color()`.
3. **Konversi `css/main.css` & `css/main.min.css` ke Variabel `--ane-warna-*`:**
   - Mendefinisikan `:root` di bagian `[01]` `css/main.css` dan mengganti seluruh warna brand statis (`#c98b49`, `#e7ad57`, `#160e06`, `#130c2f`, `#ede7db`, `#22262a`, beserta nilai `rgba()` terkait) menjadi `var(--ane-warna-*)` dan `rgba(var(--ane-warna-*-rgb), alpha)`.

## Scope
- [x] `inc/sekolahane.php`: Tambahkan submenu `Warna Web` (`acf-options-warna-web`), fungsi `sekolahane_hex2rgb()`, dan `sekolahane_render_dynamic_colors_css()`.
- [x] `inc/acf-json/field-groups.json`: Tambahkan Field Group `group_sekolahane_warna_web` berisi 7 field `color_picker`.
- [x] `css/main.css` & `css/main.min.css`: Tambahkan blok `:root` dan konversi warna hardcoded ke CSS Custom Properties `--ane-warna-*` & `--ane-warna-*-rgb`.
- [x] Verifikasi `composer lint`, `composer analyse`, `composer css:check`, `composer security:scan`, dan `composer dist:check`.

## Security Review
| Item | Status | Keterangan |
|---|---|---|
| Sanitasi kode warna HEX | ✅ | Setiap nilai field `ane-warna-*` disanitasi menggunakan `sanitize_hex_color()` dan dikonversi RGB via `sekolahane_hex2rgb()` (`ctype_xdigit`) |
| Late escaping output (`esc_html`) | ✅ | Output `<style id="ane-colors">` di-escape dengan `esc_html()` |
| Auto-sync ACF JSON | ✅ | `group_sekolahane_warna_web` tersimpan di `inc/acf-json/field-groups.json` dan otomatis tersinkron ke DB |

## Checklist Penutupan SOP
- [x] `composer lint` (PHPCS) — Lolos `0 errors` pada `inc/sekolahane.php`
- [x] `composer analyse` (PHPStan) — Lolos `[OK] No errors`
- [x] `composer css:check` (`bin/css-audit.py`) — Lolos `0 dead CSS rules` (`css/main.min.css` 124.2 KB)
- [x] `composer security:scan` & `composer dist:check` — Lolos
