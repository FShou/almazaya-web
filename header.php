<?php
/**
 * Shared site chrome: topbar, header, mobile nav.
 * Page templates call get_header() then load their content part.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if ( ! has_site_icon() ) : ?>
<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/favicon.png">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class( isset( $GLOBALS['almazaya_body_class'] ) ? $GLOBALS['almazaya_body_class'] : '' ); ?>>
<?php wp_body_open(); ?>

<!-- ================= TOPBAR ================= -->
<div class="topbar" role="navigation" aria-label="Link cepat">
  <div class="container topbar-inner">
    <div class="topbar-links">
      <a class="topbar-class" href="<?php echo esc_url( almazaya_link( 'shs_class' ) ); ?>" target="_blank" rel="noopener" aria-label="AMZ SHS Virtual Class">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10 12 5 2 10l10 5 10-5"/><path d="M6 12v5c0 1 2.7 3 6 3s6-2 6-3v-5"/><path d="M22 10v6"/></svg>
        <span>SHS Virtual Class</span>
      </a>
      <a class="topbar-class" href="<?php echo esc_url( almazaya_link( 'jhs_class' ) ); ?>" target="_blank" rel="noopener" aria-label="AMZ JHS Virtual Class">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="14" rx="2"/><path d="M3 8h18"/><path d="m7 13 2-2 2 2M7 17l2-2 2 2"/></svg>
        <span>JHS Virtual Class</span>
      </a>
      <span class="topbar-sep" aria-hidden="true"></span>
      <a class="topbar-social" href="<?php echo esc_url( almazaya_link( 'instagram' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram">
        <svg viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 3.3.1 4.8 1.7 4.9 4.9.1 1.3.1 1.6.1 4.8s0 3.6-.1 4.8c-.1 3.2-1.6 4.8-4.9 4.9-1.3.1-1.6.1-4.9.1s-3.6 0-4.9-.1c-3.3-.1-4.8-1.7-4.9-4.9C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.8C2.4 4 3.9 2.4 7.2 2.3 8.4 2.2 8.8 2.2 12 2.2Zm0 3.6a6.2 6.2 0 1 0 0 12.4 6.2 6.2 0 0 0 0-12.4Zm0 10.2a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm6.4-10.5a1.4 1.4 0 1 0 0 2.9 1.4 1.4 0 0 0 0-2.9Z"/></svg>
      <span>Instagram</span>
      </a>
      <a class="topbar-social" href="<?php echo esc_url( almazaya_link( 'tiktok' ) ); ?>" target="_blank" rel="noopener" aria-label="TikTok">
        <svg viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
      <span>TikTok</span>
      </a>
      <a class="topbar-social" href="<?php echo esc_url( almazaya_link( 'whatsapp' ) ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
        <svg viewBox="0 0 24 24"><path d="M17.5 14.4c-.3-.2-1.8-.9-2-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-.9 1.2-.2.2-.4.2-.7.1a8.2 8.2 0 0 1-2.4-1.5 9 9 0 0 1-1.7-2.1c-.2-.3 0-.5.1-.6l.5-.6c.1-.2.2-.3.3-.5v-.5L9 7c-.2-.5-.4-.4-.6-.4h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1 2.9 1.2 3.1c.2.2 2.1 3.3 5.1 4.6.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4l-.6-.3ZM12 21.8a9.7 9.7 0 0 1-5-1.4l-.4-.2-3.7 1 1-3.7-.2-.4a9.8 9.8 0 1 1 8.3 4.7ZM12 0A11.9 11.9 0 0 0 1.7 18l-1.6 6 6.1-1.6A12 12 0 1 0 12 0Z"/></svg>
      <span>WhatsApp</span>
      </a>
    </div>
  </div>
</div>

<!-- ================= HEADER ================= -->
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <div class="logo-strip">
        <?php if ( has_custom_logo() ) : ?>
          <?php the_custom_logo(); ?>
        <?php else : ?>
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo-yayasan.jpeg" alt="<?php echo esc_attr( almazaya_is_en() ? 'Al Mazaya Pelita Asia Foundation logo' : 'Logo Yayasan Al Mazaya Pelita Asia' ); ?>">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo.jpeg" alt="Logo Al Mazaya Islamic School">
          <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo-mmi.jpeg" alt="<?php echo esc_attr( almazaya_is_en() ? 'MMI logo' : 'Logo MMI' ); ?>" class="logo-mmi">
        <?php endif; ?>
      </div>
      <span class="brand-name">
        <strong>Al Mazaya Islamic School</strong>
        <span>Banjarmasin</span>
      </span>
    </a>

    <button class="nav-burger" aria-label="<?php echo esc_attr( almazaya_is_en() ? 'Open menu' : 'Buka menu' ); ?>" aria-expanded="false">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
    </button>

    <?php
    if ( has_nav_menu( 'primary' ) ) {
      wp_nav_menu(
        array(
          'theme_location' => 'primary',
          'container'      => 'nav',
          'container_class' => 'main-nav',
          'fallback_cb'    => 'almazaya_fallback_primary_nav',
        )
      );
    } else {
      almazaya_fallback_primary_nav();
    }
    ?>

    <?php almazaya_lang_toggle(); ?>

  </div>
</header>

<!-- ================= MOBILE NAV ================= -->
<div class="mobile-nav">
  <button class="nav-close" aria-label="<?php echo esc_attr( almazaya_is_en() ? 'Close menu' : 'Tutup menu' ); ?>"><svg viewBox="0 0 24 24" fill="none" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg></button>
  <div class="mobile-nav-inner">
    <?php almazaya_mobile_nav(); ?>
    <?php almazaya_lang_toggle( 'mobile-lang' ); ?>
  </div>
</div>
