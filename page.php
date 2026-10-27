<?php
/**
 * Template default untuk halaman statis (page).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<?php
		if ( have_posts() ) :
			set_views( get_the_ID() );
			while ( have_posts() ) :
				the_post();
				if ( wp_is_mobile() ) {
					get_template_part( 'tp/mobile/single', 'universal' );
				} else {
					get_template_part( 'tp/content', 'page' );
				}
			endwhile;
		else :
			get_template_part( 'tp/content', 'none' );
		endif;
		?>
	</main>
</div>

<?php get_footer(); ?>
