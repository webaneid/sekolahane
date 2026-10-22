<?php
	/*
	* Template Name: Profil Lembaga
	*/
	defined( 'ABSPATH' ) || exit;
	get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<?php

			if ( have_posts() ) :
				set_views(get_the_ID());
				while ( have_posts() ) : the_post();

					get_template_part( 'tp/pages/profil' );

				endwhile;

				else :

					get_template_part( 'tp/content', 'none' );

			endif;
		?>
	</main>
</div>

<?php get_footer (); ?>
