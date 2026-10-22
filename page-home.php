<?php
	/*
	* Template Name: Landing Page
	*/
	get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main ane-landingpage" role="main">
		<?php
			$detect = new Mobile_Detect();
			global $detect;

				if( $detect->isMobile() && !$detect->isTablet() ) {
				    get_template_part('/tp/pages/home-mobile');
				}
				elseif (! $detect->isTablet() ) {
					    get_template_part('/tp/pages/home-desktop');
				}
				else {
					get_template_part('/tp/pages/home-desktop');
				}
		?>
	</main>
</div>
<?php get_footer(); ?>
