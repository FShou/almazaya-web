# STATUS — Al Mazaya Web Project

*Last updated: 26 Aug 2026*

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

**Known placeholders needing real content:**
- All "Foto..." dashed slots (hero, profil, jenjang, galeri, berita thumbs) — need school photos
- Sejarah timeline years & milestones — need verification from school
- PPDB jadwal table & biaya — example data only
- Fasilitas list — guessed, needs confirmation
- Berita cards — copied from old site's real posts; dates/categories need verification
- Copy fact-check: Cambridge claim, alumni UI/ULM/ITS/ITB, 4 olympiad medals
- MMI Preschool photo slot + program details verification with MMI admin

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
