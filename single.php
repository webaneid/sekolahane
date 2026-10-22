<?php
get_header ();
set_views(get_the_ID());
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">
			<?php panggil_breadcrumb ();?>
		<div class="container">
			<div class="row justify-content-center">

				<div class="col-sm-10 col-md-10 col-lg-10 col-12">
					<?php

						if ( have_posts() ) :
							while ( have_posts() ) : the_post();

								get_template_part( 'tp/single', get_post_format() );

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

<?php get_footer (); ?>
