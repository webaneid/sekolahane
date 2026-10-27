<?php
/**
 * Template untuk menampilkan detail CPT Guru.
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

get_header();
set_views( get_the_ID() );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<?php if ( wp_is_mobile() ) : ?>
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'tp/mobile/single', 'universal' );
				endwhile;
			else :
				get_template_part( 'tp/content', 'none' );
			endif;
			?>
		<?php else : ?>
			<?php panggil_breadcrumb(); ?>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-sm-12 col-md-12 col-lg-8 col-12 pm-0">
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) :
								the_post();
								get_template_part( 'tp/single', 'guru' );
							endwhile;
						else :
							get_template_part( 'tp/content', 'none' );
						endif;
						?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</main>
</div>

<?php get_footer(); ?>
