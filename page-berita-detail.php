<?php
/**
 * Template Name: Detail Berita — Al Mazaya
 *
 * Single article template (?a=slug router). Long-term, articles become
 * real Posts rendered by single.php; this keeps v1 parity with static.
 */
get_header();
?>
<main class="site-main">
<?php get_template_part( 'template-parts/pages/berita-detail', almazaya_lang_suffix() ); ?>
</main>
<?php get_footer(); ?>
