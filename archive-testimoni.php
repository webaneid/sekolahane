<?php get_header(); ?>
<div id="primary" class="content-area ane-cpt-arsip">
	<main id="main" class="site-main" role="main">
	<?php panggil_breadcrumb ();?>
	<div class="container">
			<header class="entry-header">
				<div class="judul-arsip">
					<?php
					post_type_archive_title( '<h1 class="general-title">', '</h1>' );
					?>
				</div>
			</header>
				<div class="content-testimoni">
					<div class="row justify-content-center text-center">

						<?php
						if ( have_posts() ) :
						while ( have_posts() ) : the_post();
						echo '<div class="col-lg-4 col-md-4 col-sm-4">';
						get_template_part ( 'tp/content','testimoni' );
						echo '</div>';
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
