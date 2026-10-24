# Fase 09 — Audit, Pembersihan Dead CSS, & Deduplikasi Stylesheet

**Status:** Done
**Jenis:** Refactor & Optimasi (`perf(css)`)
**Mulai:** 2026-10-24
**Selesai:** 2026-10-24

## Tujuan
Merapikan `css/main.css` dan `css/main.min.css` secara menyeluruh dengan menghapus seluruh blok CSS mati (warisan komponen theme lain yang tidak ada di `sekolahane`), menghapus duplikasi selector dan properti yang saling menimpa di blok yang sama, serta menggabungkan blok `@media` yang terpecah-pecah.

## Scope
- [x] **Tahap 1 — Hapus 16 Blok Komponen CSS Mati (0% Terpakai di PHP/JS):**
  - `.flex-list`, `.flex-list__item`
  - `.ane-title .sub-judul`
  - `.search-result`, `.ane-search-form`
  - `.kontak-cs` beserta `@media screen and (max-width: 676px)` (widget lama yang sudah digantikan `.cc-contactpop`)
  - `.skillframe`, `.single-framework`, `.framwork-icon`, `.framework-name .progress`
  - `.home-client`, `.ane-konten-client`, `.post-type-archive-partner`
  - `.btn-default`, `.btn-putih`, `.btn-outline`
  - `.ane-header .primary-mobile-menu .tools-mobile` & `.header-navigation`
  - `.ane-page-about`, `.content-header`, `.home-why`
  - `.page-template-page-home .site-content`
  - `.ane-single-overlay`
  - `.ane-single-team` beserta seluruh sub-class `.teams-detail`, `.skills-detail`, `.team-skills`, `.team-framework`
  - `#footer-bar .badge`
  - `.mobile-populer`
- [x] **Tahap 2 — Hapus Duplikasi Selector & Properti Ganda di Blok yang Sama:**
  - Gabungkan rule ganda `.ane-title h1, .ane-title h2`.
  - Bersihkan 18 properti ganda yang tertimpa di dalam rule yang sama (`.webane-wrapper`, `.ane-kategori a`, `.ane-paginasi ul li span`, `.ane-sosmed ul li a`, `.ane-header .atas`, `#main-menu`, `.mean-nav`, `.home-slider`, `.blocks-gallery-item figure`, `.tagcloud a`, `.ane-konten-testimoni header`, `.orangnya span`, `.ane-konten-guru .entry-content`, `#footer-bar`).
- [x] **Tahap 3 — Konsolidasi Blok `@media` yang Bersebelahan & Minifikasi Ulang:**
  - Gabungkan blok `@media (max-width: 767px)` yang berurutan menjadi satu blok bersih.
  - Compile ulang `css/main.min.css` dan verifikasi keseimbangan kurung kurawal (`862 == 862`) serta `Remaining dead rules: 0`.

## Di Luar Scope
- Mengubah warna, ukuran font, atau tampilan komponen aktif.

## Referensi
- `css/main.css`, `css/main.min.css`

## Keputusan Kecil Selama Eksekusi
- Tetap mempertahankan seluruh class WordPress Core / Gutenberg (`.wp-block-*`, `.alignleft`, `.alignright`, `.wp-caption`, `.cat-item`, `.tagcloud`, `.wpcf7-*`) karena class tersebut dihasilkan dinamis oleh editor WordPress atau plugin form di konten pelanggan.

## Checklist Penutupan (SOP)
- [x] `composer security:scan` lolos
- [x] `composer analyse` lolos (0 error PHPStan)
- [x] `composer dist:check` lolos
- [x] Security Review dijalankan & dilaporkan
- [x] `PROGRESS.md` diupdate

## Known Limitations
- Tidak ada.

## Ringkasan Hasil
- **62 Rule / 16 Blok Komponen CSS Mati Dihapus (~496 baris di `css/main.css`):** Seluruh CSS warisan dari theme company profile/agency (`.skillframe`, `.home-client`, `.ane-konten-client`, `.post-type-archive-partner`, `.ane-page-about`, `.ane-single-team`, `.ane-single-overlay`, `.kontak-cs`, `.mobile-populer`, dll) telah bersih (`Remaining dead rules: 0`).
- **18 Properti Ganda & Blok `@media` Bersebelahan Dirapikan:** Tidak ada lagi properti yang saling menimpa di dalam selector yang sama.
- **Ukuran `css/main.min.css` Turun Menjadi `74.0 KB` (`75,785 bytes`):** Padahal di dalamnya sudah termasuk subset Bootstrap Grid/Reboot/Utilities + `.ane-svg`! Artinya, dibanding kondisi awal (`240.5 KB` total CSS + `250 KB` font `FontAne`), beban aset CSS & Font berkurang drastis tanpa mengubah tampilan visual sedikit pun.

### Hasil Security Review
| Kategori | Status | Catatan |
|---|---|---|
| Asset & CSS Integrity | Lolos | Keseimbangan kurung kurawal terverifikasi (`862 == 862`), filter IE lawas `progid:DXImageTransform.Microsoft.gradient` pada `.kontak-cs` ikut terhapus. |
| Clean Release (`dist:check`) | Lolos | Hanya `css/main.min.css` yang masuk ke paket rilis pelanggan. |
