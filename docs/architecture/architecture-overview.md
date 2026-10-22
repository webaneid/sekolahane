# Architecture Overview — Sekolah Ane

> Dokumen ini ditulis dari hasil audit kode aktual (`v3.2.1`, commit baseline
> `3e538b6`). Klaim di sini mencerminkan apa yang **benar-benar berjalan di
> kode saat ini**, termasuk bagian yang belum aktif atau warisan lama.

## 1. Gambaran Sistem
**Sekolah Ane** adalah classic WordPress theme (non-block, PHP prosedural) untuk
situs sekolah, madrasah, dan pesantren milik pelanggan Webane Indonesia.

- **Versi saat ini:** `3.2.1`
- **Target environment:** WordPress 6.0+, PHP 7.4+
- **Hard dependency:** **ACF Pro** (Advanced Custom Fields Pro — repeater,
  flexible content, dan options page dipakai secara ekstensif di seluruh
  template).
- **Pendekatan tampilan:** Satu instalasi melayani tampilan desktop dan mobile
  secara terpisah di beberapa halaman dengan deteksi server-side menggunakan
  fungsi bawaan WordPress `wp_is_mobile()`.

---

## 2. Siklus Muat PHP (`functions.php` & `inc/`)

`functions.php` menjalankan:
1. Definisi konstanta `SEKOLAHANE_VERSION` dari header `style.css`.
2. Hook `after_setup_theme` → `sekolahane_theme_setup()`:
   - `load_theme_textdomain( 'sekolahane' )`
   - Theme supports: `title-tag`, `automatic-feed-links`, `post-thumbnails`,
     `post-formats` (`video`, `gallery`), `html5`, `custom-logo` (400×97),
     `yoast-seo-breadcrumbs`.
   - Image size kustom: `kotak` (400×400 crop).
   - Menu locations: `menuutama` ("Menu Utama"), `menufooter` ("Menu Footer").
3. Hook `after_switch_theme` → `sekolahane_configure_image_sizes()`:
   mengonfigurasi ukuran gambar default (`medium` 700×394, `large` 1000×563,
   `thumbnail` 400×225) hanya saat aktivasi theme.
4. Hook `widgets_init` → `sekolahane_widgets()`: mendaftarkan sidebar
   `default-sidebar`.
5. Filter penghapus query string versi WP pada aset & meta generator.
6. `require` **4 file** di `inc/`:

### File `inc/` (Seluruhnya Aktif)
| File | Tanggung Jawab Aktual |
|---|---|
| `inc/sekolahane.php` | Enqueue CSS/JS, Google Maps & FB App ID helper, excerpt, popup gallery (`the_content`), shortcode caption, helper thumbnail/dummy/embed/YouTube, pagination, related & newest posts, prev/next post, `times_ago`, tombol share & komentar FB, author box (`the_content`), breadcrumbs, kustomisasi halaman login & dashboard admin, dynamic copyright year (dengan cache transient), custom avatar via user meta `gravatar_ane`, penghitung post views (`musi_views` + AJAX `wp_ajax_postviews`), dan pendaftaran **ACF Options Pages**. |
| `inc/custompost.php` | Mendaftarkan 3 Custom Post Type (`guru`, `ekstrakurikuler`, `testimoni`), 2 Custom Taxonomy untuk `guru` (`pelajaran`, `Kelas`), placeholder judul admin, dan menyertakan CPT ke RSS feed. |
| `inc/widgets.php` | Class `Webane_Posts_Widget` (widget daftar post berdasarkan terbaru, populer, komentar terbanyak, format video, tag, atau kategori). |
| `inc/updater.php` | Auto-updater GitHub Release (private/public repo) terintegrasi dengan halaman Appearance → Themes dan tab pengaturan Auto Update di General Settings ACF. |

---

## 3. Kontrak Data (Wajib Kompatibel Mundur)

> Semua slug/key di bawah ini sudah tersimpan di database situs pelanggan.
> **DILARANG mengubah nama/slug ini tanpa skrip migrasi.**

### 3.1 Custom Post Types (`inc/custompost.php`)
| Slug CPT | Supports | Capability Type | Archive & REST |
|---|---|---|---|
| `guru` | `title`, `editor`, `thumbnail` | `post` | `has_archive: true`, `show_in_rest: true` |
| `ekstrakurikuler` | `title`, `editor`, `thumbnail` | `post` | `has_archive: true`, `show_in_rest: true` |
| `testimoni` | `title`, `thumbnail` | `page` | `has_archive: true`, `show_in_rest: false` |

### 3.2 Custom Taxonomies (`inc/custompost.php`)
| Slug Taxonomy | Post Type | Rewrite Slug | Catatan Penting |
|---|---|---|---|
| `pelajaran` | `guru` | `pelajaran` | Hierarchical |
| `Kelas` | `guru` | `kelas` | ⚠️ Terdaftar dengan huruf **`K` kapital** (`register_taxonomy('Kelas', ...)`). Template: `taxonomy-Kelas.php`. |

### 3.3 Post Meta & User Meta
- Post meta `musi_views` — jumlah pembaca post (`get_views()` / `set_views()`).
- User meta `gravatar_ane` — ID attachment untuk avatar lokal user.

### 3.4 ACF Options Pages (`inc/sekolahane.php:906-935`)
Parent menu slug: `webane-theme-general-settings` ("Webane Settings", capability `edit_posts`), dengan 3 sub-page:
1. `Your Banners` (`Your Banners Settings`)
2. `Customer Care`
3. `Mobile Menu`

### 3.5 Daftar Field ACF yang Dipakai di Template
> Catatan: belum ada folder `acf-json/` di repo. Daftar di bawah diekstrak dari
> pemanggilan di kode PHP.

- **Options (`'option'`):**
  - Header & Umum: `ane_link_header` (array link: `url`, `title`), `nama_organisasi`, `alamat_lengkap`, `contact_telephone`, `contact_sologan`, `company_name`, `hari_buka`, `jam_buka`, `gmap`, `cf7_id`.
  - Repeaters di Option: `about_ane` (`company_name`, `company_sologan`, `company_about`), `contact_ane` (`kontak_alamat`, `kontak_telepon`, `kontak_handphone`, `kontak_email`, `kontak_website`), `sosmed_ane` (`sosmed_fb`, `sosmed_tw`, `sosmed_ig`, `sosmed_youtube`, `sosmed_wa`), `ane_cs` (`ane_aktif`, `ane_cs_label`, `ane_cs_welcome`, repeater `ane_whatsapp`, `ane_nama`, `ane_area`), `ane_mobile_menu`, `ane_menu_kategori`, `ane_mobile_landingpage`, `ane_list_lembaga`, `banner_post`.
- **Flexible Content / Repeater Halaman:**
  - `home_slider` (`ane_image`, `ane_title`, `ane_deskripsi`, `ane_link`)
  - `home_content` & `profil_content` & `blog_content`: layout section (`ane_featured`, `ane_data_sekolah`, `home_banner_*`, `home_sliding_kategori`, `pilih_kategori`, `pilih_judul`, `column_item`, `column_cat`, `column_title`, `custom_title`).
- **Field CPT / Post:**
  - `testimoni`: `ane_jabatan`, `ane_testimoni`
  - `guru` & lainnya: field profil guru di `tp/single-guru.php` dan `tp/content-guru.php`.

---

## 4. Struktur Template & Routing

### 4.1 Custom Page Templates (Root)
| File | Template Name | Routing Mobile vs Desktop |
|---|---|---|
| `page-home.php` | `Landing Page` | `Mobile_Detect` → `tp/pages/home-mobile.php` (phone) atau `tp/pages/home-desktop.php` (desktop/tablet) |
| `page-newslist.php` | `Blog Type` | `Mobile_Detect` → `tp/pages/news-mobile.php` atau `tp/pages/news-desktop.php` |
| `page-aneprofil.php` | `Profil Lembaga` | `tp/pages/profil.php` |
| `page-kelembagaan.php` | `Kelembagaan` | `tp/pages/kelembagaan.php` |
| `page-kontak.php` | `Contact Us` | `tp/content-page-kontak.php` |
| `page-mcategory.php` | `Mobile Category` | `tp/mobile/kategori.php` |

### 4.2 Archive, Single, & Hierarchy Standar
- **Single:** `single.php` (memilih `tp/single-video.php` jika post format `video`, selain itu `tp/single.php`), `single-guru.php` (`tp/single-guru.php`), `single-ekstrakurikuler.php` (`tp/single-ekstrakurikuler.php`).
- **Archive CPT & Taxonomy:** `archive-guru.php`, `archive-ekstrakurikuler.php`, `archive-testimoni.php`, `taxonomy-pelajaran.php`, `taxonomy-Kelas.php`.
- **Archive Blog:** `index.php`, `archive.php`, `category.php`, `tag.php`, `author.php`, `search.php` — semuanya memiliki cabang `Mobile_Detect` untuk menampilkan kartu `tp/content-overlay`, `tp/content-klasik`, `tp/content-list`, atau `tp/content-{format}`.

### 4.3 Organisasi `tp/` (Template Parts)
- `tp/content-*.php` — kartu item post/CPT (klasik, list, list-title, overlay, video, gallery, guru, ekstrakurikuler, testimoni, page, page-kontak, sosmed, sliders).
- `tp/section/*.php` — blok section modular untuk Landing Page & Profil (`big-slider`, `featured`, `angka`, `calltoaction`, `testimoni`, `ekstra`, `guru`, `guru-v2`, `banner`, `content`).
- `tp/news/*.php` — blok layout berita (`default`, `sliding`, `column`, `classic`).
- `tp/pages/*.php` — kerangka halaman penuh yang dipanggil oleh `page-*.php`.
- `tp/mobile/*.php` — komponen khusus tampilan mobile (`home`, `kategori`, `kategori-menu`, `landinpage`, `landingpage-menu`, `menu-footer`, `menu-lembaga`).

---

## 5. Aset Front-End (`css/`, `js/`, `fonts/`)
Dimuat di `ane_load_css_and_js()` (`inc/sekolahane.php:3-22`):
- **CSS Lokal:** `css/FontAne.css`, `css/main.min.css` (versi di-hardcode `'1.0.6'`; file `css/main.css` & `.map` ada di repo namun sumber SCSS-nya tidak ada di repo ini).
- **CSS CDN:** Font Awesome 4.7.0, Google Fonts `Poppins`, Magnific Popup 1.1.0, Owl Carousel 2.2.1, Bootstrap 4.4.1.
- **JS CDN:** jQuery 3.3.1 (me-replace jQuery bawaan WP), Magnific Popup 1.1.0, Owl Carousel 2.2.1, Bootstrap 4.3.1, Google Maps JS API (dengan key di URL).
- **JS Lokal:** `js/sekolahane.js`, plus `js/postviews-cache.js` (hanya saat `is_single()` dan `WP_CACHE` aktif). File `js/anekabar.js`, `js/bootstrap.min.js`, `js/gmap.js`, `js/plugins.js` ada di folder `js/` tapi tidak di-enqueue.
