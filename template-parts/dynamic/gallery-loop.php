<?php
/**
 * Template part: galeri dinamis — album per kategori.
 * Satu entri = satu foto (Featured Image = foto, judul = caption, taxonomy
 * `galeri_cat` = album). Halaman menampilkan kartu album (cover dari beberapa
 * foto pertama + jumlah foto); klik album = grid foto album itu; klik foto =
 * lightbox layar penuh (slide + thumbnail). Kosong = template induk memakai
 * markup statis bawaan.
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
    <div class="gal-albums" id="gal-albums">
<?php foreach ( $almazaya_albums as $almazaya_slug => $almazaya_album ) : ?>
<?php $almazaya_cover = array_slice( $almazaya_album['photos'], 0, 4 ); ?>
      <button type="button" class="gal-album reveal" data-album="<?php echo esc_attr( $almazaya_slug ); ?>">
        <span class="gal-album-cover" aria-hidden="true">
<?php foreach ( $almazaya_cover as $almazaya_c ) : ?>
          <img src="<?php echo esc_url( $almazaya_c['src'] ); ?>" alt="" loading="lazy">
<?php endforeach; ?>
        </span>
        <span class="gal-album-meta">
          <span class="gal-album-name"><?php echo esc_html( $almazaya_album['name'] ); ?></span>
          <span class="gal-album-count"><?php echo (int) count( $almazaya_album['photos'] ); ?> <?php echo esc_html( $almazaya_en ? 'photos' : 'foto' ); ?></span>
        </span>
      </button>
<?php endforeach; ?>
    </div>

<?php foreach ( $almazaya_albums as $almazaya_slug => $almazaya_album ) : ?>
    <div class="gal-album-panel" data-album="<?php echo esc_attr( $almazaya_slug ); ?>" hidden>
      <div class="gal-album-head">
        <button type="button" class="gal-album-back">&larr; <?php echo esc_html( $almazaya_en ? 'All albums' : 'Semua album' ); ?></button>
        <h3 class="gal-album-title"><?php echo esc_html( $almazaya_album['name'] ); ?></h3>
        <span class="gal-album-count"><?php echo (int) count( $almazaya_album['photos'] ); ?> <?php echo esc_html( $almazaya_en ? 'photos' : 'foto' ); ?></span>
      </div>
      <div class="gallery-bento">
<?php foreach ( $almazaya_album['photos'] as $almazaya_p ) : ?>
        <div class="has-photo img-slot">
          <img class="slot-photo" src="<?php echo esc_url( $almazaya_p['src'] ); ?>" alt="<?php echo esc_attr( $almazaya_p['label'] ); ?>">
          <span class="gal-label"><?php echo esc_html( $almazaya_p['label'] ); ?></span>
        </div>
<?php endforeach; ?>
      </div>
    </div>
<?php endforeach; ?>
