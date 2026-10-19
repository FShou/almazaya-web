# Al Mazaya Islamic School — WordPress Theme

Custom theme ported 1:1 from the static site (`rehaul` branch, cache v106).
Bilingual ID/EN, tested-up-to WordPress 7.0, requires PHP 7.4+.

## Rilis zip otomatis (GitHub Actions)

```bash
git tag v1.0.3 && git push origin v1.0.3
```

Push tag `v*` menjalankan workflow **Release theme zip**: versi theme
disamakan dengan tag → `almazaya.zip` di-build → dilampirkan ke
**GitHub Release** (lihat tab Releases). Unduh zip dari sana untuk upload ke WP.
Rilis ulang manual: Actions → Release theme zip → Run workflow → isi tag.

## Update theme di produksi (aman)

Aman — konten (post, page, menu, media, user) dan setting (Customizer,
Polylang) tersimpan di **database**, terpisah dari file theme. Selama nama
folder theme tetap `almazaya`, update file **tidak menghapus** apapun:

1. Backup dulu (UpdraftPlus/Duplicator atau panel hosting).
2. Unduh `almazaya.zip` dari rilis baru → Appearance → Themes → Add New →
   Upload → WordPress menawari **penggantian versi** → konfirmasi.
   (Alternatif 1-klik: plugin gratis **Git Updater** — WP menampilkan
   notifikasi update dari GitHub Releases.)
3. Cek homepage + 2-3 halaman + clear cache (plugin cache/CDN bila ada).
4. Gagal? Upload ulang zip versi lama dari tab Releases (= rollback),
   atau restore backup.

Jangan edit file theme langsung di produksi (hilang saat update) — pakai
Customizer → Additional CSS, atau child theme untuk kustom berat. Key
setting (`almazaya_*`) dijaga stabil antar rilis; bila ada perubahan
skema, dicatat di release notes.

## Deploy langsung ke produksi (tanpa staging)

Bisa — theme ini sudah lolos tes live di WP 7.0.7. Urutan aman:

1. **Backup penuh** WP produksi (file + database) — via hosting panel / plugin
   (UpdraftPlus, Duplicator). Simpan backup di luar server.
2. (Opsional tapi disarankan) Nyalakan **maintenance mode** 15–30 menit
   (plugin Maintenance / .maintenance) agar pengunjung tidak melihat proses setup.
3. Upload `almazaya.zip` (dari `./package-theme.sh`) → Appearance → Themes →
   **jangan Activate dulu** — klik **Live Preview** untuk cek tampilan dengan
   konten produksi (hanya admin yang melihat).
4. Kalau preview oke → **Activate**. Lalu setup: permalink *Post name* (cek),
   Polylang + bahasa, 10 page + template, menu, homepage, Customizer
   (tautan, gambar, teks, logo).
5. Verifikasi: buka 10 halaman ID + EN, tes menu/dropdown, form/kontak, HP view.
   Matikan maintenance mode.
6. **Rollback bila gagal**: restore backup langkah 1 (atau switch theme lama
   kembali — theme lama jangan dihapus sebelum stabil).

## Deploy ke staging (new.almazaya.com)

1. `./package-theme.sh` → hasil `almazaya.zip` (jangan commit file zip).
   Alternatif tanpa zip: upload isi folder ini via SFTP ke
   `wp-content/themes/almazaya/` (butuh `style.css` di root folder theme).
2. Di hosting: buat subdomain `new` (document root terpisah dari domain utama),
   aktifkan SSL (AutoSSL/Let's Encrypt), install WordPress 7.0 + database baru.
3. Di WP staging: Appearance → Themes → Upload `almazaya.zip` → Activate,
   lalu ikut bagian **Install** di bawah.
4. Kunci staging: Settings → Reading → *Discourage search engines* (+ opsional
   plugin Password Protected agar hanya internal yang bisa lihat).

## Install

1. Zip folder ini (`style.css` harus di root zip) → **Appearance → Themes → Add New → Upload**.
   Atau copy ke `wp-content/themes/almazaya/`, lalu Activate.
2. **Settings → Permalinks → Post name** (wajib — URL internal theme memakai pretty permalink).
3. Install + aktifkan plugin **Polylang**, buat 2 bahasa: `id` (default) dan `en`.
4. Buat 10 Page dengan slug persis ini (isi boleh kosong — konten dari template):
   `beranda` (jadikan **Homepage** di Settings → Reading), `tentang`,
   `jenjang` (hub Sekolah Kami), `mmi`, `smp`, `sma`, `berita`, `berita-detail`
   (template Detail Berita — dibaca via `?a=slug`), `galeri`, `ppdb`
   — lalu terjemahkan ke EN via Polylang (+ ikon). Slug terjemahan boleh beda
   (mis. `tentang` → `about`, URL `/en/about/`) — switcher bahasa mengikuti
   relasi terjemahan, bukan slug. Jangan lupa Settings → Permalinks → Save
   ulang tiap tambah bahasa.
5. Template sudah **nempel otomatis** ke slug (file `page-{slug}.php`), jadi
   tiap Page langsung tampil desain penuhnya — tak perlu pilih Template manual.
   Boleh juga dipilih manual di dropdown *Template* (daftar `… — Al Mazaya`).
6. **Appearance → Menus**: theme membuat menu awal **otomatis** (Menu Utama +
   Menu Footer, sudah terpasang ke lokasinya) saat pertama aktif — tinggal
   edit/tambah item. Kalau kosong pun tetap jalan (fallback otomatis = link
   bawaan ID/EN). Untuk bahasa kedua, buat menu terjemahannya lewat Polylang.
   (Markup menu dashboard otomatis disamakan dengan gaya bawaan: dropdown
   submenu tetap berfungsi.)
7. **Appearance → Customize → Tautan Al Mazaya**: isi URL SHS/JHS Virtual Class,
   Instagram (+ Instagram MMI), WhatsApp, YouTube, Portal PSB (default sudah terisi URL produksi).
8. **Settings → General**: Site Title = `Al Mazaya Islamic School` (tampil di
   tab browser + judul SEO; tagline opsional). Lalu
   **Appearance → Customize → Site Identity**: upload logo (opsional; fallback
   memakai logo bawaan theme) + Site Icon (pengganti favicon statis).
9. **Edit gambar & teks dari dashboard** (tanpa utak-atik file):
   - **Gambar: Beranda/Tentang/Sekolah/Jenjang/Berita/Galeri** — klik ganti
     51 foto konten (default = foto bawaan theme). Alt text tetap dari template.
   - **Teks: Footer/Kontak/CTA Pendaftaran** — tagline, jam layanan, nama
     yayasan, telepon & IG MMI, teks CTA PPDB MMI/SMP/SMA (varian ID & EN).
   - Berita/artikel dikelola via **Posts** (featured image = foto sampul).
   Tambah item baru: 1 baris di `almazaya_content_images()` /
   `almazaya_content_texts()` (functions.php) + 1 pemanggilan helper di template.

## Struktur

- `functions.php` — supports, enqueue (Ubuntu font + `assets/css/style.css` +
  `assets/js/main.js`), 2 lokasi menu, Customizer 7 URL, helper
  `almazaya_url()` / `almazaya_link()` / `almazaya_lang_suffix()`.
- `header.php` / `footer.php` — topbar, header+nav, mobile-nav, footer, tombol WA.
- `front-page.php`, `page-{tentang,jenjang,mmi,smp,sma,berita,berita-detail,galeri,ppdb}.php`
  — template tipis yang nempel otomatis ke slug halaman (tetap bisa dipilih
  manual di dropdown Template); konten di `template-parts/pages/{slug}-{id,en}.php`
  + `template-parts/dynamic/` (loop CPT).
- `page.php`, `single.php`, `index.php`, `404.php` — fallback WP standar.
- `languages/almazaya.pot` — katalog string theme (11 string chrome/admin).
- Versi asset mengikuti `ALMAZAYA_VERSION` (ganti tiap rilis agar cache pecah).

## Konten dinamis (tambah/hapus dari dashboard)

- **Posts → Berita**: halaman Berita = loop asli (6/halaman, filter
  `?kategori=slug`, pagination beneran). Kategori: `prestasi/kegiatan/pengumuman`
  (ID) + `achievement/event/announcement` (EN, terjemahkan via Polylang).
  Teaser beranda = 3 post terbaru otomatis. Detail = `single.php`.
- **Slide Hero / Mitra / Program** (CPT): tambah-hapus-urut dari dashboard
  (featured image = gambar; urutan = Page Attributes → Order).
  - Slide: kicker, judul (HTML), deskripsi (editor), 2 tombol (`page:slug`
    jadi link halaman), badge, bg foto. Tanpa foto = gradient navy.
  - Mitra: nama (title), negara (excerpt), logo (featured), URL website.
    Logo SVG tidak bisa di-upload WP — pakai PNG/WebP/JPG.
  - Program: label (title), judul panel + poin (meta box), deskripsi (editor),
    foto, key data = slug (unik, tanpa spasi).
  - Destinasi (peta overseas): **pilih negara dari dropdown** (249 negara —
    otomatis isi nama ID/EN, emoji bendera & koordinat; tetap bisa edit manual
    untuk tempat khusus), nama sekolah (title), tag, URL website, deskripsi
    (editor), logo (featured), key = slug (huruf kecil). Koordinat real
    (lat/lng) diproyeksikan ke peta SVG dunia; label anti-tabrakan otomatis.
  - EN: duplikat via Polylang (Translations). Tanpa entri = tampil konten
    bawaan theme (fallback statis, tidak kosong).
- **Seed demo**: `WP_PATH=... WP_CLI="php .../wp-cli.phar" ./bin/seed-demo.sh`
  (kategori, 3 post, 3 slide, 4 mitra, **15 program lengkap**, 5 destinasi
  + foto dari theme). Idempoten (bagian yang sudah ada di-skip).
  Isi artikel lengkap: salin dari halaman detail statis (`rehaul`).
- **Galeri dari Instagram**: dua cara (salah satu).
  Username doang tanpa token resmi Meta **tidak bisa** (akses publik ditutup
  2018) — yang "cukup username" itu widget pihak ketiga:
  1. *Plugin* (mis. Smash Balloon Social Photo Feed gratis): hubungkan akun
     IG bisnis/kreator → salin shortcode (mis. `[instagram-feed]`).
  2. *Widget username* (mis. SociableKIT / Stormlikes / Fouita, ada yang
     gratis): generate dari `@username` → salin **kode embed**-nya.
  Tempel salah satunya di Customize → Galeri Instagram (terima shortcode
  ATAU kode embed mentah). Selama kosong, halaman Galeri memakai grid foto
  bawaan (bisa diganti per foto via Gambar: Galeri).

## Catatan porting (v1)

- Konten halaman masih statis 1:1 dari HTML (ID/EN dipilih via locale).
  Migrasi ke block editor/ACF bisa incremental per halaman.
- Halaman PPDB tidak punya `<form>` (CTA mengarah ke Portal PSB eksternal).
- `hreflang` + switcher bahasa otomatis dari Polylang.

## Local dev

Butuh Docker + `wp-env` (`npm i -g @wordpress/env`):

```bash
wp-env start   # http://localhost:8888 (admin: admin/password)
```

`.wp-env.json` sudah diset: tema ter-mount, permalink postname, Polylang
ter-install otomatis, homepage = halaman `beranda`.

## Tes lokal tanpa Docker (terverifikasi 2026-10-12)

Stack: MariaDB lokal + PHP built-in server + wp-cli, WordPress 7.0.7, PHP 7.4:

```bash
sudo service mariadb start
sudo mysql -e "CREATE DATABASE wptest; CREATE USER 'wptest'@'localhost' IDENTIFIED BY 'wptest123'; GRANT ALL ON wptest.* TO 'wptest'@'localhost';"
# download + extract WP 7.0.x ke /tmp/wpsite, lalu:
ln -s /path/ke/repo-branch-wordpress /tmp/wpsite/wp-content/themes/almazaya
# wp-config.php: DB wptest/wptest/wptest123 + salts + WP_DEBUG true
wp core install --url='http://127.0.0.1:9000' --title='Al Mazaya Test' \
  --admin_user=admin --admin_password='...' --admin_email='a@b.c' --skip-email
wp theme activate almazaya
wp option update permalink_structure '/%postname%/' && wp rewrite flush
wp plugin install polylang --activate
# 10 page (slug: beranda,tentang,jenjang,mmi,smp,sma,berita,berita-detail,galeri,ppdb),
# assign template *-nya, homepage = beranda, buat menu bila perlu
cd /tmp/wpsite && php -S 127.0.0.1:9000 router.php  # lihat router.php di bawah
```

`router.php` (taruh di root WP, hanya untuk dev):

```php
<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($path !== '/' && is_file(__DIR__ . $path)) { return false; }
require __DIR__ . '/index.php';
```

Hasil tes: 10/10 halaman 200 ID & EN (locale `wp site switch-language`),
dropdown klik, lightbox, filter, router `?a=`, mobile nav, 0 PHP error —
plus override `set_theme_mod()` terbukti mengganti output render.
