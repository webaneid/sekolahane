# Conventions

## PHP
- Ikuti **WordPress Coding Standards** (dicek otomatis oleh PHPCS):
  tab untuk indentasi, `snake_case` untuk fungsi/variabel, spasi di dalam
  kurung `foo( $bar )`, Yoda condition tidak diwajibkan.
- Prefix baru: fungsi/hook/option/transient `sekolahane_`, konstanta
  `SEKOLAHANE_`, class `Sekolahane_`.
- Kompatibilitas: PHP **7.4+**, WordPress **6.0+**. Fitur PHP 8-only
  (`str_contains`, `match`, named args) jangan dipakai kecuali ada polyfill WP.
- Satu file `inc/` = satu area tanggung jawab (`inc/enqueue.php`,
  `inc/updater.php`, `inc/cpt-guru.php`, ...). Hindari file "serba ada".
- Komentar boleh Bahasa Indonesia; docblock fungsi publik minimal berisi
  satu kalimat tujuan + `@param`/`@return`.

## Template
- Template hierarchy WordPress di root; potongan reusable di `tp/`.
- Template part tidak boleh query/logika berat — taruh di fungsi `inc/`,
  template cukup memanggil dan meng-escape output.
- Nama file template part: `tp/{kelompok}/{nama}.php`, kebab-case.

## Aset
- SCSS/CSS sumber → `css/main.css`, hasil minify `css/main.min.css`.
- Library pihak ketiga: utamakan disimpan lokal (bukan CDN) atau, kalau CDN,
  versi dipin + atribut SRI. Keputusan per library dicatat di ADR.

## Branch
- `main` — production. Setiap merge berpotensi rilis ke semua pelanggan.
- `feat/{nama}`, `fix/{nama}`, `docs/{nama}`, `chore/{nama}` — dari `main`,
  di-merge kembali lewat PR (setelah repo GitHub ada).
- Branch protection di GitHub (setelah repo dibuat): `main` wajib PR + status
  check CI lolos, blokir force-push.

## Commit Message (Conventional Commits)
Format: `type(scope): deskripsi singkat` — deskripsi Bahasa Indonesia boleh.

| Type | Kapan | Memicu rilis? |
|---|---|---|
| `feat` | fitur baru yang terlihat pengguna | ✅ minor |
| `fix` | perbaikan bug | ✅ patch |
| `perf` | peningkatan performa | ✅ patch |
| `refactor` | ubah struktur tanpa ubah perilaku | ❌ |
| `style` | format kode (bukan CSS tampilan!) | ❌ |
| `docs` | dokumentasi | ❌ |
| `chore` | tooling, config, dependensi dev | ❌ |
| `test` | test | ❌ |

- Perubahan tampilan CSS yang terlihat pengguna = `fix` atau `feat`, bukan `style`.
- Scope contoh: `updater`, `guru`, `header`, `security`, `enqueue`, `docs`.
- Breaking: tambahkan footer `BREAKING CHANGE: ...` (jarang — lihat SOP).

## Versi
- Sumber kebenaran: `Version:` di `style.css`, dibaca ke konstanta
  `SEKOLAHANE_VERSION`. Dinaikkan otomatis oleh CI, jangan manual.
