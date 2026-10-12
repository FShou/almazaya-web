<?php
/**
 * Single post view — same article design as the berita-detail template.
 */
get_header();
$almazaya_en = almazaya_is_en();
?>
<main class="site-main">
  <?php
  while ( have_posts() ) :
    the_post();
    $almazaya_cats  = get_the_category();
    $almazaya_first = $almazaya_cats ? $almazaya_cats[0] : null;
    $almazaya_gold  = $almazaya_first && in_array( $almazaya_first->slug, array( 'prestasi', 'achievement' ), true ) ? ' gold' : '';
    $almazaya_catname = $almazaya_first ? $almazaya_first->name : '';
    ?>
    <section class="page-hero">
      <div class="container">
        <p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $almazaya_en ? 'Home' : 'Beranda' ); ?></a> / <a href="<?php echo esc_url( almazaya_url( 'berita', $almazaya_en ? 'en/' : '' ) ); ?>"><?php echo esc_html( $almazaya_en ? 'News' : 'Berita' ); ?></a> / <?php the_title(); ?></p>
        <h1><?php the_title(); ?></h1>
        <p><?php echo esc_html( trim( $almazaya_catname . ' · ' . get_the_date(), ' ·' ) ); ?></p>
      </div>
    </section>

    <section class="section">
      <div class="container article-body">
        <?php if ( has_post_thumbnail() ) : ?>
          <div class="has-photo img-slot article-hero"><?php the_post_thumbnail( 'large', array( 'class' => 'slot-photo' ) ); ?></div>
        <?php endif; ?>
        <div class="post-meta">
          <?php if ( $almazaya_first ) : ?>
            <span class="chip<?php echo esc_attr( $almazaya_gold ); ?>"><?php echo esc_html( $almazaya_first->name ); ?></span>
          <?php endif; ?>
          <?php echo esc_html( get_the_date() ); ?>
        </div>
        <div class="art-paras">
          <?php the_content(); ?>
        </div>
        <p style="margin-top:2rem;"><a class="more-link" href="<?php echo esc_url( almazaya_url( 'berita', $almazaya_en ? 'en/' : '' ) ); ?>">← <?php echo esc_html( $almazaya_en ? 'Back to News' : 'Kembali ke Berita' ); ?></a></p>
        <?php
        $almazaya_rel_args = array(
          'post_type'      => 'post',
          'post_status'    => 'publish',
          'posts_per_page' => 2,
          'post__not_in'   => array( get_the_ID() ),
        );
        if ( $almazaya_first ) {
          $almazaya_rel_args['category__in'] = array( $almazaya_first->term_id );
        }
        $almazaya_rel = new WP_Query( $almazaya_rel_args );
        if ( ! $almazaya_rel->have_posts() ) {
          $almazaya_rel = new WP_Query(
            array(
              'post_type'      => 'post',
              'post_status'    => 'publish',
              'posts_per_page' => 2,
              'post__not_in'   => array( get_the_ID() ),
            )
          );
        }
        if ( $almazaya_rel->have_posts() ) :
          ?>
          <div class="related-block">
            <h3><?php echo esc_html( $almazaya_en ? 'Related News' : 'Berita Terkait' ); ?></h3>
            <ul class="related-list">
              <?php
              while ( $almazaya_rel->have_posts() ) :
                $almazaya_rel->the_post();
                $almazaya_rcats  = get_the_category();
                $almazaya_rmeta  = $almazaya_rcats ? $almazaya_rcats[0]->name . ' · ' . get_the_date() : get_the_date();
                ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><span><?php echo esc_html( $almazaya_rmeta ); ?></span></li>
                <?php
              endwhile;
              ?>
            </ul>
          </div>
          <?php
        endif;
        wp_reset_postdata();
        ?>
      </div>
    </section>
    <?php
  endwhile;
  ?>
</main>
<?php get_footer(); ?>
