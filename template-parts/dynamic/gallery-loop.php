<?php
/**
 * Template part: galeri dinamis — satu tile bento = satu album (kategori).
 * Layout tetap seperti grid bawaan theme (mosaik bento); bedanya setiap tile
 * mewakili sebuah album/kategori (cover = foto pertama), dan saat diklik semua
 * foto album itu dibuka layar penuh (lightbox: slide + thumbnail pratinjau).
 * Daftar foto tiap album disimpan di wadah tersembunyi `.gal-sources` supaya
 * JS bisa membaca isinya. Kosong = template induk memakai markup statis bawaan.
 */
$almazaya_fotos = almazaya_get_ordered_posts( 'gallery' );
if ( ! $almazaya_fotos ) {
	return;
}

$almazaya_albums = array();
foreach ( $almazaya_fotos as $almazaya_foto ) {
	$almazaya_src = get_the_post_thumbnail_url( $almazaya_foto->ID, 'large' );
	if ( ! $almazaya_src ) {
		continue;
	}
	$almazaya_terms = wp_get_post_terms( $almazaya_foto->ID, 'galeri_cat' );
	$almazaya_has   = ( $almazaya_terms && ! is_wp_error( $almazaya_terms ) );
	$almazaya_slug  = $almazaya_has ? $almazaya_terms[0]->slug : 'lainnya';
	$almazaya_name  = $almazaya_has ? $almazaya_terms[0]->name : ( almazaya_is_en() ? 'More' : 'Lainnya' );
	if ( ! isset( $almazaya_albums[ $almazaya_slug ] ) ) {
		$almazaya_albums[ $almazaya_slug ] = array(
			'name'   => $almazaya_name,
			'photos' => array(),
		);
	}
	$almazaya_albums[ $almazaya_slug ]['photos'][] = array(
		'src'   => $almazaya_src,
		'label' => get_the_title( $almazaya_foto->ID ),
	);
}
if ( ! $almazaya_albums ) {
	return;
}
$almazaya_en = almazaya_is_en();
?>
        <div class="gallery-bento">
<?php foreach ( $almazaya_albums as $almazaya_slug => $almazaya_album ) : ?>
<?php
$almazaya_cover = $almazaya_album['photos'][0];
$almazaya_total = count( $almazaya_album['photos'] );
$almazaya_meta  = $almazaya_album['name'] . ' &middot; ' . $almazaya_total . ' ' . ( $almazaya_en ? 'photos' : 'foto' );
?>
          <div class="has-photo img-slot reveal" data-album="<?php echo esc_attr( $almazaya_slug ); ?>" role="button" tabindex="0" aria-label="<?php echo esc_attr( $almazaya_meta ); ?>">
            <img class="slot-photo" src="<?php echo esc_url( $almazaya_cover['src'] ); ?>" alt="<?php echo esc_attr( $almazaya_album['name'] ); ?>" loading="lazy">
            <span class="gal-label"><?php echo esc_html( $almazaya_album['name'] ); ?> &middot; <?php echo (int) $almazaya_total; ?> <?php echo esc_html( $almazaya_en ? 'photos' : 'foto' ); ?></span>
          </div>
<?php endforeach; ?>
        </div>
        <div class="gal-sources" hidden>
<?php foreach ( $almazaya_albums as $almazaya_slug => $almazaya_album ) : ?>
          <div data-album="<?php echo esc_attr( $almazaya_slug ); ?>">
<?php foreach ( $almazaya_album['photos'] as $almazaya_p ) : ?>
            <img src="<?php echo esc_url( $almazaya_p['src'] ); ?>" data-label="<?php echo esc_attr( $almazaya_p['label'] ); ?>" alt="">
<?php endforeach; ?>
          </div>
<?php endforeach; ?>
        </div>
