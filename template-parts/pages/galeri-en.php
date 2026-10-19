<?php
/**
 * Template part: galeri (EN) — converted from static galeri.html.
 * Loaded by page templates via almazaya_lang_suffix().
 */
?>
<section class="page-hero">
  <div class="container">
    <p class="breadcrumb"><a href="<?php echo esc_url( almazaya_url( 'index', '', '' ) ); ?>">Home</a> / Student Activities</p>
    <h1>Student <span class="tone">Activities</span></h1>
    <p>Documenting memorable moments of Al Mazaya students inside and outside the classroom.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php $almazaya_feed_html = almazaya_galeri_feed_html(); ?>
<?php if ( '' !== $almazaya_feed_html ) : ?>
<div class="galeri-feed"><?php echo $almazaya_feed_html; ?></div>
<?php elseif ( almazaya_has_ordered_posts( 'gallery' ) ) : ?>
<?php get_template_part( 'template-parts/dynamic/gallery-loop' ); ?>
<?php else : ?>
    <div class="filter-row reveal">
      <button class="filter-chip active">All Events</button>
      <button class="filter-chip">Academic</button>
      <button class="filter-chip">Islamic</button>
      <button class="filter-chip">Overseas</button>
      <button class="filter-chip">Graduation</button>
    </div>

<div class="gallery-bento">
      <div data-cat="Academic" class="has-photo img-slot reveal"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'english_talent_show_screenshot_20230829_151444' ) ); ?>" alt="English Talent Show · Monthly student talent stage"><span class="gal-label">English Talent Show · Monthly student talent stage</span></div>
      <div data-cat="Academic" class="has-photo img-slot warm tall reveal d1"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'market_day_20221214111711_img_7128' ) ); ?>" alt="Market Day · Entrepreneurship practice"><span class="gal-label">Market Day · Entrepreneurship practice</span></div>
      <div data-cat="Overseas" class="has-photo img-slot light reveal d2"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'overseas_img_8730_min' ) ); ?>" alt="Overseas Program · Singapore &amp; Malaysia"><span class="gal-label">Overseas Program · Singapore &amp; Malaysia</span></div>
      <div data-cat="Academic" class="has-photo img-slot light reveal"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'overseas_img_8809_min' ) ); ?>" alt="Independence Day · Fun competitions"><span class="gal-label">Independence Day · Fun competitions</span></div>
      <div data-cat="Islamic" class="has-photo img-slot reveal d1"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'ramadhan_charity_day_img_5423' ) ); ?>" alt="Ramadhan Charity Day · Sharing with others"><span class="gal-label">Ramadhan Charity Day · Sharing with others</span></div>
      <div data-cat="Graduation" class="has-photo img-slot warm reveal d2"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'quran_academy_r0003011' ) ); ?>" alt="Haflah Khatmil Qur'an · Tahfidz graduation"><span class="gal-label">Haflah Khatmil Qur'an · Tahfidz graduation</span></div>
      <div data-cat="Academic" class="has-photo img-slot warm reveal"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'overseas_img_8816_min' ) ); ?>" alt="Science Olympiad · National champion coaching"><span class="gal-label">Science Olympiad · National champion coaching</span></div>
      <div data-cat="Academic" class="has-photo img-slot reveal d1"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'english_talent_show_screenshot_20230825_132133_1' ) ); ?>" alt="English Camp · Grade-7 language immersion"><span class="gal-label">English Camp · Grade-7 language immersion</span></div>
      <div data-cat="Academic" class="has-photo img-slot light tall reveal d2"><img class="slot-photo" src="<?php echo esc_url( almazaya_img( 'school_debate_competition_aq3' ) ); ?>" alt="Bilingual Debate · 2nd Place UIN Antasari"><span class="gal-label">Bilingual Debate · 2nd Place UIN Antasari</span></div>
    </div>
<?php endif; ?>

    <p data-filter-empty hidden style="text-align:center;color:var(--slate-light);">No photos in this category yet.</p>

    <p style="text-align:center; margin-top:2.6rem;" class="reveal">
      <a class="btn btn-outline" style="color:var(--navy);" href="<?php echo esc_url( almazaya_link( 'youtube' ) ); ?>" target="_blank" rel="noopener">Watch Videos on YouTube ↗</a>
    </p>
  </div>
</section>
