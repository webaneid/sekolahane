# Fase 29 — Redesign Mobile Sliding App-Icons pada `.section-featured.featured-style-flat`

**Status:** Done
**Jenis:** Redesign Responsif Mobile (`tp/section/featured.php`, `css/main.css`, `css/main.min.css`)
**Mulai:** 2026-10-29
**Selesai:** 2026-10-29

## Tujuan
Mengubah tampilan `.section-featured.featured-style-flat` (termasuk `.featured-pos-below` dan `.featured-pos-overlap`) ketika diakses di layar mobile (`<= 767px`) menjadi deretan ikon bulat bergaya aplikasi mobile yang dapat digeser ke samping (*horizontal touch sliding / swipe*) seperti referensi desain:
1. **Horizontal Touch Slider Ringan (Pure CSS Scroll-Snap):**
   - Daftar `<ul>` menjadi satu baris horizontal (`flex-wrap: nowrap; overflow-x: auto; scroll-snap-type: x proximity`) tanpa scrollbar kasar sehingga nyaman digeser dengan jari di layar HP.
2. **Desain Lingkaran Ikon Kompak + Label di Bawahnya:**
   - Setiap item (`<li>`) berukuran kompak (`76px`) dengan lingkaran ikon `58x58px` (`border-radius: 50%`) di atas dan judul singkat `12px` rata tengah di bawahnya.
   - Item pertama (dan saat disentuh/hover) memiliki lingkaran beraksen lembut (`rgba(var(--ane-warna-utama-rgb), 0.16)`) dengan border warna utama (`rgba(var(--ane-warna-utama-rgb), 0.55)`), sedangkan item lainnya memiliki lingkaran surface terang dengan border halus.
   - Menyembunyikan deskripsi `<p>` dan tombol `.btn-primary` di layar mobile agar tampilan bersih layaknya *category/menu icons* aplikasi mobile.
3. **Ikon Bisa Diklik Langsung (`tp/section/featured.php`):**
   - Membungkus gambar ikon (`.image`) dengan `<a href="...">` jika item memiliki tautan (`ane_link`), sehingga pengguna mobile cukup mengetuk lingkaran ikon untuk membuka halaman tujuan.

## Scope
- [x] `tp/section/featured.php`: Bungkus `.image` dengan tautan `<a>` apabila `$sekolahane_link_url` tersedia.
- [x] `css/main.css` & `css/main.min.css`: Ganti langsung aturan `@media (max-width: 767px)` untuk `.section-featured.featured-style-flat` di bagian `[07]`.
- [x] Verifikasi `composer lint`, `composer analyse`, `composer css:check`, `composer security:scan`, dan `composer dist:check`.

## Security Review
| Item | Status | Keterangan |
|---|---|---|
| Late escaping output (`esc_url`, `esc_attr`, `esc_html`) | ✅ | Seluruh atribut `href`, `target`, `aria-label`, `src`, `alt`, dan `title` pada `.image` di-escape dengan ketat |
| 0 Dead CSS | ✅ | Aturan mobile lama diganti langsung di tempat (`0 dead CSS rules`) |

## Checklist Penutupan SOP
- [x] `composer lint` (PHPCS) — Lolos `0 errors, 0 warnings` pada `tp/section/featured.php`
- [x] `composer analyse` (PHPStan) — Lolos `[OK] No errors`
- [x] `composer css:check` (`bin/css-audit.py`) — Lolos `0 dead CSS rules` (`css/main.min.css` 129.2 KB)
- [x] `composer security:scan` & `composer dist:check` — Lolos
