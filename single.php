<?php
/**
 * Template untuk menampilkan artikel single post.
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
					<div class="col-sm-10 col-md-10 col-lg-10 col-12">
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) :
								the_post();
								get_template_part( 'tp/single', (string) get_post_format() );
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
