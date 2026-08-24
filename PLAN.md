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

| ID page | EN mirror | Content |
|---|---|---|
| `index.html` Beranda | `en/index.html` | Hero slider, Keunggulan, Program Unggulan, Prestasi, Agenda/Berita cards, Galeri teaser, CTA PPDB, Kontak strip |
| `tentang.html` | `en/tentang.html` | Visi-misi, profil, fasilitas, akreditasi |
| `jenjang.html` | `en/jenjang.html` | SMP & SMA program pages |
| `berita.html` | `en/berita.html` | News grid (placeholder cards for now) |
| `galeri.html` | `en/galeri.html` | Event galleries (placeholders) |
| `ppdb.html` | `en/ppdb.html` | Admission info + button ke psb subdomain |

Header: logo + nav + **ID ⇄ EN toggle** + WA floating button.
Footer: kontak, tautan cepat, sosmed, copyright.

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

## Status log

- [x] Research current site + reference template
- [x] Plan finalized & approved
- [x] Phase 1 static prototype → see STATUS.md for details & next steps
- [ ] Content pass (photos, fact-check, real PPDB data)
- [ ] Design review & iterations
- [ ] Phase 2 block theme port
- [ ] Phase 3 deployment
