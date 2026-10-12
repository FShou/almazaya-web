<?php
/**
 * Homepage (Beranda). Used automatically as the front page.
 */
get_header();
?>
<main class="site-main">
<?php get_template_part( 'template-parts/pages/beranda', almazaya_lang_suffix() ); ?>
</main>
<?php get_footer(); ?>
