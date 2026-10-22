# ADR-0001: Standar Kerja Tidak Terikat Satu AI Tool

**Status:** Accepted
**Tanggal:** 2026-10-23

## Context
Theme Webane dikerjakan bergantian dengan beberapa AI agent (Claude Code,
Antigravity, Codex) dan manusia. Di jalawarta, `AGENTS.md` dan `CLAUDE.md`
berisi teks yang sama persis — dua salinan yang cepat atau lambat akan
berbeda. Template `master-typescript` memakai hooks `.claude/` sebagai
penjaga aturan, padahal dokumen itu sendiri mengakui hooks hanya "lapisan
kenyamanan", bukan gerbang yang tidak bisa dilewati.

## Decision
1. `AGENTS.md` adalah sumber aturan tunggal. `CLAUDE.md` hanya berisi
   `@AGENTS.md` (import). Tool lain membaca `AGENTS.md` langsung.
2. Proses dan checklist ditulis sebagai markdown biasa di `docs/` (SOP,
   security checklist), bukan sebagai fitur khusus satu tool.
3. Enforcement nyata ada di **Composer scripts + CI GitHub Actions**
   (dan git pre-commit hook opsional) — berlaku siapa pun yang menulis kode.
4. Hooks/skill khusus tool boleh ditambahkan sebagai kenyamanan, tapi tidak
   boleh menjadi satu-satunya tempat sebuah aturan berada.

## Alternatif yang Dipertimbangkan
- Pakai hanya Claude Code + `.claude/hooks` seperti master-typescript —
  ditolak: mengunci ke satu vendor; aturan tidak berlaku saat kerja di tool lain.
- Duplikasi isi ke `AGENTS.md` dan `CLAUDE.md` — ditolak: pasti drift.

## Konsekuensi
- Ganti/tambah AI tool tidak mengubah standar.
- Aturan yang benar-benar wajib harus bisa dicek mesin (PHPCS/PHPStan/CI);
  aturan yang hanya tertulis bergantung pada disiplin review.
