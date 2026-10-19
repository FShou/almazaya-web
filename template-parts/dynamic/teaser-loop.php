<?php
/**
 * Dynamic homepage teaser: latest 3 posts.
 */
$almazaya_teaser = get_posts(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
	)
);
global $post;
?>
<div class="posts-featured">
<?php
foreach ( $almazaya_teaser as $post ) :
	setup_postdata( $post );
	$almazaya_cats = get_the_category();
	$almazaya_cat  = $almazaya_cats ? $almazaya_cats[0] : null;
	$almazaya_gold = $almazaya_cat && in_array( $almazaya_cat->slug, array( 'prestasi', 'achievement' ), true ) ? ' gold' : '';
	$almazaya_thumb = has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'medium_large' ) : '';
	?>
	<article class="post-card reveal">
		<div class="post-thumb img-slot<?php echo $almazaya_thumb ? ' has-photo' : ' slot-pattern'; ?>">
			<?php if ( $almazaya_thumb ) : ?>
				<img class="slot-photo" src="<?php echo esc_url( $almazaya_thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
			<?php endif; ?>
		</div>
		<div class="post-body">
			<?php if ( $almazaya_cat ) : ?>
				<span class="chip<?php echo esc_attr( $almazaya_gold ); ?>"><?php echo esc_html( $almazaya_cat->name ); ?></span>
			<?php endif; ?>
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php the_excerpt(); ?>
			<a class="more-link" href="<?php the_permalink(); ?>"><?php echo esc_html( almazaya_is_en() ? 'Read more →' : 'Baca selengkapnya →' ); ?></a>
		</div>
	</article>
	<?php
endforeach;
wp_reset_postdata();
?>
</div>
