<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php panggil_breadcrumb ();?>

		<div class="container">

			<div class="judul-arsip">
				<?php the_archive_title( '<h1 class="judul">', '</h1>' ); ?>
			</div>

			<div class="row">


				<div class="col-lg-8 pm-0">
					<div class="ane-arsip">

						<?php

						if ( have_posts() ) :
								$counter = -1; while ( have_posts() ) : the_post();
								$counter++;
									if($counter == 0){
										$detect = new Mobile_Detect();

											if( $detect->isMobile() && !$detect->isTablet() ) {

												get_template_part( 'tp/content', 'overlay' );
											}

											else {
												get_template_part( 'tp/content','klasik');
											}



									}
									elseif($counter == 5){

										get_template_part( 'tp/content', 'overlay' );
									}
									else {
										$detect = new Mobile_Detect();

											if( $detect->isMobile() && !$detect->isTablet() ) {
											    get_template_part( 'tp/content','list');
											}

											else {
												get_template_part( 'tp/content', get_post_format() );
											}
									}


								endwhile;

								else :

									get_template_part( 'tp/content', 'none' );
								endif;

						echo ane_post_pagination(); ?>
					</div>
				</div>

				<?php get_sidebar(); ?>

		</div></div>
	</main><!-- .site-main -->
</div><!-- .content-area -->
<?php get_footer ();
