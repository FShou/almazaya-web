<?php
/**
 * Template Name: Berita — Al Mazaya
 *
 * v1: static listing converted from berita.html. To switch to real posts later,
 * replace the template part with a WP loop (see single.php for the post view).
 */
get_header();
?>
<main class="site-main">
<?php get_template_part( 'template-parts/pages/berita', almazaya_lang_suffix() ); ?>
</main>
<?php get_footer(); ?>
