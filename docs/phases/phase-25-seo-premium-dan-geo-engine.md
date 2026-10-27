# Fase 25 — Mesin SEO Premium Hybrid (Yoast Booster), Google Sitelinks Schema, Tag-to-Keywords, & GEO (`llms.txt`)

**Status:** Done
**Jenis:** SEO, Structured Data (Schema.org JSON-LD), & Generative Engine Optimization (`inc/seo.php`, `functions.php`, `header.php`, `inc/sekolahane.php`)
**Mulai:** 2026-10-27
**Selesai:** 2026-10-27

## Tujuan
Meningkatkan kapabilitas SEO dan GEO (Generative Engine Optimization) tema `sekolahane` secara otomatis di belakang layar (*zero-config*) sehingga menghasilkan output setara **Yoast SEO Premium + Yoast Local SEO + Yoast News SEO + AI Search Ready**:
1. **Hybrid Yoast SEO Booster + Standalone Meta Engine (`inc/seo.php`):**
   - Mendeteksi otomatis apakah plugin Yoast SEO aktif (`sekolahane_is_yoast_active()`). Jika aktif, memperkaya output Yoast (`wpseo_metadesc`, `wpseo_opengraph_desc`, `wpseo_twitter_description`, `wpseo_opengraph_image`, `wpseo_twitter_image`) dengan *Smart Auto-Fallback Description* ketika admin lupa mengisi meta deskripsi atau gambar. Jika Yoast tidak aktif, menghasilkan seluruh tag meta SEO, OpenGraph, Twitter Card, dan Canonical secara mandiri.
2. **Konversi Otomatis Post Tag (`post_tag`), Kategori, & Taxonomy ke Multi-Layer Keywords:**
   - Menggabungkan Focus Keyphrase Yoast (`_yoast_wpseo_focuskw`), Post Tags (`post_tag`), Kategori (`category`), serta Taxonomy Guru (`pelajaran`, `Kelas`) menjadi `<meta name="keywords">`, `<meta property="article:tag">`, serta properti `"keywords"` dan `"articleSection"` pada Schema JSON-LD `NewsArticle`.
3. **Optimasi Tampilan Index Google Sitelinks & Site Name:**
   - Menghasilkan JSON-LD `@graph` (`sekolahane-schema-graph`) yang memuat:
     - `EducationalOrganization` / `School` lengkap dengan koordinat GPS (`ane_gmap`), nomor telepon/WA, alamat (`PostalAddress`), akun sosmed (`sameAs`), & kontak WA Customer Care (`contactPoint`).
     - `WebSite` (dengan `name`, `alternateName`, & `SearchAction` untuk tampilan nama brand di atas URL Google).
     - `SiteNavigationElement` otomatis dari menu utama (`menuutama`) sebagai sinyal eksplisit **Google Sitelinks** (seperti tampilan indeks Webane Indonesia).
     - `BreadcrumbList` JSON-LD modern (menggantikan markup RDFa kuno `v:url`/`v:title`).
     - Schema spesifik entitas: `NewsArticle` (Berita), `Person` (Guru beserta Jabatan & Mata Pelajaran `knowsAbout`), dan `Course` (Ekstrakurikuler).
   - Menambahkan atribut semantik `<nav aria-label="...">` pada menu utama di `header.php`.
4. **GEO (Generative Engine Optimization) — Endpoint `/llms.txt` Otomatis & AI Crawler Ready:**
   - Menyediakan endpoint dinamis `/llms.txt` (dan `?llms_txt=1`, di-cache transient 6 jam dan otomatis di-flush saat `save_post` / `acf/save_post`) yang menyajikan ringkasan terstruktur berformat Markdown berisi identitas sekolah, alamat, koordinat peta, kontak resmi, link PPDB, customer care, menu utama (Sitelinks), ekstrakurikuler, guru, dan berita terbaru untuk mesin pencari AI (Google AI Overviews, ChatGPT Search, Perplexity, Gemini, Claude).
   - Mengaktifkan direktif `max-snippet:-1, max-image-preview:large, max-video-preview:-1` (`wp_robots`) untuk mendukung Google Discover & AI Overviews, *Auto Image Alt Fallback*, *Resource Hints* (`preconnect`), serta pembersihan tag noise di `<head>`.

## Scope
- [x] Buat `inc/seo.php` dan muat dari `functions.php`.
- [x] Perbarui `header.php` (tambahkan `<nav aria-label="...">` pada menu utama desktop & mobile) dan `inc/sekolahane.php` (bersihkan atribut RDFa `v:url`/`v:title` yang sudah deprecated pada `fungsi_breadcrumbs_webane()`).
- [x] Verifikasi `composer lint`, `composer analyse`, `composer css:check`, `composer security:scan`, dan `composer dist:check`.

## Security Review
| Item | Status | Keterangan |
|---|---|---|
| Guard `defined( 'ABSPATH' ) \|\| exit;` | ✅ | Tersedia di baris pertama `inc/seo.php` |
| Late escaping output (`esc_attr`, `esc_url`, `wp_json_encode`) | ✅ | Seluruh atribut meta tag di-escape dengan `esc_attr()`/`esc_url()`, JSON-LD di-encode menggunakan `wp_json_encode()` |
| Sanitize input (`$_SERVER['REQUEST_URI']`, `$_GET['llms_txt']`) | ✅ | Menggunakan `wp_unslash()` + `sanitize_text_field()` |
| Tidak ada write DB di setiap request | ✅ | Cache `/llms.txt` disimpan dengan `set_transient()` selama 6 jam dan di-flush hanya saat `save_post` / `acf/save_post` |

## Checklist Penutupan SOP
- [x] `composer lint` (PHPCS) — Lolos `0 errors, 0 warnings` pada `inc/seo.php`, `functions.php`, dan `header.php`
- [x] `composer analyse` (PHPStan) — Lolos `[OK] No errors`
- [x] `composer css:check` (`bin/css-audit.py`) — Lolos `0 dead CSS rules`
- [x] `composer security:scan` & `composer dist:check` — Lolos
