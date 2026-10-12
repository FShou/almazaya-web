<?php
/**
 * Fallback for regular admin-created pages (block editor content).
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
        <?php the_content(); ?>
      </article>
      <?php
    endwhile;
    ?>
  </div>
</main>
<?php get_footer(); ?>
