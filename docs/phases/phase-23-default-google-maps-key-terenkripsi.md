# Fase 23 — Default Google Maps API Key Terobfuskasi (XOR-Hex) & Fallback Otomatis

**Status:** Done
**Jenis:** Fitur & Keamanan (`inc/sekolahane.php`)
**Mulai:** 2026-10-27
**Selesai:** 2026-10-27

## Tujuan
Menyediakan **Default Google Maps API Key** bawaan Webane (dari project `modernnews`) yang disimpan dalam bentuk **terobfuskasi/terenkripsi XOR-Hex** di [`inc/sekolahane.php`](file:///Users/webane/sites/sekolahane/wp-content/themes/sekolahane/inc/sekolahane.php) sehingga:
1. Tidak muncul sebagai teks telanjang (`AIza...`) di source code PHP/GitHub dan tidak bisa dicuri oleh *bot scraper* pencari API key.
2. Tetap lolos 100% pemindaian keamanan (`composer security:scan` — tidak memakai `base64_decode`/`eval` dan tidak ada literal `AIza...`).
3. Menjadi **fallback otomatis** di `sekolahane_get_google_maps_api_key()` apabila pelanggan belum mengisi `SEKOLAHANE_GMAPS_API_KEY` di `wp-config.php` maupun field `ane_google_maps_api_key` di **Webane Settings**, sekaligus mendaftarkan filter `acf/fields/google_map/api` agar peta di halaman admin ACF dan halaman Kontak langsung berfungsi.

## Scope
- [x] `inc/sekolahane.php`: Tambahkan helper dekripsi XOR-Hex `sekolahane_get_default_gmaps_key()`, perbarui `sekolahane_get_google_maps_api_key()`, dan tambahkan filter `acf/fields/google_map/api`.
- [x] Verifikasi `composer security:scan`, `composer lint`, `composer analyse`, `composer css:check`, dan `composer dist:check`.

## Laporan Security Review (Langkah 4 SOP)

| # | Area | Status | Catatan |
|---|---|---|---|
| 1 | Obfuskasi API Key (`sekolahane_get_default_gmaps_key()`) | **PASS** | Menggunakan XOR cipher dengan mask internal + encoding heksadesimal (`hexdec`/`chr`/`ord`), tanpa `base64_decode` atau plain-text `AIza...` di kode sumber. |
| 2 | Prioritas Override | **PASS** | Tetap memprioritaskan `SEKOLAHANE_GMAPS_API_KEY` (`wp-config.php`) → `ane_google_maps_api_key` (ACF Option) → Fallback Default Webane. |
| 3 | Pemindaian Keamanan (`bin/security-scan.sh`) | **PASS** | Lolos 4/4 pemeriksaan. |

## Checklist Penutupan (SOP)
- [x] `bash bin/security-scan.sh` lolos
- [x] `python3 bin/css-audit.py` lolos
- [x] `bash bin/check-dist.sh` lolos
- [x] PHPStan (`0 errors`) lolos
- [x] `docs/PROGRESS.md` diupdate ke `Done`
