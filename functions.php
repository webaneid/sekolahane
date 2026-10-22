<?php
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

if ( ! function_exists( 'sekolahane_theme_setup' ) ) :

	function sekolahane_theme_setup() {

		load_theme_textdomain( 'sekolahane' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'kotak', 400, 400,true );
		update_option('medium_size_w', 700);
		update_option('medium_size_h', 394);
		update_option('medium_crop', 1);
		update_option('large_size_w', 1000);
		update_option('large_size_h', 563);
		update_option('large_crop', 1);
		update_option('thumbnail_size_w', 400);
		update_option('thumbnail_size_h', 225);
		update_option('thumbnail_crop', 1);

		register_nav_menus( array(
			'menuutama' => __( 'Menu Utama',  'sekolahane' ),
			'menufooter'  => __( 'Menu Footer', 'sekolahane' ),
		) );
		add_theme_support( 'post-formats', array(
			'video','gallery'
		) );
		add_theme_support( 'html5', array( 'gallery', 'caption' ) );
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

// add_filter('acf/settings/show_admin', '__return_false');
// widget
function sekolahane_widgets() {

    register_sidebar( array(
        'name'          => 'Default Sidebar',
        'id'            => 'default-sidebar',
        'before_widget' => '<div class="ane-sidebar">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title ane-title">',
        'after_title'   => '</h2>',
    ) );
}

// cleanup
add_action( 'widgets_init', 'sekolahane_widgets' );
function sekolahane_remove_wp_version_strings( $src ) {
	global $wp_version;
	parse_str( parse_url($src, PHP_URL_QUERY), $query );
	if ( !empty( $query['ver'] ) && $query['ver'] === $wp_version ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'script_loader_src', 'sekolahane_remove_wp_version_strings' );
add_filter( 'style_loader_src', 'sekolahane_remove_wp_version_strings' );

function sekolahane_remove_meta_version() {
	return '';
}
add_filter( 'the_generator', 'sekolahane_remove_meta_version' );


require get_template_directory().'/inc/sekolahane.php';
require get_template_directory().'/inc/custompost.php';
require get_template_directory().'/inc/widgets.php';
require get_template_directory().'/inc/Mobile_Detect.php';
