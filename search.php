<?php
/**
 * Template hasil pencarian.
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php panggil_breadcrumb(); ?>

		<div class="container"><div class="row">
				<div class="col-lg-12">
					<div class="judul-arsip">
						<h3 class="general-title">
							<?php
							printf(
								/* translators: %s: kata kunci pencarian */
								esc_html__( 'Hasil Pencarian: %s', 'sekolahane' ),
								'<span>' . esc_html( get_search_query() ) . '</span>'
							);
							?>
						</h3>
						<?php get_search_form(); ?>
					</div>
				</div>
				<div class="col-lg-8 pm-0">
					<div class="ane-arsip-post">
						<?php
						if ( have_posts() ) :
							$counter = -1;
							while ( have_posts() ) :
								the_post();
								++$counter;
								if ( 0 === $counter ) {
									if ( wp_is_mobile() ) {
										get_template_part( 'tp/content', 'overlay' );
									} else {
										get_template_part( 'tp/content', 'klasik' );
									}
								} elseif ( 5 === $counter ) {
									get_template_part( 'tp/content', 'overlay' );
								} else {
									if ( wp_is_mobile() ) {
										get_template_part( 'tp/content', 'list' );
									} else {
										get_template_part( 'tp/content', (string) get_post_format() );
									}
								}
							endwhile;
						else :
							get_template_part( 'tp/content', 'none' );
						endif;

						ane_post_pagination();
						?>
					</div>
				</div>

				<?php get_sidebar(); ?>

		</div></div>
	</main><!-- .site-main -->
</div><!-- .content-area -->
<?php
get_footer();
