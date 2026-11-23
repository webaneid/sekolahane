# Fase 44 — Pengayaan Standar SEO Modern 2026, GEO (`/llms-full.txt`, AI `robots.txt`, Auto-`FAQPage`, `Speakable`), Yoast Graph Sync, & Auto-Redirect 301

**Status:** Done

## 1. Tujuan & Cakupan
Melengkapi mesin SEO & GEO Hybrid di [`inc/seo.php`](../../inc/seo.php) dengan 5 peningkatan terpilih hasil evaluasi arsitektur SEO Modern 2026 & Kesiapan LLM (Zero-Config, 0 beban PageSpeed, dan tanpa ketergantungan API berbayar):

1. **Kontrol Eksplisit AI Search Crawlers pada `robots.txt` (`sekolahane_seo_robots_txt`):**
   - Menambahkan aturan izin eksplisit (`Allow: /`) untuk bot mesin pencari AI utama (`OAI-SearchBot`, `GPTBot`, `ChatGPT-User`, `PerplexityBot`, `ClaudeBot`, `Google-Extended`, `Applebot-Extended`).
   - Memblokir scraper dataset massal non-pencarian (`CCBot`, `Bytespider`).
   - Mencantumkan URL `Sitemap:` otomatis (`sitemap_index.xml` bila Yoast aktif, atau `wp-sitemap.xml` bawaan WordPress Core).
2. **Endpoint Virtual `/llms-full.txt` (Pendamping `/llms.txt`):**
   - Menambahkan dukungan `/llms-full.txt` (dan `?llms_txt=full`) dengan transient cache terpisah (`sekolahane_llms_full_txt_cache`, TTL 6 jam, auto-flush saat `save_post` / `acf/save_post`).
   - Memuat profil lengkap sekolah, halaman statis utama (Profil, Kelembagaan, Kontak, PPDB) beserta cuplikan isinya, daftar lengkap Guru (nama, jabatan, mata pelajaran), Ekstrakurikuler, serta 30 berita terbaru dengan ringkasan komprehensif untuk konsumsi RAG / AI mendalam.
   - Menambahkan `<link rel="alternate" type="text/plain" title="LLMs-Full.txt - Basis Pengetahuan Lengkap AI" href=".../llms-full.txt" />` di `<head>`.
3. **Auto-Redirect 301 Cerdas Saat Slug Berubah (`sekolahane_log_slug_change_redirect` & `sekolahane_execute_404_slug_redirect`):**
   - Mendeteksi perubahan URL/slug pada `post`, `page`, `guru`, dan `ekstrakurikuler` yang berstatus `publish` melalui hook `post_updated`.
   - Menyimpan pemetaan `old_path => post_id` di option `sekolahane_seo_redirects` dengan batas antrean maksimal **200 entri terbaru (LRU/FIFO)** agar tabel `wp_options` tidak pernah membengkak.
   - Mengeksekusi `wp_safe_redirect( get_permalink( $target_id ), 301 )` pada hook `template_redirect` **hanya saat `is_404()`**, sehingga **0 overhead** pada seluruh halaman normal (`200 OK`).
4. **Pengayaan Schema GEO (`SpeakableSpecification`, `abstract`, Auto-`FAQPage`, & Deduplikasi Graph Yoast):**
   - Menambahkan properti `abstract` dan `speakable` (`SpeakableSpecification` dengan `cssSelector`: `.post-title`, `.ane-content > p:first-of-type`) pada node `NewsArticle`.
   - Mengekstrak otomatis pasangan tanya-jawab dari konten halaman/artikel (mendukung blok `.schema-faq-section` maupun elemen HTML5 `<details><summary>`) menjadi node JSON-LD `FAQPage` (`sekolahane_extract_faq_schema_node()`).
   - Saat Yoast SEO aktif, menyuntikkan node unik theme (`EducationalOrganization`, `SiteNavigationElement`, `Person` Guru, `Course` Ekstrakurikuler, `FAQPage`, serta pengayaan `keywords`/`abstract`/`speakable` pada `Article`) langsung ke filter `wpseo_schema_graph` dan tidak mencetak tag `<script type="application/ld+json">` ganda di `wp_head`, sehingga bebas duplikasi node `WebSite` dan `BreadcrumbList`.
5. **Auto-Sync Focus Keyphrase & Meta Description Yoast Saat `save_post` (`sekolahane_sync_yoast_meta_on_save`):**
   - Saat post/CPT dipublikasikan atau diperbarui (`wp_after_insert_post`) dan Yoast SEO aktif, jika `_yoast_wpseo_focuskw` masih kosong maka otomatis diisi dari Tag pertama / Nama Mapel / Judul post; jika `_yoast_wpseo_metadesc` masih kosong maka otomatis diisi dari ringkasan cerdas post (`sekolahane_build_post_smart_description( $post )`).

## 2. Daftar File yang Diubah
- `inc/seo.php`
- `docs/PROGRESS.md`
