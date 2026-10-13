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

define( 'ALMAZAYA_VERSION', '1.0.4' );
define( 'ALMAZAYA_JS_VERSION', '1.0.4' );

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
 * URL to a theme page. $slug is one of index|tentang|jenjang|mmi|smp|sma|berita|berita-detail|galeri|ppdb.
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
		'mmi_instagram'  => 'https://www.instagram.com/modernmontessoribanjarmasin/',
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
		'mmi_instagram'  => __( 'Instagram MMI URL', 'almazaya' ),
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

	/* Content images, grouped per page section. */
	$img_sections = array();
	foreach ( almazaya_content_images() as $key => $info ) {
		$sec_id = 'almazaya_imgs_' . sanitize_key( $info['section'] );
		if ( ! isset( $img_sections[ $sec_id ] ) ) {
			$wp_customize->add_section(
				$sec_id,
				array(
					/* translators: %s: page group, e.g. Beranda */
					'title'    => sprintf( __( 'Gambar: %s', 'almazaya' ), $info['section'] ),
					'priority' => 40,
				)
			);
			$img_sections[ $sec_id ] = true;
		}
		$wp_customize->add_setting(
			'almazaya_img_' . $key,
			array(
				'default'           => get_template_directory_uri() . '/assets/img/' . $info['file'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'almazaya_img_' . $key,
				array(
					'label'   => $info['label'],
					'section' => $sec_id,
				)
			)
		);
	}

	/* Content texts (ID + EN variants). */
	$txt_sections = array();
	foreach ( almazaya_content_texts() as $key => $info ) {
		$sec_id = 'almazaya_txt_' . sanitize_key( $info['section'] );
		if ( ! isset( $txt_sections[ $sec_id ] ) ) {
			$wp_customize->add_section(
				$sec_id,
				array(
					'title'    => sprintf( __( 'Teks: %s', 'almazaya' ), $info['section'] ),
					'priority' => 41,
				)
			);
			$txt_sections[ $sec_id ] = true;
		}
		foreach ( array( 'id' => 'ID', 'en' => 'EN' ) as $lang => $lang_label ) {
			$setting_id = 'almazaya_txt_' . $key . '_' . $lang;
			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'           => $info[ $lang ],
					'sanitize_callback' => ( $info['type'] === 'html' ) ? 'wp_kses_post' : 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				$setting_id,
				array(
					'label'   => $info['label'] . ' (' . $lang_label . ')',
					'section' => $sec_id,
					'type'    => ( $info['type'] === 'html' ) ? 'textarea' : 'text',
				)
			);
		}
	}

	/* Instagram feed (optional): shortcode from a gallery plugin
	 * (e.g. Smash Balloon) OR raw embed HTML from a username widget
	 * (e.g. SociableKIT, Stormlikes, Fouita — generate from @username,
	 * paste the code here). When filled, the Galeri page shows the IG
	 * feed instead of the bundled photo grid. */
	$wp_customize->add_section(
		'almazaya_galeri',
		array(
			'title'       => __( 'Galeri Instagram', 'almazaya' ),
			'priority'    => 42,
			'description' => __( 'Tempel shortcode (mis. [instagram-feed]) ATAU kode embed dari widget username IG. Kosongkan untuk memakai grid foto bawaan.', 'almazaya' ),
		)
	);
	$wp_customize->add_setting(
		'almazaya_galeri_feed',
		array(
			'default'           => '',
			'sanitize_callback' => 'almazaya_sanitize_embed',
		)
	);
	$wp_customize->add_control(
		'almazaya_galeri_feed',
		array(
			'label'   => __( 'Shortcode / kode embed Instagram', 'almazaya' ),
			'section' => 'almazaya_galeri',
			'type'    => 'textarea',
		)
	);
}
add_action( 'customize_register', 'almazaya_customize_register' );

/** Render Instagram feed: shortcode or raw embed HTML (empty = bundled grid). */
function almazaya_galeri_feed_html() {
	$feed = trim( get_theme_mod( 'almazaya_galeri_feed', '' ) );
	if ( '' === $feed ) {
		return '';
	}
	if ( strpos( $feed, '[' ) !== false && strpos( $feed, ']' ) !== false ) {
		return do_shortcode( $feed );
	}
	return $feed;
}

/** Embed-code sanitizer: raw for trusted admins, kses otherwise. */
function almazaya_sanitize_embed( $v ) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		return $v;
	}
	return wp_kses_post( $v );
}

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
			array( 'berita', 'News' ),
			array( 'galeri', 'Student Activities' ),
			array( 'ppdb', 'Admission' ),
		);
	}
	return array(
		array( 'index', 'Beranda' ),
		array( 'tentang', 'Tentang' ),
			array( 'jenjang', 'Sekolah Kami', $school_sub ),
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

/* ---------- Dashboard-editable content: images ----------
 * Every content photo (51) is replaceable via Customizer, grouped per page.
 * To add a new one: append a row to almazaya_content_images() and use
 *   <?php echo esc_url( almazaya_img( 'key' ) ); ?>
 * in the template. Alt texts stay in the markup (edit alongside).
 */
function almazaya_content_images() {
	return array(
		'2527_3' => array( 'file' => '2527-3.webp', 'label' => 'Tahfidz Camp', 'section' => 'Beranda' ),
		'2527_img_20230215_wa0042' => array( 'file' => '2527-img-20230215-wa0042.webp', 'label' => 'Foto Kantor Yayasan', 'section' => 'Tentang' ),
		'2527_z1' => array( 'file' => '2527-z1.webp', 'label' => 'TKA & UTBK Intensive', 'section' => 'Beranda' ),
		'2750_r0003169' => array( 'file' => '2750-r0003169.webp', 'label' => 'TKA & UTBK Camp', 'section' => 'Beranda' ),
		'category_news_whats_app_image_2023_11_23_at_11_52_59_am_124' => array( 'file' => 'category-news-whats-app-image-2023-11-23-at-11-52-59-am-124.webp', 'label' => 'Foto berita olimpiade SMP', 'section' => 'Berita' ),
		'category_news_whats_app_image_2023_11_23_at_11_52_59_am' => array( 'file' => 'category-news-whats-app-image-2023-11-23-at-11-52-59-am.webp', 'label' => 'Achievement Photo', 'section' => 'Berita' ),
		'classroom_r0003044' => array( 'file' => 'classroom-r0003044.webp', 'label' => 'Computer & IT Lab · Coding & digital literacy', 'section' => 'Sekolah' ),
		'classroom_r0003050' => array( 'file' => 'classroom-r0003050.webp', 'label' => 'Foundation Class', 'section' => 'Beranda' ),
		'english_talent_show_screenshot_20230825_132045_1' => array( 'file' => 'english-talent-show-screenshot-20230825-132045-1.webp', 'label' => 'English Camp', 'section' => 'Beranda' ),
		'english_talent_show_screenshot_20230825_132133_1' => array( 'file' => 'english-talent-show-screenshot-20230825-132133-1.webp', 'label' => 'English Camp · Grade-7 language immersion', 'section' => 'Galeri' ),
		'english_talent_show_screenshot_20230829_131851' => array( 'file' => 'english-talent-show-screenshot-20230829-131851.webp', 'label' => 'English Zone · Cambridge immersion', 'section' => 'Sekolah' ),
		'english_talent_show_screenshot_20230829_135505' => array( 'file' => 'english-talent-show-screenshot-20230829-135505.webp', 'label' => 'English Talent Show', 'section' => 'Beranda' ),
		'english_talent_show_screenshot_20230829_140122' => array( 'file' => 'english-talent-show-screenshot-20230829-140122.webp', 'label' => 'Club & Enrichment', 'section' => 'Beranda' ),
		'english_talent_show_screenshot_20230829_145220' => array( 'file' => 'english-talent-show-screenshot-20230829-145220.webp', 'label' => 'English Camp', 'section' => 'Beranda' ),
		'english_talent_show_screenshot_20230829_145717' => array( 'file' => 'english-talent-show-screenshot-20230829-145717.webp', 'label' => 'English Talent Show', 'section' => 'Beranda' ),
		'english_talent_show_screenshot_20230829_151444' => array( 'file' => 'english-talent-show-screenshot-20230829-151444.webp', 'label' => 'English Talent Show · Monthly student talent stage', 'section' => 'Galeri' ),
		'hall_r0003030' => array( 'file' => 'hall-r0003030.webp', 'label' => 'Indoor Field · Sports & ceremonies', 'section' => 'Sekolah' ),
		'hello_world_wis' => array( 'file' => 'hello-world-wis.webp', 'label' => 'Library · References & Islamic literature', 'section' => 'Sekolah' ),
		'home_0011' => array( 'file' => 'home-0011.webp', 'label' => 'Lapangan Outdoor · Aktivitas & turnamen', 'section' => 'Sekolah' ),
		'home_20221214074906_img_6966' => array( 'file' => 'home-20221214074906-img-6966.webp', 'label' => 'Annual ABUELA Event', 'section' => 'Beranda' ),
		'home_img_1509' => array( 'file' => 'home-img-1509.webp', 'label' => 'Life Skill', 'section' => 'Beranda' ),
		'home_img_8658_min' => array( 'file' => 'home-img-8658-min.webp', 'label' => 'Academic Excellence', 'section' => 'Tentang' ),
		'junior_high_school_r0003026' => array( 'file' => 'junior-high-school-r0003026.webp', 'label' => 'Foto Angkatan Pertama SMP', 'section' => 'Tentang' ),
		'laboratory_r0003017' => array( 'file' => 'laboratory-r0003017.webp', 'label' => 'Math & Science Camp', 'section' => 'Beranda' ),
		'laboratory_r0003078' => array( 'file' => 'laboratory-r0003078.webp', 'label' => 'Biology Lab · Hands-on science', 'section' => 'Sekolah' ),
		'laboratory_r0003095' => array( 'file' => 'laboratory-r0003095.webp', 'label' => 'Lab Fisika & Kimia · Percobaan saintifik', 'section' => 'Sekolah' ),
		'market_day_20221214073641_img_6924' => array( 'file' => 'market-day-20221214073641-img-6924.webp', 'label' => 'Market Day booth', 'section' => 'Beranda' ),
		'market_day_20221214111711_img_7128' => array( 'file' => 'market-day-20221214111711-img-7128.webp', 'label' => 'Market Day · Belajar wirausaha', 'section' => 'Galeri' ),
		'market_day_20221215085811_img_7341' => array( 'file' => 'market-day-20221215085811-img-7341.webp', 'label' => 'Market Day suasana', 'section' => 'Beranda' ),
		'market_day_20221215085818_img_7342' => array( 'file' => 'market-day-20221215085818-img-7342.webp', 'label' => 'Foto Market Day', 'section' => 'Berita' ),
		'overseas_dsc09466' => array( 'file' => 'overseas-dsc09466.webp', 'label' => 'Outing Class', 'section' => 'Beranda' ),
		'overseas_dsc09507' => array( 'file' => 'overseas-dsc09507.webp', 'label' => 'Overseas Program', 'section' => 'Beranda' ),
		'overseas_img_8635_min' => array( 'file' => 'overseas-img-8635-min.webp', 'label' => 'Achievement Photo', 'section' => 'Beranda' ),
		'overseas_img_8648_min' => array( 'file' => 'overseas-img-8648-min.webp', 'label' => 'Islamic Studies', 'section' => 'Tentang' ),
		'overseas_img_8652_min' => array( 'file' => 'overseas-img-8652-min.webp', 'label' => 'Character Building', 'section' => 'Tentang' ),
		'overseas_img_8661_min' => array( 'file' => 'overseas-img-8661-min.webp', 'label' => 'English Development', 'section' => 'Tentang' ),
		'overseas_img_8679_min' => array( 'file' => 'overseas-img-8679-min.webp', 'label' => 'Event Photo', 'section' => 'Beranda' ),
		'overseas_img_8712_min' => array( 'file' => 'overseas-img-8712-min.webp', 'label' => 'Ilustrasi SD Al Mazaya', 'section' => 'Tentang' ),
		'overseas_img_8730_min' => array( 'file' => 'overseas-img-8730-min.webp', 'label' => 'Overseas Program', 'section' => 'Beranda' ),
		'overseas_img_8756_min' => array( 'file' => 'overseas-img-8756-min.webp', 'label' => 'Graduation Ceremony', 'section' => 'Beranda' ),
		'overseas_img_8809_min' => array( 'file' => 'overseas-img-8809-min.webp', 'label' => 'HUT Kemerdekaan RI', 'section' => 'Beranda' ),
		'overseas_img_8816_min' => array( 'file' => 'overseas-img-8816-min.webp', 'label' => 'Olimpiade Sains', 'section' => 'Beranda' ),
		'quran_academy_r0002997' => array( 'file' => 'quran-academy-r0002997.webp', 'label' => 'Musala · Heart of worship & din', 'section' => 'Sekolah' ),
		'quran_academy_r0003011' => array( 'file' => 'quran-academy-r0003011.webp', 'label' => "Haflah Khatmil Qur'an · Tahfidz graduation", 'section' => 'Beranda' ),
		'ramadhan_charity_day_img_5416_1' => array( 'file' => 'ramadhan-charity-day-img-5416-1.webp', 'label' => 'Ramadhan Charity Day', 'section' => 'Beranda' ),
		'ramadhan_charity_day_img_5423' => array( 'file' => 'ramadhan-charity-day-img-5423.webp', 'label' => 'Ramadhan Charity Day · Berbagi ke sesama', 'section' => 'Galeri' ),
		'school_debate_competition_aq1' => array( 'file' => 'school-debate-competition-aq1.webp', 'label' => 'Debate Photo', 'section' => 'Beranda' ),
		'school_debate_competition_aq2' => array( 'file' => 'school-debate-competition-aq2.webp', 'label' => 'Foto debat UIN Antasari', 'section' => 'Berita' ),
		'school_debate_competition_aq3' => array( 'file' => 'school-debate-competition-aq3.webp', 'label' => 'Bilingual Debate · 2nd Place UIN Antasari', 'section' => 'Galeri' ),
		'senior_high_school_a_capture' => array( 'file' => 'senior-high-school-a-capture.webp', 'label' => 'Graduate Quality Test', 'section' => 'Beranda' ),
		'senior_high_school_p' => array( 'file' => 'senior-high-school-p.webp', 'label' => 'Foto Siswa SMA', 'section' => 'Tentang' ),
	);
}

/**
 * Content image URL (Customizer-overridable, theme asset fallback).
 */
function almazaya_img( $key ) {
	$all = almazaya_content_images();
	if ( ! isset( $all[ $key ] ) ) {
		return get_template_directory_uri() . '/assets/img/';
	}
	return get_theme_mod( 'almazaya_img_' . $key, get_template_directory_uri() . '/assets/img/' . $all[ $key ]['file'] );
}

/* ---------- Dashboard-editable content: texts ----------
 * Site-wide copy (footer, kontak, CTA pendaftaran), ID + EN variants.
 * type "text" = plain (escaped on output), "html" = limited tags allowed,
 * "url" = link. Same extension pattern as images above.
 */
function almazaya_content_texts() {
	return array(
		'footer_tagline' => array( 'label' => 'Footer: tagline', 'type' => 'text', 'section' => 'Footer',
			'id' => 'Mewujudkan generasi Islam unggul dan berakhlak mulia melalui pendidikan Islami, bahasa, dan teknologi.',
			'en' => 'Your Islamic School in Banjarmasin — shaping an excellent, noble Islamic generation.' ),
		'footer_head_links' => array( 'label' => 'Footer: judul Tautan', 'type' => 'text', 'section' => 'Footer',
			'id' => 'Tautan Cepat', 'en' => 'Quick Links' ),
		'footer_head_hours' => array( 'label' => 'Footer: judul Jam layanan', 'type' => 'text', 'section' => 'Footer',
			'id' => 'Jam Layanan', 'en' => 'Office Hours' ),
		'office_hours' => array( 'label' => 'Footer: jam layanan', 'type' => 'html', 'section' => 'Footer',
			'id' => 'Senin – Sabtu<br>07.00 – 16.00 WITA',
			'en' => 'Monday – Saturday<br>07.00 – 16.00 WITA (GMT+8)' ),
		'footer_org' => array( 'label' => 'Footer: nama sekolah (copyright)', 'type' => 'text', 'section' => 'Footer',
			'id' => 'Al Mazaya Islamic School Banjarmasin', 'en' => 'Al Mazaya Islamic School Banjarmasin' ),
		'footer_rights' => array( 'label' => 'Footer: teks hak cipta', 'type' => 'text', 'section' => 'Footer',
			'id' => 'All rights reserved.', 'en' => 'All rights reserved.' ),
		'foundation_name' => array( 'label' => 'Footer: nama yayasan', 'type' => 'text', 'section' => 'Footer',
			'id' => 'Yayasan Al Mazaya Pelita Asia', 'en' => 'Al Mazaya Pelita Asia Foundation' ),
		'mmi_phone' => array( 'label' => 'MMI: nomor telepon', 'type' => 'text', 'section' => 'Kontak',
			'id' => '0811-465-4040', 'en' => '0811-465-4040' ),
		'mmi_ig_handle' => array( 'label' => 'MMI: handle Instagram', 'type' => 'text', 'section' => 'Kontak',
			'id' => '@modernmontessoribanjarmasin', 'en' => '@modernmontessoribanjarmasin' ),
		'cta_mmi_kicker' => array( 'label' => 'CTA MMI: kicker', 'type' => 'text', 'section' => 'CTA Pendaftaran',
			'id' => 'Pendaftaran MMI Preschool', 'en' => 'MMI Preschool Admission' ),
		'cta_mmi_h2' => array( 'label' => 'CTA MMI: judul', 'type' => 'html', 'section' => 'CTA Pendaftaran',
			'id' => 'Mulai dari <span class="tone">Usia Dini</span>',
			'en' => 'Start from <span class="tone">Early Age</span>' ),
		'cta_mmi_p' => array( 'label' => 'CTA MMI: deskripsi', 'type' => 'text', 'section' => 'CTA Pendaftaran',
			'id' => 'Jadwalkan observasi kelas dan konsultasi tumbuh kembang buah hati bersama tim MMI Al Mazaya.',
			'en' => 'Schedule a classroom observation and consultation with the MMI Al Mazaya team.' ),
		'cta_smp_kicker' => array( 'label' => 'CTA SMP: kicker', 'type' => 'text', 'section' => 'CTA Pendaftaran',
			'id' => 'Pendaftaran SMP', 'en' => 'JHS Admission' ),
		'cta_smp_h2' => array( 'label' => 'CTA SMP: judul', 'type' => 'html', 'section' => 'CTA Pendaftaran',
			'id' => 'Fondasi Kuat <span class="tone">Sejak Kelas 7</span>',
			'en' => 'Strong Foundations <span class="tone">from Grade 7</span>' ),
		'cta_smp_p' => array( 'label' => 'CTA SMP: deskripsi', 'type' => 'text', 'section' => 'CTA Pendaftaran',
			'id' => 'Bergabunglah dengan angkatan SMP Al Mazaya — kuota tiap tahun ajaran terbatas.',
			'en' => 'Join the Al Mazaya JHS cohort — seats are limited each academic year.' ),
		'cta_sma_kicker' => array( 'label' => 'CTA SMA: kicker', 'type' => 'text', 'section' => 'CTA Pendaftaran',
			'id' => 'Pendaftaran SMA', 'en' => 'SHS Admission' ),
		'cta_sma_h2' => array( 'label' => 'CTA SMA: judul', 'type' => 'html', 'section' => 'CTA Pendaftaran',
			'id' => 'Raih <span class="tone">PTN Impian</span>',
			'en' => 'Reach Your <span class="tone">Dream University</span>' ),
		'cta_sma_p' => array( 'label' => 'CTA SMA: deskripsi', 'type' => 'text', 'section' => 'CTA Pendaftaran',
			'id' => 'Lulusan kami telah diterima di UI, ULM, ITS, dan ITB — giliran Anda berikutnya.',
			'en' => 'Our graduates are now at UI, ULM, ITS, and ITB — you could be next.' ),
	);
}

/** Dashboard text (ID/EN aware). Pair with esc_html() unless type is html. */
function almazaya_text( $key ) {
	$all = almazaya_content_texts();
	if ( ! isset( $all[ $key ] ) ) {
		return '';
	}
	$def = almazaya_is_en() ? $all[ $key ]['en'] : $all[ $key ]['id'];
	return get_theme_mod( 'almazaya_txt_' . $key . '_' . almazaya_lang_suffix(), $def );
}

/** Dashboard rich text (limited HTML allowed, sanitized on save). Echo raw. */
function almazaya_html( $key ) {
	return almazaya_text( $key );
}

/* ---------- Manageable content: CPT Slide / Mitra / Program ----------
 * Hero slider, partner logos, and program explorer pull from these post
 * types (tambah/hapus/susun via dashboard, featured image = gambar).
 * Templates fall back to the bundled static markup when a type is empty.
 * Bilingual: translate each entry with Polylang; loops follow the locale.
 */

function almazaya_register_cpts() {
	register_post_type(
		'slide',
		array(
			'labels'       => array(
				'name'          => __( 'Slide Hero', 'almazaya' ),
				'singular_name' => __( 'Slide', 'almazaya' ),
				'add_new_item'  => __( 'Tambah Slide', 'almazaya' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'show_in_rest' => false,
			'menu_icon'    => 'dashicons-images-alt2',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		)
	);
	register_post_type(
		'mitra',
		array(
			'labels'       => array(
				'name'          => __( 'Mitra', 'almazaya' ),
				'singular_name' => __( 'Mitra', 'almazaya' ),
				'add_new_item'  => __( 'Tambah Mitra', 'almazaya' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'show_in_rest' => false,
			'menu_icon'    => 'dashicons-networking',
			'supports'     => array( 'title', 'thumbnail', 'excerpt', 'page-attributes' ),
		)
	);
	register_post_type(
		'program',
		array(
			'labels'       => array(
				'name'          => __( 'Program', 'almazaya' ),
				'singular_name' => __( 'Program', 'almazaya' ),
				'add_new_item'  => __( 'Tambah Program', 'almazaya' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'show_in_rest' => false,
			'menu_icon'    => 'dashicons-welcome-learn-more',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		)
	);
	register_post_type(
		'destination',
		array(
			'labels'       => array(
				'name'          => __( 'Destinasi', 'almazaya' ),
				'singular_name' => __( 'Destinasi', 'almazaya' ),
				'add_new_item'  => __( 'Tambah Negara', 'almazaya' ),
			),
			'public'       => true,
			'has_archive'  => false,
			'show_in_rest' => false,
			'menu_icon'    => 'dashicons-location-alt',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		)
	);
}
add_action( 'init', 'almazaya_register_cpts' );

/** Ordered, published posts of a CPT (Polylang filters by locale automatically). */
function almazaya_get_ordered_posts( $type, $number = -1 ) {
	$posts = get_posts(
		array(
			'post_type'      => $type,
			'post_status'    => 'publish',
			'posts_per_page' => $number,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		)
	);
	return is_array( $posts ) ? $posts : array();
}

/** True when the CPT has at least one published post. */
function almazaya_has_posts( $type ) {
	$found = get_posts(
		array(
			'post_type'      => $type,
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	return ! empty( $found );
}

/** Resolve a button URL: "page:slug" becomes the theme page URL. */
function almazaya_btn_url( $url ) {
	if ( strpos( $url, 'page:' ) === 0 ) {
		return almazaya_url( substr( $url, 5 ), almazaya_is_en() ? 'en/' : '' );
	}
	return $url;
}

/* ----- Meta boxes ----- */

function almazaya_add_meta_boxes() {
	add_meta_box( 'almazaya_slide', __( 'Konten Slide', 'almazaya' ), 'almazaya_slide_box', 'slide', 'normal', 'high' );
	add_meta_box( 'almazaya_mitra', __( 'Tautan Mitra', 'almazaya' ), 'almazaya_mitra_box', 'mitra', 'side', 'default' );
	add_meta_box( 'almazaya_program', __( 'Detail Program', 'almazaya' ), 'almazaya_program_box', 'program', 'normal', 'high' );
	add_meta_box( 'almazaya_destination', __( 'Detail Destinasi & Titik Peta', 'almazaya' ), 'almazaya_destination_box', 'destination', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'almazaya_add_meta_boxes' );

function almazaya_slide_box( $post ) {
	wp_nonce_field( 'almazaya_meta', 'almazaya_nonce' );
	$get = function ( $k ) use ( $post ) {
		return esc_attr( get_post_meta( $post->ID, $k, true ) );
	};
	$heading = get_post_meta( $post->ID, '_almazaya_heading', true );
	echo '<p><label><strong>Kicker</strong></label><br><input type="text" name="_almazaya_kicker" value="' . $get( '_almazaya_kicker' ) . '" style="width:100%"></p>';
	echo '<p><label><strong>Judul (boleh HTML &lt;span class="tone"&gt;)</strong></label><br><textarea name="_almazaya_heading" rows="2" style="width:100%">' . esc_textarea( $heading ) . '</textarea></p>';
	echo '<p><label><strong>Tombol 1: teks &amp; URL (URL boleh "page:ppdb")</strong></label><br><input type="text" name="_almazaya_btn1_label" value="' . $get( '_almazaya_btn1_label' ) . '" style="width:48%"> <input type="text" name="_almazaya_btn1_url" value="' . $get( '_almazaya_btn1_url' ) . '" style="width:48%"></p>';
	echo '<p><label><strong>Tombol 2: teks &amp; URL (kosongkan bila tak perlu)</strong></label><br><input type="text" name="_almazaya_btn2_label" value="' . $get( '_almazaya_btn2_label' ) . '" style="width:48%"> <input type="text" name="_almazaya_btn2_url" value="' . $get( '_almazaya_btn2_url' ) . '" style="width:48%"></p>';
	echo '<p><label><strong>Badge: judul &amp; teks (kosongkan bila tak perlu)</strong></label><br><input type="text" name="_almazaya_badge_title" value="' . $get( '_almazaya_badge_title' ) . '" style="width:48%"> <input type="text" name="_almazaya_badge_text" value="' . $get( '_almazaya_badge_text' ) . '" style="width:48%"></p>';
	echo '<p>Deskripsi = isi editor utama. Gambar latar = Featured image. Urutan = Page Attributes → Order.</p>';
}

function almazaya_mitra_box( $post ) {
	wp_nonce_field( 'almazaya_meta', 'almazaya_nonce' );
	$url = esc_attr( get_post_meta( $post->ID, '_almazaya_url', true ) );
	echo '<p><label><strong>URL website mitra</strong></label><br><input type="url" name="_almazaya_url" value="' . $url . '" style="width:100%"></p>';
	echo '<p>Nama = Title. Negara = Excerpt. Logo = Featured image.</p>';
}

function almazaya_program_box( $post ) {
	wp_nonce_field( 'almazaya_meta', 'almazaya_nonce' );
	$heading = get_post_meta( $post->ID, '_almazaya_heading', true );
	$items   = get_post_meta( $post->ID, '_almazaya_items', true );
	echo '<p><label><strong>Judul panel (boleh HTML &lt;span class="tone"&gt;)</strong></label><br><textarea name="_almazaya_heading" rows="2" style="width:100%">' . esc_textarea( $heading ) . '</textarea></p>';
	echo '<p><label><strong>Daftar poin (satu &lt;li&gt; per baris, HTML sederhana)</strong></label><br><textarea name="_almazaya_items" rows="5" style="width:100%">' . esc_textarea( $items ) . '</textarea></p>';
	echo '<p>Label tab &amp; badge = Title. Deskripsi = isi editor. Foto = Featured image. Key data = slug post.</p>';
}

function almazaya_destination_box( $post ) {
	wp_nonce_field( 'almazaya_meta', 'almazaya_nonce' );
	$get = function ( $k ) use ( $post ) {
		return esc_attr( get_post_meta( $post->ID, $k, true ) );
	};
	echo '<p><label><strong>Nama negara (mis. Singapore)</strong></label><br><input type="text" name="_almazaya_country" value="' . $get( '_almazaya_country' ) . '" style="width:100%"></p>';
	echo '<p><label><strong>Emoji bendera (mis. 🇸🇬)</strong></label><br><input type="text" name="_almazaya_flag" value="' . $get( '_almazaya_flag' ) . '" style="width:100%"></p>';
	echo '<p><label><strong>Tag (mis. Montessori Authentic)</strong></label><br><input type="text" name="_almazaya_tag" value="' . $get( '_almazaya_tag' ) . '" style="width:100%"></p>';
	echo '<p><label><strong>URL website sekolah (kosongkan bila tak ada)</strong></label><br><input type="url" name="_almazaya_website" value="' . $get( '_almazaya_website' ) . '" style="width:100%"></p>';
	echo '<p><label><strong>Titik peta: Latitude &amp; Longitude desimal</strong> (mis. Singapore: 1.3521, 103.8198 — lihat di Google Maps, klik kanan → salin koordinat)</label><br><input type="number" step="any" name="_almazaya_lat" value="' . $get( '_almazaya_lat' ) . '" min="-90" max="90" style="width:32%" placeholder="1.3521"> <input type="number" step="any" name="_almazaya_lng" value="' . $get( '_almazaya_lng' ) . '" min="-180" max="180" style="width:32%" placeholder="103.8198"></p>';
	echo '<p>Nama sekolah = Title. Deskripsi = isi editor. Logo/foto = Featured image. Key = slug post (huruf kecil, tanpa spasi).</p>';
}

function almazaya_save_meta( $post_id ) {
	if ( ! isset( $_POST['almazaya_nonce'] ) || ! wp_verify_nonce( $_POST['almazaya_nonce'], 'almazaya_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$text_fields = array( '_almazaya_kicker', '_almazaya_btn1_label', '_almazaya_btn2_label', '_almazaya_badge_title', '_almazaya_badge_text', '_almazaya_country', '_almazaya_flag', '_almazaya_tag' );
	foreach ( $text_fields as $f ) {
		if ( isset( $_POST[ $f ] ) ) {
			update_post_meta( $post_id, $f, sanitize_text_field( $_POST[ $f ] ) );
		}
	}
	$url_fields = array( '_almazaya_btn1_url', '_almazaya_btn2_url', '_almazaya_url', '_almazaya_website' );
	foreach ( $url_fields as $f ) {
		if ( isset( $_POST[ $f ] ) ) {
			update_post_meta( $post_id, $f, esc_url_raw( $_POST[ $f ] ) );
		}
	}
	if ( isset( $_POST['_almazaya_heading'] ) ) {
		update_post_meta( $post_id, '_almazaya_heading', wp_kses_post( $_POST['_almazaya_heading'] ) );
	}
	if ( isset( $_POST['_almazaya_items'] ) ) {
		update_post_meta( $post_id, '_almazaya_items', wp_kses_post( $_POST['_almazaya_items'] ) );
	}
	if ( isset( $_POST['_almazaya_lat'] ) && '' !== $_POST['_almazaya_lat'] ) {
		update_post_meta( $post_id, '_almazaya_lat', min( 90, max( -90, (float) $_POST['_almazaya_lat'] ) ) );
	}
	if ( isset( $_POST['_almazaya_lng'] ) && '' !== $_POST['_almazaya_lng'] ) {
		update_post_meta( $post_id, '_almazaya_lng', min( 180, max( -180, (float) $_POST['_almazaya_lng'] ) ) );
	}
}
add_action( 'save_post', 'almazaya_save_meta' );

/* ----- Berita helpers ----- */

/** Known category slugs in display order, per locale. */
function almazaya_news_cat_slugs() {
	return almazaya_is_en()
		? array( 'achievement', 'event', 'announcement' )
		: array( 'prestasi', 'kegiatan', 'pengumuman' );
}

/** Existing news categories (slug => [name, link]), Semua/All handled by caller. */
function almazaya_news_cats() {
	$out = array();
	foreach ( almazaya_news_cat_slugs() as $slug ) {
		$cat = get_category_by_slug( $slug );
		if ( $cat ) {
			$out[ $slug ] = array( $cat->name, get_category_link( $cat ) );
		}
	}
	return $out;
}

/** Pagination with theme classes. Pass a custom WP_Query or null for main query. */
function almazaya_pagination( $query = null, $current = 1, $add_args = array() ) {
	$q     = $query ? $query : $GLOBALS['wp_query'];
	$pages = (int) $q->max_num_pages;
	if ( $pages < 2 ) {
		return;
	}
	if ( ! $query ) {
		$current = max( 1, (int) get_query_var( 'paged', 1 ) );
	}
	$links = paginate_links(
		array(
			'total'     => $pages,
			'current'   => $current,
			'type'      => 'array',
			'prev_text' => '←',
			'next_text' => '→',
			'add_args'  => $add_args,
		)
	);
	if ( empty( $links ) ) {
		return;
	}
	echo '<nav class="pagination reveal" aria-label="Navigasi halaman">';
	foreach ( $links as $link ) {
		$cls = strpos( $link, 'current' ) !== false ? 'page-btn current' : 'page-btn';
		$link = preg_replace( '/class="[^"]*"/', 'class="' . $cls . '"', $link, 1 );
		if ( strpos( $link, 'class=' ) === false ) {
			$link = str_replace( '<a ', '<a class="' . $cls . '" ', $link );
		}
		echo $link;
	}
	echo '</nav>';
}

/* ---------- Manageable content: CPT Destination (peta overseas) ----------
 * Tiap negara = 1 post: nama sekolah (title), deskripsi (editor),
 * foto/logo (featured image), slug = key data (huruf kecil, tanpa spasi,
 * mis. "turkey"). Titik peta dari koordinat X (0-1000) / Y (0-480)
 * sesuai viewBox peta — klik kanan peta tidak tersedia, isi angka:
 * titik baru bisa dikira-kira dari negara tetangga yang sudah ada.
 */

function almazaya_destination_meta_keys() {
	return array( '_almazaya_country', '_almazaya_flag', '_almazaya_tag', '_almazaya_website', '_almazaya_lat', '_almazaya_lng' );
}

/** Proyeksi lat/lng real ke koordinat SVG peta (viewBox 1000x480).
 * Dikalibrasi least-squares dari 5 titik bawaan (error maks ~21px —
 * tak kasatmata di peta stilasi). Fallback statis memakai koordinat asli. */
function almazaya_latlng_to_svg( $lat, $lng ) {
	$x = 2.4526 * (float) $lng + 533.87;
	$y = -2.9005 * (float) $lat + 274.46;
	return array( round( min( 1000, max( 0, $x ) ), 1 ), round( min( 480, max( 0, $y ) ), 1 ) );
}
