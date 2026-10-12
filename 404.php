<?php
/**
 * 404 — page not found.
 */
get_header();
$en = almazaya_is_en();
?>
<main class="site-main">
  <div class="container section" style="text-align:center; padding:4rem 1rem;">
    <p class="kicker"><?php echo esc_html( $en ? 'Not found' : 'Tidak ditemukan' ); ?></p>
    <h1>404</h1>
    <p><?php echo esc_html( $en ? 'Sorry, the page you are looking for does not exist.' : 'Maaf, halaman yang Anda cari tidak tersedia.' ); ?></p>
    <p><a class="btn btn-gold" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $en ? 'Back to Home' : 'Kembali ke Beranda' ); ?></a></p>
  </div>
</main>
<?php get_footer(); ?>
