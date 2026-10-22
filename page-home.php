<?php
	/*
	* Template Name: Landing Page
	*/
	defined( 'ABSPATH' ) || exit;
	get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main ane-landingpage" role="main">
		<?php
			if ( wp_is_mobile() ) {
				get_template_part( 'tp/pages/home-mobile' );
			} else {
				get_template_part( 'tp/pages/home-desktop' );
			}
		?>
	</main>
</div>
<?php get_footer(); ?>
