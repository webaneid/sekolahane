<?php
	/*
	* Template Name: Blog Type
	*/
	get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
			$detect = new Mobile_Detect();
			global $detect;

				if( $detect->isMobile() && !$detect->isTablet() ) {
				    get_template_part('tp/pages/news-mobile');
				}
				elseif (! $detect->isTablet() ) {
					    get_template_part('tp/pages/news-desktop');
				}
				else {
					get_template_part('tp/pages/news-desktop');
				}
		?>
	</main>
</div>
<?php get_footer(); ?>
