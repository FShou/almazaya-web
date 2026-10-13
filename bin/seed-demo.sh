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

if [ "$(wp post list --post_type=post --format=count 2>/dev/null)" -eq 0 ]; then
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

fi
if [ "$(wp post list --post_type=slide --format=count 2>/dev/null)" -eq 0 ]; then
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

fi
if [ "$(wp post list --post_type=mitra --format=count 2>/dev/null)" -eq 0 ]; then
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

fi
if [ "$(wp post list --post_type=program --format=count 2>/dev/null)" -eq 0 ]; then
echo "== programs (15, full) =="
G1IMG=$(img classroom-r0003050.webp 'Foundation Class' 2>/dev/null) || true
G1=$(wp post create --post_type=program --post_name=fnd --post_title='Foundation Class' --post_content='Program pembuka jenjang untuk membangun adab, karakter, dan keterampilan dasar belajar dengan pendekatan yang ramah anak dan bertahap.' --post_excerpt='Program pembuka jenjang untuk membangun adab, karakter, dan keterampilan dasar belajar dengan pendekatan yang ramah anak dan bertahap.' --post_status=publish --menu_order=1 --porcelain)
[ -n "$G1IMG" ] && wp post meta update "$G1" _thumbnail_id "$G1IMG" >/dev/null || true
wp post meta update "$G1" _almazaya_heading 'Mulai dengan <span class="tone">Fondasi</span> yang Kuat' >/dev/null
wp post meta update "$G1" _almazaya_items '<li><span class="mc-dot"></span><b>Montessori & Fondasi</b> — metode pertama yang ramah anak</li><li><span class="mc-dot gold"></span><b>Adab & Karakter</b> — dibiasakan sejak hari pertama</li><li><span class="mc-dot teal"></span><b>Keterampilan Dasar</b> — siap sebelum beranjak naik</li>' >/dev/null
G2IMG=$(img overseas-dsc09507.webp 'Overseas Program' 2>/dev/null) || true
G2=$(wp post create --post_type=program --post_name=ovs --post_title='Overseas Program' --post_content='Imersi singkat di sekolah mitra luar negeri untuk menumbuhkan wawasan global, kemandirian, dan jejaring internasional.' --post_excerpt='Imersi singkat di sekolah mitra luar negeri untuk menumbuhkan wawasan global, kemandirian, dan jejaring internasional.' --post_status=publish --menu_order=2 --porcelain)
[ -n "$G2IMG" ] && wp post meta update "$G2" _thumbnail_id "$G2IMG" >/dev/null || true
wp post meta update "$G2" _almazaya_heading 'Belajar <span class="tone">Lintas Negara</span>' >/dev/null
wp post meta update "$G2" _almazaya_items '<li><span class="mc-dot"></span><b>Kemitraan Global</b> — MMI, MITA, Minaret, LUC, Harvest</li><li><span class="mc-dot gold"></span><b>Imersi Budaya</b> — hidup & belajar di luar negeri</li><li><span class="mc-dot teal"></span><b>Jaringan Internasional</b> — teman dari berbagai negara</li>' >/dev/null
G3IMG=$(img quran-academy-r0003011.webp 'Program Tahfidz' 2>/dev/null) || true
G3=$(wp post create --post_type=program --post_name=tfd --post_title='Program Tahfidz' --post_content='Pembinaan tahfidz berjenjang dengan halaqah rutin, murajaah terjadwal, dan pendampingan penuh dari ustadz pembimbing.' --post_excerpt='Pembinaan tahfidz berjenjang dengan halaqah rutin, murajaah terjadwal, dan pendampingan penuh dari ustadz pembimbing.' --post_status=publish --menu_order=3 --porcelain)
[ -n "$G3IMG" ] && wp post meta update "$G3" _thumbnail_id "$G3IMG" >/dev/null || true
wp post meta update "$G3" _almazaya_heading 'Hafalan <span class="tone">Al-Qur'"'"'an</span>' >/dev/null
wp post meta update "$G3" _almazaya_items '<li><span class="mc-dot"></span><b>Halaqah Rutin</b> — setoran hafalan terjadwal</li><li><span class="mc-dot gold"></span><b>Target Berjenjang</b> — sesuai kemampuan siswa</li><li><span class="mc-dot teal"></span><b>Murajaah Terjaga</b> — hafalan tetap kuat</li>' >/dev/null
G4IMG=$(img english-talent-show-screenshot-20230829-140122.webp 'Club & Enrichment' 2>/dev/null) || true
G4=$(wp post create --post_type=program --post_name=clb --post_title='Club & Enrichment' --post_content='Klub dan pengayaan lintas bidang — sains, seni, olahraga, bahasa — untuk menyalurkan minat dan potensi siswa.' --post_excerpt='Klub dan pengayaan lintas bidang — sains, seni, olahraga, bahasa — untuk menyalurkan minat dan potensi siswa.' --post_status=publish --menu_order=4 --porcelain)
[ -n "$G4IMG" ] && wp post meta update "$G4" _thumbnail_id "$G4IMG" >/dev/null || true
wp post meta update "$G4" _almazaya_heading 'Bakat <span class="tone">Diasah</span>' >/dev/null
wp post meta update "$G4" _almazaya_items '<li><span class="mc-dot"></span><b>Pilihan Klub</b> — sesuai minat & bakat</li><li><span class="mc-dot gold"></span><b>Pembinaan Olimpiade</b> — rapi menuju kompetisi</li><li><span class="mc-dot teal"></span><b>Soft Skill</b> — komunikasi & kepemimpinan</li>' >/dev/null
G5IMG=$(img home-img-1509.webp 'Life Skill' 2>/dev/null) || true
G5=$(wp post create --post_type=program --post_name=lsk --post_title='Life Skill' --post_content='Keterampilan hidup praktis yang membentuk kemandirian siswa: mengelola diri, berkolaborasi, dan menghadapi kehidupan nyata.' --post_excerpt='Keterampilan hidup praktis yang membentuk kemandirian siswa: mengelola diri, berkolaborasi, dan menghadapi kehidupan nyata.' --post_status=publish --menu_order=5 --porcelain)
[ -n "$G5IMG" ] && wp post meta update "$G5" _thumbnail_id "$G5IMG" >/dev/null || true
wp post meta update "$G5" _almazaya_heading 'Kecakapan <span class="tone">Hidup</span>' >/dev/null
wp post meta update "$G5" _almazaya_items '<li><span class="mc-dot"></span><b>Kemandirian</b> — mengurus diri sehari-hari</li><li><span class="mc-dot gold"></span><b>Kelola & Rencana</b> — bekal hidup mandiri</li><li><span class="mc-dot teal"></span><b>Kolaborasi</b> — bekerja dalam tim</li>' >/dev/null
G6IMG=$(img senior-high-school-a-capture.webp 'Uji Mutu Lulusan' 2>/dev/null) || true
G6=$(wp post create --post_type=program --post_name=uji --post_title='Uji Mutu Lulusan' --post_content='Standar kompetensi lulusan yang terukur melalui asesmen berkala agar setiap lulusan benar-benar siap melanjutkan studi.' --post_excerpt='Standar kompetensi lulusan yang terukur melalui asesmen berkala agar setiap lulusan benar-benar siap melanjutkan studi.' --post_status=publish --menu_order=6 --porcelain)
[ -n "$G6IMG" ] && wp post meta update "$G6" _thumbnail_id "$G6IMG" >/dev/null || true
wp post meta update "$G6" _almazaya_heading 'Mutu <span class="tone">Terjamin</span>' >/dev/null
wp post meta update "$G6" _almazaya_items '<li><span class="mc-dot"></span><b>Standar Kompetensi</b> — capaian jelas & terukur</li><li><span class="mc-dot gold"></span><b>Asesmen Berkala</b> — pantauan perkembangan</li><li><span class="mc-dot teal"></span><b>Sertifikat Capaian</b> — bukti kualitas lulusan</li>' >/dev/null
G7IMG=$(img 2527-z1.webp 'TKA & UTBK Intensive' 2>/dev/null) || true
G7=$(wp post create --post_type=program --post_name=utb --post_title='TKA & UTBK Intensive' --post_content='Pendalaman padat untuk tes masuk perguruan tinggi: TKA, UTBK, dan try out berkala agar lulusan diterima di PTN pilihan.' --post_excerpt='Pendalaman padat untuk tes masuk perguruan tinggi: TKA, UTBK, dan try out berkala agar lulusan diterima di PTN pilihan.' --post_status=publish --menu_order=7 --porcelain)
[ -n "$G7IMG" ] && wp post meta update "$G7" _thumbnail_id "$G7IMG" >/dev/null || true
wp post meta update "$G7" _almazaya_heading 'Tembus <span class="tone">PTN</span> Favorit' >/dev/null
wp post meta update "$G7" _almazaya_items '<li><span class="mc-dot"></span><b>Try Out Berkala</b> — ukur kesiapan tiap pekan</li><li><span class="mc-dot gold"></span><b>Pembahasan Tuntas</b> — semua subtes dikuasai</li><li><span class="mc-dot teal"></span><b>Simulasi UTBK</b> — terbiasa dengan format asli</li>' >/dev/null
G8IMG=$(img overseas-dsc09466.webp 'Outing Class' 2>/dev/null) || true
G8=$(wp post create --post_type=program --post_name=otg --post_title='Outing Class' --post_content='Pembelajaran kontekstual di luar ruangan yang menghubungkan teori dengan pengalaman nyata — alam, museum, industri, dan komunitas.' --post_excerpt='Pembelajaran kontekstual di luar ruangan yang menghubungkan teori dengan pengalaman nyata — alam, museum, industri, dan komunitas.' --post_status=publish --menu_order=8 --porcelain)
[ -n "$G8IMG" ] && wp post meta update "$G8" _thumbnail_id "$G8IMG" >/dev/null || true
wp post meta update "$G8" _almazaya_heading 'Belajar di <span class="tone">Luar Kelas</span>' >/dev/null
wp post meta update "$G8" _almazaya_items '<li><span class="mc-dot"></span><b>Studi Lapangan</b> — belajar dari dunia nyata</li><li><span class="mc-dot gold"></span><b>Kontekstual</b> — teori & praktik bertemu</li><li><span class="mc-dot teal"></span><b>Kebersamaan</b> — rekam jejak terbaik</li>' >/dev/null
G9IMG=$(img 2750-r0003169.webp 'TKA & UTBK Camp' 2>/dev/null) || true
G9=$(wp post create --post_type=program --post_name=utc --post_title='TKA & UTBK Camp' --post_content='Camp belajar intensif menjelang ujian masuk PTN dengan suasana asrama, pendampingan penuh, dan drill soal terarah.' --post_excerpt='Camp belajar intensif menjelang ujian masuk PTN dengan suasana asrama, pendampingan penuh, dan drill soal terarah.' --post_status=publish --menu_order=9 --porcelain)
[ -n "$G9IMG" ] && wp post meta update "$G9" _thumbnail_id "$G9IMG" >/dev/null || true
wp post meta update "$G9" _almazaya_heading 'Fokus <span class="tone">Intensif</span>' >/dev/null
wp post meta update "$G9" _almazaya_items '<li><span class="mc-dot"></span><b>Suasana Asrama</b> — fokus tanpa distraksi</li><li><span class="mc-dot gold"></span><b>Drill Soal</b> — latihan kata demi kata</li><li><span class="mc-dot teal"></span><b>Target Sekolah</b> — tantangan sesuai kampus</li>' >/dev/null
G10IMG=$(img laboratory-r0003017.webp 'Math & Science Camp' 2>/dev/null) || true
G10=$(wp post create --post_type=program --post_name=msc --post_title='Math & Science Camp' --post_content='Camp sains dan matematika berbasis eksperimen dan pemecahan masalah untuk menumbuhkan logika serta rasa ingin tahu.' --post_excerpt='Camp sains dan matematika berbasis eksperimen dan pemecahan masalah untuk menumbuhkan logika serta rasa ingin tahu.' --post_status=publish --menu_order=10 --porcelain)
[ -n "$G10IMG" ] && wp post meta update "$G10" _thumbnail_id "$G10IMG" >/dev/null || true
wp post meta update "$G10" _almazaya_heading 'Eksplorasi <span class="tone">Sains</span> & Angka' >/dev/null
wp post meta update "$G10" _almazaya_items '<li><span class="mc-dot"></span><b>Eksperimen Langsung</b> — praktik di lab</li><li><span class="mc-dot gold"></span><b>Matematika Kreatif</b> — berpikir di luar kotak</li><li><span class="mc-dot teal"></span><b>Pembinaan Olimpiade</b> — sains & matematika</li>' >/dev/null
G11IMG=$(img english-talent-show-screenshot-20230829-145220.webp 'English Camp' 2>/dev/null) || true
G11=$(wp post create --post_type=program --post_name=enc --post_title='English Camp' --post_content='Program perendaman bahasa Inggris: speaking zone, vocabulary building, dan aktivitas penuh yang membangun percaya diri.' --post_excerpt='Program perendaman bahasa Inggris: speaking zone, vocabulary building, dan aktivitas penuh yang membangun percaya diri.' --post_status=publish --menu_order=11 --porcelain)
[ -n "$G11IMG" ] && wp post meta update "$G11" _thumbnail_id "$G11IMG" >/dev/null || true
wp post meta update "$G11" _almazaya_heading 'Imersi <span class="tone">Bahasa Inggris</span>' >/dev/null
wp post meta update "$G11" _almazaya_items '<li><span class="mc-dot"></span><b>Speaking Zone</b> — sering bicara berbahasa Inggris</li><li><span class="mc-dot gold"></span><b>Vocabulary Drills</b> — kosakata melimpah</li><li><span class="mc-dot teal"></span><b>Percaya Diri</b> — berani tampil</li>' >/dev/null
G12IMG=$(img 2527-3.webp 'Tahfidz Camp' 2>/dev/null) || true
G12=$(wp post create --post_type=program --post_name=tfc --post_title='Tahfidz Camp' --post_content='Camp intensif tahfidz dengan setoran pagi, murajaah, dan pembinaan adab untuk memperkuat hafalan dalam suasana kebersamaan.' --post_excerpt='Camp intensif tahfidz dengan setoran pagi, murajaah, dan pembinaan adab untuk memperkuat hafalan dalam suasana kebersamaan.' --post_status=publish --menu_order=12 --porcelain)
[ -n "$G12IMG" ] && wp post meta update "$G12" _thumbnail_id "$G12IMG" >/dev/null || true
wp post meta update "$G12" _almazaya_heading 'Camp <span class="tone">Hafalan</span>' >/dev/null
wp post meta update "$G12" _almazaya_items '<li><span class="mc-dot"></span><b>Setoran Pagi</b> — semangat baru tiap hari</li><li><span class="mc-dot gold"></span><b>Murajaah Intensif</b> — hafalan tetap terjaga</li><li><span class="mc-dot teal"></span><b>Adab Penghafal</b> — akhlak para pencinta Al-Qur'"'"'an</li>' >/dev/null
G13IMG=$(img market-day-20221215085811-img-7341.webp 'Market Day' 2>/dev/null) || true
G13=$(wp post create --post_type=program --post_name=mkd --post_title='Market Day' --post_content='Siswa berlatih berjualan sungguhan: menyiapkan produk, mengelola modal, melayani pembeli, dan belajar dari hasil usahanya.' --post_excerpt='Siswa berlatih berjualan sungguhan: menyiapkan produk, mengelola modal, melayani pembeli, dan belajar dari hasil usahanya.' --post_status=publish --menu_order=13 --porcelain)
[ -n "$G13IMG" ] && wp post meta update "$G13" _thumbnail_id "$G13IMG" >/dev/null || true
wp post meta update "$G13" _almazaya_heading 'Jiwa <span class="tone">Wirausaha</span>' >/dev/null
wp post meta update "$G13" _almazaya_items '<li><span class="mc-dot"></span><b>Jual-Beli Langsung</b> — jualan sungguhan di sekolah</li><li><span class="mc-dot gold"></span><b>Kelola Modal</b> — hitung untung & rugi</li><li><span class="mc-dot teal"></span><b>Kerja Tim</b> — bagi peran yang rapi</li>' >/dev/null
G14IMG=$(img home-20221214074906-img-6966.webp 'Event Tahunan ABUELA' 2>/dev/null) || true
G14=$(wp post create --post_type=program --post_name=abl --post_title='Event Tahunan ABUELA' --post_content='Event tahunan keluarga besar Al Mazaya: pentas seni, apresiasi prestasi, dan silaturahmi bersama orang tua serta siswa.' --post_excerpt='Event tahunan keluarga besar Al Mazaya: pentas seni, apresiasi prestasi, dan silaturahmi bersama orang tua serta siswa.' --post_status=publish --menu_order=14 --porcelain)
[ -n "$G14IMG" ] && wp post meta update "$G14" _thumbnail_id "$G14IMG" >/dev/null || true
wp post meta update "$G14" _almazaya_heading 'Pesta <span class="tone">Kebersamaan</span>' >/dev/null
wp post meta update "$G14" _almazaya_items '<li><span class="mc-dot"></span><b>Pentas Seni</b> — bakat siswa ditampilkan</li><li><span class="mc-dot gold"></span><b>Apresiasi Prestasi</b> — rayakan pencapaian</li><li><span class="mc-dot teal"></span><b>Silaturahmi</b> — bersama keluarga besar</li>' >/dev/null
G15IMG=$(img english-talent-show-screenshot-20230829-145717.webp 'English Talent Show' 2>/dev/null) || true
G15=$(wp post create --post_type=program --post_name=ets --post_title='English Talent Show' --post_content='Panggung bakat berbahasa Inggris — pidato, drama, nyanyi — untuk melatih keberanian tampil dan publik speaking.' --post_excerpt='Panggung bakat berbahasa Inggris — pidato, drama, nyanyi — untuk melatih keberanian tampil dan publik speaking.' --post_status=publish --menu_order=15 --porcelain)
[ -n "$G15IMG" ] && wp post meta update "$G15" _thumbnail_id "$G15IMG" >/dev/null || true
wp post meta update "$G15" _almazaya_heading 'Panggung <span class="tone">Bakat</span>' >/dev/null
wp post meta update "$G15" _almazaya_items '<li><span class="mc-dot"></span><b>Drama & Pidato</b> — tampil penuh percaya diri</li><li><span class="mc-dot gold"></span><b>Public Speaking</b> — terbiasa di depan umum</li><li><span class="mc-dot teal"></span><b>Apresiasi Bakat</b> — satu panggung untuk semua</li>' >/dev/null
echo "programs seeded"
fi
if [ "$(wp post list --post_type=destination --format=count 2>/dev/null)" -eq 0 ]; then
echo "== destinations (5; logo MITA menyusul manual karena SVG) =="
mkdest() { # slug title country flag tag url lat lng img desc order
  local D
  D=$(wp post create --post_type=destination --post_name="$1" --post_title="$2" --post_content="${10}" --post_status=publish --menu_order="${11}" --porcelain)
  wp post meta update "$D" _almazaya_country "$3" >/dev/null
  wp post meta update "$D" _almazaya_flag "$4" >/dev/null
  wp post meta update "$D" _almazaya_tag "$5" >/dev/null
  [ -n "$6" ] && wp post meta update "$D" _almazaya_website "$6" >/dev/null
  wp post meta update "$D" _almazaya_lat "$7" >/dev/null
  wp post meta update "$D" _almazaya_lng "$8" >/dev/null
  if [ -n "$9" ]; then
    local IM
    IM=$(img "$9" "$2" 2>/dev/null) && wp post meta update "$D" _thumbnail_id "$IM" >/dev/null || echo "(logo $1 dilewati)"
  fi
  echo "$D"
}
D1=$(mkdest singapore "Modern Montessori International (MMI)" Singapore "🇸🇬" "Montessori Authentic" "https://modern-montessori.com" 1.3521 103.8198 "logo-mmi-site.webp" "Kemitraan utama jenjang KB-TK. MMI Singapore adalah otoritas Montessori autentik." 1)
D2=$(mkdest japan "MITA International School of Science" Japan "🇯🇵" "Science & Technology" "https://www.mita-is.ed.jp" 35.6074 140.1065 "" "Sekolah sains internasional di Chiba, Jepang." 2)
D3=$(mkdest malaysia "Lincoln University College (LUC)" Malaysia "🇲🇾" "University Pathway" "https://www.lincoln.edu.my" 3.1390 101.6869 "logo-luc.webp" "Universitas terakreditasi di Malaysia untuk studi lanjut." 3)
D4=$(mkdest australia "Minaret College" Australia "🇦🇺" "Islamic Education" "https://minaret.vic.edu.au" -37.8136 144.9631 "logo-minaret.webp" "Sekolah Islam terkemuka di Melbourne, Australia." 4)
D5=$(mkdest turkey "Harvest International School" Turkey "🇹🇷" "Multilingual & Culture" "" 41.0082 28.9784 "logo-harvest.avif" "Sekolah internasional di Istanbul, Turki." 5)
echo "destinations: $D1 $D2 $D3 $D4 $D5"
fi
wp rewrite flush >/dev/null
echo "== tetapkan bahasa ID bila Polylang aktif =="
wp eval 'if (function_exists("pll_set_post_language")) { $ids=get_posts(array("post_type"=>"any","post_status"=>"any","posts_per_page"=>-1,"fields"=>"ids")); foreach($ids as $id){ if(!pll_get_post_language($id)) pll_set_post_language($id,"id"); } $terms=get_terms(array("taxonomy"=>array("category"),"hide_empty"=>false,"fields"=>"ids")); foreach($terms as $t){ if(!pll_get_term_language($t)) pll_set_term_language($t,"id"); } echo "lang assigned\n"; } else { echo "polylang off, skip\n"; }'
echo DONE
