# ADR-0002: Versioning & Rilis Otomatis

**Status:** Accepted
**Tanggal:** 2026-10-23

## Context
Jalawarta merilis dengan cara manual: edit `Version` di `style.css`, tulis
`CHANGELOG.md`, buat tag `vX.Y.Z`, push tag → workflow membuat GitHub Release
+ ZIP. Langkah manual ini rawan lupa/salah (versi di `style.css` tidak sama
dengan tag, changelog tertinggal). master-typescript memakai semantic-release
yang menentukan versi dari Conventional Commits.

Sekolahane sudah di versi `3.2.1` dan terpasang di situs pelanggan, jadi
penomoran harus melanjutkan dari situ (updater membandingkan versi).

## Decision
1. **SemVer**, melanjutkan dari `3.2.1`. Tag berformat `vX.Y.Z`.
2. **Conventional Commits wajib** (`docs/conventions.md`).
3. **semantic-release** berjalan di GitHub Actions setiap push ke `main`:
   - menentukan versi dari commit sejak tag terakhir (`fix`/`perf` → patch,
     `feat` → minor, `BREAKING CHANGE` → major);
   - menulis versi ke `style.css` (`Version:`), memperbarui `CHANGELOG.md`,
     commit `chore(release): X.Y.Z [skip ci]`, membuat tag;
   - build ZIP bersih berdasarkan `.distignore` dengan folder root bernama
     slug theme (`sekolahane/`), lalu menjadikannya asset GitHub Release.
4. `SEKOLAHANE_VERSION` di PHP dibaca dari header `style.css`
   (`wp_get_theme()->get( 'Version' )`) — satu sumber kebenaran.
5. `.distignore` adalah satu-satunya daftar file yang tidak ikut ZIP
   (docs, AGENTS/CLAUDE, tooling, `.github`, `vendor` dev, dst).

## Alternatif yang Dipertimbangkan
- Tetap manual seperti jalawarta — ditolak: rawan human error, dan setiap
  rilis langsung tersebar ke semua situs.
- release-please (rilis lewat PR) — layak, tapi beda dari master-typescript;
  bisa dipertimbangkan kalau ingin ada "tombol" konfirmasi sebelum rilis.

## Konsekuensi
- Merge ke `main` = rilis. Disiplin commit message menjadi krusial.
- Commit `docs:`/`chore:`/`refactor:` bisa di-merge tanpa memicu update di
  situs pelanggan.
- CI membutuhkan Node hanya untuk semantic-release; theme sendiri tidak
  bergantung pada Node saat runtime.
