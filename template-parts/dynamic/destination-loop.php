<?php
/**
 * Dynamic overseas destinations (CPT destination), modes via $args['part']:
 * map (Leaflet container) | chips | cards (modal) | mapscript (DATA +
 * handlers + Leaflet init). Falls back to bundled static SVG markup
 * when empty (caller handles fallback).
 */
$almazaya_args = isset( $args ) && is_array( $args ) ? $args : array();
$almazaya_part = isset( $almazaya_args['part'] ) ? $almazaya_args['part'] : 'map';
$almazaya_dests = almazaya_get_ordered_posts( 'destination' );
$almazaya_en   = almazaya_is_en();

if ( 'map' === $almazaya_part ) :
	?>
	<div id="ov-map" class="ov-map" role="application" aria-label="<?php echo esc_attr( $almazaya_en ? 'Map of overseas destinations' : 'Peta destinasi overseas' ); ?>"></div>
	<?php

elseif ( 'chips' === $almazaya_part ) :
	echo '<div class="overseas-chips reveal">';
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
	echo '</div>';

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

elseif ( 'mapscript' === $almazaya_part ) :
	$almazaya_data  = array();
	$almazaya_order = array();
	$almazaya_pts   = array();
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
		$almazaya_lat = get_post_meta( $almazaya_d->ID, '_almazaya_lat', true );
		$almazaya_lng = get_post_meta( $almazaya_d->ID, '_almazaya_lng', true );
		if ( '' !== $almazaya_lat && '' !== $almazaya_lng ) {
			$almazaya_pts[] = array(
				'slug' => $almazaya_d->post_name,
				'lat'  => (float) $almazaya_lat,
				'lng'  => (float) $almazaya_lng,
				'name' => $almazaya_cname,
			);
		}
	endforeach;
	$almazaya_json = str_replace( '</', '<\/', wp_json_encode( $almazaya_data ) );
	?>
	<script>
	(function(){{
		var DATA = <?php echo $almazaya_json; ?>;
		var ORDER = <?php echo wp_json_encode( $almazaya_order ); ?>;
		var PTS = <?php echo wp_json_encode( $almazaya_pts ); ?>;
		var modal = document.getElementById('overseas-modal');
		var country = document.getElementById('overseasModalCountry');
		var idx = 0;
		var active = null;
		var marks = {};
		function markActive(k) {{
			document.querySelectorAll('.ov-pin span.active').forEach(function(s){{ s.classList.remove('active'); }});
			if (k && marks[k] && marks[k].getElement()) {{
				var sp = marks[k].getElement().querySelector('span');
				if (sp) {{ sp.classList.add('active'); }}
			}}
		}}
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
			markActive(k);
			if (focus) document.getElementById('overseasModalClose').focus();
		}}
		function hide() {{
			modal.classList.remove('open');
			document.body.classList.remove('modal-open');
			if (active) {{ active.classList.remove('active'); active = null; }}
			markActive(null);
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
		if (typeof L !== 'undefined' && PTS.length) {
			var map = L.map('ov-map', { scrollWheelZoom: false, attributionControl: true }).setView([20, 30], 2);
			var icon = L.divIcon({ className: 'ov-pin', html: '<span></span>', iconSize: [20, 20], iconAnchor: [10, 10] });
			PTS.forEach(function(pt){
				var mk = L.marker([pt.lat, pt.lng], { icon: icon, title: pt.name, keyboard: true }).addTo(map);
				mk.on('click', function(){ show(pt.slug, true); });
				marks[pt.slug] = mk;
			});
			var bnds = L.latLngBounds(PTS.map(function(pt){ return [pt.lat, pt.lng]; }));
			map.fitBounds(bnds, { padding: [36, 36] });
			if (map.getZoom() > 4) { map.setZoom(4); }
		}
	}})();
	</script>
	<?php
endif;
