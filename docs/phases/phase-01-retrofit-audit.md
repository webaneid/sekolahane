# Fase 01 — Retrofit Audit: Architecture Overview & Gap Analysis

**Status:** Done
**Jenis:** Normal (murni dokumentasi & audit, tidak mengubah kode)
**Mulai:** 2026-10-23
**Selesai:** 2026-10-23

## Tujuan
Mengikuti prinsip `retrofit-adopt` dari `master-typescript`: sebelum mengubah
kode apa pun di theme yang sudah berjalan di production, dokumentasikan dulu
arsitektur aktual (`architecture-overview.md`) berdasarkan sumber kode primer,
dan daftar seluruh kesenjangan antara kondisi kode saat ini dengan standar baru
(`RETROFIT-GAPS.md`) beserta tingkat keparahan dan fase perbaikannya.

## Scope
- [x] Audit menyeluruh seluruh file PHP (`functions.php`, `inc/*.php`, template root, `tp/**/*.php`), JS, dan CSS
- [x] Tulis `docs/architecture/architecture-overview.md` (data model, routing, ACF, file aktif vs tidak aktif)
- [x] Tulis `docs/RETROFIT-GAPS.md` (temuan dikelompokkan: Security, Bug/Logic Error, Dead/Unloaded Code, Performance, Coding Standards)
- [x] Update `docs/PROGRESS.md` dan tutup Fase 01

## Di Luar Scope
- Mengubah kode PHP/JS/CSS apa pun (dikerjakan di Fase 02–04).

## Referensi
- `AGENTS.md`
- `docs/architecture/architecture-security.md`
- `phpstan-baseline.neon`

## Keputusan Kecil Selama Eksekusi
- File di `inc/` yang saat ini **tidak di-require** oleh `functions.php`
  (`color.php`, `customizer.php`, `option.php`, `post-view.php`, `related.php`,
  `single-iklan.php`) didokumentasikan secara eksplisit agar tidak dianggap
  aktif oleh AI/developer, dan keputusannya (hapus vs aktifkan kembali)
  dipisahkan per file di `RETROFIT-GAPS.md`.
- Slug taxonomy `'Kelas'` (dengan K kapital) dicatat sebagai kontrak DB yang
  tidak boleh diubah tanpa migrasi.

## Checklist Penutupan (SOP)
- [x] `composer lint:changed` & `composer analyse` lolos
- [x] Tidak ada perubahan pada file runtime theme
- [x] `PROGRESS.md` diupdate ke `Done`
- [x] Commit `docs(retrofit): ...`

## Known Limitations
- Definisi field group ACF tidak disimpan di repo (`acf-json/` belum ada);
  daftar field di `architecture-overview.md` diekstrak dari pemanggilan
  `get_field()`/`get_sub_field()`/`have_rows()` di template.

## Ringkasan Hasil
Arsitektur aktual theme telah didokumentasikan di `docs/architecture/architecture-overview.md`
dan 21 gap teridentifikasi di `docs/RETROFIT-GAPS.md` (1 Critical, 3 High,
10 Medium, 7 Low) lengkap dengan lokasi baris dan alokasi fase perbaikannya.
