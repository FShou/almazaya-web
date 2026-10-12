<?php
/**
 * Dynamic program explorer (CPT program): stage scenes + panel + peek buttons.
 * Tail (DATA script + lightbox) lives in programs-tail.php.
 */
$almazaya_programs = almazaya_get_ordered_posts( 'program' );
$almazaya_pi      = 0;
?>
<div class="modclass">
	<div class="modclass-media reveal" id="mc-stage">
		<button class="mc-fs-btn" aria-label="Fullscreen" onclick="mcFullscreen()">
			<svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/></svg>
		</button>
		<?php foreach ( $almazaya_programs as $almazaya_prog ) : ?>
			<?php
			$almazaya_pslug = $almazaya_prog->post_name;
			$almazaya_pimg  = get_the_post_thumbnail_url( $almazaya_prog, 'large' );
			if ( ! $almazaya_pimg ) {
				$almazaya_pimg = almazaya_img( 'overseas_img_8730_min' );
			}
			?>
			<div class="mc-scene<?php echo 0 === $almazaya_pi ? ' active' : ''; ?>" data-scene="<?php echo esc_attr( $almazaya_pslug ); ?>">
				<span class="modclass-badge"><?php echo esc_html( $almazaya_prog->post_title ); ?></span>
				<img class="mc-photo" src="<?php echo esc_url( $almazaya_pimg ); ?>" alt="<?php echo esc_attr( $almazaya_prog->post_title ); ?>">
			</div>
			<?php $almazaya_pi++; ?>
		<?php endforeach; ?>
	</div>

	<?php $almazaya_first = $almazaya_programs[0]; ?>
	<div class="modclass-panel reveal d1">
		<span class="kicker" id="mc-label"><?php echo esc_html( $almazaya_first->post_title ); ?></span>
		<h3 id="mc-heading"><?php echo get_post_meta( $almazaya_first->ID, '_almazaya_heading', true ) ? get_post_meta( $almazaya_first->ID, '_almazaya_heading', true ) : esc_html( $almazaya_first->post_title ); ?></h3>
		<p id="mc-desc"><?php echo esc_html( $almazaya_first->post_excerpt ? $almazaya_first->post_excerpt : wp_trim_words( wp_strip_all_tags( $almazaya_first->post_content ), 32 ) ); ?></p>
		<ul class="modclass-list" id="mc-list">
			<?php echo get_post_meta( $almazaya_first->ID, '_almazaya_items', true ); ?>
		</ul>
		<a class="btn btn-gold" href="<?php echo esc_url( almazaya_url( 'jenjang', almazaya_is_en() ? 'en/' : '' ) ); ?>" id="mc-cta"><?php echo esc_html( almazaya_is_en() ? 'See All Programs →' : 'Lihat Semua Program →' ); ?></a>
	</div>
</div>

<div class="prog-slider reveal">
	<button class="prog-arrow prev" aria-label="Program sebelumnya" onclick="progMove(-1)">‹</button>
	<div class="prog-track" id="prog-track">
		<?php
		$almazaya_pj = 0;
		foreach ( $almazaya_programs as $almazaya_prog ) :
			$almazaya_pimg = get_the_post_thumbnail_url( $almazaya_prog, 'large' );
			if ( ! $almazaya_pimg ) {
				$almazaya_pimg = almazaya_img( 'overseas_img_8730_min' );
			}
			?>
			<button class="mc-peek<?php echo 0 === $almazaya_pj ? ' active' : ''; ?>" data-target="<?php echo esc_attr( $almazaya_prog->post_name ); ?>" onclick="mcSwitch('<?php echo esc_js( $almazaya_prog->post_name ); ?>',this)">
				<div class="mc-peek-scene"><img src="<?php echo esc_url( $almazaya_pimg ); ?>" alt=""></div>
				<span><?php echo esc_html( $almazaya_prog->post_title ); ?></span>
			</button>
			<?php $almazaya_pj++; ?>
		<?php endforeach; ?>
	</div>
	<button class="prog-arrow next" aria-label="Program berikutnya" onclick="progMove(1)">›</button>
</div>
