# Al Mazaya Islamic School — WordPress Theme

Custom theme ported 1:1 from the static site (`rehaul` branch, cache v106).
Bilingual ID/EN, tested-up-to WordPress 7.0, requires PHP 7.4+.

## Install

1. Zip folder ini (`style.css` harus di root zip) → **Appearance → Themes → Add New → Upload**.
   Atau copy ke `wp-content/themes/almazaya/`, lalu Activate.
2. **Settings → Permalinks → Post name** (wajib — URL internal theme memakai pretty permalink).
3. Install + aktifkan plugin **Polylang**, buat 2 bahasa: `id` (default) dan `en`.
4. Buat 10 Page dengan slug persis ini (isi boleh kosong — konten dari template):
   `beranda` (jadikan **Homepage** di Settings → Reading), `tentang`,
   `jenjang` (hub Sekolah Kami), `mmi`, `smp`, `sma`, `berita`, `berita-detail`
   (template Detail Berita — dibaca via `?a=slug`), `galeri`, `ppdb`
   — lalu terjemahkan ke EN via Polylang (+ ikon).
5. Di tiap Page → **Template**: pilih `… — Al Mazaya` yang sesuai
   (Tentang wajib pakai template *Tentang* agar class `about` aktif;
   MMI/SMP/SMA pakai template masing-masing).
6. **Appearance → Menus**: buat menu *Primary* (6 item utama + submenu
   MMI/SMP/SMA di bawah Sekolah Kami, tiap bahasa) assign ke *Menu Utama*; buat menu footer assign ke *Menu Footer*.
   Tanpa menu pun jalan (fallback otomatis = link bawaan ID/EN).
7. **Appearance → Customize → Tautan Al Mazaya**: isi URL SHS/JHS Virtual Class,
   Instagram, WhatsApp, YouTube, Portal PSB (default sudah terisi URL produksi).
8. **Appearance → Customize → Site Identity**: upload logo (opsional; fallback
   memakai logo bawaan theme) + Site Icon (pengganti favicon statis).

## Struktur

- `functions.php` — supports, enqueue (Ubuntu font + `assets/css/style.css` +
  `assets/js/main.js`), 2 lokasi menu, Customizer 7 URL, helper
  `almazaya_url()` / `almazaya_link()` / `almazaya_lang_suffix()`.
- `header.php` / `footer.php` — topbar, header+nav, mobile-nav, footer, tombol WA.
- `front-page.php`, `template-{tentang,akademik,jenjang,berita,galeri,ppdb}.php`
  — template tipis; konten di `template-parts/pages/{slug}-{id,en}.php`.
- `page.php`, `single.php`, `index.php`, `404.php` — fallback WP standar.
- `languages/almazaya.pot` — katalog string theme (11 string chrome/admin).
- Versi asset mengikuti `ALMAZAYA_VERSION` (ganti tiap rilis agar cache pecah).

## Catatan porting (v1)

- Konten halaman masih statis 1:1 dari HTML (ID/EN dipilih via locale).
  Migrasi ke block editor/ACF bisa incremental per halaman.
- Template *Berita* = listing statis; `single.php` siap untuk post Berita WP
  begitu redaksi mulai publish via Posts.
- Halaman PPDB tidak punya `<form>` (CTA mengarah ke Portal PSB eksternal).
- `hreflang` + switcher bahasa otomatis dari Polylang.

## Local dev

Butuh Docker + `wp-env` (`npm i -g @wordpress/env`):

```bash
wp-env start   # http://localhost:8888 (admin: admin/password)
```

`.wp-env.json` sudah diset: tema ter-mount, permalink postname, Polylang
ter-install otomatis, homepage = halaman `beranda`.
