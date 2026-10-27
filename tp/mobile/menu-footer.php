<?php
/**
 * Template part: Mobile App Bottom Navigation Bar (#footer-bar).
 *
 * Menampilkan 5 menu utama layaknya aplikasi mobile modern:
 * Profile, News, Home (di tengah dengan floating dock), PPDB, dan Contact.
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_home_url  = home_url( '/' );
$sekolahane_blog_id   = (int) get_option( 'page_for_posts' );
$sekolahane_news_url  = $sekolahane_blog_id > 0 ? (string) get_permalink( $sekolahane_blog_id ) : $sekolahane_home_url;
$sekolahane_ppdb_link = get_field( 'ane_link_header', 'option' );
$sekolahane_ppdb_url  = ( is_array( $sekolahane_ppdb_link ) && ! empty( $sekolahane_ppdb_link['url'] ) ) ? (string) $sekolahane_ppdb_link['url'] : '#';

$sekolahane_default_items = array(
	array(
		'title'  => __( 'Profile', 'sekolahane' ),
		'url'    => '#',
		'target' => '_self',
		'icon'   => 'profile',
	),
	array(
		'title'  => __( 'News', 'sekolahane' ),
		'url'    => $sekolahane_news_url,
		'target' => '_self',
		'icon'   => 'news',
	),
	array(
		'title'  => __( 'Home', 'sekolahane' ),
		'url'    => $sekolahane_home_url,
		'target' => '_self',
		'icon'   => 'home',
	),
	array(
		'title'  => __( 'PPDB', 'sekolahane' ),
		'url'    => $sekolahane_ppdb_url,
		'target' => '_self',
		'icon'   => 'ppdb',
	),
	array(
		'title'  => __( 'Contact', 'sekolahane' ),
		'url'    => '#',
		'target' => '_self',
		'icon'   => 'contact',
	),
);

$sekolahane_saved_rows = array();
if ( have_rows( 'ane_mobile_menu', 'option' ) ) {
	while ( have_rows( 'ane_mobile_menu', 'option' ) ) {
		the_row();
		$sekolahane_link   = get_sub_field( 'ane_link' );
		$sekolahane_icon   = trim( (string) get_sub_field( 'ane_icon' ) );
		$sekolahane_url    = ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['url'] ) ) ? trim( (string) $sekolahane_link['url'] ) : '';
		$sekolahane_title  = ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['title'] ) ) ? trim( (string) $sekolahane_link['title'] ) : '';
		$sekolahane_target = ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['target'] ) ) ? trim( (string) $sekolahane_link['target'] ) : '_self';

		$sekolahane_saved_rows[] = array(
			'title'  => $sekolahane_title,
			'url'    => $sekolahane_url,
			'target' => $sekolahane_target,
			'icon'   => $sekolahane_icon,
		);
	}
}

$sekolahane_menu_items = array();
$sekolahane_row_count  = count( $sekolahane_saved_rows );

if ( 5 === $sekolahane_row_count ) {
	foreach ( $sekolahane_saved_rows as $sekolahane_idx => $sekolahane_row ) {
		$sekolahane_fallback     = $sekolahane_default_items[ $sekolahane_idx ];
		$sekolahane_menu_items[] = array(
			'title'  => '' !== $sekolahane_row['title'] ? $sekolahane_row['title'] : $sekolahane_fallback['title'],
			'url'    => '' !== $sekolahane_row['url'] ? $sekolahane_row['url'] : $sekolahane_fallback['url'],
			'target' => '' !== $sekolahane_row['target'] ? $sekolahane_row['target'] : '_self',
			'icon'   => '' !== $sekolahane_row['icon'] ? $sekolahane_row['icon'] : $sekolahane_fallback['icon'],
		);
	}
} elseif ( 4 === $sekolahane_row_count ) {
	// Kompatibilitas data lama (4 baris di DB): 2 di kiri, Home otomatis di tengah, 2 di kanan.
	$sekolahane_side_defaults = array(
		$sekolahane_default_items[0],
		$sekolahane_default_items[1],
		$sekolahane_default_items[3],
		$sekolahane_default_items[4],
	);
	$sekolahane_mapped_sides  = array();
	foreach ( $sekolahane_saved_rows as $sekolahane_idx => $sekolahane_row ) {
		$sekolahane_fallback       = $sekolahane_side_defaults[ $sekolahane_idx ];
		$sekolahane_mapped_sides[] = array(
			'title'  => '' !== $sekolahane_row['title'] ? $sekolahane_row['title'] : $sekolahane_fallback['title'],
			'url'    => '' !== $sekolahane_row['url'] ? $sekolahane_row['url'] : $sekolahane_fallback['url'],
			'target' => '' !== $sekolahane_row['target'] ? $sekolahane_row['target'] : '_self',
			'icon'   => '' !== $sekolahane_row['icon'] ? $sekolahane_row['icon'] : $sekolahane_fallback['icon'],
		);
	}
	$sekolahane_menu_items = array(
		$sekolahane_mapped_sides[0],
		$sekolahane_mapped_sides[1],
		$sekolahane_default_items[2],
		$sekolahane_mapped_sides[2],
		$sekolahane_mapped_sides[3],
	);
} else {
	$sekolahane_menu_items = $sekolahane_default_items;
}
?>
<nav id="footer-bar" class="footer-bar" aria-label="<?php esc_attr_e( 'Menu Navigasi Mobile', 'sekolahane' ); ?>">
	<?php
	foreach ( $sekolahane_menu_items as $sekolahane_index => $sekolahane_item ) :
		$sekolahane_is_center = ( 2 === $sekolahane_index );
		$sekolahane_item_cls  = $sekolahane_is_center ? 'footer-bar-item footer-bar-center' : 'footer-bar-item';
		?>
		<a href="<?php echo esc_url( $sekolahane_item['url'] ); ?>" target="<?php echo esc_attr( $sekolahane_item['target'] ); ?>" class="<?php echo esc_attr( $sekolahane_item_cls ); ?>">
			<span class="footer-bar-icon">
				<?php echo sekolahane_icon( $sekolahane_item['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</span>
			<span class="footer-bar-label"><?php echo esc_html( $sekolahane_item['title'] ); ?></span>
		</a>
	<?php endforeach; ?>
</nav>
