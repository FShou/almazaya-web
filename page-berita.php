<?php
/**
 * Template Name: Berita — Al Mazaya
 *
 * Real post loop with category filter (?kategori=slug) + pagination.
 * Falls back to the bundled static listing when no posts exist yet.
 */
get_header();
$almazaya_en   = almazaya_is_en();
$almazaya_pfx  = $almazaya_en ? 'en/' : '';
$almazaya_paged = max( 1, (int) get_query_var( 'paged', 1 ) );
$almazaya_cat   = isset( $_GET['kategori'] ) ? sanitize_key( $_GET['kategori'] ) : '';
$almazaya_args  = array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 6,
	'paged'          => $almazaya_paged,
);
if ( '' !== $almazaya_cat ) {
	$almazaya_args['category_name'] = $almazaya_cat;
}
$almazaya_q = new WP_Query( $almazaya_args );
?>
<main class="site-main">
<?php if ( $almazaya_q->have_posts() ) : ?>
	<section class="page-hero">
		<div class="container">
			<p class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $almazaya_en ? 'Home' : 'Beranda' ); ?></a> / <?php echo esc_html( $almazaya_en ? 'News' : 'Berita' ); ?></p>
			<h1><?php echo $almazaya_en ? 'News &amp; <span class="tone">Achievements</span>' : 'Berita &amp; <span class="tone">Prestasi</span>'; ?></h1>
			<p><?php echo esc_html( $almazaya_en ? 'Latest news on student achievements, school activities, and official announcements.' : 'Kabar terbaru seputar prestasi siswa, kegiatan sekolah, dan pengumuman resmi.' ); ?></p>
		</div>
	</section>

	<section class="section">
		<div class="container">
			<div class="filter-row reveal">
				<?php
				$almazaya_base = almazaya_url( 'berita', $almazaya_pfx );
				printf(
					'<a class="filter-chip%s" href="%s">%s</a>',
					'' === $almazaya_cat ? ' active' : '',
					esc_url( $almazaya_base ),
					esc_html( $almazaya_en ? 'All' : 'Semua' )
				);
				foreach ( almazaya_news_cats() as $almazaya_slug => $almazaya_info ) {
					printf(
						'<a class="filter-chip%s" href="%s">%s</a>',
						$almazaya_cat === $almazaya_slug ? ' active' : '',
						esc_url( $almazaya_base . '?kategori=' . $almazaya_slug ),
						esc_html( $almazaya_info[0] )
					);
				}
				?>
			</div>

			<div class="posts-editorial">
				<?php
				while ( $almazaya_q->have_posts() ) :
					$almazaya_q->the_post();
					$almazaya_cats = get_the_category();
					$almazaya_first = $almazaya_cats ? $almazaya_cats[0] : null;
					$almazaya_gold = $almazaya_first && in_array( $almazaya_first->slug, array( 'prestasi', 'achievement' ), true ) ? ' gold' : '';
					$almazaya_thumb = has_post_thumbnail();
					?>
					<article class="post-card reveal">
						<div class="post-thumb img-slot<?php echo $almazaya_thumb ? ' has-photo' : ' slot-pattern'; ?>">
							<?php if ( $almazaya_thumb ) : ?>
								<img class="slot-photo" src="<?php echo esc_url( get_the_post_thumbnail_url( null, 'medium_large' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
							<?php endif; ?>
						</div>
						<div class="post-body">
							<div class="post-meta">
								<?php if ( $almazaya_first ) : ?>
									<span class="chip<?php echo esc_attr( $almazaya_gold ); ?>"><?php echo esc_html( $almazaya_first->name ); ?></span>
								<?php endif; ?>
								<?php echo esc_html( get_the_date() ); ?>
							</div>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php the_excerpt(); ?>
							<a class="more-link" href="<?php the_permalink(); ?>"><?php echo esc_html( $almazaya_en ? 'Read more →' : 'Baca selengkapnya →' ); ?></a>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<?php almazaya_pagination( $almazaya_q, $almazaya_paged, '' !== $almazaya_cat ? array( 'kategori' => $almazaya_cat ) : array() ); ?>
		</div>
	</section>
<?php else : ?>
	<?php get_template_part( 'template-parts/pages/berita', almazaya_lang_suffix() ); ?>
<?php endif; ?>
</main>
<?php
wp_reset_postdata();
get_footer();
?>
