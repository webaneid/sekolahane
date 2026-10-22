<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ane-mobile-cat'); ?>>
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<div class="isi">

				<div class="pilih-kategori">
					<?php if( get_field('ane_aktif') ) {
							echo "<h1>Pilih Kategori</h1>";
							get_template_part ('tp/mobile/kategori-menu');
						}
					?>
				</div>
				<h1>Konten Terbaru</h1>
						<?php

							if ( get_query_var('paged') ) {
								$paged = get_query_var('paged');
							} elseif ( get_query_var('page') ) {
								$paged = get_query_var('page');
							} else {
								$paged = 1;
							}
							if(1 == $paged) {
								get_template_part('tp/news', 'featured-mobile');
							}
							$mobile_query_args = array(
								'post_type' => 'post',
								'posts_per_page' => 15,
								'paged' => $paged,
								'post_status' => 'publish',
							);
							$mobile_query = new WP_Query( $mobile_query_args );

							echo '<section class="ane-newest">';
								if ( $mobile_query->have_posts() ) :
									$counter = -1; while( $mobile_query->have_posts() ) : $mobile_query->the_post();

										$counter++;

											if($counter == 7){
												get_template_part( 'tp/content','list' );
												get_template_part('tp/mobile','news-populer');
											}

											else {
												get_template_part( 'tp/content','list' );

										}


									endwhile; wp_reset_postdata();

								echo '</section>';

							if ($mobile_query->max_num_pages > 1) :
								$orig_query = $wp_query;
								$wp_query = $mobile_query;
									echo ane_post_pagination();
								$wp_query = $orig_query;
							endif;
							// wp_reset_postdata(); // reset the query
							else:
								echo '<p>'.__('Sorry, no posts matched your criteria.').'</p>';
							endif;
						?>
			</div>

		</div>
	</div>
</div>
</article>
