<?php
/**
 * Dynamic hero slider (CPT slide). Locale-agnostic; translate slides via Polylang.
 * Falls back to bundled static slides when empty (caller handles fallback).
 */
$almazaya_slides   = almazaya_get_ordered_posts( 'slide' );
$almazaya_variants = array( '', 'alt', 'gold' );
$almazaya_si       = 0;
?>
<section data-slider>
  <div class="hero">
<?php
foreach ( $almazaya_slides as $almazaya_slide ) :
	$almazaya_kicker      = get_post_meta( $almazaya_slide->ID, '_almazaya_kicker', true );
	$almazaya_heading     = get_post_meta( $almazaya_slide->ID, '_almazaya_heading', true );
	$almazaya_desc        = apply_filters( 'the_content', $almazaya_slide->post_content );
	$almazaya_b1_label    = get_post_meta( $almazaya_slide->ID, '_almazaya_btn1_label', true );
	$almazaya_b1_url      = get_post_meta( $almazaya_slide->ID, '_almazaya_btn1_url', true );
	$almazaya_b2_label    = get_post_meta( $almazaya_slide->ID, '_almazaya_btn2_label', true );
	$almazaya_b2_url      = get_post_meta( $almazaya_slide->ID, '_almazaya_btn2_url', true );
	$almazaya_badge_title = get_post_meta( $almazaya_slide->ID, '_almazaya_badge_title', true );
	$almazaya_badge_text  = get_post_meta( $almazaya_slide->ID, '_almazaya_badge_text', true );
	$almazaya_bg          = get_the_post_thumbnail_url( $almazaya_slide, 'large' );
	$almazaya_cls         = 'hero-slide' . ( 0 === $almazaya_si ? ' current' : '' );
	if ( '' !== $almazaya_variants[ $almazaya_si % 3 ] ) {
		$almazaya_cls .= ' ' . $almazaya_variants[ $almazaya_si % 3 ];
	}
	if ( $almazaya_bg ) {
		$almazaya_cls .= ' has-bg';
	}
	?>
	<div class="<?php echo esc_attr( $almazaya_cls ); ?>">
		<?php if ( $almazaya_bg ) : ?>
			<img class="hero-bg" src="<?php echo esc_url( $almazaya_bg ); ?>" alt="">
		<?php endif; ?>
		<div class="container hero-inner">
			<?php if ( $almazaya_kicker ) : ?>
				<span class="kicker"><?php echo esc_html( $almazaya_kicker ); ?></span>
			<?php endif; ?>
			<h1><?php echo $almazaya_heading ? $almazaya_heading : esc_html( $almazaya_slide->post_title ); ?></h1>
			<?php echo $almazaya_desc; ?>
			<?php if ( $almazaya_b1_label || $almazaya_b2_label ) : ?>
				<div class="hero-actions">
					<?php
					foreach ( array( array( $almazaya_b1_label, $almazaya_b1_url, true ), array( $almazaya_b2_label, $almazaya_b2_url, false ) ) as $almazaya_btn ) {
						if ( '' === $almazaya_btn[0] ) {
							continue;
						}
						$almazaya_href = almazaya_btn_url( $almazaya_btn[1] );
						$almazaya_ext  = ( strpos( $almazaya_href, 'http' ) === 0 && strpos( $almazaya_href, home_url() ) !== 0 ) ? ' target="_blank" rel="noopener"' : '';
						printf(
							'<a class="btn %s" href="%s"%s>%s</a>',
							$almazaya_btn[2] ? 'btn-gold' : 'btn-outline',
							esc_url( $almazaya_href ),
							$almazaya_ext,
							esc_html( $almazaya_btn[0] )
						);
					}
					?>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( $almazaya_badge_title ) : ?>
			<div class="hero-badge">
				<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15a7 7 0 0 0 7-7c0-1.5-.5-3-1.3-4.2L15 7l-3-3-3 3L6.3 3.8A7 7 0 0 0 5 8a7 7 0 0 0 7 7Z"/><path d="M9 21h6M10 17.5 9.5 21M14 17.5l.5 3.5M12 15v2.5"/></svg>
				<div>
					<strong><?php echo esc_html( $almazaya_badge_title ); ?></strong>
					<?php if ( $almazaya_badge_text ) : ?>
						<span><?php echo esc_html( $almazaya_badge_text ); ?></span>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<?php
	$almazaya_si++;
endforeach;
?>
<div class="hero-controls"></div>
  </div>
</section>
