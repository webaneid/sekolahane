<?php get_header ();?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php panggil_breadcrumb ();?>

		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="judul-arsip">
						<?php
						single_term_title( '<h1 class="general-title">', '</h1>' );
						?>
					</div>
				</div>
			</div>

					<div class="konten-arsip if-mobile">

						<?php

						if ( have_posts() ) :
							echo '<div class="row justify-content-center">';
								while ( have_posts() ) : the_post();
									echo '<div class="col-md-3 col-6 mb-20">';
										get_template_part( 'tp/content', 'guru' );
									echo '</div>';

								endwhile;

								else :
									get_template_part( 'tp/content', 'none' );
							echo '</div>';
								endif;

						echo ane_post_pagination(); ?>
					</div>


		</div>
	</main><!-- .site-main -->
</div><!-- .content-area -->
<?php get_footer ();
