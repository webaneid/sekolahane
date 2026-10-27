<?php
/**
 * Fungsi utama theme Sekolah Ane (enqueue, helper tampilan, breadcrumbs, views, ACF options).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals

/**
 * Ambil Google Maps API Key dari konstanta wp-config.php atau ACF option.
 *
 * @return string API key atau string kosong jika belum dikonfigurasi.
 */
function sekolahane_get_google_maps_api_key() {
	if ( defined( 'SEKOLAHANE_GMAPS_API_KEY' ) && is_string( SEKOLAHANE_GMAPS_API_KEY ) ) {
		$key = trim( SEKOLAHANE_GMAPS_API_KEY );
		if ( '' !== $key ) {
			return $key;
		}
	}

	if ( function_exists( 'get_field' ) ) {
		$acf_key = get_field( 'ane_google_maps_api_key', 'option' );
		if ( is_string( $acf_key ) && '' !== trim( $acf_key ) ) {
			return trim( $acf_key );
		}
	}

	return '';
}

/**
 * Ambil Facebook App ID dari konstanta wp-config.php atau ACF option.
 *
 * @return string Facebook App ID atau string kosong.
 */
function sekolahane_get_fb_app_id() {
	if ( defined( 'SEKOLAHANE_FB_APP_ID' ) && is_string( SEKOLAHANE_FB_APP_ID ) ) {
		$app_id = trim( SEKOLAHANE_FB_APP_ID );
		if ( '' !== $app_id ) {
			return $app_id;
		}
	}

	if ( function_exists( 'get_field' ) ) {
		$acf_app_id = get_field( 'ane_fb_app_id', 'option' );
		if ( is_string( $acf_app_id ) && '' !== trim( $acf_app_id ) ) {
			return trim( $acf_app_id );
		}
	}

	return '';
}

/**
 * Render inline SVG icon pengganti FontAne & FontAwesome.
 *
 * Dibungkus tag <i> agar seluruh selector CSS existing (.ane-footer ul li i,
 * .ane-sosmed ul li a i, .lainnya i, dll) tetap bekerja identik. Mendukung
 * pemetaan otomatis kode icon lama berformat `fa-*` agar kompatibel dengan
 * data database situs pelanggan.
 *
 * @param string $name Nama icon (mis. 'home', 'profile', 'news', 'ppdb', 'contact', atau kode legacy 'fa-*').
 * @return string Markup HTML inline SVG yang aman.
 */
function sekolahane_icon( $name ) {
	$raw_name = strtolower( trim( (string) $name ) );
	$raw_name = (string) preg_replace( '/^fa[srlbd]?\s+/', '', $raw_name );
	if ( 0 === strpos( $raw_name, 'fa-' ) ) {
		$raw_name = substr( $raw_name, 3 );
	}

	$aliases = array(
		'clock-o'        => 'clock',
		'calendar-o'     => 'calendar',
		'Agenda'         => 'calendar',
		'agenda'         => 'calendar',
		'building'       => 'profile',
		'building-o'     => 'profile',
		'university'     => 'profile',
		'bank'           => 'profile',
		'institution'    => 'profile',
		'school'         => 'profile',
		'user-circle'    => 'profile',
		'newspaper-o'    => 'news',
		'newspaper'      => 'news',
		'file-text-o'    => 'news',
		'file-text'      => 'news',
		'bullhorn'       => 'news',
		'rss'            => 'news',
		'graduation-cap' => 'ppdb',
		'mortar-board'   => 'ppdb',
		'user-plus'      => 'ppdb',
		'id-card'        => 'ppdb',
		'id-card-o'      => 'ppdb',
		'pencil-square'  => 'ppdb',
		'edit'           => 'ppdb',
		'phone'          => 'contact',
		'phone-square'   => 'contact',
		'comments'       => 'contact',
		'comments-o'     => 'contact',
		'commenting'     => 'contact',
		'commenting-o'   => 'contact',
		'envelope'       => 'email',
		'envelope-o'     => 'email',
		'address-book'   => 'contact',
		'address-book-o' => 'contact',
		'headphones'     => 'contact',
		'book'           => 'buku',
		'map-marker'     => 'lokasi',
		'mobile'         => 'handphone',
		'desktop'        => 'laptop',
		'users'          => 'users',
		'group'          => 'users',
		'user'           => 'users',
		'male'           => 'users',
		'female'         => 'users',
		'child'          => 'users',
		'trophy'         => 'prestasi',
		'award'          => 'prestasi',
		'certificate'    => 'prestasi',
		'star-o'         => 'star',
		'futbol-o'       => 'ekstra',
		'basketball'     => 'ekstra',
		'music'          => 'ekstra',
		'paint-brush'    => 'ekstra',
		'picture-o'      => 'galeri',
		'image'          => 'galeri',
		'camera'         => 'galeri',
		'video-camera'   => 'galeri',
	);

	if ( isset( $aliases[ $raw_name ] ) ) {
		$raw_name = $aliases[ $raw_name ];
	}

	$paths = array(
		'home'                => '<path d="M12 3.1 3.5 10a1 1 0 0 0-.37.78v9.22A1.5 1.5 0 0 0 4.63 21.5h4.62v-6.25a1.25 1.25 0 0 1 1.25-1.25h3a1.25 1.25 0 0 1 1.25 1.25v6.25h4.62a1.5 1.5 0 0 0 1.5-1.5v-9.22a1 1 0 0 0-.37-.78L12 3.1z"/>',
		'profile'             => '<path d="M12 2 2 7v2h20V7L12 2zm-7 9v7H3v2h18v-2h-2v-7h-2v7h-4v-7h-2v7H7v-7H5z"/>',
		'news'                => '<path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>',
		'ppdb'                => '<path d="M12 3 1 9l11 6 9-4.91V17h2V9L12 3zm-7 10.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>',
		'contact'             => '<path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-7 11H7v-2h6v2zm4-4H7V7h10v2z"/>',
		'users'               => '<path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>',
		'prestasi'            => '<path d="M19 5h-2V3H7v2H5a2 2 0 0 0-2 2v1c0 2.55 1.92 4.63 4.39 4.94A5.01 5.01 0 0 0 11 15.9V19H7v2h10v-2h-4v-3.1a5.01 5.01 0 0 0 3.61-2.96C19.08 12.63 21 10.55 21 8V7a2 2 0 0 0-2-2zM5 8V7h2v3.82C5.84 10.4 5 9.3 5 8zm14 0c0 1.3-.84 2.4-2 2.82V7h2v1z"/>',
		'ekstra'              => '<path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm1 14.93V14h-2v2.93A8.006 8.006 0 0 1 4.07 11H7V9H4.07A8.006 8.006 0 0 1 11 4.07V7h2V4.07A8.006 8.006 0 0 1 19.93 9H17v2h2.93A8.006 8.006 0 0 1 13 16.93z"/>',
		'galeri'              => '<path d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>',
		'star'                => '<path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>',
		'clock'               => '<path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/>',
		'eye'                 => '<path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>',
		'linkedin'            => '<path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14zm-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68zm1.39 9.94v-8.37H5.5v8.37h2.77z"/>',
		'link'                => '<path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/>',
		'check'               => '<path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>',
		'buku'                => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V2H6.5A2.5 2.5 0 0 0 4 4.5v15zm2.5-.5a.5.5 0 0 0 0 1H19v-1H6.5zM8 6h8v2H8V6zm0 4h8v2H8v-2z"/>',
		'search'              => '<path d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 1 0-.7.7l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9z"/>',
		'lokasi'              => '<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/>',
		'telepon'             => '<path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.61 21 3 13.39 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.46.57 3.58a1 1 0 0 1-.25 1.01l-2.2 2.2z"/>',
		'handphone'           => '<path d="M15.5 1h-8A2.5 2.5 0 0 0 5 3.5v17A2.5 2.5 0 0 0 7.5 23h8a2.5 2.5 0 0 0 2.5-2.5v-17A2.5 2.5 0 0 0 15.5 1zm-4 21c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm4.5-4H7V4h9v14z"/>',
		'email'               => '<path d="M20 4H4a2 2 0 0 0-1.99 2L2 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>',
		'laptop'              => '<path d="M20 18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z"/>',
		'whatsapp'            => '<path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91C21.95 6.45 17.5 2 12.04 2zm5.82 14.01c-.24.68-1.41 1.3-1.95 1.38-.5.08-1.13.11-1.83-.11-.42-.13-.96-.31-1.65-.61-2.91-1.26-4.81-4.19-4.96-4.38-.14-.19-1.18-1.57-1.18-3s.75-2.13 1.01-2.42c.27-.29.58-.36.78-.36.19 0 .39 0 .56.01.18.01.42-.07.66.5.24.58.82 2.01.89 2.15.07.15.12.31.02.5-.1.19-.15.31-.29.48-.15.17-.31.38-.44.51-.15.15-.3.31-.13.6.17.29.76 1.25 1.63 2.02 1.12.99 2.06 1.3 2.35 1.45.29.15.46.12.63-.07.17-.19.73-.85.92-1.14.19-.29.39-.24.65-.15.27.1 1.7.8 1.99.95.29.15.48.22.56.34.07.12.07.7-.17 1.38z"/>',
		'facebook'            => '<path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z"/>',
		'twitter'             => '<path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>',
		'youtube'             => '<path d="M21.58 7.19a2.51 2.51 0 0 0-1.77-1.77C18.25 5 12 5 12 5s-6.25 0-7.81.42a2.51 2.51 0 0 0-1.77 1.77C2 8.75 2 12 2 12s0 3.25.42 4.81a2.51 2.51 0 0 0 1.77 1.77C5.75 19 12 19 12 19s6.25 0 7.81-.42a2.51 2.51 0 0 0 1.77-1.77C22 15.25 22 12 22 12s0-3.25-.42-4.81zM10 15V9l5.2 3-5.2 3z"/>',
		'instagram'           => '<path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2zm-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6zm9.65 1.5a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>',
		'chevron-right-alt-2' => '<path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm-1.29 14.29L9.3 14.88 12.17 12 9.3 9.12l1.41-1.41L15 12l-4.29 4.29z"/>',
		'chevron-left'        => '<path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>',
		'chevron-right'       => '<path d="M8.59 16.59 10 18l6-6-6-6-1.41 1.41L13.17 12z"/>',
		'calendar'            => '<path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 0 0 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/>',
	);

	if ( ! isset( $paths[ $raw_name ] ) ) {
		if ( '' !== $raw_name ) {
			$raw_name = 'star';
		} else {
			return '';
		}
	}

	return '<i class="ane-icon" aria-hidden="true"><svg class="ane-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" focusable="false">' . $paths[ $raw_name ] . '</svg></i>';
}

/**
 * Izinkan elemen <svg> dan <path> pada konteks 'post' di wp_kses_post()
 * agar output inline SVG dari sekolahane_icon() tidak terhapus saat escaping.
 *
 * @param array<string, mixed> $tags    Daftar tag HTML yang diizinkan.
 * @param string               $context Konteks kses.
 * @return array<string, mixed>
 */
function sekolahane_allow_svg_in_kses( $tags, $context ) {
	if ( 'post' === $context ) {
		$tags['svg']  = array(
			'class'       => true,
			'xmlns'       => true,
			'viewbox'     => true,
			'fill'        => true,
			'focusable'   => true,
			'aria-hidden' => true,
			'width'       => true,
			'height'      => true,
		);
		$tags['path'] = array(
			'd'    => true,
			'fill' => true,
		);
	}
	return $tags;
}
add_filter( 'wp_kses_allowed_html', 'sekolahane_allow_svg_in_kses', 10, 2 );

/**
 * Enqueue stylesheet dan script front-end theme.
 *
 * @return void
 */
function ane_load_css_and_js() {
	$ver     = defined( 'SEKOLAHANE_VERSION' ) ? SEKOLAHANE_VERSION : '3.2.1';
	$css_f   = get_template_directory() . '/css/main.min.css';
	$js_f    = get_template_directory() . '/js/sekolahane.js';
	$css_ver = file_exists( $css_f ) ? (string) filemtime( $css_f ) : $ver;
	$js_ver  = file_exists( $js_f ) ? (string) filemtime( $js_f ) : $ver;

	wp_enqueue_style( 'Google-Fonts', 'https://fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700,800,900&display=swap', array(), null );
	wp_enqueue_style( 'OwlCarouse', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css', array(), '2.2.1' );

	if ( is_singular() ) {
		wp_enqueue_style( 'magnific-popup', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css', array(), '1.1.0' );
		wp_enqueue_script( 'magnific', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	}

	wp_enqueue_style( 'sekolahane-css', get_template_directory_uri() . '/css/main.min.css', array(), $css_ver );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'OwlCarousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js', array( 'jquery' ), '2.2.1', true );

	if ( is_page_template( 'page-kontak.php' ) ) {
		$gmaps_key = sekolahane_get_google_maps_api_key();
		if ( '' !== $gmaps_key ) {
			wp_enqueue_script(
				'googlemap',
				'https://maps.googleapis.com/maps/api/js?key=' . rawurlencode( $gmaps_key ),
				array( 'jquery' ),
				null,
				true
			);
		}
	}

	wp_enqueue_script( 'sekolahane-js', get_template_directory_uri() . '/js/sekolahane.js', array( 'jquery' ), $js_ver, true );
}
add_action( 'wp_enqueue_scripts', 'ane_load_css_and_js' );

/**
 * Konfigurasi Google Maps API key untuk field Google Map ACF.
 *
 * @return void
 */
function ane_google_map_init() {
	$gmaps_key = sekolahane_get_google_maps_api_key();
	if ( '' !== $gmaps_key && function_exists( 'acf_update_setting' ) ) {
		acf_update_setting( 'google_api_key', $gmaps_key );
	}
}
add_action( 'acf/init', 'ane_google_map_init' );

/**
 * Batasi panjang kata excerpt.
 *
 * @param int $length Panjang default.
 * @return int
 */
function new_excerpt_length( $length ) {
	return 15;
}
add_filter( 'excerpt_length', 'new_excerpt_length', 15 );

/**
 * Bersihkan bracket trailing pada excerpt.
 *
 * @param string $text Teks excerpt.
 * @return string
 */
function change_excerpt( $text ) {
	$pos = strrpos( $text, '[' );
	if ( false === $pos ) {
		return $text;
	}

	return rtrim( substr( $text, 0, $pos ) );
}
add_filter( 'get_the_excerpt', 'change_excerpt' );

/**
 * Tambahkan class `gallery-popup` pada tautan gambar di dalam konten post.
 *
 * @param string $content Isi post.
 * @return string
 */
function webane_popup_gallery( $content ) {
	global $post;
	$post_title  = ( is_object( $post ) && isset( $post->post_title ) ) ? esc_attr( $post->post_title ) : '';
	$pattern     = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
	$replacement = '<a$1href=$2$3.$4$5 class="gallery-popup" title="' . $post_title . '"$6>';
	$replaced    = preg_replace( $pattern, $replacement, $content );

	return is_string( $replaced ) ? $replaced : $content;
}
add_filter( 'the_content', 'webane_popup_gallery' );

/**
 * Render shortcode caption gambar.
 *
 * @param array<string, mixed> $attr    Atribut shortcode.
 * @param string|null          $content Konten di dalam shortcode.
 * @return string
 */
function sekolahane_caption( $attr, $content = null ) {
	$output = apply_filters( 'img_caption_shortcode', '', $attr, $content );
	if ( '' !== $output ) {
		return $output;
	}

	$atts = shortcode_atts(
		array(
			'id'      => '',
			'align'   => 'alignnone',
			'width'   => '',
			'caption' => '',
		),
		$attr
	);

	$width   = (int) $atts['width'];
	$caption = (string) $atts['caption'];
	if ( 1 > $width || '' === $caption ) {
		return (string) $content;
	}

	$id_attr = '' !== (string) $atts['id'] ? 'id="' . esc_attr( (string) $atts['id'] ) . '" ' : '';
	$align   = esc_attr( (string) $atts['align'] );

	return '<figure ' . $id_attr . 'class="wp-caption ' . $align . '" style="width: ' . $width . 'px">'
		. do_shortcode( (string) $content )
		. '<figcaption class="wp-caption-text">' . wp_kses_post( $caption ) . '</figcaption></figure>';
}
add_shortcode( 'wp_caption', 'sekolahane_caption' );
add_shortcode( 'caption', 'sekolahane_caption' );

/**
 * URL fallback dummy thumbnail.
 *
 * @return string
 */
function sekolahane_dummy_tumbnail() {
	return (string) get_theme_mod( 'dummythumb', get_template_directory_uri() . '/img/dummy-thumbnail.jpg' );
}

/**
 * Ambil embed media pertama dari konten post.
 *
 * @param array<int, string> $type Jenis media yang dicari.
 * @return string
 */
function ane_get_embedded_media( $type = array() ) {
	$content = do_shortcode( apply_filters( 'the_content', get_the_content() ) );
	$embed   = get_media_embedded_in_content( $content, $type );

	if ( empty( $embed ) || ! isset( $embed[0] ) ) {
		return '';
	}

	if ( in_array( 'audio', $type, true ) ) {
		return str_replace( '?visual=true', '?visual=false', $embed[0] );
	}

	return (string) $embed[0];
}

/**
 * Bangun URL thumbnail YouTube dari URL/iframe video.
 *
 * @param string $url  URL atau kode iframe YouTube.
 * @param string $size Prefix ukuran thumbnail (mis. mq, hq, maxres).
 * @return string
 */
function ane_get_youtube_thumbnail( $url, $size = '' ) {
	$thumb_base_uri = 'https://img.youtube.com/vi/';
	$id             = '';
	$size_file      = '' !== $size ? $size . 'default.jpg' : 'default.jpg';
	$url            = (string) $url;

	if ( preg_match( '/iframe/', $url ) ) {
		$id = (string) preg_replace( '/[\s\S]*\/embed\/|"[\s\S]*|\?[\s\S]*/', '', $url );
	} elseif ( preg_match( '/youtu\.be/', $url ) || preg_match( '/embed/', $url ) ) {
		$id = (string) preg_replace( '/^((?![^\/]+$).)*\//', '', $url );
	} else {
		$id = (string) preg_replace( '/^((?![^\?v]+$).)*=|&[^\&]*/', '', $url );
	}

	return $thumb_base_uri . $id . '/' . $size_file;
}

/**
 * URL gambar placeholder persegi (kotak).
 *
 * @return string
 */
function ane_dummy_kotak() {
	return (string) get_theme_mod( 'dummythumb', get_template_directory_uri() . '/img/no-image-kotak.jpg' );
}

/**
 * Tampilkan atau kembalikan HTML navigasi paginasi arsip.
 *
 * @param \WP_Query|null $wp_query Objek query kustom (opsional).
 * @param bool           $echo     True untuk langsung echo.
 * @return string|null
 */
function ane_post_pagination( ?\WP_Query $wp_query = null, $echo = true ) {
	if ( null === $wp_query ) {
		global $wp_query;
	}

	if ( ! $wp_query instanceof \WP_Query ) {
		return null;
	}

	$pages = paginate_links(
		array(
			'base'         => str_replace( '999999999', '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'format'       => '?paged=%#%',
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'total'        => (int) $wp_query->max_num_pages,
			'type'         => 'array',
			'show_all'     => false,
			'end_size'     => 3,
			'mid_size'     => 1,
			'prev_next'    => true,
			'prev_text'    => sekolahane_icon( 'chevron-left' ),
			'next_text'    => sekolahane_icon( 'chevron-right' ),
			'add_args'     => false,
			'add_fragment' => '',
		)
	);

	if ( is_array( $pages ) ) {
		$pagination = '<div class="ane-paginasi"><ul>';
		foreach ( $pages as $page ) {
			$pagination .= '<li>' . $page . '</li>';
		}
		$pagination .= '</ul></div>';

		if ( $echo ) {
			echo wp_kses_post( $pagination );
		} else {
			return $pagination;
		}
	}

	return null;
}

/**
 * Tampilkan daftar post terkait berdasarkan tag pertama.
 *
 * @return void
 */
function ane_related_post() {
	global $post;
	if ( ! is_object( $post ) || empty( $post->ID ) ) {
		return;
	}

	$tags = wp_get_post_tags( $post->ID );
	if ( ! empty( $tags ) && isset( $tags[0]->term_id ) ) {
		$all_tags = $tags[0]->term_id;
		$args     = array(
			'tag__in'             => array( $all_tags ),
			'post__not_in'        => array( $post->ID ),
			'posts_per_page'      => 5,
			'ignore_sticky_posts' => 1,
			'orderby'             => 'rand',
		);

		$related_query = new WP_Query( $args );
		if ( $related_query->have_posts() ) {
			?>
			<span><?php esc_html_e( 'Post Terkait', 'sekolahane' ); ?></span>
			<div class="isi-konten-terkait">
				<?php
				while ( $related_query->have_posts() ) :
					$related_query->the_post();
					get_template_part( 'tp/content', 'list' );
				endwhile;
				?>
			</div>
			<?php
		}
		wp_reset_postdata();
	}
}

/**
 * Tampilkan 5 post terbaru.
 *
 * @return void
 */
function ane_newest_posts() {
	$args = array(
		'posts_per_page'      => 5,
		'ignore_sticky_posts' => 1,
	);

	$newest_query = new WP_Query( $args );
	if ( $newest_query->have_posts() ) {
		?>
		<span><?php esc_html_e( 'Konten Terbaru', 'sekolahane' ); ?></span>
		<div class="isi-konten">
			<?php
			while ( $newest_query->have_posts() ) :
				$newest_query->the_post();
				get_template_part( 'tp/content', 'list' );
			endwhile;
			?>
		</div>
		<?php
	}
	wp_reset_postdata();
}

/**
 * Kembalikan HTML navigasi post sebelumnya dan berikutnya.
 *
 * @return string
 */
function ane_prev_next_post() {
	$prev_post = get_previous_post( true );
	$prev_img  = ane_dummy_kotak();
	if ( $prev_post instanceof WP_Post && has_post_thumbnail( $prev_post ) ) {
		$prev_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post ), 'kotak' );
		if ( is_array( $prev_thumb ) && ! empty( $prev_thumb[0] ) ) {
			$prev_img = $prev_thumb[0];
		}
	}

	$next_post = get_next_post( true );
	$next_img  = ane_dummy_kotak();
	if ( $next_post instanceof WP_Post && has_post_thumbnail( $next_post ) ) {
		$next_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post ), 'kotak' );
		if ( is_array( $next_thumb ) && ! empty( $next_thumb[0] ) ) {
			$next_img = $next_thumb[0];
		}
	}

	$content  = '<div class="row">';
	$content .= '<div class="col-md-6">';
	if ( $prev_post instanceof WP_Post ) {
		$prev_url   = esc_url( get_permalink( $prev_post->ID ) );
		$prev_title = esc_html( get_the_title( $prev_post ) );
		$prev_alt   = esc_attr( get_the_title( $prev_post ) );

		$content .= '
				<div class="nav-header-prev">
					<span>' . sekolahane_icon( 'chevron-left' ) . ' Prev Post</span>
				</div>
				<article class="ane-konten-nav">
					<div class="entry-header">
						<a href="' . $prev_url . '">
							<div class="ane-image">
								<img src="' . esc_url( $prev_img ) . '" alt="' . $prev_alt . '" title="' . $prev_alt . '">
							</div>
						</a>
					</div>
					<div class="entry-content">
						<a href="' . $prev_url . '">' . $prev_title . '</a>
					</div>
				</article>';
	}
	$content .= '</div>';
	$content .= '<div class="col-md-6">';
	if ( $next_post instanceof WP_Post ) {
		$next_url   = esc_url( get_permalink( $next_post->ID ) );
		$next_title = esc_html( get_the_title( $next_post ) );
		$next_alt   = esc_attr( get_the_title( $next_post ) );

		$content .= '
				<div class="nav-header-prev text-right">
					<span>Next Post ' . sekolahane_icon( 'chevron-right' ) . '</span>
				</div>
				<article class="ane-konten-nav nav-next">
					<div class="entry-header">
						<a href="' . $next_url . '">
							<div class="ane-image">
								<img src="' . esc_url( $next_img ) . '" alt="' . $next_alt . '" title="' . $next_alt . '">
							</div>
						</a>
					</div>
					<div class="entry-content">
						<a href="' . $next_url . '">' . $next_title . '</a>
					</div>
				</article>';
	}
	$content .= '</div>';
	$content .= '</div>';

	return $content;
}

/**
 * Format selisih waktu relatif ("... yang lalu").
 *
 * @param int|string $seconds Timestamp post.
 * @param int|bool   $time    Timestamp pembanding.
 * @return string
 */
function times_ago( $seconds = 1, $time = false ) {
	if ( ! is_numeric( $seconds ) ) {
		$seconds = 1;
	}
	$now = (int) current_time( 'timestamp', 0 );
	if ( $now <= (int) $seconds ) {
		$diff = 1;
	} else {
		$diff = $now - (int) $seconds;
	}

	$years   = (int) floor( $diff / 31536000 );
	$months  = (int) floor( $diff / 2628000 );
	$weeks   = (int) floor( $diff / 604800 );
	$days    = (int) floor( $diff / 86400 );
	$hours   = (int) floor( $diff / 3600 );
	$minutes = (int) floor( $diff / 60 );

	if ( $years > 5 ) {
		$str  = date_i18n( (string) get_option( 'date_format' ), (int) strtotime( (string) get_the_time( 'Y-m-d' ) ) );
		$str .= ' ' . esc_html( (string) get_the_time() );
	} elseif ( $years > 0 ) {
		/* translators: %s: jumlah tahun */
		$str = sprintf( _n( '%s tahun lalu', '%s tahun lalu', $years, 'sekolahane' ), $years );
	} elseif ( $months > 0 ) {
		/* translators: %s: jumlah bulan */
		$str = sprintf( _n( '%s bulan lalu', '%s bulan lalu', $months, 'sekolahane' ), $months );
	} elseif ( $weeks > 0 ) {
		/* translators: %s: jumlah minggu */
		$str = sprintf( _n( '%s minggu lalu', '%s minggu lalu', $weeks, 'sekolahane' ), $weeks );
	} elseif ( $days > 0 ) {
		/* translators: %s: jumlah hari */
		$str = sprintf( _n( '%s hari lalu', '%s hari lalu', $days, 'sekolahane' ), $days );
	} elseif ( $hours > 0 ) {
		/* translators: %s: jumlah jam */
		$str = sprintf( _n( '%s jam lalu', '%s jam lalu', $hours, 'sekolahane' ), $hours );
	} elseif ( $minutes > 0 ) {
		/* translators: %s: jumlah menit */
		$str = sprintf( _n( '%s menit lalu', '%s menit lalu', $minutes, 'sekolahane' ), $minutes );
	} else {
		/* translators: %s: jumlah detik */
		$str = sprintf( _n( '%s detik lalu', '%s detik lalu', $diff, 'sekolahane' ), $diff );
	}

	return trim( $str );
}

/**
 * Kembalikan elemen HTML waktu relatif post.
 *
 * @return string
 */
function ane_load_times_ago() {
	$timestamp = (int) get_the_time( 'U' );

	return '
	<div class="meta-time">
		' . sekolahane_icon( 'clock' ) . '
		' . esc_html( times_ago( $timestamp ) ) . '
	</div>
	';
}

/**
 * Kembalikan tombol berbagi media sosial modern + tombol salin tautan (Copy URL).
 *
 * Menggunakan direct share URL tanpa iframe/SDK berat pihak ketiga agar ringan
 * di desktop maupun mobile.
 *
 * @return string
 */
function fungsi_share_webane() {
	global $post;
	$post_id    = ( is_object( $post ) && isset( $post->ID ) ) ? $post->ID : get_the_ID();
	$raw_title  = wp_strip_all_tags( get_the_title( $post_id ) );
	$title      = rawurlencode( $raw_title );
	$permalink  = (string) get_permalink( $post_id );
	$enc_url    = rawurlencode( $permalink );
	$share_text = rawurlencode( $raw_title . ' - ' . $permalink );

	$twitter_handler = get_option( 'twitter_handler' );
	$via             = ! empty( $twitter_handler ) ? '&via=' . rawurlencode( (string) $twitter_handler ) : '';

	$whatsapp = 'https://api.whatsapp.com/send?text=' . $share_text;
	$facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . $enc_url;
	$twitter  = 'https://twitter.com/intent/tweet?text=' . $title . '&url=' . $enc_url . $via;
	$linkedin = 'https://www.linkedin.com/sharing/share-offsite/?url=' . $enc_url;

	$label_share  = esc_html__( 'Bagikan:', 'sekolahane' );
	$label_copy   = esc_html__( 'Salin Link', 'sekolahane' );
	$label_copied = esc_attr__( 'Tersalin!', 'sekolahane' );

	$content  = '<div class="social-share-buttons">';
	$content .= '<span class="share-label">' . $label_share . '</span>';
	$content .= '<ul>';
	$content .= '<li><a class="share-btn whatsapp" href="' . esc_url( $whatsapp ) . '" target="_blank" rel="nofollow noopener noreferrer" aria-label="WhatsApp">' . sekolahane_icon( 'whatsapp' ) . '<span>WhatsApp</span></a></li>';
	$content .= '<li><a class="share-btn facebook" href="' . esc_url( $facebook ) . '" target="_blank" rel="nofollow noopener noreferrer" aria-label="Facebook">' . sekolahane_icon( 'facebook' ) . '<span>Facebook</span></a></li>';
	$content .= '<li><a class="share-btn twitter" href="' . esc_url( $twitter ) . '" target="_blank" rel="nofollow noopener noreferrer" aria-label="X / Twitter">' . sekolahane_icon( 'twitter' ) . '<span>Twitter</span></a></li>';
	$content .= '<li><a class="share-btn linkedin" href="' . esc_url( $linkedin ) . '" target="_blank" rel="nofollow noopener noreferrer" aria-label="LinkedIn">' . sekolahane_icon( 'linkedin' ) . '<span>LinkedIn</span></a></li>';
	$content .= '<li><button type="button" class="share-btn share-copy" data-url="' . esc_url( $permalink ) . '" data-copied-text="' . $label_copied . '" aria-label="' . esc_attr( $label_copy ) . '"><span class="copy-icon-default">' . sekolahane_icon( 'link' ) . '</span><span class="copy-icon-done">' . sekolahane_icon( 'check' ) . '</span><span class="copy-label">' . $label_copy . '</span></button></li>';
	$content .= '</ul></div>';

	return $content;
}

/**
 * Kembalikan blok komentar Facebook untuk halaman single.
 *
 * @return string
 */
function fungsi_komen_facebook_webane() {
	$fb_app_id = sekolahane_get_fb_app_id();
	$appid_qs  = '' !== $fb_app_id ? '&appId=' . rawurlencode( $fb_app_id ) : '';
	$sdk_url   = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v5.0' . $appid_qs . '&autoLogAppEvents=1';

	$content = '<div id="fb-root"></div>';
	// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
	$content .= '<script async defer crossorigin="anonymous" src="' . esc_url( $sdk_url ) . '"></script>';
	$content .= '<div class="fb-comments" data-href="' . esc_url( (string) get_permalink() ) . '" data-numposts="10" data-width="100%"></div>';

	return $content;
}

/**
 * Tambahkan kotak profil penulis di akhir artikel single.
 *
 * @param string $content Konten post.
 * @return string
 */
function sekolahane_author_info_box( $content ) {
	global $post;

	if ( is_single() && is_object( $post ) && isset( $post->post_author ) ) {
		$author_id    = (int) $post->post_author;
		$display_name = get_the_author_meta( 'display_name', $author_id );
		if ( empty( $display_name ) ) {
			$display_name = get_the_author_meta( 'nickname', $author_id );
		}

		$user_description = get_the_author_meta( 'user_description', $author_id );
		$user_website     = get_the_author_meta( 'url', $author_id );
		$user_posts       = get_author_posts_url( (int) get_the_author_meta( 'ID', $author_id ) );

		$author_details = '';
		if ( ! empty( $display_name ) ) {
			$author_details .= '<h2 class="author_name">Penulis: ' . esc_html( $display_name ) . '</h2>';
		}

		if ( ! empty( $user_description ) ) {
			$author_details .= '<div class="author_details">'
				. get_avatar( get_the_author_meta( 'user_email', $author_id ), 90 )
				. wp_kses_post( nl2br( $user_description ) )
				. '</div>';
		}

		$author_details .= '<div class="author_links"><a href="' . esc_url( $user_posts ) . '">Semua tulisan ' . esc_html( $display_name ) . '</a>';

		if ( ! empty( $user_website ) ) {
			$author_details .= ' | <a href="' . esc_url( $user_website ) . '" target="_blank" rel="nofollow noopener">Website</a></div>';
		} else {
			$author_details .= '</div>';
		}

		$content .= '<footer class="author_bio_section">' . $author_details . '</footer>';
	}

	return $content;
}
add_filter( 'the_content', 'sekolahane_author_info_box' );

/**
 * Bangun HTML jejak breadcrumbs.
 *
 * @return string
 */
function fungsi_breadcrumbs_webane() {
	$home_link        = esc_url( home_url( '/' ) );
	$home_text        = sekolahane_icon( 'home' );
	$link_before      = '<li class="parent-page">';
	$link_after       = '</li>';
	$link_attr        = ' rel="v:url" property="v:title"';
	$link             = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
	$delimiter        = '';
	$before           = '<li>';
	$after            = '</li>';
	$page_addon       = '';
	$breadcrumb_trail = '';
	$category_links   = '';

	$wp_the_query   = $GLOBALS['wp_the_query'];
	$queried_object = $wp_the_query->get_queried_object();

	if ( is_singular() && $queried_object instanceof WP_Post ) {
		$post_object    = sanitize_post( $queried_object );
		$title          = apply_filters( 'the_title', $post_object->post_title );
		$parent         = (int) $post_object->post_parent;
		$post_type      = $post_object->post_type;
		$post_id        = $post_object->ID;
		$post_link      = $before . wp_kses_post( $title ) . $after;
		$parent_string  = '';
		$post_type_link = '';

		if ( 'post' === $post_type ) {
			$categories = get_the_category( $post_id );
			if ( ! empty( $categories ) ) {
				$category    = $categories[0];
				$cat_parents = get_category_parents( $category, true, $delimiter );
				if ( is_string( $cat_parents ) ) {
					$category_links = str_replace( '<a', $link_before . '<a' . $link_attr, $cat_parents );
					$category_links = str_replace( '</a>', '</a>' . $link_after, $category_links );
				}
			}
		}

		if ( ! in_array( $post_type, array( 'post', 'page', 'attachment' ), true ) ) {
			$post_type_object = get_post_type_object( $post_type );
			$archive_link     = esc_url( (string) get_post_type_archive_link( $post_type ) );
			if ( is_object( $post_type_object ) && isset( $post_type_object->labels->singular_name ) ) {
				$post_type_link = sprintf( $link, $archive_link, esc_html( $post_type_object->labels->singular_name ) );
			}
		}

		if ( 0 !== $parent ) {
			$parent_links = array();
			while ( $parent ) {
				$post_parent = get_post( $parent );
				if ( ! $post_parent instanceof WP_Post ) {
					break;
				}
				$parent_links[] = sprintf( $link, esc_url( (string) get_permalink( $post_parent->ID ) ), esc_html( get_the_title( $post_parent->ID ) ) );
				$parent         = (int) $post_parent->post_parent;
			}
			$parent_links  = array_reverse( $parent_links );
			$parent_string = implode( $delimiter, $parent_links );
		}

		if ( '' !== $parent_string ) {
			$breadcrumb_trail = $parent_string . $delimiter . $post_link;
		} else {
			$breadcrumb_trail = $post_link;
		}

		if ( '' !== $post_type_link ) {
			$breadcrumb_trail = $post_type_link . $delimiter . $breadcrumb_trail;
		}

		if ( '' !== $category_links ) {
			$breadcrumb_trail = $category_links . $breadcrumb_trail;
		}
	}

	if ( is_archive() ) {
		if ( is_category() || is_tag() || is_tax() ) {
			$term_object = get_term( $queried_object );
			if ( $term_object instanceof WP_Term ) {
				$taxonomy           = $term_object->taxonomy;
				$term_name          = esc_html( $term_object->name );
				$term_parent        = (int) $term_object->parent;
				$taxonomy_object    = get_taxonomy( $taxonomy );
				$tax_label          = ( is_object( $taxonomy_object ) && isset( $taxonomy_object->labels->singular_name ) ) ? esc_html( $taxonomy_object->labels->singular_name ) : '';
				$current_term_link  = $before . $tax_label . ': ' . $term_name . $after;
				$parent_term_string = '';

				if ( 0 !== $term_parent ) {
					$parent_term_links = array();
					while ( $term_parent ) {
						$term = get_term( $term_parent, $taxonomy );
						if ( ! $term instanceof WP_Term ) {
							break;
						}
						$term_link           = get_term_link( $term );
						$parent_term_links[] = sprintf( $link, esc_url( is_string( $term_link ) ? $term_link : '' ), esc_html( $term->name ) );
						$term_parent         = (int) $term->parent;
					}
					$parent_term_links  = array_reverse( $parent_term_links );
					$parent_term_string = implode( $delimiter, $parent_term_links );
				}

				if ( '' !== $parent_term_string ) {
					$breadcrumb_trail = $parent_term_string . $delimiter . $current_term_link;
				} else {
					$breadcrumb_trail = $current_term_link;
				}
			}
		} elseif ( is_author() && is_object( $queried_object ) && isset( $queried_object->data->display_name ) ) {
			$breadcrumb_trail = esc_html__( 'Author archive for ', 'sekolahane' ) . $before . esc_html( $queried_object->data->display_name ) . $after;
		} elseif ( is_date() ) {
			$year       = isset( $wp_the_query->query_vars['year'] ) ? (int) $wp_the_query->query_vars['year'] : 0;
			$monthnum   = isset( $wp_the_query->query_vars['monthnum'] ) ? (int) $wp_the_query->query_vars['monthnum'] : 0;
			$day        = isset( $wp_the_query->query_vars['day'] ) ? (int) $wp_the_query->query_vars['day'] : 0;
			$month_name = '';

			if ( $monthnum ) {
				$date_time = DateTime::createFromFormat( '!m', (string) $monthnum );
				if ( $date_time instanceof DateTime ) {
					$month_name = $date_time->format( 'F' );
				}
			}

			if ( is_year() ) {
				$breadcrumb_trail = $before . esc_html( (string) $year ) . $after;
			} elseif ( is_month() ) {
				$year_link        = sprintf( $link, esc_url( get_year_link( $year ) ), esc_html( (string) $year ) );
				$breadcrumb_trail = $year_link . $delimiter . $before . esc_html( $month_name ) . $after;
			} elseif ( is_day() ) {
				$year_link        = sprintf( $link, esc_url( get_year_link( $year ) ), esc_html( (string) $year ) );
				$month_link       = sprintf( $link, esc_url( get_month_link( $year, $monthnum ) ), esc_html( $month_name ) );
				$breadcrumb_trail = $year_link . $delimiter . $month_link . $delimiter . $before . esc_html( (string) $day ) . $after;
			}
		} elseif ( is_post_type_archive() ) {
			$post_type = isset( $wp_the_query->query_vars['post_type'] ) ? $wp_the_query->query_vars['post_type'] : '';
			if ( is_array( $post_type ) ) {
				$post_type = reset( $post_type );
			}
			$post_type_object = get_post_type_object( (string) $post_type );
			if ( is_object( $post_type_object ) && isset( $post_type_object->labels->singular_name ) ) {
				$breadcrumb_trail = $before . esc_html( $post_type_object->labels->singular_name ) . $after;
			}
		}
	}

	if ( is_search() ) {
		$breadcrumb_trail = esc_html__( 'Pencarian untuk: ', 'sekolahane' ) . $before . get_search_query() . $after;
	}

	if ( is_404() ) {
		$breadcrumb_trail = $before . esc_html__( 'Error 404', 'sekolahane' ) . $after;
	}

	if ( is_paged() ) {
		$current_page = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : (int) get_query_var( 'page' );
		/* translators: %s: nomor halaman */
		$page_addon = $before . sprintf( esc_html__( ' ( Page %s )', 'sekolahane' ), number_format_i18n( $current_page ) ) . $after;
	}

	$breadcrumb_output_link = '<ul>';
	if ( is_home() || is_front_page() ) {
		if ( is_paged() ) {
			$breadcrumb_output_link .= '<li class="parent-page"> <a href="' . $home_link . '">' . $home_text . '</a></li>';
			$breadcrumb_output_link .= $page_addon;
		}
	} else {
		$breadcrumb_output_link .= '<li><a href="' . $home_link . '" rel="v:url" property="v:title">' . $home_text . '</a></li>';
		$breadcrumb_output_link .= $delimiter;
		$breadcrumb_output_link .= $breadcrumb_trail;
		$breadcrumb_output_link .= $page_addon;
	}
	$breadcrumb_output_link .= '</ul><!-- .breadcrumbs -->';

	return $breadcrumb_output_link;
}

/**
 * Tampilkan pembungkus section breadcrumbs.
 *
 * @return void
 */
function panggil_breadcrumb() {
	?>
	<div class="breadcrumb-area pt-15 pb-15">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb-container">
						<?php echo wp_kses_post( fungsi_breadcrumbs_webane() ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Kustomisasi tampilan form login wp-login.php.
 *
 * @return void
 */
function webane_load_login_form_logo() {
	?>
	<style type="text/css">
		.login {background: #73ab01;}
		#login h1 a, .login h1 a {
			background-image: url(https://4.bp.blogspot.com/-jF3KjigDQCY/W7-WgeouSoI/AAAAAAAAAYc/zLuvSenN5oI7fuC_TnDIf14n9FUW40tXwCLcBGAs/s1600/login.png);
		}
		#login {
			background-color: #fff;
			width: 100%;
			overflow: hidden;
			-webkit-box-shadow: 0 25px 70px rgba(0, 0, 0, 0.07);
			box-shadow: 0 25px 70px rgba(0, 0, 0, 0.07);
		}
		#login .button-primary {
			margin-top: 10px; display: block; width: 100%; background:#73ab01; color:#fff; border-color:#fff;
		}
		#login input[type="text"], #login input[type="password"] {border:0; border-bottom: 1px solid #73ab01}
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'webane_load_login_form_logo' );

/**
 * Placeholder dashboard widget.
 *
 * @return void
 */
function wpexplorer_dashboard_widget_function() {
	echo esc_html__( "Hello there, I'm a great Dashboard Widget. Edit me!", 'sekolahane' );
}

/**
 * Sesuaikan widget di halaman Dashboard wp-admin.
 *
 * @return void
 */
function my_dashboard_widgets() {
	global $wp_meta_boxes;
	unset(
		$wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'],
		$wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'],
		$wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']
	);
	wp_add_dashboard_widget( 'dashboard_custom_feed', 'Greating From Webane', 'dashboard_custom_feed_output' );
}
add_action( 'wp_dashboard_setup', 'my_dashboard_widgets' );

/**
 * Tampilkan RSS feed Webane di widget dashboard.
 *
 * @return void
 */
function dashboard_custom_feed_output() {
	echo '<div class="rss-widget">';
	wp_widget_rss_output(
		array(
			'url'          => 'https://webane.com/feed/',
			'title'        => 'Webane Indonesia',
			'items'        => 10,
			'show_summary' => 0,
			'show_author'  => 0,
			'show_date'    => 1,
		)
	);
	echo '</div>';
}

/**
 * Ubah teks kredit di footer wp-admin.
 *
 * @return string
 */
function wpexplorer_remove_footer_admin() {
	return '<span id="footer-thankyou">Designed with love by <a href="https://webane.com/" target="_blank" rel="nofollow noopener">Webane Indonesia</a> Powered By WordPress</span>';
}
add_filter( 'admin_footer_text', 'wpexplorer_remove_footer_admin' );

/**
 * Tampilkan banner informasi Webane di wp-admin.
 *
 * @return void
 */
function webane_ads_on_admin() {
	$imageku = 'https://4.bp.blogspot.com/-J2K6WKNTj2E/W7-WgY1y9uI/AAAAAAAAAYg/GSYOwtOOJEEydFWCbxxfTGK5XtAM1cI7wCLcBGAs/s1600/webane-indonesia-ads.jpg';
	$output  = '<a href="https://webane.com"><img style="width:100%;" src="' . esc_url( $imageku ) . '" alt="Webane Indonesia"></a>';

	add_settings_error( 'webane_ads_on_admin', esc_attr( 'settings_updated' ), $output, 'notice-warning' );
	settings_errors( 'webane_ads_on_admin' );
}
add_action( 'admin_notices', 'webane_ads_on_admin' );

/**
 * Kembalikan HTML kredit desain di footer front-end.
 *
 * @return string
 */
function webane_load_designed_by() {
	$webane_site = 'https://webane.com';
	return '| Designed with love by <a href="' . esc_url( $webane_site ) . '" target="_blank" rel="nofollow noopener" title="Web Design Webane Indonesia">Webane Indonesia</a>';
}

/**
 * Ambil rentang tahun publikasi post untuk copyright footer (di-cache transient 1 hari).
 *
 * @return string
 */
function webane_load_dynamic_copyright_year() {
	$cached = get_transient( 'sekolahane_copyright_year' );
	if ( false !== $cached && is_string( $cached ) ) {
		return $cached;
	}

	global $wpdb;
	$copyright_dates = $wpdb->get_results(
		"SELECT YEAR(min(post_date_gmt)) AS firstdate, YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish'"
	);

	$output = '';
	if ( ! empty( $copyright_dates ) && isset( $copyright_dates[0]->firstdate ) ) {
		$copyright = '&copy; ' . (int) $copyright_dates[0]->firstdate;
		if ( $copyright_dates[0]->firstdate !== $copyright_dates[0]->lastdate ) {
			$copyright .= '-' . (int) $copyright_dates[0]->lastdate;
		}
		$output = $copyright;
	}

	set_transient( 'sekolahane_copyright_year', $output, DAY_IN_SECONDS );

	return $output;
}

/**
 * Gunakan field gambar ACF (`gravatar_ane`) sebagai avatar profil user.
 *
 * @param string     $avatar      Tag `<img>` avatar default.
 * @param int|string $id_or_email ID user, objek komentar, atau alamat email.
 * @param int        $size        Ukuran dimensi avatar dalam piksel.
 * @param string     $default     URL default avatar.
 * @param string     $alt         Atribut alt gambar.
 * @return string
 */
function sekolahane_acf_profile_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
	$user = false;

	if ( is_numeric( $id_or_email ) ) {
		$user = get_user_by( 'id', (int) $id_or_email );
	} elseif ( is_object( $id_or_email ) ) {
		if ( ! empty( $id_or_email->user_id ) ) {
			$user = get_user_by( 'id', (int) $id_or_email->user_id );
		}
	} elseif ( is_string( $id_or_email ) ) {
		$user = get_user_by( 'email', $id_or_email );
	}

	if ( ! $user instanceof WP_User ) {
		return $avatar;
	}

	$image_id = get_user_meta( $user->ID, 'gravatar_ane', true );
	if ( empty( $image_id ) ) {
		return $avatar;
	}

	$image_url = wp_get_attachment_image_src( (int) $image_id, 'kotak' );
	if ( ! is_array( $image_url ) || empty( $image_url[0] ) ) {
		return $avatar;
	}

	$avatar_url = $image_url[0];
	$size_int   = absint( $size );

	return '<img alt="' . esc_attr( (string) $alt ) . '" src="' . esc_url( $avatar_url ) . '" class="avatar avatar-' . esc_attr( (string) $size_int ) . '" height="' . esc_attr( (string) $size_int ) . '" width="' . esc_attr( (string) $size_int ) . '"/>';
}
add_filter( 'get_avatar', 'sekolahane_acf_profile_avatar', 10, 5 );

/**
 * Ambil jumlah pembaca (views) suatu post.
 *
 * @param int|string $post_id ID post (opsional).
 * @return string|false
 */
function get_views( $post_id = '' ) {
	if ( empty( $post_id ) ) {
		global $post;
		$post_id = ( is_object( $post ) && isset( $post->ID ) ) ? $post->ID : get_the_ID();
	}

	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return false;
	}

	$count_key = 'musi_views';
	$raw_count = get_post_meta( $post_id, $count_key, true );

	if ( '' === $raw_count || false === $raw_count ) {
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
		$count_num = 0;
	} else {
		$count_num = (int) $raw_count;
	}

	$formatted = number_format_i18n( $count_num );

	/* translators: %s: jumlah pembaca */
	return sprintf( _n( '%s view', '%s views', $count_num, 'sekolahane' ), $formatted );
}

/**
 * Tambah +1 jumlah pembaca post (ketika WP_CACHE tidak aktif).
 *
 * @param int|string $post_id ID post (opsional).
 * @return bool|void
 */
function set_views( $post_id = '' ) {
	if ( defined( 'WP_CACHE' ) && WP_CACHE ) {
		return false;
	}

	if ( empty( $post_id ) ) {
		global $post;
		$post_id = ( is_object( $post ) && isset( $post->ID ) ) ? $post->ID : get_the_ID();
	}

	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return false;
	}

	$count_key = 'musi_views';
	$count     = get_post_meta( $post_id, $count_key, true );
	if ( '' === $count || false === $count ) {
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
	} else {
		$next = (int) $count + 1;
		update_post_meta( $post_id, $count_key, $next );
	}
}

// Hindari prefetching browser menambah jumlah views secara tidak sengaja.
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

/**
 * Tambahkan kolom Views pada tabel daftar Posts di wp-admin.
 *
 * @param array<string, string> $defaults Kolom tabel.
 * @return array<string, string>
 */
function musi_column_views( $defaults ) {
	$defaults['musi_post_views'] = __( 'Views', 'sekolahane' );
	return $defaults;
}
add_filter( 'manage_posts_columns', 'musi_column_views' );

/**
 * Tampilkan isi kolom Views di tabel daftar Posts wp-admin.
 *
 * @param string $column_name Nama kolom.
 * @param int    $id          ID post.
 * @return void
 */
function musi_custom_column_views( $column_name, $id ) {
	if ( 'musi_post_views' === $column_name ) {
		echo esc_html( (string) get_views( $id ) );
	}
}
add_action( 'manage_posts_custom_column', 'musi_custom_column_views', 5, 2 );

/**
 * Enqueue script penghitung post views via AJAX saat WP_CACHE aktif.
 *
 * @return void
 */
function musi_postview_cache_count_enqueue() {
	global $post;
	if ( is_single() && ( defined( 'WP_CACHE' ) && WP_CACHE ) && is_object( $post ) && isset( $post->ID ) ) {
		wp_localize_script(
			'sekolahane-js',
			'postViewsCache',
			array(
				'admin_ajax_url' => admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ),
				'post_id'        => (int) $post->ID,
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'musi_postview_cache_count_enqueue', 20 );

/**
 * Handler AJAX untuk menambah jumlah pembaca ketika halaman di-cache.
 *
 * @return void
 */
function musi_increment_views() {
	if ( ! empty( $_GET['postviews_id'] ) && ( defined( 'WP_CACHE' ) && WP_CACHE ) ) {
		$post_id = absint( wp_unslash( $_GET['postviews_id'] ) );
		if ( $post_id > 0 && 'publish' === get_post_status( $post_id ) ) {
			$count_key = 'musi_views';
			$count     = get_post_meta( $post_id, $count_key, true );
			if ( '' === $count || false === $count ) {
				delete_post_meta( $post_id, $count_key );
				add_post_meta( $post_id, $count_key, '0' );
			} else {
				$next = (int) $count + 1;
				update_post_meta( $post_id, $count_key, $next );
			}
		}
	}
	exit();
}
add_action( 'wp_ajax_postviews', 'musi_increment_views' );
add_action( 'wp_ajax_nopriv_postviews', 'musi_increment_views' );

// Daftarkan halaman ACF Options.
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => 'Webane General Information',
			'menu_title' => 'Webane Settings',
			'menu_slug'  => 'webane-theme-general-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => 'Your Banners Settings',
			'menu_title'  => 'Your Banners',
			'parent_slug' => 'webane-theme-general-settings',
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => 'Customer Care',
			'menu_title'  => 'Customer Care',
			'parent_slug' => 'webane-theme-general-settings',
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => 'Mobile Menu',
			'menu_title'  => 'Mobile Menu',
			'parent_slug' => 'webane-theme-general-settings',
		)
	);
}

/**
 * Daftarkan field API Keys (Google Maps & Facebook App ID) di Webane Settings.
 *
 * @return void
 */
function sekolahane_register_api_keys_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'                   => 'group_sekolahane_api_keys',
			'title'                 => __( 'Integrasi & API Key', 'sekolahane' ),
			'fields'                => array(
				array(
					'key'       => 'field_sekolahane_api_tab',
					'label'     => __( 'API & Integrasi', 'sekolahane' ),
					'type'      => 'tab',
					'placement' => 'top',
				),
				array(
					'key'          => 'field_sekolahane_gmaps_key',
					'label'        => __( 'Google Maps API Key', 'sekolahane' ),
					'name'         => 'ane_google_maps_api_key',
					'type'         => 'password',
					'instructions' => __( 'Opsional. Isi jika ingin menampilkan peta lokasi Google Maps, atau definisikan konstanta SEKOLAHANE_GMAPS_API_KEY di wp-config.php.', 'sekolahane' ),
				),
				array(
					'key'          => 'field_sekolahane_fb_app_id',
					'label'        => __( 'Facebook App ID', 'sekolahane' ),
					'name'         => 'ane_fb_app_id',
					'type'         => 'text',
					'instructions' => __( 'Opsional. Isi untuk integrasi komentar Facebook, atau definisikan konstanta SEKOLAHANE_FB_APP_ID di wp-config.php.', 'sekolahane' ),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'webane-theme-general-settings',
					),
				),
			),
			'menu_order'            => 98,
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
		)
	);
}
add_action( 'acf/init', 'sekolahane_register_api_keys_fields' );

/**
 * Isi nilai default 5 menu utama (Profile, News, Home, PPDB, Contact) pada
 * repeater `ane_mobile_menu` di halaman admin Mobile Menu jika belum ada data.
 *
 * Dengan filter ini, ketika admin membuka `admin.php?page=acf-options-mobile-menu`,
 * ke-5 baris menu langsung terbuka dengan icon dan judul default yang sudah
 * dipetakan sehingga admin cukup mengarahkan URL-nya saja.
 *
 * @param mixed $value Nilai field dari database.
 * @return mixed
 */
function sekolahane_init_default_mobile_menu( $value ) {
	if ( ! empty( $value ) && is_array( $value ) ) {
		return $value;
	}

	$home_url  = home_url( '/' );
	$blog_id   = (int) get_option( 'page_for_posts' );
	$news_url  = $blog_id > 0 ? (string) get_permalink( $blog_id ) : $home_url;
	$ppdb_link = function_exists( 'get_field' ) ? get_field( 'ane_link_header', 'option' ) : null;
	$ppdb_url  = ( is_array( $ppdb_link ) && ! empty( $ppdb_link['url'] ) ) ? (string) $ppdb_link['url'] : '#';

	return array(
		array(
			'field_6189660d2faec' => array(
				'title'  => __( 'Profile', 'sekolahane' ),
				'url'    => '#',
				'target' => '',
			),
			'field_6189662f2faed' => 'profile',
		),
		array(
			'field_6189660d2faec' => array(
				'title'  => __( 'News', 'sekolahane' ),
				'url'    => $news_url,
				'target' => '',
			),
			'field_6189662f2faed' => 'news',
		),
		array(
			'field_6189660d2faec' => array(
				'title'  => __( 'Home', 'sekolahane' ),
				'url'    => $home_url,
				'target' => '',
			),
			'field_6189662f2faed' => 'home',
		),
		array(
			'field_6189660d2faec' => array(
				'title'  => __( 'PPDB', 'sekolahane' ),
				'url'    => $ppdb_url,
				'target' => '',
			),
			'field_6189662f2faed' => 'ppdb',
		),
		array(
			'field_6189660d2faec' => array(
				'title'  => __( 'Contact', 'sekolahane' ),
				'url'    => '#',
				'target' => '',
			),
			'field_6189662f2faed' => 'contact',
		),
	);
}
add_filter( 'acf/load_value/name=ane_mobile_menu', 'sekolahane_init_default_mobile_menu' );
