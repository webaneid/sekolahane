# Glossary

| Istilah | Arti |
|---|---|
| **Guru** | Custom post type `guru` — profil tenaga pengajar |
| **Ekstrakurikuler** | Custom post type `ekstrakurikuler` — kegiatan ekstrakurikuler |
| **Testimoni** | Custom post type `testimoni` — testimoni alumni/wali |
| **Kelas**, **Pelajaran** | Custom taxonomy untuk CPT `guru` (`inc/custompost.php`). ⚠️ Slug taxonomy Kelas terdaftar dengan huruf kapital `'Kelas'` (rewrite `'kelas'`) — jangan diubah ke lowercase karena data term pelanggan terikat ke `'Kelas'`. |
| **Webane Settings** | Halaman option ACF milik theme (info umum, banner, customer care) |
| **Fase** | Satu unit kerja menurut `SOP.md` |
| **ADR** | Architecture Decision Record — catatan keputusan besar (`docs/decisions/`) |
| **Rilis** | Versi baru yang dibuat CI saat merge ke `main`; otomatis ditawarkan ke situs pelanggan |
| **Situs pelanggan** | Situs customer Webane yang memakai theme ini |
