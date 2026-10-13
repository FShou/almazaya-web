<?php
/**
 * Dynamic overseas destinations (CPT destination), 4 modes via $args['part']:
 * dots (SVG markers) | chips | cards (modal) | script (DATA + handlers).
 * Falls back to bundled static markup when empty (caller handles fallback).
 */
$almazaya_args = isset( $args ) && is_array( $args ) ? $args : array();
$almazaya_part = isset( $almazaya_args['part'] ) ? $almazaya_args['part'] : 'dots';
$almazaya_dests = almazaya_get_ordered_posts( 'destination' );
$almazaya_en   = almazaya_is_en();

if ( 'dots' === $almazaya_part ) :
	foreach ( $almazaya_dests as $almazaya_d ) :
		$almazaya_slug = $almazaya_d->post_name;
		$almazaya_cx   = (int) get_post_meta( $almazaya_d->ID, '_almazaya_map_x', true );
		$almazaya_cy   = (int) get_post_meta( $almazaya_d->ID, '_almazaya_map_y', true );
		$almazaya_cname = get_post_meta( $almazaya_d->ID, '_almazaya_country', true );
		if ( '' === $almazaya_cname ) {
			$almazaya_cname = $almazaya_slug;
		}
		?>
		<g class="map-dest" data-country="<?php echo esc_attr( $almazaya_slug ); ?>" role="button" tabindex="0" aria-label="<?php echo esc_attr( $almazaya_cname ); ?>"><circle cx="<?php echo esc_attr( $almazaya_cx ); ?>" cy="<?php echo esc_attr( $almazaya_cy ); ?>" r="16" class="map-hit"/><circle cx="<?php echo esc_attr( $almazaya_cx ); ?>" cy="<?php echo esc_attr( $almazaya_cy ); ?>" r="6" class="map-marker"/><text x="<?php echo esc_attr( $almazaya_cx ); ?>" y="<?php echo esc_attr( $almazaya_cy - 20 ); ?>" class="map-label" text-anchor="middle"><?php echo esc_html( $almazaya_cname ); ?></text></g>
		<?php
	endforeach;

elseif ( 'chips' === $almazaya_part ) :
	$almazaya_first = true;
	foreach ( $almazaya_dests as $almazaya_d ) :
		$almazaya_cname = get_post_meta( $almazaya_d->ID, '_almazaya_country', true );
		if ( '' === $almazaya_cname ) {
			$almazaya_cname = $almazaya_d->post_name;
		}
		$almazaya_flag = get_post_meta( $almazaya_d->ID, '_almazaya_flag', true );
		if ( ! $almazaya_first ) {
			echo ' ';
		}
		$almazaya_first = false;
		printf(
			'<button class="ov-chip" data-country="%s">%s%s</button>',
			esc_attr( $almazaya_d->post_name ),
			$almazaya_flag ? esc_html( $almazaya_flag ) . ' ' : '',
			esc_html( $almazaya_cname )
		);
	endforeach;

elseif ( 'cards' === $almazaya_part ) :
	foreach ( $almazaya_dests as $almazaya_d ) :
		$almazaya_cname = get_post_meta( $almazaya_d->ID, '_almazaya_country', true );
		if ( '' === $almazaya_cname ) {
			$almazaya_cname = $almazaya_d->post_name;
		}
		$almazaya_flag = get_post_meta( $almazaya_d->ID, '_almazaya_flag', true );
		$almazaya_tag  = get_post_meta( $almazaya_d->ID, '_almazaya_tag', true );
		$almazaya_web  = get_post_meta( $almazaya_d->ID, '_almazaya_website', true );
		$almazaya_logo = get_the_post_thumbnail_url( $almazaya_d, 'medium' );
		$almazaya_desc = $almazaya_d->post_excerpt ? $almazaya_d->post_excerpt : wp_trim_words( wp_strip_all_tags( $almazaya_d->post_content ), 32 );
		?>
		<article class="map-modal-card" id="mc-<?php echo esc_attr( $almazaya_d->post_name ); ?>">
			<header class="map-modal-head"><span class="map-modal-flag"><?php echo esc_html( $almazaya_flag ); ?></span><div><?php if ( $almazaya_tag ) : ?><span class="map-modal-tag"><?php echo esc_html( $almazaya_tag ); ?></span><?php endif; ?><h4><?php echo esc_html( $almazaya_d->post_title ); ?></h4></div></header>
			<?php if ( $almazaya_logo ) : ?>
				<img class="map-modal-logo" src="<?php echo esc_url( $almazaya_logo ); ?>" alt="<?php echo esc_attr( $almazaya_d->post_title ); ?>" loading="lazy">
			<?php endif; ?>
			<p class="map-modal-desc"><?php echo esc_html( $almazaya_desc ); ?></p>
			<?php if ( $almazaya_web ) : ?>
				<a class="btn btn-gold map-link" href="<?php echo esc_url( $almazaya_web ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $almazaya_en ? 'Visit Website →' : 'Kunjungi Website →' ); ?></a>
			<?php else : ?>
				<span class="map-nolink"><?php echo esc_html( $almazaya_en ? 'Official website not available yet' : 'Website resmi belum tersedia' ); ?></span>
			<?php endif; ?>
		</article>
		<?php
	endforeach;

elseif ( 'script' === $almazaya_part ) :
	$almazaya_data  = array();
	$almazaya_order = array();
	foreach ( $almazaya_dests as $almazaya_d ) :
		$almazaya_cname = get_post_meta( $almazaya_d->ID, '_almazaya_country', true );
		if ( '' === $almazaya_cname ) {
			$almazaya_cname = $almazaya_d->post_name;
		}
		$almazaya_data[ $almazaya_d->post_name ] = array(
			'c' => $almazaya_cname,
			'n' => $almazaya_d->post_title,
			'e' => get_post_meta( $almazaya_d->ID, '_almazaya_flag', true ),
		);
		$almazaya_order[] = $almazaya_d->post_name;
	endforeach;
	$almazaya_first = reset( $almazaya_dests );
	$almazaya_fcname = get_post_meta( $almazaya_first->ID, '_almazaya_country', true );
	if ( '' === $almazaya_fcname ) {
		$almazaya_fcname = $almazaya_first->post_name;
	}
	$almazaya_json = str_replace( '</', '<\/', wp_json_encode( $almazaya_data ) );
	?>
	<script>
	(function(){{
		var DATA = <?php echo $almazaya_json; ?>;
		var ORDER = <?php echo wp_json_encode( $almazaya_order ); ?>;
		var modal = document.getElementById('overseas-modal');
		var country = document.getElementById('overseasModalCountry');
		var idx = 0;
		var active = null;
		function show(k, focus) {{
			idx = ORDER.indexOf(k);
			for (var i=0;i<ORDER.length;i++) document.getElementById('mc-'+ORDER[i]).classList.toggle('active', ORDER[i]===k);
			var d = DATA[k];
			country.textContent = (d.e ? d.e + ' ' : '') + d.c;
			modal.classList.add('open');
			document.body.classList.add('modal-open');
			if (active) active.classList.remove('active');
			var m = document.querySelector('.map-dest[data-country="'+k+'"] .map-marker');
			if (m) {{ m.classList.add('active'); active = m; }}
			if (focus) document.getElementById('overseasModalClose').focus();
		}}
		function hide() {{
			modal.classList.remove('open');
			document.body.classList.remove('modal-open');
			if (active) {{ active.classList.remove('active'); active = null; }}
		}}
		function nav(d) {{ show(ORDER[(idx + d + ORDER.length) % ORDER.length]); }}
		document.querySelectorAll('.map-dest').forEach(function(el){{
			el.addEventListener('click', function(){{ show(el.getAttribute('data-country'), true); }});
			el.addEventListener('keydown', function(e){{ if (e.key==='Enter'||e.key===' ') {{ e.preventDefault(); show(el.getAttribute('data-country'), true); }} }});
		}});
		document.querySelectorAll('.ov-chip').forEach(function(el){{
			el.addEventListener('click', function(){{ show(el.getAttribute('data-country'), true); }});
		}});
		document.querySelectorAll('.map-nav-btn').forEach(function(el){{
			el.addEventListener('click', function(){{ nav(parseInt(el.getAttribute('data-dir'),10)); }});
		}});
		document.getElementById('overseasModalClose').addEventListener('click', hide);
		modal.addEventListener('click', function(e){{ if (e.target===modal) hide(); }});
		document.addEventListener('keydown', function(e){{ if (e.key==='Escape' && modal.classList.contains('open')) hide(); }});
	}})();
	</script>
	<?php
endif;
