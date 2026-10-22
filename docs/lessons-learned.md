# Lessons Learned

> Format: tanggal, masalah, root cause, fix, pencegahan. Entri terbaru di atas.
> Wajib diisi setelah debugging signifikan atau hotfix production.

---

## 2026-10-23 — Celah Stored XSS & Fatal Error PHP 8.x pada Kode Theme Lama
**Masalah:**
1. Ditemukan `remove_filter( 'pre_user_description', 'wp_filter_kses' );` di `inc/sekolahane.php` ditambah output bio penulis tanpa escaping di `inc/sekolahane.php` dan `author.php` (Stored XSS).
2. Di PHP 8.0+, `@number_format( $count )` ketika post meta `musi_views` masih kosong (`''`) melempar `TypeError` yang tidak bisa diredam operator `@` (Fatal Error).
3. Di PHP 8.4, parameter opsional bertipe class/array dengan default `null` tanpa tanda `?` (`WP_Query $wp_query = null`, `array $headers = null`) memicu `Deprecated: Implicitly marking parameter as nullable is deprecated`.
**Root cause:** Kode warisan PHP 5/7 yang mematikan filter keamanan inti WordPress demi kemudahan input HTML di bio dan mengandalkan error suppression `@` serta tipe parameter implisit.
**Fix:**
1. Menghapus `remove_filter( 'pre_user_description', 'wp_filter_kses' )` dan membungkus output bio dengan `wp_kses_post()`.
2. Mengubah perhitungan views ke `(int) $raw_count` + `number_format_i18n()`.
3. Menambahkan eksplisit nullable `?WP_Query` dan `?array`, serta mengosongkan `phpstan-baseline.neon` hingga 0 error.
**Pencegahan:** Wajib jalankan `composer security:scan`, `composer lint:syntax` (PHP 8.4), dan `composer analyse` (PHPStan tanpa baseline) di setiap perubahan sebelum commit.

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
