# Lessons Learned

> Format: tanggal, masalah, root cause, fix, pencegahan. Entri terbaru di atas.
> Wajib diisi setelah debugging signifikan atau hotfix production.

---

## 2026-10-23 — Folder theme production tanpa version control
**Masalah:** Theme sekolahane (v3.2.1, terpasang di situs pelanggan) tidak
berada di git; tidak ada riwayat perubahan, tidak bisa rollback, tidak ada CI.
**Root cause:** Theme dikembangkan langsung di folder situs lokal sejak 2019.
**Fix:** `git init` + commit baseline `3e538b6` sebelum perubahan apa pun.
**Pencegahan:** Theme baru WAJIB dimulai dari repo (template `master-wordpress`).

---

## [Tanggal] — [Judul]
**Masalah:**
**Root cause:**
**Fix:**
**Pencegahan:**
