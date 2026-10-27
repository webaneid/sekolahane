<?php
/**
 * Template Name: Contact Us
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php if ( ! wp_is_mobile() ) : ?>
			<?php panggil_breadcrumb(); ?>
		<?php endif; ?>

		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-11 col-12">
					<?php
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							get_template_part( 'tp/content', 'page-kontak' );
						endwhile;
					else :
						get_template_part( 'tp/content', 'none' );
					endif;
					?>
				</div>
			</div>
		</div>
	</main>
</div>
<?php get_footer(); ?>
