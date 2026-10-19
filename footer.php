<?php
/**
 * Shared site footer + floating WhatsApp button.
 */
$en = almazaya_is_en();
?>
<footer class="site-footer">
  <div class="container footer-grid">
    <div class="footer-brand">
      <div class="logo-strip">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo-yayasan.jpeg" alt="<?php echo esc_attr( $en ? 'Al Mazaya Pelita Asia Foundation logo' : 'Logo Yayasan Al Mazaya Pelita Asia' ); ?>">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo.jpeg" alt="Logo Al Mazaya Islamic School">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo-mmi.jpeg" alt="<?php echo esc_attr( $en ? 'MMI logo' : 'Logo MMI' ); ?>" class="logo-mmi">
      </div>
      <h4>AL MAZAYA ISLAMIC SCHOOL</h4>
      <p><?php echo esc_html( almazaya_text( 'footer_tagline' ) ); ?></p>
      <div class="socials">
        <a href="<?php echo esc_url( almazaya_link( 'instagram' ) ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 3.3.1 4.8 1.7 4.9 4.9.1 1.3.1 1.6.1 4.8s0 3.6-.1 4.8c-.1 3.2-1.6 4.8-4.9 4.9-1.3.1-1.6.1-4.9.1s-3.6 0-4.9-.1c-3.3-.1-4.8-1.7-4.9-4.9C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.8C2.4 4 3.9 2.4 7.2 2.3 8.4 2.2 8.8 2.2 12 2.2Zm0 3.6a6.2 6.2 0 1 0 0 12.4 6.2 6.2 0 0 0 0-12.4Zm0 10.2a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm6.4-10.5a1.4 1.4 0 1 0 0 2.9 1.4 1.4 0 0 0 0-2.9Z"/></svg></a>
        <a href="<?php echo esc_url( almazaya_link( 'youtube' ) ); ?>" target="_blank" rel="noopener" aria-label="YouTube"><svg viewBox="0 0 24 24"><path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2 31.3 31.3 0 0 0 0 12a31.3 31.3 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.3 31.3 0 0 0 24 12a31.3 31.3 0 0 0-.5-5.8ZM9.6 15.6V8.4L15.8 12l-6.2 3.6Z"/></svg></a>
        <a href="<?php echo esc_url( almazaya_link( 'tiktok' ) ); ?>" target="_blank" rel="noopener" aria-label="TikTok"><svg viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg></a>
        <a href="<?php echo esc_url( almazaya_link( 'whatsapp' ) ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><svg viewBox="0 0 24 24"><path d="M17.5 14.4c-.3-.2-1.8-.9-2-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-.9 1.2-.2.2-.4.2-.7.1a8.2 8.2 0 0 1-2.4-1.5 9 9 0 0 1-1.7-2.1c-.2-.3 0-.5.1-.6l.5-.6c.1-.2.2-.3.3-.5v-.5L9 7c-.2-.5-.4-.4-.6-.4h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1 2.9 1.2 3.1c.2.2 2.1 3.3 5.1 4.6.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4l-.6-.3ZM12 21.8a9.7 9.7 0 0 1-5-1.4l-.4-.2-3.7 1 1-3.7-.2-.4a9.8 9.8 0 1 1 8.3 4.7ZM12 0A11.9 11.9 0 0 0 1.7 18l-1.6 6 6.1-1.6A12 12 0 1 0 12 0Z"/></svg></a>
      </div>
    </div>
    <div>
      <h4><?php echo esc_html( almazaya_text( 'footer_head_links' ) ); ?></h4>
      <?php
      if ( has_nav_menu( 'footer' ) ) {
        wp_nav_menu(
          array(
            'theme_location' => 'footer',
            'container'      => false,
            'menu_class'     => 'footer-links',
            'fallback_cb'    => 'almazaya_fallback_footer_nav',
          )
        );
      } else {
        almazaya_fallback_footer_nav();
      }
      ?>
    </div>
    <div>
      <h4>Virtual Class</h4>
      <ul class="footer-links">
        <li><a href="<?php echo esc_url( almazaya_link( 'shs_class' ) ); ?>" target="_blank" rel="noopener">SHS Virtual Class</a></li>
        <li><a href="<?php echo esc_url( almazaya_link( 'jhs_class' ) ); ?>" target="_blank" rel="noopener">JHS Virtual Class</a></li>
      </ul>
      <h4 style="margin-top:1.6rem;"><?php echo esc_html( almazaya_text( 'footer_head_hours' ) ); ?></h4>
      <p><?php echo almazaya_html( 'office_hours' ); ?></p>
    </div>
  </div>
  <div class="container footer-bottom">
    <span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( almazaya_text( 'footer_org' ) ); ?>. <?php echo esc_html( almazaya_text( 'footer_rights' ) ); ?></span>
    <span><?php echo esc_html( almazaya_text( 'foundation_name' ) ); ?></span>
  </div>
</footer>

<a class="wa-float" href="<?php echo esc_url( almazaya_link( 'whatsapp_float' ) ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $en ? 'WhatsApp chat' : 'Chat WhatsApp' ); ?>">
  <svg viewBox="0 0 24 24"><path d="M17.5 14.4c-.3-.2-1.8-.9-2-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-.9 1.2-.2.2-.4.2-.7.1a8.2 8.2 0 0 1-2.4-1.5 9 9 0 0 1-1.7-2.1c-.2-.3 0-.5.1-.6l.5-.6c.1-.2.2-.3.3-.5v-.5L9 7c-.2-.5-.4-.4-.6-.4h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1 2.9 1.2 3.1c.2.2 2.1 3.3 5.1 4.6.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4l-.6-.3ZM12 21.8a9.7 9.7 0 0 1-5-1.4l-.4-.2-3.7 1 1-3.7-.2-.4a9.8 9.8 0 1 1 8.3 4.7ZM12 0A11.9 11.9 0 0 0 1.7 18l-1.6 6 6.1-1.6A12 12 0 1 0 12 0Z"/></svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
