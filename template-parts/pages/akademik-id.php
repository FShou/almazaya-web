<?php
/**
 * Template part: akademik (ID) — converted from static akademik.html.
 * Loaded by page templates via almazaya_lang_suffix().
 */
?>
<section class="page-hero">
  <div class="container">
    <p class="breadcrumb"><a href="<?php echo esc_url( almazaya_url( 'index', '', '' ) ); ?>">Beranda</a> / Akademik</p>
    <h1>Akademik <span class="tone">Al Mazaya</span></h1>
    <p>Membangun kecerdasan, karakter, dan kesiapan global melalui kurikulum terpadu.</p>
  </div>
</section>

<!-- PILAR PENDIDIKAN -->
<section class="section" id="pilar">
  <div class="container">
    <div class="section-head center reveal">
      <span class="kicker">Pilar Pendidikan</span>
      <h2>Empat <span class="tone">Pilar</span> Pembelajaran</h2>
      <p>Setiap proses belajar di Al Mazaya bertumpu pada empat fondasi yang saling melengkapi.</p>
    </div>
    <div class="values-grid">
      <article class="feature-card facility-card reveal">
        <h3>Islamic Studies</h3>
        <p>Pemahaman dan nilai Islam yang kuat sebagai akar setiap pembelajaran.</p>
      </article>
      <article class="feature-card facility-card reveal d1">
        <h3>Character Building</h3>
        <p>Pembentukan akhlak mulia melalui budaya 5S, 5R, dan keteladanan.</p>
      </article>
      <article class="feature-card facility-card reveal d2">
        <h3>Academic Excellence</h3>
        <p>Keunggulan akademik dengan kurikulum Merdeka dan pendekatan saintifik.</p>
      </article>
      <article class="feature-card facility-card reveal d3">
        <h3>English Development</h3>
        <p>Penguasaan Bahasa Inggris sebagai bekal persaingan global.</p>
      </article>
    </div>
  </div>
</section>

<!-- KELAS MODERN & VIRTUAL CLASS -->
<section class="section" id="virtual-class">
  <div class="container">
    <div class="section-head center reveal">
      <span class="kicker">Kelas Modern</span>
      <h2>Belajar <span class="tone">Digital</span> &amp; Tanpa Batas</h2>
    </div>

    <div class="modclass">
      <div class="modclass-media reveal" id="mc-stage">
        <button class="mc-fs-btn" aria-label="Perbesar" onclick="mcFullscreen()">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
        </button>

        <div class="mc-scene active" data-scene="desk">
          <span class="modclass-badge">Ruang Kelas Digital</span>
          <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/classroom-r0003044.jpg" alt="Ruang Kelas Digital">
        </div>

        <div class="mc-scene" data-scene="lab">
          <span class="modclass-badge">Lab Komputer &amp; IT</span>
          <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/classroom-whats-app-image-2023-07-31-at-20-29-23.jpg" alt="Lab Komputer &amp; IT">
        </div>

        <div class="mc-scene" data-scene="sci">
          <span class="modclass-badge">Lab IPA · Fisika &amp; Kimia</span>
          <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/laboratory-r0003095.jpg" alt="Lab IPA · Fisika &amp; Kimia">
        </div>

        <div class="mc-scene" data-scene="bio">
          <span class="modclass-badge">Lab Biologi</span>
          <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/laboratory-r0003078.jpg" alt="Lab Biologi">
        </div>

        <div class="mc-scene" data-scene="lib">
          <span class="modclass-badge">Perpustakaan</span>
          <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/hello-world-wis.jpg" alt="Perpustakaan">
        </div>

        <div class="mc-scene" data-scene="eng">
          <span class="modclass-badge">English Zone</span>
          <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/english-talent-show-screenshot-20230829-131851.jpg" alt="English Zone">
        </div>

        <div class="mc-scene" data-scene="mus">
          <span class="modclass-badge">Musala</span>
          <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/quran-academy-r0002997.jpg" alt="Musala">
        </div>

        <div class="mc-scene" data-scene="hall">
          <span class="modclass-badge">Lapangan Indoor</span>
          <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/hall-r0003030.jpg" alt="Lapangan Indoor">
        </div>
      </div>

      <div class="modclass-panel reveal d1">
        <span class="kicker" id="mc-label">Pengalaman Belajar</span>
        <h3 id="mc-heading">Kelas yang <span class="tone">Hidup</span>, Tanpa Hard Copy</h3>
        <p id="mc-desc">Mayoritas pembelajaran berlangsung lewat tablet &amp; perangkat smart. Setiap siswa belajar dengan cara yang personal dan menyenangkan.</p>

        <ul class="modclass-list" id="mc-list">
          <li><span class="mc-dot"></span><b>Tablet &amp; Gadget</b> — tanpa modul kertas</li>
          <li><span class="mc-dot gold"></span><b>WiFi Cepat</b> — merata di seluruh kampus</li>
          <li><span class="mc-dot teal"></span><b>Virtual Class</b> — belajar kapan &amp; di mana saja</li>
        </ul>

        <a class="btn btn-gold" href="<?php echo esc_url( almazaya_url( 'ppdb', '', '' ) ); ?>">Gabung Sekarang →</a>
      </div>
    </div>

    <div class="modclass-more">
      <button class="mc-peek active reveal" data-target="desk" onclick="mcSwitch('desk',this)">
        <div class="mc-peek-scene desk-scene"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/classroom-r0003044.jpg" alt=""></div>
        <span>Ruang Kelas Digital</span>
      </button>
      <button class="mc-peek reveal d1" data-target="lab" onclick="mcSwitch('lab',this)">
        <div class="mc-peek-scene lab-scene"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/classroom-whats-app-image-2023-07-31-at-20-29-23.jpg" alt=""></div>
        <span>Lab Komputer &amp; IT</span>
      </button>
      <button class="mc-peek reveal d2" data-target="sci" onclick="mcSwitch('sci',this)">
        <div class="mc-peek-scene sci-scene"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/laboratory-r0003095.jpg" alt=""></div>
        <span>Lab IPA (Fisika–Kimia)</span>
      </button>
      <button class="mc-peek reveal" data-target="bio" onclick="mcSwitch('bio',this)">
        <div class="mc-peek-scene"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/laboratory-r0003078.jpg" alt=""></div>
        <span>Lab Biologi</span>
      </button>
      <button class="mc-peek reveal" data-target="lib" onclick="mcSwitch('lib',this)">
        <div class="mc-peek-scene"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/hello-world-wis.jpg" alt=""></div>
        <span>Perpustakaan</span>
      </button>
      <button class="mc-peek reveal" data-target="eng" onclick="mcSwitch('eng',this)">
        <div class="mc-peek-scene"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/english-talent-show-screenshot-20230829-131851.jpg" alt=""></div>
        <span>English Zone</span>
      </button>
      <button class="mc-peek reveal" data-target="mus" onclick="mcSwitch('mus',this)">
        <div class="mc-peek-scene"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/quran-academy-r0002997.jpg" alt=""></div>
        <span>Musala</span>
      </button>
      <button class="mc-peek reveal" data-target="hall" onclick="mcSwitch('hall',this)">
        <div class="mc-peek-scene"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/hall-r0003030.jpg" alt=""></div>
        <span>Lapangan Indoor</span>
      </button>
    </div>
  </div>
</section>

<!-- PROGRAM AKADEMIK -->
<section class="section bg-mist" id="program">
  <div class="container">
    <div class="section-head center reveal">
      <span class="kicker">Program Pembelajaran</span>
      <h2>Dari Usia Dini <span class="tone">Hingga SMA</span></h2>
    </div>
    <div class="pillars-grid">
      <article class="feature-card facility-card reveal">
        <h3>KB-TK MMI</h3>
        <p>Montessori authentic: Mum &amp; Me, Playgroup, dan Kinderworld untuk usia 6 bulan–6 tahun.</p>
        <a class="more-link" href="<?php echo esc_url( almazaya_url( 'jenjang', '', '#mmi' ) ); ?>">Lihat jenjang →</a>
      </article>
      <article class="feature-card facility-card reveal d1">
        <h3>SMP</h3>
        <p>Foundation, English Quarantine, English Camp, Science Camp, dan pembinaan olimpiade.</p>
        <a class="more-link" href="<?php echo esc_url( almazaya_url( 'jenjang', '', '' ) ); ?>">Lihat jenjang →</a>
      </article>
      <article class="feature-card facility-card reveal d2">
        <h3>SMA</h3>
        <p>Super Camp, Students Club, Enrichment, serta persiapan UTBK dan beasiswa.</p>
        <a class="more-link" href="<?php echo esc_url( almazaya_url( 'jenjang', '', '' ) ); ?>">Lihat jenjang →</a>
      </article>
      <article class="feature-card facility-card reveal d3">
        <h3>Virtual Class</h3>
        <p>AMZ SHS &amp; JHS Virtual Class — kelas virtual terintegrasi untuk belajar kapan saja.</p>
        <a class="more-link" href="#virtual-class">Coba lihat →</a>
      </article>
    </div>
  </div>
</section>

<!-- KURIKULUM & KEUNGGULAN -->
<section class="section">
  <div class="container">
    <div class="section-head center reveal">
      <span class="kicker">Kurikulum</span>
      <h2>Merdeka, Terpadu, <span class="tone">Berbasis Riset</span></h2>
    </div>
    <div class="vm-grid">
      <div class="feature-card facility-card reveal">
        <h3>Kurikulum Nasional &amp; Keislaman</h3>
        <ul class="modclass-list" style="margin:0;">
          <li><span class="mc-dot"></span><b>Kurikulum Merdeka</b> — merdeka belajar, berdiferensiasi</li>
          <li><span class="mc-dot gold"></span><b>Diniyah &amp; Tahfidz</b> — T3Q terintegrasi</li>
          <li><span class="mc-dot teal"></span><b>Bahasa Inggris</b> — standar Cambridge di English Zone</li>
        </ul>
      </div>
      <div class="feature-card facility-card reveal d1">
        <h3>Pembinaan Kompetisi</h3>
        <ul class="modclass-list" style="margin:0;">
          <li><span class="mc-dot"></span><b>Olimpiade Sains &amp; Bahasa</b> — juara nasional</li>
          <li><span class="mc-dot gold"></span><b>Debat &amp; Public Speaking</b> — juara UIN</li>
          <li><span class="mc-dot teal"></span><b>Islamic &amp; English Olympiad</b> — medali emas</li>
        </ul>
      </div>
    </div>
  </div>
</section>





<script>
function mcSwitch(scene,btn){
  var stage=document.getElementById('mc-stage'),peeks=document.querySelectorAll('.mc-peek');
  stage.querySelectorAll('.mc-scene').forEach(function(s){s.classList.remove('active')});
  stage.querySelector('[data-scene="'+scene+'"]').classList.add('active');
  peeks.forEach(function(p){p.classList.remove('active')});
  btn.classList.add('active');
  var lb=document.getElementById('mc-lightbox');
  lb.querySelectorAll('.mc-scene').forEach(function(s){s.classList.remove('active')});
  lb.querySelector('[data-scene="'+scene+'"]').classList.add('active');
  var descs={desk:{label:'Pengalaman Belajar',head:'Kelas yang <span class="tone">Hidup</span>, Tanpa Hard Copy',desc:'Mayoritas pembelajaran berlangsung lewat tablet & perangkat smart. Setiap siswa belajar dengan cara yang personal dan menyenangkan.',items:'<li><span class="mc-dot"></span><b>Tablet & Gadget</b> — tanpa modul kertas</li><li><span class="mc-dot gold"></span><b>WiFi Cepat</b> — merata di seluruh kampus</li><li><span class="mc-dot teal"></span><b>Virtual Class</b> — belajar kapan & di mana saja</li>'},lab:{label:'Lab Komputer & IT',head:'Kode & <span class="tone">Literasi Digital</span>',desc:'Lab komputer berisi monitor interaktif & perangkat lengkap untuk coding, desain, dan penelusuran digital.',items:'<li><span class="mc-dot"></span><b>Monitor Interaktif</b> — 1 siswa : 1 perangkat</li><li><span class="mc-dot gold"></span><b>Koneksi Cepat</b> — akses materi online</li><li><span class="mc-dot teal"></span><b>Proyek Kreatif</b> — koding, desain, riset</li>'},sci:{label:'Lab IPA (Fisika–Kimia)',head:'Eksperimen <span class="tone">Langsung</span>',desc:'Laboratorium IPA terpadu dengan peralatan praktikum fisika dan kimia untuk pembelajaran berbasis inquiry.',items:'<li><span class="mc-dot"></span><b>Peralatan Lengkap</b> — gelas kimia, mikroskop, timbangan</li><li><span class="mc-dot gold"></span><b>Praktikum Inquiry</b> — metode saintifik</li><li><span class="mc-dot teal"></span><b>Riset Siswa</b> — olimpiade sains & kompetisi</li>'},bio:{label:'Lab Biologi',head:'Mengamati <span class="tone">Mahkluk Hidup</span>',desc:'Laboratorium biologi untuk pengamatan mikroskop, spesimen, dan riset siswa.',items:'<li><span class="mc-dot"></span><b>Mikroskop & Spesimen</b> — pengamatan langsung</li><li><span class="mc-dot gold"></span><b>Praktikum Sains</b> — metode ilmiah</li><li><span class="mc-dot teal"></span><b>Riset & Olimpiade</b> — pembinaan intensif</li>'},lib:{label:'Perpustakaan',head:'Jendela <span class="tone">Literasi</span>',desc:'Perpustakaan dengan koleksi literatur Islami & referensi akademik untuk menumbuhkan gemar membaca.',items:'<li><span class="mc-dot"></span><b>Koleksi Islami</b> — kitab & literatur</li><li><span class="mc-dot gold"></span><b>Area Baca Nyaman</b> — fokus & tenang</li><li><span class="mc-dot teal"></span><b>Program Literasi</b> — reading culture</li>'},eng:{label:'English Zone',head:'Bicara <span class="tone">Bahasa Global</span>',desc:'English Zone menghadirkan lingkungan imersi Cambridge untuk percakapan & literasi bahasa Inggris.',items:'<li><span class="mc-dot"></span><b>Imersi Cambridge</b> — standar internasional</li><li><span class="mc-dot gold"></span><b>Conversation Daily</b> — bahasa Inggris sehari-hari</li><li><span class="mc-dot teal"></span><b>Debat & Public Speaking</b> — percaya diri</li>'},mus:{label:'Musala',head:'Hening dalam <span class="tone">Ibadah</span>',desc:'Musala yang bersih & nyaman menjadi pusat ibadah serta pembinaan diniyah dan tahfidz.',items:'<li><span class="mc-dot"></span><b>Salat Berjamaah</b> — terjaga setiap waktu</li><li><span class="mc-dot gold"></span><b>Diniyah & Tahfidz</b> — diintegrasikan</li><li><span class="mc-dot teal"></span><b>Lingkungan Bersih</b> — khusyuk & nyaman</li>'},hall:{label:'Lapangan Indoor',head:'Bergerak <span class="tone">Bersama</span>',desc:'Lapangan indoor multifungsi untuk olahraga, upacara, dan kegiatan siswa sepanjang tahun.',items:'<li><span class="mc-dot"></span><b>Multifungsi</b> — basket, badminton, senam</li><li><span class="mc-dot gold"></span><b>Kegiatan & Upacara</b> — kapan saja</li><li><span class="mc-dot teal"></span><b>Sehat & Aktif</b> — budaya olahraga</li>'}};
  var d=descs[scene]||descs.desk;
  document.getElementById('mc-label').innerHTML=d.label;
  document.getElementById('mc-heading').innerHTML=d.head;
  document.getElementById('mc-desc').innerHTML=d.desc;
  document.getElementById('mc-list').innerHTML=d.items;
}
function mcFullscreen(){
  var lb=document.getElementById('mc-lightbox');
  var active=document.querySelector('#mc-stage .mc-scene.active');
  lb.querySelectorAll('.mc-scene').forEach(function(s){s.classList.remove('active')});
  lb.querySelector('[data-scene="'+active.dataset.scene+'"]').classList.add('active');
  lb.classList.add('open');document.body.style.overflow='hidden';
}
function mcCloseLB(){document.getElementById('mc-lightbox').classList.remove('open');document.body.style.overflow='';}
document.addEventListener('keydown',function(e){if(e.key==='Escape')mcCloseLB()});
</script>
<!-- lightbox -->
<div class="mc-lightbox" id="mc-lightbox" onclick="if(event.target===this)mcCloseLB()">
  <div class="mc-lightbox-inner">
    <div class="mc-scene active" data-scene="desk">
      <span class="modclass-badge">Ruang Kelas Digital</span>
      <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/classroom-r0003044.jpg" alt="Ruang Kelas Digital">
    </div>
    <div class="mc-scene" data-scene="lab">
      <span class="modclass-badge">Lab Komputer &amp; IT</span>
      <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/classroom-whats-app-image-2023-07-31-at-20-29-23.jpg" alt="Lab Komputer &amp; IT">
    </div>
    <div class="mc-scene" data-scene="sci">
      <span class="modclass-badge">Lab IPA · Fisika &amp; Kimia</span>
      <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/laboratory-r0003095.jpg" alt="Lab IPA · Fisika &amp; Kimia">
    </div>
    <div class="mc-scene" data-scene="bio">
      <span class="modclass-badge">Lab Biologi</span>
      <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/laboratory-r0003078.jpg" alt="Lab Biologi">
    </div>
    <div class="mc-scene" data-scene="lib">
      <span class="modclass-badge">Perpustakaan</span>
      <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/hello-world-wis.jpg" alt="Perpustakaan">
    </div>
    <div class="mc-scene" data-scene="eng">
      <span class="modclass-badge">English Zone</span>
      <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/english-talent-show-screenshot-20230829-131851.jpg" alt="English Zone">
    </div>
    <div class="mc-scene" data-scene="mus">
      <span class="modclass-badge">Musala</span>
      <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/quran-academy-r0002997.jpg" alt="Musala">
    </div>
    <div class="mc-scene" data-scene="hall">
      <span class="modclass-badge">Lapangan Indoor</span>
      <img class="mc-photo" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/hall-r0003030.jpg" alt="Lapangan Indoor">
    </div>
  </div>
  <button class="mc-lb-close" onclick="mcCloseLB()" aria-label="Tutup">×</button>
</div>
