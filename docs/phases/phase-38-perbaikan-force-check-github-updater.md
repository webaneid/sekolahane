# Fase 38 — Perbaikan Instant Force-Check & Auto-Clear Cache pada GitHub Updater

**Status:** Done
**Jenis:** Kecil
**Mulai:** 2026-11-02
**Selesai:** 2026-11-02

## Tujuan
Memperbaiki alur pengecekan update manual (**Cek Update Sekarang**) di `inc/updater.php` agar:
1. Begitu tombol **Cek Update Sekarang** diklik, WordPress langsung menarik rilis terbaru dari GitHub di request yang sama (tanpa perlu refresh halaman kedua kali).
2. Saat admin menyimpan perubahan di halaman **Pengaturan Umum** (misalnya baru memasukkan GitHub Personal Access Token), cache transient `sekolahane_github_release` dan `update_themes` otomatis dibersihkan.
3. Mendukung fallback unduhan baik ketika repositori bersifat *Private* (dengan token) maupun *Public* (tanpa token).

## Scope
- [x] Jalankan `sekolahane_updater_force_check_handler()` pada prioritas `1` di `admin_init` (sebelum `_maybe_update_themes()` milik WordPress Core di prioritas `10`) dan panggil `wp_update_themes()` secara langsung setelah menghapus transient.
- [x] Tambahkan hook `acf/save_post` (`sekolahane_updater_on_save_options()`) untuk menghapus transient `sekolahane_github_release` dan `update_themes` setiap kali pengaturan theme disimpan.
- [x] Izinkan `sekolahane_updater_get_release()` tetap memanggil endpoint rilis GitHub meskipun token belum diisi (menggunakan `browser_download_url` jika tanpa token, dan API asset URL dengan header `Accept: application/octet-stream` jika memakai token).
- [x] Perjelas pesan `admin_notices` setelah klik **Cek Update Sekarang** agar menampilkan apakah versi baru ditemukan, sudah versi terbaru, atau token belum valid.

## Checklist Penutupan (SOP)
- [x] `composer lint:changed` — nol pelanggaran di `inc/updater.php`
- [x] `composer analyse` — nol error PHPStan
- [x] `composer css:check` — `0 dead CSS rules`
- [x] Security Review (`check_admin_referer`, `current_user_can( 'update_themes' )`, `esc_html`)
- [x] `PROGRESS.md` diupdate
- [x] Commit & push sesuai Conventional Commits
