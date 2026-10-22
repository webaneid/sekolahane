<?php
	/*
	* Template Name: Blog Type
	*/
	defined( 'ABSPATH' ) || exit;
	get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
			if ( wp_is_mobile() ) {
				get_template_part( 'tp/pages/news-mobile' );
			} else {
				get_template_part( 'tp/pages/news-desktop' );
			}
		?>
	</main>
</div>
<?php get_footer(); ?>
