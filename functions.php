<?php
/**
 * Al Mazaya Islamic School — theme functions.
 *
 * v1 port: static pages live in template-parts/pages/{slug}-{id,en}.php,
 * shared chrome (topbar/header/footer) in header.php / footer.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ALMAZAYA_VERSION', '1.0.0' );
define( 'ALMAZAYA_JS_VERSION', '1.0.0' );

/* ---------- Setup ---------- */

function almazaya_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	register_nav_menus(
		array(
			'primary' => __( 'Menu Utama', 'almazaya' ),
			'footer'  => __( 'Menu Footer', 'almazaya' ),
		)
	);
}
add_action( 'after_setup_theme', 'almazaya_setup' );

/* ---------- Assets ---------- */

function almazaya_assets() {
	wp_enqueue_style(
		'almazaya-fonts',
		'https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style(
		'almazaya-style',
		get_template_directory_uri() . '/assets/css/style.css',
		array( 'almazaya-fonts' ),
		ALMAZAYA_VERSION
	);
	wp_enqueue_script(
		'almazaya-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		ALMAZAYA_JS_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'almazaya_assets' );

/* ---------- Language helpers (Polylang-aware) ---------- */

/**
 * True when the current locale is English.
 * Works with Polylang (sets locale per language) and plain installs.
 */
function almazaya_is_en() {
	if ( function_exists( 'pll_current_language' ) ) {
		return pll_current_language() === 'en';
	}
	return strpos( get_locale(), 'en' ) === 0;
}

/** Template-part suffix: 'en' or 'id'. */
function almazaya_lang_suffix() {
	return almazaya_is_en() ? 'en' : 'id';
}

/* ---------- Internal URLs ---------- */

/**
 * URL to a theme page. $slug is one of index|tentang|akademik|jenjang|berita|galeri|ppdb.
 * $lang_prefix is 'en/' for the English tree (Polylang default), '' otherwise.
 * Requires pages with matching slugs + "Post name" permalinks (see README).
 */
function almazaya_url( $slug = 'index', $lang_prefix = '', $anchor = '' ) {
	$path = ( $lang_prefix === 'en/' ) ? 'en/' : '';
	if ( $slug !== 'index' ) {
		$path .= $slug . '/';
	}
	return home_url( $path ) . $anchor;
}

/* ---------- Customizer links ---------- */

function almazaya_default_links() {
	return array(
		'shs_class'      => 'https://almazayaislamicschool.sch.id/class',
		'jhs_class'      => 'https://almazayaislamicschool.my.id/class/login/index.php',
		'instagram'      => 'https://www.instagram.com/almazayaislamicschool/',
		'whatsapp'       => 'https://wa.me/628115051123',
		'whatsapp_float' => 'https://wa.me/628115051123?text=Assalamualaikum',
		'youtube'        => 'https://www.youtube.com/@almazayaislamicschool1244',
		'psb'            => 'https://psb.almazayaislamicschool.sch.id',
	);
}

/** Configurable external URL, e.g. almazaya_link( 'instagram' ). */
function almazaya_link( $key ) {
	$defaults = almazaya_default_links();
	$fallback = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '#';
	return get_theme_mod( 'almazaya_' . $key, $fallback );
}

function almazaya_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'almazaya_links',
		array(
			'title'    => __( 'Tautan Al Mazaya', 'almazaya' ),
			'priority' => 30,
		)
	);
	$labels = array(
		'shs_class'      => __( 'SHS Virtual Class URL', 'almazaya' ),
		'jhs_class'      => __( 'JHS Virtual Class URL', 'almazaya' ),
		'instagram'      => __( 'Instagram URL', 'almazaya' ),
		'whatsapp'       => __( 'WhatsApp URL', 'almazaya' ),
		'whatsapp_float' => __( 'WhatsApp mengambang URL', 'almazaya' ),
		'youtube'        => __( 'YouTube URL', 'almazaya' ),
		'psb'            => __( 'Portal PSB URL', 'almazaya' ),
	);
	foreach ( almazaya_default_links() as $key => $default ) {
		$wp_customize->add_setting(
			'almazaya_' . $key,
			array(
				'default'           => $default,
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'almazaya_' . $key,
			array(
				'label'   => $labels[ $key ],
				'section' => 'almazaya_links',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'almazaya_customize_register' );

/* ---------- Nav data (shared by header fallback + mobile nav) ---------- */

function almazaya_primary_links() {
	$en = almazaya_is_en();
	$school_sub = $en
		? array(
			array( 'mmi', 'MMI Preschool' ),
			array( 'smp', 'Junior High' ),
			array( 'sma', 'Senior High' ),
		)
		: array(
			array( 'mmi', 'KB-TK MMI' ),
			array( 'smp', 'SMP' ),
			array( 'sma', 'SMA' ),
		);
	if ( $en ) {
		return array(
			array( 'index', 'Home' ),
			array( 'tentang', 'About' ),
			array( 'jenjang', 'Our School', $school_sub ),
			array( 'akademik', 'Academics' ),
			array( 'berita', 'News' ),
			array( 'galeri', 'Student Activities' ),
			array( 'ppdb', 'Admission' ),
		);
	}
	return array(
		array( 'index', 'Beranda' ),
		array( 'tentang', 'Tentang' ),
		array( 'jenjang', 'Sekolah Kami', $school_sub ),
		array( 'akademik', 'Akademik' ),
		array( 'berita', 'Berita' ),
		array( 'galeri', 'Aktivitas Siswa' ),
		array( 'ppdb', 'PPDB' ),
	);
}

function almazaya_footer_links() {
	if ( almazaya_is_en() ) {
		return array(
			array( 'tentang', 'About Us' ),
			array( 'jenjang', 'Our School' ),
			array( 'akademik', 'Academics' ),
			array( 'berita', 'News & Achievements' ),
			array( 'galeri', 'Student Activities' ),
			array( 'ppdb', 'Admission' ),
		);
	}
	return array(
		array( 'tentang', 'Tentang Kami' ),
		array( 'jenjang', 'Sekolah Kami' ),
		array( 'berita', 'Berita & Prestasi' ),
		array( 'galeri', 'Aktivitas Siswa' ),
		array( 'ppdb', 'PPDB' ),
	);
}

/** Slug of the page currently shown (best effort, for the .active state). */
function almazaya_current_slug() {
	if ( is_front_page() ) {
		return 'index';
	}
	$obj = get_queried_object();
	if ( $obj instanceof WP_Post ) {
		return $obj->post_name;
	}
	return '';
}

function almazaya_fallback_primary_nav() {
	$cur  = almazaya_current_slug();
	$pfx  = almazaya_is_en() ? 'en/' : '';
	$inschool = in_array( $cur, array( 'jenjang', 'mmi', 'smp', 'sma' ), true );
	echo '<nav class="main-nav"><ul>';
	foreach ( almazaya_primary_links() as $item ) {
		$slug  = $item[0];
		$label = $item[1];
		$sub   = isset( $item[2] ) ? $item[2] : null;
		if ( $sub ) {
			printf(
				'<li class="has-sub"><a href="%s"%s>%s</a><ul class="sub-nav">',
				esc_url( almazaya_url( $slug, $pfx ) ),
				$inschool ? ' class="active"' : '',
				esc_html( $label )
			);
			foreach ( $sub as $child ) {
				printf(
					'<li><a href="%s"%s>%s</a></li>',
					esc_url( almazaya_url( $child[0], $pfx ) ),
					( $cur === $child[0] ) ? ' class="active"' : '',
					esc_html( $child[1] )
				);
			}
			echo '</ul></li>';
		} else {
			printf(
				'<li><a href="%s"%s>%s</a></li>',
				esc_url( almazaya_url( $slug, $pfx ) ),
				( $cur === $slug ) ? ' class="active"' : '',
				esc_html( $label )
			);
		}
	}
	echo '</ul></nav>';
}

function almazaya_fallback_footer_nav() {
	echo '<ul class="footer-links">';
	foreach ( almazaya_footer_links() as $item ) {
		list( $slug, $label ) = $item;
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( almazaya_url( $slug, almazaya_is_en() ? 'en/' : '' ) ),
			esc_html( $label )
		);
	}
	printf(
		'<li><a href="%s" target="_blank" rel="noopener">%s</a></li>',
		esc_url( almazaya_link( 'psb' ) ),
		esc_html( almazaya_is_en() ? 'Online Admission Portal' : 'Portal PSB Online' )
	);
	echo '</ul>';
}

/** Language switcher: Polylang when available, static home links otherwise. */
function almazaya_lang_toggle( $extra_class = '' ) {
	$cls = 'lang-toggle' . ( $extra_class ? ' ' . $extra_class : '' );
	if ( function_exists( 'pll_the_languages' ) ) {
		$langs = pll_the_languages( array( 'raw' => 1 ) );
		if ( ! empty( $langs ) && ! isset( $langs['error'] ) ) {
			$label = almazaya_is_en() ? 'Switch language' : 'Ganti bahasa';
			echo '<span class="' . esc_attr( $cls ) . '" aria-label="' . esc_attr( $label ) . '">';
			foreach ( $langs as $code => $l ) {
				printf(
					'<a%s href="%s" title="%s">%s</a>',
					! empty( $l['current_lang'] ) ? ' class="active"' : '',
					esc_url( $l['url'] ),
					esc_attr( $l['name'] ),
					esc_html( strtoupper( substr( $code, 0, 2 ) ) )
				);
			}
			echo '</span>';
			return;
		}
	}
	$en    = almazaya_is_en();
	$label = $en ? 'Switch language' : 'Ganti bahasa';
	printf(
		'<span class="%s" aria-label="%s"><a%s href="%s" title="Bahasa Indonesia">ID</a><a%s href="%s" title="English">EN</a></span>',
		esc_attr( $cls ),
		esc_attr( $label ),
		$en ? '' : ' class="active"',
		esc_url( home_url( '/' ) ),
		$en ? ' class="active"' : '',
		esc_url( home_url( '/en/' ) )
	);
}
