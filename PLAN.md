# Al Mazaya Islamic School — Website Rebuild Plan

> Redesign of https://almazayaislamicschool.sch.id (WordPress, currently outdated).
> Strategy: **static HTML prototype first → port to WordPress block theme → deploy via WP admin.**
> No local WordPress environment — prototype is reviewed directly in the browser.

## Brand

- **School:** Al Mazaya Islamic School (SMP & SMA), Banjarmasin
  Jl. Cempaka Besar No. 57, Kel. Mawar, Banjarmasin Tengah, Kalimantan Selatan
- **Foundation:** Yayasan Al Mazaya Pelita Asia · Akreditasi A · Kurikulum Merdeka
- **Logo:** `~/Downloads/almazaya logo.jpeg` (low-res; header/favicon use OK)
- **Colors:** biru donker (navy) + gold, from the logo:

| Token | Hex | Role |
|---|---|---|
| `--navy` | `#10294A` | primary brand, headers, hero |
| `--navy-deep` | `#0A1D36` | dark sections, hover |
| `--gold` | `#C9A227` | accent, CTA, highlights |
| `--gold-soft` | `#E8CE7A` | hover accents |
| `--mist` | `#F3F6FB` | light section bg |
| `--slate` | `#334155` | body text |

- **Typography:** Ubuntu (Google Fonts, 300–800)
- **Design language** (reference: template184.webekspor.com): hero slider,
  dual-tone headings, card grids/carousels, scroll-reveal animations — rebuilt
  clean with vanilla CSS/JS (no Elementor/Astra).

## Contact / links to wire in

- WhatsApp: +62 811-5051-123 (`https://wa.me/628115051123`)
- Email: humas@almazayaislamicschool.sch.id
- Instagram: @almazayaislamicschool · YouTube: @almazayaislamicschool1244
- PSB online: https://psb.almazayaislamicschool.sch.id (linked, kept as-is)

## Site structure (ID primary, EN secondary)

Sitemap groups covered by the nav (Beranda / Tentang / Sekolah Kami / Akademik / Berita / Aktivitas Siswa / PPDB):

| ID page | EN mirror | Content |
|---|---|---|
| `index.html` Beranda | `en/index.html` | Hero slider, Keunggulan, Program Unggulan, Prestasi, Agenda/Berita cards, Aktivitas teaser, CTA PPDB, Kontak strip |
| `tentang.html` Tentang | `en/tentang.html` | Visi-misi, profil, fasilitas, akreditasi |
| `jenjang.html` Sekolah Kami | `en/jenjang.html` | SMP & SMA program pages (Our School) |
| `akademik.html` Akademik | `en/akademik.html` | Pilar evaluasi, modern classroom / virtual class, program akademik, kurikulum & pembinaan kompetisi |
| `berita.html` Berita | `en/berita.html` | News grid grouped (Prestasi / Kegiatan) |
| `galeri.html` Aktivitas Siswa | `en/galeri.html` | Student activities galleries (placeholders) |
| `ppdb.html` PPDB | `en/ppdb.html` | Admission info + button ke psb subdomain |

Header: logo + nav + **ID ⇄ EN toggle** + WA floating button.
Footer: kontak, tautan cepat, sosmed, copyright.
Nav label mapping: ID `Beranda / Tentang / Sekolah Kami / Akademik / Berita / Aktivitas Siswa / PPDB`;
EN `Home / About / Our School / Academics / News / Student Activities / Admission`.

## Phases

### Phase 1 — Static HTML prototype *(current)*
Plain HTML/CSS/JS in this repo. Self-contained: Google Fonts only external dep.
Images that need real school photos = labeled placeholder slots.

### Phase 2 — Port approved design → WP block theme `almazaya.zip`
Same HTML restructured into block theme:
```
almazaya/
├── style.css        theme header
├── theme.json       palette, typography, spacing tokens
├── templates/       front-page, index, single, page, archive, search, 404
├── parts/           header, footer
├── patterns/        hero, keunggulan, prestasi, berita grid, galeri, cta-ppdb
└── assets/          css/js/fonts/logo
```
Bilingual on live site via Polylang (ID default). Posts skipped for now —
news section wired later to WP posts.

### Phase 3 — Deploy via WP admin (no FTP)
1. Appearance → Themes → Add New → upload `almazaya.zip` → Activate
2. Old theme stays installed = instant rollback; content untouched

## Plan (saved) — CDN blur-up photos, site-wide

**Goal:** blur-up image loading — tiny blurred copy of each photo shows instantly, full-res fades in sharp on `load`. CDN-generated placeholder (Cloudinary / Imgix / ImageKit), CDN-agnostic.

**Scope:** all ~70 photo slots across the 12 pages:
- `hist-photo` ×10 (tentang + en/tentang timeline: `2015-smp`, `2017-sma`, `2021-yapa`, `2025-kbtk`, `2027-sd`)
- `img-slot` / `post-thumb` ×~60 (galeri grid, berita thumbs, about overview, jenjang cards)

**Pattern — every slot becomes a wrap with 2 layers + fallback:**
```html
<figure class="img-slot bp-wrap reveal d1" data-bp-base="…">  <!-- slug filled later -->
  <img class="bp-blur" alt="">
  <img class="bp-full" alt="…">
  <span class="gal-label bp-cap">…caption…</span>  <!-- overlay caption kept on loaded photos -->
  <span class="bp-fallback">Foto Prestasi</span>    <!-- dashed placeholder text -->
</figure>
```
- `.img-slot` class retained → existing sizing kept (post-thumb 170px, galeri aspect-ratios, min-height slots)
- bare "Foto …" text → `.bp-fallback`; galeri `.gal-label` stays as permanent overlay
- outer classes (`warm`/`light`/`tall`/`reveal`) untouched; EN pages reuse the same slugs/assets

**CSS state machine:**
- default (no `data-bp-base`) / `has-fallback` → only dashed placeholder visible (today's look)
- `bp-loading` → tiny blurred layer (`filter: blur(20px)`, scaled) shown
- `bp-loaded` → full layer fades in + de-blurs (`opacity 0→1`, `blur(8px)→0`); dashed `::after` hidden
- `.gal-label` gets a subtle bottom scrim when `bp-loaded` for readability

**JS (`main.js`, new IIFE):**
- top config: `BLUR_SUFFIX` + `FULL_SUFFIX` (one-line CDN swap, e.g. Cloudinary `w_25,e_blur:1200,f_auto,q_auto`)
- per `.bp-wrap`: empty `data-bp-base` → keep fallback; else set srcs, add `bp-loading` → `bp-loaded` on `load`, `has-fallback` on `error`; handle cached (`complete`); honor `prefers-reduced-motion`

**Edits:** 12 HTML pages (scriptable slot conversion, slug from caption), `style.css` (`.bp-*` + states), `main.js` (loader), cache bump v41 → v42.

**Not touched:** hero slider (text-only; trivial to add photo+blur later).

## Status log

- [x] Research current site + reference template
- [x] Plan finalized & approved
- [x] Phase 1 static prototype → see STATUS.md for details & next steps
- [ ] Content pass (photos, fact-check, real PPDB data)
- [ ] Design review & iterations
- [ ] Phase 2 block theme port
- [ ] Phase 3 deployment
