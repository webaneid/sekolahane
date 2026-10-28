# Fase 36 — Naik Target Runtime ke PHP 8.0+

**Status:** Done
**Jenis:** Berisiko (menyentuh `requires_php` di updater)
**Mulai:** 2026-10-29
**Selesai:** 2026-10-29

## Tujuan
Target minimum theme naik dari PHP 7.4 ke 8.0 supaya fitur PHP 8.0 boleh dipakai
dan tooling lint/analyse sejalan dengan runtime situs pelanggan.

## Scope
- [x] `composer.json`: `require php >=8.0`, `platform.php 8.0.30`, `composer.lock` diperbarui
- [x] `phpcs.xml.dist`: `testVersion 8.0-`
- [x] `inc/updater.php`: `requires_php` 8.0
- [x] Dokumen: README, `conventions.md`, `architecture-overview.md`, `AGENTS.md`
- [ ] Verifikasi semua situs pelanggan sudah PHP 8.0+ sebelum rilis

## Di Luar Scope
- Memakai fitur PHP 8.0 di kode lama (tidak ada refactor).
- Fitur PHP 8.1+ (tetap dilarang).

## Referensi
- `docs/conventions.md` (aturan kompatibilitas)
- ADR-0002/0003 (updater & rilis)

## Keputusan Kecil Selama Eksekusi
- Minimum dipatok 8.0 (bukan 8.1+) agar situs pelanggan tidak terlalu cepat tertinggal.
- `style.css` tidak punya header `Requires PHP`, jadi tidak diubah.

## Checklist Penutupan (SOP)
- [ ] `composer lint` — lint penuh OOM di 1 GB (masalah lama); `lint:changed` lolos
- [x] `composer analyse` — No errors
- [x] `composer css:check`, `security:scan`, `dist:check` lolos
- [x] Scan PHPCompatibilityWP 8.0- pada kode theme: 0 temuan
- [x] Cek manual di situs lokal: `debug.log` hanya menampilkan notice ACF textdomain, sudah diperbaiki (`fix(acf)`)
- [x] Security Review: hanya 1 string di `inc/updater.php`, tidak ada output/input baru
- [x] `PROGRESS.md` diupdate
- [x] Commit sesuai Conventional Commits

## Known Limitations
- `composer lint` penuh kehabisan memori karena ribuan pelanggaran WPCS lama (GAP-21).
- Situs pelanggan di PHP 7.4 tidak akan melihat update baru.

## Ringkasan Hasil
Target PHP 8.0+ aktif. Bonus fix: ACF Options page dipindah ke `acf/init`.
