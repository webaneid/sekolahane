<?php
/**
 * Header template theme Sekolah Ane.
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="fb-root"></div>
<div class="webane-wrapper">
<header class="ane-header">
	<div class="atas">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-6">
					<?php
					$sekolahane_link = get_field( 'ane_link_header', 'option' );
					if ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['url'] ) ) :
						$sekolahane_link_title = isset( $sekolahane_link['title'] ) ? (string) $sekolahane_link['title'] : '';
						?>
						<div class="kiri">
							<a href="<?php echo esc_url( (string) $sekolahane_link['url'] ); ?>" class="ane-topbutton"><i class="ane-buku"></i> <?php echo esc_html( $sekolahane_link_title ); ?></a>
						</div>
					<?php endif; ?>
				</div>
				<div class="col-md-6 col-6 text-right">
					<?php get_template_part( 'tp/content', 'sosmed' ); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="bawah">
		<div class="desktop-menu">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-lg-3 col-4">
						<?php
						$sekolahane_logo = (string) get_theme_mod( 'logo', get_template_directory_uri() . '/img/logo-sekolahane.png' );
						if ( has_custom_logo() ) {
							the_custom_logo();
						} else {
							echo '<a class="logo" href="' . esc_url( home_url( '/' ) ) . '" rel="home"><img src="' . esc_url( $sekolahane_logo ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '"></a>';
						}
						?>
					</div>
					<div class="col-md-9 col-lg-9 col-8 post-tengah">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menuutama',
								'container_id'   => 'main-menu',
								'echo'           => true,
								'fallback_cb'    => 'wp_page_menu',
								'items_wrap'     => '<ul class="main-menu">%3$s</ul>',
								'depth'          => 4,
							)
						);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="primary-mobile-menu">
		<?php
		$sekolahane_logo = (string) get_theme_mod( 'logo', get_template_directory_uri() . '/img/logo-sekolahane.png' );
		if ( has_custom_logo() ) {
			the_custom_logo();
		} else {
			echo '<a class="logo" href="' . esc_url( home_url( '/' ) ) . '" rel="home"><img src="' . esc_url( $sekolahane_logo ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '"></a>';
		}
		?>
		<div class="mobile-menu-area">
			<div class="mobile-menu">
				<nav id="mobile-menu-active">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menuutama',
							'container'      => 'div',
							'fallback_cb'    => 'wp_page_menu',
							'depth'          => 4,
						)
					);
					?>
				</nav>
			</div>
		</div>
	</div>
</header>
