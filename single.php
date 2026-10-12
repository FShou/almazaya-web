<?php
/**
 * Single post view (for future Berita posts published via WP).
 */
get_header();
?>
<main class="site-main">
  <div class="container section">
    <?php
    while ( have_posts() ) :
      the_post();
      ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-article' ); ?>>
        <?php the_title( '<h1>', '</h1>' ); ?>
        <p class="post-meta">
          <?php
          $almazaya_scats = get_the_category();
          if ( $almazaya_scats ) {
            $almazaya_sgold = in_array( $almazaya_scats[0]->slug, array( 'prestasi', 'achievement' ), true ) ? ' gold' : '';
            echo '<span class="chip' . esc_attr( $almazaya_sgold ) . '">' . esc_html( $almazaya_scats[0]->name ) . '</span> ';
          }
          echo esc_html( get_the_date() );
          ?>
        </p>
        <?php
        if ( has_post_thumbnail() ) {
          the_post_thumbnail( 'large' );
        }
        ?>
        <?php the_content(); ?>
        <p style="margin-top:2rem;"><a class="more-link" href="<?php echo esc_url( almazaya_url( 'berita', almazaya_is_en() ? 'en/' : '' ) ); ?>">← <?php echo esc_html( almazaya_is_en() ? 'Back to News' : 'Kembali ke Berita' ); ?></a></p>
      </article>
      <?php
    endwhile;
    the_post_navigation();
    ?>
  </div>
</main>
<?php get_footer(); ?>
