# Fase 42 — Perbaikan Tumpukan Teks & Slide pada Hero Slider (`js/sekolahane.js`)

**Status:** Done

## 1. Masalah & Root Cause
- **Gejala:** Saat Hero Slider (`.home-big-slider`) berpindah ke slide berikutnya, teks dan konten dari slide sebelumnya tetap tertinggal dan bertumpuk di atas slide baru.
- **Root Cause:** Sama persis dengan yang pernah terjadi di `makhadane` (commit `0a56ba9`): konfigurasi OwlCarousel pada `.home-big-slider` di [`js/sekolahane.js`](../../js/sekolahane.js) masih menggunakan opsi `animateOut: 'fadeOut'` dan `animateIn: 'fadeIn'`. Padahal stylesheet `animate.css` sudah dihapus sejak konsolidasi aset (Fase 02). Tanpa keyframe CSS `fadeOut`/`fadeIn`, OwlCarousel menambahkan inline `style="left: ...px"` pada `.owl-item` lama dan menunggu event `animationend` yang tidak pernah terpanggil, sehingga slide lama tidak pernah dibersihkan posisinya dan bertumpuk dengan slide aktif.

## 2. Solusi
- Mengganti `animateOut: 'fadeOut'` dan `animateIn: 'fadeIn'` dengan `smartSpeed: 700` pada inisialisasi `.home-big-slider` di [`js/sekolahane.js`](../../js/sekolahane.js), sehingga OwlCarousel menggunakan transisi geser native `translate3d` (`700ms`) yang membawa gambar beserta teksnya secara utuh dan sinkron.

## 3. File yang Diubah
- `js/sekolahane.js`
- `docs/PROGRESS.md`
- `docs/lessons-learned.md`
