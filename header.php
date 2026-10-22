<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v5.0&appId=150033455013036&autoLogAppEvents=1"></script>
<div class="webane-wrapper">
<header class="ane-header">
	<div class="atas">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-6">
					<?php $link = get_field('ane_link_header','option');
					if( !empty( $link ) ):
					 ?>
					<div class="kiri">
						<a href="<?php echo $link['url']; ?>" class="ane-topbutton"><i class="ane-buku"></i> <?php echo $link['title']; ?></a>
					</div>
					<?php endif; ?>
				</div>
				<div class="col-md-6 col-6 text-right">
					<?php get_template_part('tp/content','sosmed') ?>
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
		                    $logoimg = get_theme_mod( 'logo', get_template_directory_uri().'/img/logo-sekolahane.png' );
		                    if ( has_custom_logo() ) {
		                    the_custom_logo();
		                    }
		                    else {
		                        echo '<a class="logo" href="' .get_home_url(). '" rel="home"><img src="' .$logoimg. '" title="' .get_bloginfo( 'name' ).'" alt="' .get_bloginfo( 'name' ).'"></a>';
		                    }
		                ?>
		            </div>
		            <div class="col-md-9 col-lg-9 col-8 post-tengah">
		                <?php
		                    wp_nav_menu(  array(
		                    'theme_location' => 'menuutama',
		                    'container_id'    => 'main-menu',
		                    'echo'            => true,
		                    'fallback_cb'    => 'wp_page_menu',
		                    'items_wrap'      => '<ul class="main-menu">%3$s</ul>',
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
			$logoimg = get_theme_mod( 'logo', get_template_directory_uri().'/img/logo-sekolahane.png' );
			if ( has_custom_logo() ) {
			the_custom_logo();
			}
			else {
				echo '<a class="logo" href="' .get_home_url(). '" rel="home"><img src="' .$logoimg. '" title="' .get_bloginfo( 'name' ).'" alt="' .get_bloginfo( 'name' ).'"></a>';
			}
		?>
		<div class="mobile-menu-area">
			<div class="mobile-menu">
				<nav id="mobile-menu-active">
					<?php
								wp_nav_menu(  array(
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
