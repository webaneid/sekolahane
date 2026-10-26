# Fase 16 — Redesign Section Call to Action (`tp/section/calltoaction.php`)

- **Status:** `Done`
- **Tanggal:** 2026-10-27

## Tujuan
1. **3 Pilihan Gaya Desain Call to Action (`ane_cta_style`):**
   - **1. Floating Bento Split (`bento` — Default):** Kartu raksasa membulat (`border-radius: 28px`) di dalam container dengan *dark-gold gradient mesh* + *ambient glow* di atas foto background. Kolom kiri menampilkan teks ajakan (judul & deskripsi), sedangkan kolom kanan menampilkan panel tombol aksi.
   - **2. Full-Width Glassmorphism Stage (`glass`):** Section *full-width* dari ujung ke ujung layar (menghapus `background-attachment: fixed` yang bermasalah di Safari iOS) dengan kartu kaca buram (*Frosted Glass*, `backdrop-filter: blur(16px)`) rata tengah di atas latar foto.
   - **3. Asymmetric Image Frame (`frame`):** Kartu *split* modern di mana foto yang di-upload tampil utuh dan terang di dalam bingkai kanan, sedangkan sisi kiri berisi judul, deskripsi, dan tombol aksi.
2. **Opsi Margin Bawah (`ane_cta_margin`):**
   - `yes` (`Pakai Margin Bawah` / `80px`) atau `no` (`Tanpa Margin Bawah (Menempel)` / `0px`).
3. **Opsi Tombol Pendamping WhatsApp Otomatis (`ane_cta_wa`):**
   - Menampilkan tombol kedua *"Chat WhatsApp"* yang otomatis mengambil nomor WA sekolah dari pengaturan `sosmed_ane` / `contact_ane` untuk mendongkrak konversi pendaftaran.
4. **Fallback Tanpa Gambar Background:**
   - Memperbaiki pembatas lama `if ( ! empty( $image ) )` agar section CTA tetap tampil mewah dengan *luxury dark-gold gradient* meskipun admin belum mengunggah foto background.

## File yang Diubah
- `docs/PROGRESS.md`
- `docs/phases/phase-16-redesign-section-calltoaction.md`
- `inc/acf-json/field-groups.json`
- `tp/section/calltoaction.php`
- `css/main.css`
- `css/main.min.css`

## Checklist Verifikasi
- [x] `python3 bin/css-audit.py` -> `0 dead CSS rules`
- [x] `bash bin/security-scan.sh` -> Lolos
- [x] `bash bin/check-dist.sh` -> Lolos
- [x] PHPCS (`tp/section/calltoaction.php`) & PHPStan -> `0 errors`
