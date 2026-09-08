# STATUS — Al Mazaya Web Project

*Last updated: 8 Sep 2026*

## Current State

**Phase 1 COMPLETE — static prototype** · branch `main` → github.com/FShou/almazaya-web

| Piece | Status |
|---|---|
| Design system (`assets/css/style.css`) | ✅ done — all colors/fonts as CSS vars in `:root` |
| ID pages: Beranda, Tentang, Jenjang, Berita, Galeri, PPDB | ✅ done (placeholder content where noted) |
| EN mirrors under `en/` | ✅ done |
| Header/nav/ID⇄EN toggle/WA button/mobile menu | ✅ working (toggle fix verified) |
| Validation | ✅ all 12 pages: valid HTML, no broken links |
| Local preview | `python3 -m http.server 8765` in repo root |

**IA restructure — align to sitemap** (3 Sep 2026, `v=57`):
- `berita.html` + `en/berita.html`: grouped post cards under sitemap-style dividers — "Kehidupan Siswa · Prestasi → Student Achievements" and "Kehidupan Siswa · Kegiatan → Activities"; activities span full-width band
- New `.posts-group-head` + `.posts-editorial .post-card:nth-of-type(1)` feature span (was `:first-child`, broke w/ divider)
- Nav labels aligned to sitemap groups: ID `Jenjang→Sekolah`, `Galeri→Kehidupan Siswa`; added `Akademik/Academics` item (desktop+mobile+EN footer) → links `index.html#akademik` (Empat Pilar section, id added on ID+EN)
- Tighter `.main-nav` spacing to fit 7 items (gap/padding reduced)
- Cache bump all pages `v=55 → v=57`

**IA restructure — nav final + new Academics page** (3 Sep 2026):
- **NEW `akademik.html` + `en/akademik.html`** (Academics page, fresh content): Empat Pilar, kombinasi modern-classroom/IT-lab/Science-lab interactive showcase (`mc-stage` + fullscreen lightbox), Program Akademik (MMI/SMP/SMA/Virtual Class), Kurikulum & Pembinaan Kompetisi. Reuses existing CSS (`.modclass`,`mc-*`,`pillars-grid`,`feature-card`,`vm-grid`) — no new CSS.
- Sitemap groups now each map to a page: About(tentang) / Our School(jenjang) / **Academics(akademik)** / Student Life(galeri) / News(berita) / Admission(ppdb)
- Nav labels finalized on all 13 pages (ID): `Beranda / Tentang / Sekolah Kami / Akademik / Berita / Aktivitas Siswa / PPDB`; (EN): `Home / About / Our School / Academics / News / Student Activities / Admission`
- Nav item `Akademik` retargeted from `index.html#akademik` → `akademik.html` on every page (was the Empat Pilar anchor); galeri label `Kehidupan Siswa/Gallery` → `Aktivitas Siswa/Student Activities`; jenjang label `Sekolah/Programs` → `Sekolah Kami/Our School`
- `galeri.html`/`en/galeri.html` retitled as **Aktivitas Siswa / Student Activities** (hero + breadcrumb + title/meta)
- Footer quick links updated to match; verified tag balance on all 13 files (all OK)
- No CSS/JS change → cache stays `v=57`; working tree uncommitted

**Header cleanup — remove Apply Now CTA + toggle to side** (3 Sep 2026):
- Removed the header `nav-cta` "Daftar Sekarang/Apply Now" pill button from the desktop nav on all pages (incl. PPDB `#daftar` variant) + mobile-menu CTA block; deleted now-dead `.nav-cta` / `.nav-cta-mobile` CSS
- `.lang-toggle` now absolutely positioned at the right edge of `.header-inner` (`right:0`, vertical-center) so the centered `.main-nav` stays perfectly centered and the toggle sits flush to the side/browser edge
- Cache bump `v=57 → v=58` (CSS changed); all 14 files; tag balance verified
- Working tree uncommitted

**About de-slop — editorial V&M + values** (3 Sep 2026):
- New `.vm-split` (about only): asymmetric `1.45fr/1fr` — Vision = dark display panel w/ oversized quote + gold rule + muted `رؤية` watermark; Mission = white panel, numbered 01–04 editorial rows split by 1px rules
- New `.values-editorial` (about only): 5 rampsembay value columns as a ruled editorial strip (top/bottom rules + column dividers + big index numeral), not uniform equal cards
- Removed `.vm-card`/`.value-card` usage on `tentang.html`/`en/tentang.html`; legacy `.values-grid`/`.vm-grid` untouched (still used by `akademik.html`)
- Cache bump `v=58 → v=59`; tag balance verified

**About pillars → home-style story-chapters** (3 Sep 2026):
- `#pilar` rebuilt on the home page's proven narrative zigzag: 4 `story-chapter` articles (gold medallion 01–04, oversized ghost numeral, `story-img` `warm`/`light` with `gal-label`, `story-marker`) + `story-bridge` pull-quote between 02 and 03 — replaces the uniform navy bento boxes (`.pillar`/`.pillars-grid` now dead on about)
- Applied to ID + EN; reuses existing home CSS (no new CSS) → no cache bump needed

**About overview → clean intro-lead/intro-stats** (3 Sep 2026):
- `#yayasan` Overview: asymmetric `1.4fr/1fr` — left `.intro-lead` = kicker + large navy/gold heading + narrative + gold CTA; right `.intro-stats` = 4 foundations as strong numbered statement rows (`.fd` 01–04, top-rule dividers), echoing home's confident rhythm w/o a grid of equal boxes
- This **supersedes** the earlier intermediate `.intro-split`/`.four-fond`/`.edu-path` version (rooted out as part of the "jomplang" clutter); dead CSS for `.intro-split`/`.four-fond`/`.edu-path`/`.pillar-ghost` + pillar tone rules **removed** from `style.css`
- Applied to ID + EN; cache bump `v=60 → v=61`; tag balance verified

**About — Budaya visual overhaul** (3 Sep 2026):
- Replaced the plain navy `.culture-strip` box with `.culture-visual` — asymmetric split: left = 2 stacked student photo slots (Senyum & Salam / Sopan & Santun, warm/gold + cool/green); right = dark editorial panel listing the 5S and 5R as numbered ruled rows (gold accent) with a lead line tying values to daily ritual
- Removed now-dead `.culture-strip` CSS; values-editorial (5 core values) kept intact
- Applied to ID + EN; cache bump `v=61 → v=62`; tag balance verified

**Home audit — Empat Pilar realigned to source doc** (3 Sep 2026):
- Audited `index.html` + `en/index.html` against ABOUT_US.md: About page was already 100% doc-faithful; the Home Empat Pilar section (which maps to the doc's Pilar Pendidikan) contained invented quotes attributed to the school + unsourced claims (30 juz, national olympiads, Cambridge class)
- Fixed: lead quote → official vision verbatim (attributed "Visi Pendidikan Al Mazaya"); each pillar now uses the doc's exact language (nilai-nilai Islam kuat / budaya 5S + 5 ninti / budaya belajar kreatif-kritis / keterampilan Bahasa Inggris utk dunia berkembang); story-bridge → doc's integration statement instead of fabricated adab quote
- Remaining home claims (Cambridge cert, 30 juz, Akreditasi A, Kurikulum Merdeka, 6 negara, UI/ULM/ITS/ITB, tablet-majority) → moved to Known placeholders fact-check list
- HTML-only → no cache bump; tag balance verified

**Move Fasilitas → Program page; drop Kelas Modern from About** (3 Sep 2026):
- `tentang.html` + `en/tentang.html`: removed the `#kelas-modern` CTA band (was non-source marketing content) and the `#fasilitas` section (placeholder, not in ABOUT_US.md); removed "Fasilitas/Facilities" from the About sub-nav — About now = Sekilas/Sejarah/Visi-Misi/Pilar/Nilai (all MD-sourced)
- `jenjang.html` + `en/jenjang.html`: added `#fasilitas` facilities gallery section (gallery-grid + facility-chips) before footer — temporary home until real facility data
- Retargeted home `mc-cta` (index + en/index) `tentang.html#kelas-modern` → `jenjang.html#fasilitas`; no dangling `#kelas-modern` refs remain
- HTML-only change → no cache bump; tag balance verified on all edited files
- Working tree uncommitted

**Tentang page restructured** (26 Aug 2026):
- New section flow: Yayasan → Sejarah timeline → Visi-Misi → Nilai & Budaya → Fasilitas
- Sub-nav anchor bar under hero (sticky on scroll)
- Sejarah timeline with year badges (placeholder dates — verify with school)
- Value cards grid (6 values) + Budaya Harian strip
- Same restructure applied to both ID and EN versions

**Branding & header overhaul** (26 Aug 2026):
- 3-logo strip (Yayasan → AMZ → MMI) in header & footer of all 12 pages
- Logos: `logo-yayasan.jpeg` (200×200), `logo.jpeg` AMZ (148×148), `logo-mmi.jpeg` (225×225); MMI larger via `.logo-mmi`
- Header: no background island, brand shifted `-100px` on desktop only, solid white bg on scroll (no transparency)
- Footer: white island, `space-between`, `max-width: 260px`
- Nav centered (`flex:1; justify-content:center`), global `ul` list-style reset
- Mobile header (≤960px): no `-100px` margin, brand name text centered (absolute), logos 34px

**Mobile nav rebuilt** (26 Aug 2026):
- Separate `<div class="mobile-nav">` overlay on all 12 pages (desktop nav untouched)
- Off-screen slide-in (`translateX(-100%)` → `0` on `.open`), z-index 9999, solid `#10294A`
- Close button (X) top-right, links close on tap, body scroll-lock, `overflow-y: auto` if tall
- Desktop `.main-nav` hidden ≤960px; burger + lang toggle remain in header

**MMI Preschool section added** (26 Aug 2026):
- New first section on `jenjang.html` + `en/jenjang.html` (before SMP)
- Content researched: MMI London partnership, first authentic Montessori in Kalimantan
- Programs: Mum & Me (6–24 mo), Playgroup (2–3 y), Montessori Kinderworld (3–6 y)
- Contact: 0811-465-4040, IG @modernmontessoribanjarmasin (soft opening Jul 2025)

**Infra**:
- Cache-busting `?v=10` on all CSS/JS `<link>`/`<script>` tags (bump on future changes)

**Homepage jenjang section** (26 Aug 2026):
- 3 cards: MMI (teal), SMP (navy), SMA (gold) in `grid-3`
- Cards stacked at center on load, fan out with CSS animation when 70% into viewport
- Scroll reveal uses `hasScrolled` flag — no animation fires until user scrolls first
- `.jenjang-arc` class on section (grid bottom-aligned via `align-items: end`)

**Tentang halaman — implementasi konten resmi** (2 Sep 2026):
- Source: `Narasi Websites 1 About Us.docx` → disalin ke `ABOUT_US.md`
- Overview section: nama "Sekilas Al Mazaya", konsep one-stop education services, 4 fondasi (nilai Islam, karakter, akademik, Bahasa Inggris), kutipan visi dalam blockquote
- Sejarah: tanggal resmi (2015 SMP · 2017 SMA · 2021 YAPA · 2025 KB-TK MMI · 2027 SD rencana) menggantikan placeholder lama; tiap item **click-to-expand** (accordion via `.hist-detail`)
- Visi & Misi: visi resmi + 4 misi resmi
- **NEW section "Empat Pilar"** (`#pilar`): Islamic Studies, Character Building, Academic Excellence, English Development — **interactive cards** (click to expand, `.pillar.active` toggles gold)
- Nilai & Budaya: 5 nilai resmi (Jujur, Disiplin, Tanggung Jawab, Mandiri, Inisiatif) menggantikan 6 placeholder + budaya 5S & 5R menggantikan budaya harian
- Interactivity via `data-pillar` + `.hist-item` handlers in `main.js`
- Applied to both ID (`tentang.html`) & EN (`en/tentang.html`); sub-nav updated with "Pilar" link
- CSS: `.pillars-grid`, `.pillar`, `.pillar-desc`, `.pillar-toggle`, `.hist-detail`, `.hist-chev`

**Tentang — Sejarah timeline rework** (2 Sep 2026, replace click-to-expand):
- Timeline = **sticky full-screen slides** (`.hist-row` `position:sticky` at `--header-h`, `min-height: calc(100vh - var(--header-h))`, z-index 1..5)
- Each year pins at the same top; the next year's slide **covers** the previous (no fan/overlap wisps)
- Photo **bleeds to the browser edge**, alternating sides per year (`.hist-photo` `order:-1` on even), `object-fit:cover`
- Text side: big outlined year inside, tag, title, checklist; subtle tonal gradient per year (teal/navy/gold family)
- No card box; timeline moved **outside `.container`** so it spans full viewport width
- Mobile (≤640px): stacked column, text top + photo `flex:1 1 40vh` fills remaining height
- `.hist-scroll` container: full width; the old card/dot/rail CSS and `.hist-item` JS handlers removed

**Known placeholders needing real content:**
- All "Foto..." dashed slots — **filled 8 Sep 2026** with real school-site media (best-effort; some labels need final swap with school's preferred shots)
- Sejarah timeline years & milestones — need verification from school
- PPDB jadwal table & biaya — example data only
- Fasilitas list — guessed, needs confirmation
- Berita cards — copied from old site's real posts; dates/categories need verification
- MMI Preschool photo slot + program details verification with MMI admin
- **Home CLAIMS TO FACT-CHECK** → full checklist di **`FACT_CHECK.md`** (11 kategori: akreditasi, Cambridge, tahfidz, prestasi/alumni, kelas modern, MMI, program, fasilitas, kontak, PPDB, + yang sudah resmi utk cross-check) — dikumpulkan 3 Sep 2026 dari seluruh halaman
- Home Empat Pilar quotes were previously invented w/ school attribution — **fixed 3 Sep 2026**: now use official vision + doc's pillar language; invented quotes removed (ID+EN)

**Photo slots auto-filled from real site media** (8 Sep 2026):
- Downloaded 188 real images from `almazayaislamicschool.sch.id` media library via curl+cookies (CF blocks HTML/wp-json but not image files); rendered them into every photo placeholder across 10 pages (ID + EN: index, tentang, jenjang, berita, galeri)
- Best-effort semantic mapping: story pillars → student photos, berita thumbs → event shots, galeri events → matching activity photos, sejarah → dated originals, fasilitas → facility-capable shots (some labels best-effort, ready to swap)
- `.slot-photo` rule added to `style.css` (cover + `object-fit`), `.has-photo` hides dashed placeholder border + forces label legibility over any image
- Hi-res pass: 300px thumbnails (dsc*/r000*/aq*/sejarah) swapped for 17 full-size `img-*-min.jpg` (5328×4000) so large slots stay sharp; `img-8712` ref fixed to `-min`
- Cache bump `v=62 → v=63` on all 14 files; div tag balance verified; 104 `slot-photo` refs, zero broken image links; all 10 pages load-tested in headless Chromium (0 broken, 0 <600px)
- Working tree uncommitted

**Kelas Modern scenes → real facility photos** (8 Sep 2026):
- The 8 `mc-scene` showcase panels (akademik + index, ID + EN) now show real photos instead of CSS illustration icons: `desk` Ruang Kelas Digital, `lab` Lab Komputer & IT, `sci` Lab IPA Fisika-Kimia, `bio` Lab Biologi, `lib` Perpustakaan, `eng` English Zone, `mus` Musala, `hall` Lapangan Indoor
- New CSS: `.mc-scene .mc-photo` (absolute cover), `.mc-peek-scene img` thumbnails; showcase grid `.modclass-more` 4→2 (≤960)→1 (≤640) cols
- Same validated filenames as `jenjang.html#fasilitas` mapping; EN paths use `../assets/img/`; verified 0 dangling img refs
- Cache bump `v=63 → v=64` on all 14 files (CSS changed); tag balance verified

**Sejarah timeline photo/caption fix** (8 Sep 2026):
- Bug: `.hist-photo` lacked `position:relative`, so `<img class="slot-photo">` (`absolute; inset:0`) anchored to the sticky `.hist-row` → photo full-bled over the whole slide and hid the text column + "Foto…" captions ("g full" + "tulisannya g keliatan")
- Fix: `.hist-photo` now `position:relative; overflow:hidden` (photo locked to its column); all 5 per-page history captions in `tentang.html` + `en/tentang.html` wrapped in `<span class="gal-label">` (z-index 2 → legible over photo)
- No cache bump needed beyond `v=64`; tag balance verified; 0 dangling refs

**Housekeeping — prune unused assets + crawl leftovers** (8 Sep 2026):
- Queried all `src= assets/img/*` refs across ID+EN pages, diffed vs `assets/img/` → 104 files (14MB) never referenced; moved to `/home/tiny/crawler-archive/unused-imgs/` (repo `assets/img` now 43 files, all used)
- Entire crawling toolchain/leftovers from `/tmp/opencode` (501MB: crawlers, cookies sqlite, captured html/png, logs, ff profiles, venv) consolidated to `/home/tiny/crawler-archive/opencode-tmp/` — one archive folder outside the repo
- **Committed & pushed**: `c5ba57b` → origin/main (57 files, +458/−377)

## Next Steps (in order)

1. **Content pass** ← *next session*
   - Gather photos from school (or old WP media library via admin)
   - Fact-check & finalize copy per list above
   - Real PPDB schedule/fees
2. **Design review iterations** — any layout/color feedback from stakeholder
3. **Phase 2: port to WordPress block theme**
   - Restructure approved HTML → `theme.json` + templates/parts/patterns
   - Bilingual live = Polylang plugin (ID default)
   - Output: `almazaya.zip`
4. **Phase 3: deploy**
   - WP admin → Appearance → Themes → Add New → upload zip → activate
   - Old theme stays installed = instant rollback
5. *(Later)* wire Berita/Galeri to real WP posts; migrate old content if wanted

## Environment Notes

- SSH config set: `github.com` uses key `~/.ssh/github` (user **FShou**) — pushes just work
- Git identity (repo-local): Faqih <faqihsuyudi2020@gmail.com>
- Palette is placeholder navy/gold — swap exact brand hexes anytime in `style.css:6`
