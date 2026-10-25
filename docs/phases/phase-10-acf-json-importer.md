# Fase 10 — Bundling & Importer ACF JSON (`inc/acf-importer.php`) + Guard `docs/`

**Status:** Done
**Jenis:** Fitur Admin & Standarisasi Deployment (`feat(acf)`)
**Mulai:** 2026-10-25
**Selesai:** 2026-10-25

## Tujuan
1. Memastikan folder `docs/` 100% tidak pernah masuk ke paket rilis production (`dist:check`).
2. Memindahkan definisi 13 Field Group ACF dari `docs/json/acf-export-2026-10-24.json` ke folder aset kode `inc/acf-json/field-groups.json` agar ikut terbundel di dalam rilis theme.
3. Membuat modul `inc/acf-importer.php` yang:
   - Mengecek apakah plugin **ACF Pro** aktif (dan memberi peringatan di `wp-admin` jika belum aktif).
   - Otomatis me-load seluruh 13 Field Group dari JSON sebagai fallback maupun auto-import saat aktivasi theme (`after_switch_theme`).
   - Menyediakan tab & tombol **"Import Field ACF dari JSON"** di halaman **Webane Settings** (`webane-theme-general-settings`) dengan proteksi Nonce, `current_user_can( 'manage_options' )`, dan pencegahan duplikasi ID grup di database.

## Scope
- [x] **Pindahkan File JSON ACF ke `inc/acf-json/field-groups.json`:**
  - Pindahkan `docs/json/acf-export-2026-10-24.json` → `inc/acf-json/field-groups.json` dan hapus folder `docs/json/`.
  - Perkuat `bin/check-dist.sh` untuk memverifikasi secara eksplisit bahwa `docs/` tidak ada di paket rilis DAN `inc/acf-json/field-groups.json` ada di paket rilis.
- [x] **Buat `inc/acf-importer.php` & Require di `functions.php`:**
  - `sekolahane_is_acf_active()` + `sekolahane_acf_missing_notice()` di `admin_notices` jika ACF Pro belum aktif.
  - `sekolahane_get_bundled_acf_groups()` untuk membaca seluruh file `.json` di `inc/acf-json/`.
  - `sekolahane_get_db_acf_group_id( string $group_key ): int` untuk mengecek apakah grup sudah ada di tabel `wp_posts` (`post_type = 'acf-field-group'`).
  - `sekolahane_import_acf_json_groups( bool $overwrite = false ): int` menggunakan `acf_import_field_group()` yang idempotent (menyertakan `$group['ID']` bila sudah ada di DB agar tidak pernah terjadi duplikasi field group).
  - Hook `after_switch_theme` untuk auto-import grup yang belum ada saat theme diaktifkan.
  - Hook `acf/init` untuk mendaftarkan grup yang belum ada di DB sebagai local fallback (`acf_add_local_field_group`) sekaligus mendaftarkan tab **Import ACF JSON** beserta tombol **Import / Sinkronkan Semua JSON ACF** di halaman **Webane Settings**.
  - Handler `admin_init` (`sekolahane_handle_acf_json_import`) dengan `current_user_can( 'manage_options' )` dan `check_admin_referer( 'sekolahane_acf_import_action' )`.

## Di Luar Scope
- Redesign visual dashboard custom `Webane Settings` (akan dikerjakan pada fase khusus desain dashboard admin berikutnya).

## Referensi
- `inc/acf-importer.php`
- `inc/acf-json/field-groups.json`
- `functions.php`, `bin/check-dist.sh`, `.distignore`

## Keputusan Kecil Selama Eksekusi
- Menyimpan file JSON ACF di `inc/acf-json/field-groups.json` (bukan di `docs/json/`) karena seluruh isi `docs/` dibuang oleh `.distignore` saat pembuatan ZIP rilis ke pelanggan.
- Menggunakan pencocokan `post_name = $group_key` pada `post_type = 'acf-field-group'` sebelum memanggil `acf_import_field_group()` supaya klik tombol Import berkali-kali tetap aman (update in-place, 0 duplikasi).

## Checklist Penutupan (SOP)
- [x] `composer security:scan` lolos
- [x] `composer lint:changed` lolos (0 error PHPCS)
- [x] `composer analyse` lolos (0 error PHPStan, 74/74 file)
- [x] `composer css:check` lolos
- [x] `composer dist:check` lolos (`docs/` tidak ada di rilis, `inc/acf-json/field-groups.json` ada di rilis)
- [x] Security Review dijalankan & dilaporkan
- [x] `PROGRESS.md` diupdate

## Known Limitations
- Tidak ada.

## Ringkasan Hasil
- **Proteksi `docs/` di Rilis:** `.distignore` dan `bin/check-dist.sh` memastikan folder `docs/` tidak pernah masuk ke paket rilis pelanggan.
- **Bundel 13 Field Group ACF (`inc/acf-json/field-groups.json`):** Seluruh 13 grup ACF (`Customer Care`, `Guru Detail`, `Informasi Umum`, `Testimoni Detail`, `User Gravatar`, `Banner Iklan`, `Blog Type Settings`, `Landing Page Content`, `Mobile Footer Menu`, `Page Profil Lembaga`, `Top Header Link`, `Mobile Profil Lembaga`, `Mobile Menu Kategori`) kini terbundel resmi di dalam theme.
- **Tiga Lapis Kemudahan di `inc/acf-importer.php`:**
  1. **Cek ACF Pro:** Jika ACF Pro belum aktif, muncul peringatan jelas di `wp-admin`.
  2. **Auto-Install & Fallback Instan:** Saat theme diaktifkan (`after_switch_theme`), grup ACF otomatis di-import ke DB; jika ada grup yang belum masuk DB, otomatis di-load via `acf_add_local_field_group()` sehingga situs langsung siap pakai.
  3. **Tab & Tombol "Import ACF JSON" di `Webane Settings`:** Menampilkan status berapa dari 13 grup yang sudah ada di DB, lengkap dengan tombol **Import Field yang Belum Ada** dan **Import / Sinkronkan Semua JSON ACF** (idempotent tanpa duplikasi).

### Hasil Security Review
| Kategori | Status | Catatan |
|---|---|---|
| Output Escaping | Lolos | Seluruh teks/URL di panel admin di-escape dengan `esc_html`, `esc_url`, `esc_js`. |
| Input Sanitization | Lolos | Parameter `$_GET['sekolahane_acf_import']` menggunakan `sanitize_key( wp_unslash( ... ) )` dan `$_GET['sekolahane_acf_imported']` menggunakan `absint( wp_unslash( ... ) )`. |
| Nonce & Capability | Lolos | Aksi import dilindungi `current_user_can( 'manage_options' )` + `check_admin_referer( 'sekolahane_acf_import_action' )`. |
| File Read Safety | Lolos | Hanya membaca file statis internal `get_template_directory() . '/inc/acf-json/*.json'`, tidak menerima path dari input user. |
