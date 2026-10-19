<?php
/**
 * Template part: galeri dinamis — satu post = satu foto.
 * Foto = Featured Image, judul = caption, taxonomy `galeri_cat` = label filter.
 * Dipanggil dari galeri-id/en.php hanya bila ada entri; jika kosong, template
 * induk memakai markup statis bawaan (byte-identik dengan desain asli).
 */
$almazaya_fotos = almazaya_get_ordered_posts( 'gallery' );
if ( ! $almazaya_fotos ) {
	return;
}
$almazaya_cats = get_terms(
	array(
		'taxonomy'   => 'galeri_cat',
		'hide_empty' => true,
	)
);
?>
    <div class="filter-row reveal">
      <button class="filter-chip active"><?php echo esc_html( almazaya_is_en() ? 'All Events' : 'Semua Event' ); ?></button>
<?php if ( $almazaya_cats && ! is_wp_error( $almazaya_cats ) ) : ?>
<?php foreach ( $almazaya_cats as $almazaya_cat ) : ?>
      <button class="filter-chip"><?php echo esc_html( $almazaya_cat->name ); ?></button>
<?php endforeach; ?>
<?php endif; ?>
    </div>

<div class="gallery-bento">
<?php
foreach ( $almazaya_fotos as $almazaya_foto ) :
	$almazaya_src = get_the_post_thumbnail_url( $almazaya_foto->ID, 'large' );
	if ( ! $almazaya_src ) {
		continue;
	}
	$almazaya_terms = wp_get_post_terms( $almazaya_foto->ID, 'galeri_cat' );
	$almazaya_cat   = ( $almazaya_terms && ! is_wp_error( $almazaya_terms ) ) ? $almazaya_terms[0]->name : '';
	$almazaya_label = get_the_title( $almazaya_foto->ID );
	?>
      <div<?php echo $almazaya_cat ? ' data-cat="' . esc_attr( $almazaya_cat ) . '"' : ''; ?> class="has-photo img-slot reveal">
        <img class="slot-photo" src="<?php echo esc_url( $almazaya_src ); ?>" alt="<?php echo esc_attr( $almazaya_label ); ?>">
        <span class="gal-label"><?php echo esc_html( $almazaya_label ); ?></span>
      </div>
<?php endforeach; ?>
    </div>
