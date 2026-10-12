<?php
/**
 * Dynamic partner grid (CPT mitra). URL optional; logo falls back to initial.
 */
$almazaya_mitra = almazaya_get_ordered_posts( 'mitra' );
?>
<div class="partner-grid">
<?php
foreach ( $almazaya_mitra as $almazaya_m ) :
	$almazaya_murl     = get_post_meta( $almazaya_m->ID, '_almazaya_url', true );
	$almazaya_mlogo    = get_the_post_thumbnail_url( $almazaya_m, 'medium' );
	$almazaya_mcountry = $almazaya_m->post_excerpt;
	$almazaya_mtag     = $almazaya_murl ? 'a' : 'div';
	?>
	<<?php echo $almazaya_mtag; ?> class="partner-card reveal"<?php echo $almazaya_murl ? ' href="' . esc_url( $almazaya_murl ) . '" target="_blank" rel="noopener"' : ''; ?>>
		<?php if ( $almazaya_mlogo ) : ?>
			<img class="partner-logo" src="<?php echo esc_url( $almazaya_mlogo ); ?>" alt="<?php echo esc_attr( $almazaya_m->post_title ); ?>">
		<?php else : ?>
			<span class="partner-logo-fallback" aria-hidden="true"><?php echo esc_html( strtoupper( substr( $almazaya_m->post_title, 0, 1 ) ) ); ?></span>
		<?php endif; ?>
		<h3><?php echo esc_html( $almazaya_m->post_title ); ?></h3>
		<?php if ( $almazaya_mcountry ) : ?>
			<p><?php echo esc_html( $almazaya_mcountry ); ?></p>
		<?php endif; ?>
	</<?php echo $almazaya_mtag; ?>>
<?php endforeach; ?>
</div>
