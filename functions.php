<?php
/**
 * Setup utama theme Sekolah Ane.
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'SEKOLAHANE_VERSION' ) ) {
	$sekolahane_theme_ver = wp_get_theme( get_template() )->get( 'Version' );
	define( 'SEKOLAHANE_VERSION', is_string( $sekolahane_theme_ver ) && '' !== $sekolahane_theme_ver ? $sekolahane_theme_ver : '3.2.1' );
}

if ( ! function_exists( 'sekolahane_theme_setup' ) ) :
	/**
	 * Daftarkan fitur theme, ukuran gambar, dan lokasi menu.
	 *
	 * @return void
	 */
	function sekolahane_theme_setup() {
		load_theme_textdomain( 'sekolahane' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'kotak', 400, 400, true );

		register_nav_menus(
			array(
				'menuutama'  => __( 'Menu Utama', 'sekolahane' ),
				'menufooter' => __( 'Menu Footer', 'sekolahane' ),
			)
		);

		add_theme_support(
			'post-formats',
			array(
				'video',
				'gallery',
			)
		);

		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 97,
				'width'       => 400,
				'flex-width'  => false,
				'flex-height' => false,
			)
		);

		add_theme_support( 'yoast-seo-breadcrumbs' );
	}
endif;
add_action( 'after_setup_theme', 'sekolahane_theme_setup' );

/**
 * Set ukuran gambar default WordPress hanya saat theme diaktifkan atau saat upgrade versi.
 *
 * @return void
 */
function sekolahane_configure_image_sizes() {
	update_option( 'medium_size_w', 700 );
	update_option( 'medium_size_h', 394 );
	update_option( 'medium_crop', 1 );
	update_option( 'large_size_w', 1000 );
	update_option( 'large_size_h', 563 );
	update_option( 'large_crop', 1 );
	update_option( 'thumbnail_size_w', 400 );
	update_option( 'thumbnail_size_h', 225 );
	update_option( 'thumbnail_crop', 1 );
	update_option( 'sekolahane_image_sizes_ver', SEKOLAHANE_VERSION );
}
add_action( 'after_switch_theme', 'sekolahane_configure_image_sizes' );

/**
 * Pastikan ukuran & crop gambar tersetel satu kali setelah auto-update versi baru.
 *
 * @return void
 */
function sekolahane_maybe_upgrade_image_sizes() {
	if ( get_option( 'sekolahane_image_sizes_ver' ) !== SEKOLAHANE_VERSION ) {
		sekolahane_configure_image_sizes();
	}
}
add_action( 'admin_init', 'sekolahane_maybe_upgrade_image_sizes' );

/**
 * Daftarkan area widget sidebar.
 *
 * @return void
 */
function sekolahane_widgets() {
	register_sidebar(
		array(
			'name'          => __( 'Default Sidebar', 'sekolahane' ),
			'id'            => 'default-sidebar',
			'before_widget' => '<div class="ane-sidebar">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title ane-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'sekolahane_widgets' );

/**
 * Hapus query string versi WordPress bawaan dari URL script/style.
 *
 * @param string $src URL aset.
 * @return string
 */
function sekolahane_remove_wp_version_strings( $src ) {
	global $wp_version;

	if ( ! is_string( $src ) || '' === $src ) {
		return $src;
	}

	$query_string = wp_parse_url( $src, PHP_URL_QUERY );
	if ( ! is_string( $query_string ) || '' === $query_string ) {
		return $src;
	}

	$query = array();
	parse_str( $query_string, $query );

	if ( ! empty( $query['ver'] ) && $query['ver'] === $wp_version ) {
		$src = remove_query_arg( 'ver', $src );
	}

	return $src;
}
add_filter( 'script_loader_src', 'sekolahane_remove_wp_version_strings' );
add_filter( 'style_loader_src', 'sekolahane_remove_wp_version_strings' );

/**
 * Kosongkan meta tag generator WordPress.
 *
 * @return string
 */
function sekolahane_remove_meta_version() {
	return '';
}
add_filter( 'the_generator', 'sekolahane_remove_meta_version' );

require get_template_directory() . '/inc/sekolahane.php';
require get_template_directory() . '/inc/seo.php';
require get_template_directory() . '/inc/custompost.php';
require get_template_directory() . '/inc/widgets.php';
require get_template_directory() . '/inc/updater.php';
require get_template_directory() . '/inc/webp-converter.php';
require get_template_directory() . '/inc/acf-importer.php';
