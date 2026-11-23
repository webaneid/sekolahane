# Fase 43 — Perbaikan Tinggi Kartu Section Featured di Mobile (`css/main.css`)

**Status:** Done

## 1. Masalah & Root Cause
- **Gejala:** Pada tampilan mobile (`<= 767px`), kartu di `.section-featured.featured-style-default` terlihat sangat tinggi (`290px`) dengan ruang kosong besar di bagian bawah, padahal di mobile elemen deskripsi (`<p>`) dan tombol (`.btn-primary`) disembunyikan sehingga hanya menyisakan ikon dan judul `<h3>`.
- **Root Cause:** Konflik spesifisitas CSS (*CSS specificity*):
  - Pada aturan desktop (baris 3604), `.section-featured.featured-style-default ul li` memiliki `min-height: 290px;` dengan spesifisitas **`(0, 2, 2)`**.
  - Pada blok `@media (max-width: 767px)` (baris 3799), reset `min-height: 0;` ditulis menggunakan selektor `.section-featured ul li` yang hanya memiliki spesifisitas **`(0, 1, 2)`**.
  - Akibatnya, `min-height: 290px` dari desktop tetap menang di mobile dan memaksa kartu memanjang ke bawah.

## 2. Solusi
- Menambahkan `.section-featured.featured-style-default ul li` pada blok `@media (max-width: 767px)` di [`css/main.css`](../../css/main.css) agar `min-height: 0;` menang secara spesifisitas.
- Mengatur kartu mobile dengan `display: flex; align-items: center; justify-content: center;`, proporsi ikon `42x42` px, margin ringkas, serta stretched-link (`h3 a::after { inset: 0; }`) agar seluruh area kartu dapat disentuh di mobile.

## 3. File yang Diubah
- `css/main.css` & `css/main.min.css`
- `docs/PROGRESS.md`
