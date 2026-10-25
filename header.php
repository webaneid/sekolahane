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
			<div class="row align-items-center">
				<div class="col-md-5 col-6">
					<div class="kiri">
						<span class="top-date">
							<?php echo sekolahane_icon( 'calendar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php echo esc_html( wp_date( 'l, j F Y' ) ); ?>
						</span>
					</div>
				</div>
				<div class="col-md-7 col-6 text-right">
					<div class="kanan">
						<?php
						$sekolahane_wa_raw   = '';
						$sekolahane_wa_label = '';
						$sekolahane_sosmed   = get_field( 'sosmed_ane', 'option' );
						$sekolahane_contact  = get_field( 'contact_ane', 'option' );

						if ( is_array( $sekolahane_sosmed ) && ! empty( $sekolahane_sosmed['sosmed_wa'] ) ) {
							$sekolahane_wa_label = trim( wp_strip_all_tags( (string) $sekolahane_sosmed['sosmed_wa'] ) );
							$sekolahane_wa_raw   = (string) preg_replace( '/[^0-9]/', '', $sekolahane_wa_label );
						} elseif ( is_array( $sekolahane_contact ) && ! empty( $sekolahane_contact['kontak_handphone'] ) ) {
							$sekolahane_wa_label = trim( wp_strip_all_tags( (string) $sekolahane_contact['kontak_handphone'] ) );
							$sekolahane_wa_raw   = (string) preg_replace( '/[^0-9]/', '', $sekolahane_wa_label );
						}

						if ( '' !== $sekolahane_wa_raw && '0' === substr( $sekolahane_wa_raw, 0, 1 ) ) {
							$sekolahane_wa_raw = '62' . substr( $sekolahane_wa_raw, 1 );
						}

						if ( '' !== $sekolahane_wa_raw ) :
							?>
							<a href="<?php echo esc_url( 'https://wa.me/' . $sekolahane_wa_raw ); ?>" class="ane-top-wa" target="_blank" rel="noopener noreferrer">
								<?php echo sekolahane_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<span><?php echo esc_html( '+' . $sekolahane_wa_raw ); ?></span>
							</a>
						<?php endif; ?>

						<?php
						$sekolahane_link = get_field( 'ane_link_header', 'option' );
						if ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['url'] ) ) :
							$sekolahane_link_title  = isset( $sekolahane_link['title'] ) ? trim( wp_strip_all_tags( (string) $sekolahane_link['title'] ) ) : '';
							$sekolahane_link_title  = '' !== $sekolahane_link_title ? $sekolahane_link_title : __( 'Pendaftaran', 'sekolahane' );
							$sekolahane_link_target = ! empty( $sekolahane_link['target'] ) ? (string) $sekolahane_link['target'] : '_self';
							?>
							<a href="<?php echo esc_url( (string) $sekolahane_link['url'] ); ?>" target="<?php echo esc_attr( $sekolahane_link_target ); ?>" class="ane-topbutton">
								<?php echo sekolahane_icon( 'buku' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<span><?php echo esc_html( $sekolahane_link_title ); ?></span>
							</a>
						<?php endif; ?>
					</div>
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
