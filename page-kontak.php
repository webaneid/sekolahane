<?php
	/*
	* Template Name: Contact Us
	*/
	defined( 'ABSPATH' ) || exit;
	get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php panggil_breadcrumb ();?>

		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-10">


					<?php	if ( have_posts() ) :
							while ( have_posts() ) : the_post();

								get_template_part( 'tp/content', 'page-kontak');

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
