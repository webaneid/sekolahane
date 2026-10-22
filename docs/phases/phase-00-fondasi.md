# Fase 00 — Fondasi: Git, SOP, Aturan, Tooling

**Status:** Done
**Jenis:** Normal (tidak mengubah perilaku theme)
**Mulai:** 2026-10-23
**Selesai:** 2026-10-23

## Tujuan
Menyiapkan fondasi kerja sebelum menyentuh kode: version control, aturan
kerja untuk manusia & AI, SOP, dan alat cek otomatis. Mengadopsi standar
`master-typescript` (proses, ADR, security checklist) ke dunia PHP/WordPress,
dan pola updater jalawarta sebagai standar auto-update.

## Scope
- [x] `git init` + commit baseline kondisi asli (`3e538b6`)
- [x] `.gitignore`, `.gitattributes`, `.distignore`
- [x] `AGENTS.md` (sumber aturan tunggal) + `CLAUDE.md` (import)
- [x] `README.md` onboarding
- [x] `docs/SOP.md`, `conventions.md`, `PROGRESS.md`, `lessons-learned.md`, `glossary.md`
- [x] `docs/architecture/architecture-security.md` + checklist review
- [x] ADR-0001 (tool-agnostic), ADR-0002 (versioning & rilis), ADR-0003 (auto-update)
- [x] `composer.json` + PHPCS (WPCS) + PHPStan, terpasang & jalan
- [x] Baseline jumlah pelanggaran lint/analyse tercatat (`phpstan-baseline.neon`)

## Di Luar Scope
- Mengubah kode PHP/template apa pun (Fase 03+).
- CI & workflow rilis (Fase 02 — butuh repo GitHub).
- Audit arsitektur lengkap (Fase 01).

## Referensi
- `docs/decisions/adr-0001..0003`
- Sumber: `~/sites/master-typescript`, `~/sites/modernnews/.../jalawarta/inc/updater.php`

## Keputusan Kecil Selama Eksekusi
- PHPStan mulai di **level 3** + baseline (`phpstan-baseline.neon`, 50 error
  existing di-freeze): kode lama tidak memblokir, kode baru tidak boleh
  menambah error. Level dinaikkan bertahap per fase pembersihan.
- PHPCS memakai ruleset `WordPress` penuh, kecuali aturan nama file
  (template hierarchy) dan Yoda condition. Ditambah `composer lint:changed`
  (`bin/lint-changed.sh`) untuk mengecek hanya file yang disentuh di tiap fase.
- `composer.json` mengunci `platform.php` 7.4 supaya dependensi dev tidak
  menarik paket yang butuh PHP lebih baru dari target theme.
- `inc/Mobile_Detect.php` (library pihak ketiga) dikecualikan dari lint.

## Checklist Penutupan (SOP)
- [x] `composer lint` & `composer analyse` bisa dijalankan
- [x] Tidak ada perubahan perilaku theme (hanya file baru non-runtime)
- [x] `PROGRESS.md` diupdate
- [x] Commit `chore:`/`docs:` (tidak memicu rilis)

## Known Limitations
- Kode lama masih punya 7.681 error + 802 warning WPCS (7.452 bisa di-autofix
  via `phpcbf`, 322 `OutputNotEscaped`) dan 50 error PHPStan di baseline —
  diperbaiki bertahap di Fase 03–04.

## Ringkasan Hasil
Fondasi Git (`3e538b6`), aturan tunggal `AGENTS.md`/`CLAUDE.md`, SOP 6 langkah,
ADR-0001..0003, serta PHPCS (WPCS) + PHPStan level 3 dengan baseline telah
aktif tanpa menyentuh satu baris pun kode runtime theme.
