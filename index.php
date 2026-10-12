<?php
/**
 * Blog/post fallback (used when posts are published, e.g. future Berita posts).
 */
get_header();
?>
<main class="site-main">
  <div class="container section">
    <?php if ( have_posts() ) : ?>
      <?php
      while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <?php the_excerpt(); ?>
        </article>
        <?php
      endwhile;
      the_posts_navigation();
      ?>
    <?php else : ?>
      <p><?php esc_html_e( 'Belum ada tulisan.', 'almazaya' ); ?></p>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
