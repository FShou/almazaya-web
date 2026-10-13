<?php
/**
 * Template part: galeri (ID) — converted from static galeri.html.
 * Loaded by page templates via almazaya_lang_suffix().
 */
?>
<section class="page-hero">
  <div class="container">
    <p class="breadcrumb"><a href="<?php echo esc_url( almazaya_url( 'index', '', '' ) ); ?>">Beranda</a> / Aktivitas Siswa</p>
    <h1>Aktivitas <span class="tone">Siswa</span></h1>
    <p>Dokumentasi momen berkesan siswa Al Mazaya dalam dan luar kelas.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="filter-row reveal">
      <button class="filter-chip active">Semua Event</button>
      <button class="filter-chip">Akademik</button>
      <button class="filter-chip">Islami</button>
      <button class="filter-chip">Overseas</button>
      <button class="filter-chip">Wisuda</button>
    </div>

    <!-- TODO WP: digantikan galeri/album WordPress -->
    <?php $almazaya_feed_html = almazaya_galeri_feed_html(); ?>
<?php if ( '' !== $almazaya_feed_html ) : ?>
<div class="galeri-feed"><?php echo $almazaya_feed_html; ?></div>
<?php else : ?>
<div class="gallery-bento">
      <div data-cat="Akademik" class="has-photo img-slot reveal"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'english_talent_show_screenshot_20230829_151444' ) ); ?>" alt="English Talent Show · Panggung bulanan bakat siswa"><span class="gal-label">English Talent Show · Panggung bulanan bakat siswa</span></div>
      <div data-cat="Akademik" class="has-photo img-slot warm tall reveal d1"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'market_day_20221214111711_img_7128' ) ); ?>" alt="Market Day · Belajar wirausaha"><span class="gal-label">Market Day · Belajar wirausaha</span></div>
      <div data-cat="Overseas" class="has-photo img-slot light reveal d2"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'overseas_img_8730_min' ) ); ?>" alt="Overseas Program · Singapura &amp; Malaysia"><span class="gal-label">Overseas Program · Singapura &amp; Malaysia</span></div>
      <div data-cat="Akademik" class="has-photo img-slot light reveal"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'overseas_img_8809_min' ) ); ?>" alt="HUT Kemerdekaan RI · Lomba seru"><span class="gal-label">HUT Kemerdekaan RI · Lomba seru</span></div>
      <div data-cat="Islami" class="has-photo img-slot reveal d1"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'ramadhan_charity_day_img_5423' ) ); ?>" alt="Ramadhan Charity Day · Berbagi ke sesama"><span class="gal-label">Ramadhan Charity Day · Berbagi ke sesama</span></div>
      <div data-cat="Wisuda" class="has-photo img-slot warm reveal d2"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'quran_academy_r0003011' ) ); ?>" alt="Haflah Khatmil Qur'an · Wisuda tahfidz"><span class="gal-label">Haflah Khatmil Qur'an · Wisuda tahfidz</span></div>
      <div data-cat="Akademik" class="has-photo img-slot warm reveal"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'overseas_img_8816_min' ) ); ?>" alt="Olimpiade Sains · Pembinaan juara nasional"><span class="gal-label">Olimpiade Sains · Pembinaan juara nasional</span></div>
      <div data-cat="Akademik" class="has-photo img-slot reveal d1"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'english_talent_show_screenshot_20230825_132133_1' ) ); ?>" alt="English Camp · Imersi bahasa kelas 7"><span class="gal-label">English Camp · Imersi bahasa kelas 7</span></div>
      <div data-cat="Akademik" class="has-photo img-slot light tall reveal d2"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'school_debate_competition_aq3' ) ); ?>" alt="Debat Bilingual · Juara 2 UIN Antasari"><span class="gal-label">Debat Bilingual · Juara 2 UIN Antasari</span></div>
    </div>
<?php endif; ?>

    <p data-filter-empty hidden style="text-align:center;color:var(--slate-light);">Belum ada foto pada kategori ini.</p>

    <p style="text-align:center; margin-top:2.6rem;" class="reveal">
      <a class="btn btn-outline" style="color:var(--navy);" href="<?php echo esc_url( almazaya_link( 'youtube' ) ); ?>" target="_blank" rel="noopener">Tonton Video di YouTube ↗</a>
    </p>
  </div>
</section>
