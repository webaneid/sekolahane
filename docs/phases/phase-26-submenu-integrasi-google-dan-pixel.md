# Fase 26 — Submenu Admin "Google & Tracking" (GTM, GA4, Search Console, Meta/FB Pixel, & TikTok Pixel)

**Status:** Done
**Jenis:** Fitur Admin ACF & Integrasi Tracking (`inc/sekolahane.php`, `inc/seo.php`, `header.php`, `inc/acf-json/field-groups.json`)
**Mulai:** 2026-10-27
**Selesai:** 2026-10-27

## Tujuan
Menambahkan submenu khusus **Google & Tracking** (`admin.php?page=acf-options-google-tracking`) di bawah menu **Webane Settings** untuk memudahkan integrasi layanan Google dan Pixel iklan tanpa perlu menyentuh kode atau menginstal plugin tambahan:
1. **Tab 1 — Integrasi Google (Search Console, Tag Manager, Analytics):**
   - **Google Search Console Verification (`sekolahane_gsc_verification`):** Mendukung input kode verifikasi langsung maupun copy-paste tag `<meta name="google-site-verification" ...>` penuh (otomatis diekstrak kodenya via `sekolahane_extract_verification_token()`).
   - **Google Tag Manager Container ID (`sekolahane_gtm_id`):** Cukup isi `GTM-XXXXXXX`, otomatis merender script GTM di `<head>` (`sekolahane_render_tracking_head()`) serta `<noscript><iframe>` tepat setelah `<body>` (`wp_body_open` / `sekolahane_render_tracking_body_open()`).
   - **Google Analytics 4 Measurement ID (`sekolahane_ga4_id`):** Cukup isi `G-XXXXXXXXXX` (atau `UA-...`), otomatis memuat `gtag.js` secara `async` di `<head>`.
2. **Tab 2 — Meta / Facebook Pixel & TikTok Pixel:**
   - **Meta / Facebook Pixel ID (`sekolahane_fb_pixel_id`):** Cukup isi Pixel ID numerik, otomatis merender kode resmi `fbq('init')` & `fbq('track', 'PageView')` beserta fallback `<noscript>`.
   - **Meta Domain Verification (`sekolahane_fb_domain_verify`):** Mendukung kode verifikasi domain Meta Business Suite (`facebook-domain-verification`).
   - **TikTok Pixel ID (`sekolahane_tiktok_pixel_id`):** Opsional untuk pelacakan kampanye PPDB di TikTok Ads.

## Scope
- [x] `inc/sekolahane.php`: Tambahkan `acf_add_options_sub_page()` untuk **Google & Tracking** (`acf-options-google-tracking`).
- [x] `inc/seo.php` & `inc/acf-json/field-groups.json`: Daftarkan Field Group ACF `group_sekolahane_google_tracking` serta fungsi ekstraksi & render script tracking yang aman (hanya merender ID tervalidasi regex, bebas risiko XSS).
- [x] `header.php`: Tambahkan standar `wp_body_open()` tepat setelah tag `<body <?php body_class(); ?>>` untuk penempatan `<noscript>` Google Tag Manager.
- [x] Verifikasi `composer lint`, `composer analyse`, `composer css:check`, `composer security:scan`, dan `composer dist:check`.

## Security Review
| Item | Status | Keterangan |
|---|---|---|
| Validasi ketat ID Tracking (anti-XSS) | ✅ | Seluruh ID (`GTM-*`, `G-*`, Pixel ID numerik, TikTok Pixel ID, dan kode verifikasi) divalidasi dengan regex whitelist ketat di `sekolahane_get_tracking_settings()` dan `sekolahane_extract_verification_token()` |
| Late escaping output (`esc_attr`, `esc_url`, `esc_js`) | ✅ | Seluruh nilai yang dicetak ke dalam HTML/JS di-escape dengan `esc_attr()`, `esc_url()`, dan `esc_js()` |
| Auto-sync ACF JSON | ✅ | `group_sekolahane_google_tracking` disimpan di `inc/acf-json/field-groups.json` sehingga otomatis tersinkron ke DB via `inc/acf-importer.php` |

## Checklist Penutupan SOP
- [x] `composer lint` (PHPCS) — Lolos `0 errors, 0 warnings` pada `inc/seo.php` & `header.php`
- [x] `composer analyse` (PHPStan) — Lolos `[OK] No errors`
- [x] `composer css:check` (`bin/css-audit.py`) — Lolos `0 dead CSS rules`
- [x] `composer security:scan` & `composer dist:check` — Lolos
