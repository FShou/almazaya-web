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
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php the_title( '<h1>', '</h1>' ); ?>
        <p class="post-meta"><?php echo esc_html( get_the_date() ); ?></p>
        <?php
        if ( has_post_thumbnail() ) {
          the_post_thumbnail( 'large' );
        }
        ?>
        <?php the_content(); ?>
      </article>
      <?php
    endwhile;
    the_post_navigation();
    ?>
  </div>
</main>
<?php get_footer(); ?>
