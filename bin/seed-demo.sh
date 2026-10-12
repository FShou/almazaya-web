#!/usr/bin/env bash
# Seed demo content: categories, posts, slides, mitra, programs.
# Usage (from theme root on branch wordpress):
#   WP_PATH=/tmp/opencode/wpsite WP_CLI="php /tmp/opencode/wp-cli.phar" ./bin/seed-demo.sh
# Re-running duplicates content. EN translations: do via Polylang dashboard
# (this seeds ID content; EN templates show it too until translated).
set -euo pipefail
THEME_DIR="$(cd "$(dirname "$0")/.." && pwd)"
WP_PATH="${WP_PATH:-/tmp/opencode/wpsite}"
WP="${WP_CLI:-wp}"
A="$THEME_DIR/assets/img"

wp() { ( cd "$WP_PATH" && $WP "$@" ); }

echo "== bersihkan konten bawaan WP (hello world, sample page) =="
HELLO=$(wp post list --post_type=post --name=hello-world --format=ids 2>/dev/null || true)
[ -n "$HELLO" ] && wp post delete $HELLO --force >/dev/null || true
SAMPLE=$(wp post list --post_type=page --name=sample-page --format=ids 2>/dev/null || true)
[ -n "$SAMPLE" ] && wp post delete $SAMPLE --force >/dev/null || true

echo "== categories =="
wp term create category Prestasi --slug=prestasi --description="Prestasi siswa" >/dev/null || true
wp term create category Kegiatan --slug=kegiatan --description="Kegiatan sekolah" >/dev/null || true
wp term create category Pengumuman --slug=pengumuman --description="Pengumuman resmi" >/dev/null || true
wp term create category Achievement --slug=achievement >/dev/null || true
wp term create category Event --slug=event >/dev/null || true
wp term create category Announcement --slug=announcement >/dev/null || true

img() { wp media import "$A/$1" --porcelain --title="$2"; }

echo "== posts (3) =="
P1IMG=$(img overseas-img-8635-min.webp "Prestasi Olimpiade")
P1=$(wp post create --post_type=post --post_title="4 Siswi SMP Al Mazaya Raih Medali Olimpiade Nasional" --post_excerpt="Prestasi membanggakan di kancah nasional yang kembali membuktikan mutu pembinaan akademik Al Mazaya." --post_content="Prestasi membanggakan di kancah nasional yang kembali membuktikan mutu pembinaan akademik Al Mazaya. (Isi lengkap menyusul dari redaksi.)"  --post_status=publish --porcelain)
wp post meta update "$P1" _thumbnail_id "$P1IMG" >/dev/null
wp post term add "$P1" category prestasi >/dev/null
P2IMG=$(img school-debate-competition-aq1.webp "Debat UIN")
P2=$(wp post create --post_type=post --post_title='Juara 2 Debat "International Events" UIN Antasari' --post_excerpt="Siswi SMA Al Mazaya sukses meraih posisi kedua dalam kompetisi debat tingkat perguruan tinggi." --post_content="Siswi SMA Al Mazaya sukses meraih posisi kedua dalam kompetisi debat tingkat perguruan tinggi. (Isi lengkap menyusul dari redaksi.)"  --post_status=publish --porcelain)
wp post meta update "$P2" _thumbnail_id "$P2IMG" >/dev/null
wp post term add "$P2" category prestasi >/dev/null
P3IMG=$(img overseas-img-8679-min.webp "English Talent Show")
P3=$(wp post create --post_type=post --post_title="English Talent Show: Panggung Bakat Siswa Setiap Bulan" --post_excerpt="Nyanyian, tari tradisional, drama, pidato, hingga tilawah Al-Qur'an ditampilkan dalam acara bulanan sekolah." --post_content="Nyanyian, tari tradisional, drama, pidato, hingga tilawah Al-Qur'an ditampilkan dalam acara bulanan sekolah. (Isi lengkap menyusul dari redaksi.)"  --post_status=publish --porcelain)
wp post meta update "$P3" _thumbnail_id "$P3IMG" >/dev/null
wp post term add "$P3" category kegiatan >/dev/null
echo "posts: $P1 $P2 $P3"

echo "== slides (3) =="
S1IMG=$(img home-20221214074906-img-6966.webp "Hero ABUELA")
S1=$(wp post create --post_type=slide --post_title="Slide 1 Adab Akademik" --post_content="Kecerdasan intelektual harus beriringan dengan keluhuran akhlak." --post_status=publish --menu_order=1 --porcelain)
wp post meta update "$S1" _thumbnail_id "$S1IMG" >/dev/null
wp post meta update "$S1" _almazaya_kicker "Assalamu'alaikum warahmatullahi wabarakatuh" >/dev/null
wp post meta update "$S1" _almazaya_heading 'Kuat dalam Adab, Unggul dalam <span class="tone">Akademik</span>' >/dev/null
wp post meta update "$S1" _almazaya_btn1_label "Daftar Sekarang" >/dev/null
wp post meta update "$S1" _almazaya_btn1_url "page:ppdb" >/dev/null
wp post meta update "$S1" _almazaya_btn2_label "Profil Sekolah" >/dev/null
wp post meta update "$S1" _almazaya_btn2_url "page:tentang" >/dev/null
wp post meta update "$S1" _almazaya_badge_title "Akreditasi A" >/dev/null
wp post meta update "$S1" _almazaya_badge_text "Kurikulum Merdeka · SMP & SMA" >/dev/null
S2IMG=$(img overseas-img-8730-min.webp "Hero Global")
S2=$(wp post create --post_type=slide --post_title="Slide 2 Global" --post_content="Membekali siswa dengan Bahasa Inggris intensif dan Overseas Program." --post_status=publish --menu_order=2 --porcelain)
wp post meta update "$S2" _thumbnail_id "$S2IMG" >/dev/null
wp post meta update "$S2" _almazaya_kicker "Sekolah Berwawasan Global" >/dev/null
wp post meta update "$S2" _almazaya_heading 'Berwawasan <span class="tone">Global</span>' >/dev/null
wp post meta update "$S2" _almazaya_btn1_label "Lihat Program" >/dev/null
wp post meta update "$S2" _almazaya_btn1_url "page:jenjang" >/dev/null
S3IMG=$(img quran-academy-r0003011.webp "Hero Tahfidz")
S3=$(wp post create --post_type=slide --post_title="Slide 3 PPDB" --post_content="Pendaftaran siswa baru SMP & SMA tahun ajaran baru telah dibuka." --post_status=publish --menu_order=3 --porcelain)
wp post meta update "$S3" _thumbnail_id "$S3IMG" >/dev/null
wp post meta update "$S3" _almazaya_kicker "PPDB Dibuka" >/dev/null
wp post meta update "$S3" _almazaya_heading "Bergabunglah dengan Keluarga Besar Al Mazaya" >/dev/null
wp post meta update "$S3" _almazaya_btn1_label "Daftar Online" >/dev/null
wp post meta update "$S3" _almazaya_btn1_url "https://psb.almazayaislamicschool.sch.id" >/dev/null
wp post meta update "$S3" _almazaya_btn2_label "Info PPDB" >/dev/null
wp post meta update "$S3" _almazaya_btn2_url "page:ppdb" >/dev/null
echo "slides: $S1 $S2 $S3"

echo "== mitra (4; MITA menyusul manual karena logo SVG) =="
M1IMG=$(img logo-mmi-site.webp "Logo MMI")
M1=$(wp post create --post_type=mitra --post_title="Modern Montessori International (MMI)" --post_excerpt="Singapore" --post_status=publish --menu_order=1 --porcelain)
wp post meta update "$M1" _thumbnail_id "$M1IMG" >/dev/null
wp post meta update "$M1" _almazaya_url "https://modern-montessori.com" >/dev/null
M2IMG=$(img logo-minaret.webp "Logo Minaret")
M2=$(wp post create --post_type=mitra --post_title="Minaret College" --post_excerpt="Australia" --post_status=publish --menu_order=2 --porcelain)
wp post meta update "$M2" _thumbnail_id "$M2IMG" >/dev/null
wp post meta update "$M2" _almazaya_url "https://minaret.vic.edu.au" >/dev/null
M3IMG=$(img logo-luc.webp "Logo LUC")
M3=$(wp post create --post_type=mitra --post_title="Lincoln University College (LUC)" --post_excerpt="Malaysia" --post_status=publish --menu_order=3 --porcelain)
wp post meta update "$M3" _thumbnail_id "$M3IMG" >/dev/null
wp post meta update "$M3" _almazaya_url "https://www.lincoln.edu.my" >/dev/null
M4IMG=$(img quran-academy-r0003011.webp "Logo Harvest")
M4=$(wp post create --post_type=mitra --post_title="Harvest International School" --post_excerpt="Turkey" --post_status=publish --menu_order=4 --porcelain)
wp post meta update "$M4" _thumbnail_id "$M4IMG" >/dev/null
echo "mitra: $M1 $M2 $M3 $M4 (tanpa URL = kartu non-link)"

echo "== programs (3) =="
G1IMG=$(img classroom-r0003050.webp "Foundation Class")
G1=$(wp post create --post_type=program --post_name=fnd --post_title="Foundation Class" --post_content="Program pembuka jenjang untuk membangun adab, karakter, dan keterampilan dasar belajar." --post_excerpt="Program pembuka jenjang untuk membangun adab dan karakter." --post_status=publish --menu_order=1 --porcelain)
wp post meta update "$G1" _thumbnail_id "$G1IMG" >/dev/null
wp post meta update "$G1" _almazaya_heading 'Mulai dengan <span class="tone">Fondasi</span> yang Kuat' >/dev/null
wp post meta update "$G1" _almazaya_items '<li><span class="mc-dot"></span><b>Montessori & Fondasi</b> — ramah anak</li><li><span class="mc-dot gold"></span><b>Adab & Karakter</b> — sejak hari pertama</li>' >/dev/null
G2IMG=$(img overseas-dsc09507.webp "Overseas Program")
G2=$(wp post create --post_type=program --post_name=ovs --post_title="Overseas Program" --post_content="Imersi singkat di sekolah mitra luar negeri." --post_excerpt="Imersi singkat di sekolah mitra luar negeri." --post_status=publish --menu_order=2 --porcelain)
wp post meta update "$G2" _thumbnail_id "$G2IMG" >/dev/null
wp post meta update "$G2" _almazaya_heading 'Belajar <span class="tone">Lintas Negara</span>' >/dev/null
wp post meta update "$G2" _almazaya_items '<li><span class="mc-dot"></span><b>Kemitraan Global</b> — MMI, MITA, Minaret, LUC, Harvest</li>' >/dev/null
G3IMG=$(img quran-academy-r0003011.webp "Program Tahfidz")
G3=$(wp post create --post_type=program --post_name=tfd --post_title="Program Tahfidz" --post_content="Pembinaan tahfidz berjenjang dengan halaqah rutin." --post_excerpt="Pembinaan tahfidz berjenjang dengan halaqah rutin." --post_status=publish --menu_order=3 --porcelain)
wp post meta update "$G3" _thumbnail_id "$G3IMG" >/dev/null
wp post meta update "$G3" _almazaya_heading 'Hafalan <span class="tone">Al-Qur'"'"'an</span>' >/dev/null
wp post meta update "$G3" _almazaya_items '<li><span class="mc-dot"></span><b>Halaqah Rutin</b> — setoran terjadwal</li>' >/dev/null
echo "programs: $G1 $G2 $G3"
wp rewrite flush >/dev/null
echo "== tetapkan bahasa ID bila Polylang aktif =="
wp eval 'if (function_exists("pll_set_post_language")) { $ids=get_posts(array("post_type"=>"any","post_status"=>"any","posts_per_page"=>-1,"fields"=>"ids")); foreach($ids as $id){ if(!pll_get_post_language($id)) pll_set_post_language($id,"id"); } $terms=get_terms(array("taxonomy"=>array("category"),"hide_empty"=>false,"fields"=>"ids")); foreach($terms as $t){ if(!pll_get_term_language($t)) pll_set_term_language($t,"id"); } echo "lang assigned\n"; } else { echo "polylang off, skip\n"; }'
echo DONE
