# Fase 02 — Auto-Updater, CI, & Release Workflow

**Status:** Done
**Jenis:** Normal
**Mulai:** 2026-10-23
**Selesai:** 2026-10-23

## Tujuan
Memasang sistem auto-update theme dari GitHub private release (penyempurnaan
dari `jalawarta/inc/updater.php` sesuai ADR-0003) serta pipeline CI/CD GitHub
Actions untuk validasi otomatis (`composer lint:changed` + `composer analyse`)
dan rilis ZIP otomatis (ADR-0002).

## Scope
- [x] Dokumentasi `docs/architecture/architecture-deployment.md`
- [x] Buat `inc/updater.php` sesuai standar (`sekolahane_` prefix, nonce, WPCS + PHPStan bersih)
- [x] Muat `inc/updater.php` dari `functions.php` dan definisikan `SEKOLAHANE_VERSION`
- [x] Pindahkan `update_option()` ukuran gambar di `functions.php` ke `after_switch_theme` (GAP-11) & perbaiki `parse_str(null)` untuk PHP 8.1+
- [x] Buat `.github/workflows/ci.yml` (validasi PHPCS + PHPStan tiap push/PR)
- [x] Buat `.github/workflows/release.yml` + `.releaserc.json` (semantic-release + build ZIP berdasarkan `.distignore`)
- [x] Buat `CHANGELOG.md` awal dan tag `v3.2.1` pada commit baseline
- [x] Jalankan SOP Langkah 3 (`lint:changed`, `analyse`) & Langkah 4 (Security Review)

## Di Luar Scope
- Perbaikan security pada file lama (`inc/sekolahane.php`, template) — itu Fase 03.
- Push ke GitHub remote (menunggu URL repo privat dari user, bisa dihubungkan kapan saja).

## Referensi
- `docs/decisions/adr-0002-versioning-dan-rilis.md`
- `docs/decisions/adr-0003-auto-update-github-private.md`
- `docs/architecture/architecture-deployment.md`
- `docs/architecture/architecture-security.md`

## Keputusan Kecil Selama Eksekusi
- Nama field ACF untuk menyimpan token tetap `ane_updater_token` (tetapi tipe
  field diubah dari `text` menjadi `password` agar token tidak terpampang
  plaintext di layar admin) dan mendukung konstanta `SEKOLAHANE_UPDATER_TOKEN`
  di `wp-config.php`.
- Parent slug halaman ACF Option di `sekolahane` adalah
  `webane-theme-general-settings`, sehingga lokasi field group updater diarahkan
  ke `webane-theme-general-settings`.
- Header `Authorization` hanya dikirim ke path `api.github.com/repos/webaneid/sekolahane/`
  dan `github.com/webaneid/sekolahane/` (tidak dikirim ke domain CDN umum).
- Tombol Force Check memakai `wp_nonce_url()` + `check_admin_referer( 'sekolahane_updater_action' )`
  + `current_user_can( 'update_themes' )`.

## Security Review — Fase 02 (`functions.php`, `inc/updater.php`)
- ✅ **Lolos:**
  - Seluruh output di `inc/updater.php` di-escape (`esc_html`, `esc_html__`, `esc_html_e`, `esc_url`).
  - Aksi `sekolahane_force_check` diverifikasi dengan `current_user_can( 'update_themes' )` + `check_admin_referer( 'sekolahane_updater_action' )`.
  - Token tidak di-hardcode; field input ACF bertipe `password`; header `Authorization` dibatasi ketat ke path repo `webaneid/sekolahane`.
  - `update_option()` di `functions.php` dipindahkan dari `after_setup_theme` ke `after_switch_theme`.
  - Guard `defined( 'ABSPATH' ) || exit;` terpasang di kedua file.
- ⚠️ **Perlu diperbaiki:** Tidak ada pada file yang disentuh di fase ini.
- ❓ **Perlu dicek manual:** Setelah repo GitHub privat `webaneid/sekolahane` dibuat, uji tombol "Cek Update Sekarang" di `wp-admin → Webane Settings → Update`.

## Checklist Penutupan (SOP)
- [x] `composer lint:changed` — nol pelanggaran di file baru/diubah (`functions.php`, `inc/updater.php`)
- [x] `composer analyse` — nol error
- [x] Security Review dijalankan & dilaporkan
- [x] `PROGRESS.md` diupdate
- [x] Commit sesuai Conventional Commits

## Known Limitations
- Workflow GitHub Actions baru akan aktif berjalan setelah repo di-push ke
  GitHub (`webaneid/sekolahane`).

## Ringkasan Hasil
`inc/updater.php` standar Webane, perbaikan `functions.php` (`SEKOLAHANE_VERSION`,
`after_switch_theme`, kompatibilitas PHP 8.1+ `wp_parse_url`), serta workflow CI
(`.github/workflows/ci.yml`) dan Release otomatis (`.github/workflows/release.yml` +
`.releaserc.json`) selesai dibuat dan lolos 100% PHPCS + PHPStan.
