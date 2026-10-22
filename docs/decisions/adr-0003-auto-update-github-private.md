# ADR-0003: Auto-Update dari GitHub Release (Repo Privat)

**Status:** Accepted
**Tanggal:** 2026-10-23

## Context
Theme dipasang di banyak situs pelanggan; update manual (upload ZIP satu per
satu) tidak skala. Jalawarta sudah memiliki updater yang terbukti jalan
(`inc/updater.php`): cek `releases/latest` di repo GitHub privat memakai
Personal Access Token yang diisi per situs di ACF option, hook ke
`pre_set_site_transient_update_themes`, `themes_api`, `http_request_args`,
dan `upgrader_source_selection`.

Catatan dari review updater jalawarta:
- Token disimpan di DB tiap situs pelanggan. Token fine-grained dengan scope
  *Contents: read-only* pada satu repo membatasi dampak bocor (hanya bisa
  membaca source theme), tapi tetap tersebar.
- Link "Cek Update Sekarang" (`?ane_force_check=1`) tanpa nonce (Low: hanya
  menghapus cache, sudah dicek capability).
- Nama konstanta/fungsi berprefix `ane_` — kalau dua theme Webane dengan
  updater yang sama terpasang di satu situs (mis. theme induk + anak, atau
  saat preview), terjadi fatal "cannot redeclare".

## Decision
Mengadopsi pola updater jalawarta sebagai **modul standar Webane** dengan
perbaikan berikut:
1. Satu file `inc/updater.php` yang identik di semua theme; perbedaan antar
   theme hanya lewat konstanta (`SEKOLAHANE_UPDATER_REPO`, slug). Semua
   fungsi/transient berprefix slug theme → tidak bentrok antar theme.
2. Sumber token berurutan: konstanta `SEKOLAHANE_UPDATER_TOKEN` di
   `wp-config.php` (disarankan) → ACF option → tanpa token (updater diam).
3. "Cek Update Sekarang" memakai `wp_nonce_url()` + `check_admin_referer()`.
4. Header Authorization hanya ditambahkan ke host GitHub untuk repo ini.
5. Hanya asset `.zip` rilis yang diterima (tanpa fallback zipball).
6. Mode debug hanya untuk `update_themes` capability, tidak menampilkan token.

## Alternatif yang Dipertimbangkan
- **Update server milik Webane** (endpoint di webane.com yang memegang token
  dan memeriksa lisensi/domain) — lebih aman dan memungkinkan kontrol
  lisensi, tapi butuh infrastruktur baru. **Arah jangka panjang** → ADR baru
  yang men-supersede ADR ini ketika siap; modul updater dirancang supaya
  cukup mengganti URL sumber metadata.
- Repo rilis publik terpisah — ditolak: source theme proprietary jadi publik.
- Library `plugin-update-checker` — layak, tapi menambah dependensi besar
  untuk fungsi yang sudah terbukti jalan dengan ~300 baris.

## Konsekuensi
- Situs pelanggan yang masih memakai versi tanpa updater (≤ 3.2.1) perlu
  **satu kali update manual** ke versi pertama yang membawa updater.
- Setiap situs perlu token (sekali setup). Rotasi token = isi ulang di
  situs (atau di `wp-config.php`).
- Kualitas setiap rilis langsung terasa di semua situs → SOP Langkah 3–6
  tidak boleh dilewati.
