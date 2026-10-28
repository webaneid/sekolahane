<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('landing-page'); ?>>
	<?php
		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}
		if(1 == $paged) {
			if( have_rows('home_content') ):
				while( have_rows('home_content') ): the_row();

				if( get_row_layout() == 'home_box_slider' ):
				get_template_part('tp/section/big-slider');

					elseif( get_row_layout() == 'home_featured' ):
					get_template_part('tp/section/featured');

					elseif( get_row_layout() == 'home_cta' ):
					get_template_part('tp/section/calltoaction');

					elseif( get_row_layout() == 'home_testimoni' ):
					get_template_part('tp/section/testimoni');

					elseif( get_row_layout() == 'home_ekstrakurikuler' ):
					get_template_part('tp/section/ekstra');

					elseif( get_row_layout() == 'home_guru' ):
					get_template_part('tp/section/guru');

					elseif( get_row_layout() == 'home_funfact' ):
					get_template_part('tp/section/funfact');

				    endif;
				endwhile;
			endif;
		}
		$mobile_query_args = array(
			'post_type' => 'post',
			'posts_per_page' => 10,
			'paged' => $paged,
			'post_status' => 'publish',
		);
		$mobile_query = new WP_Query( $mobile_query_args );

		echo '<section class="ane-post-mobile">';
			echo '<div class="home-title">
			<h2>Informasi <span>Terbaru</span>
			</div>
			';
			if ( $mobile_query->have_posts() ) :
				$counter = -1; while( $mobile_query->have_posts() ) : $mobile_query->the_post();

					$counter++;
						if($counter == 4){

							get_template_part( 'tp/content','overlay');

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
			echo '<p>' . esc_html__( 'Sorry, no posts matched your criteria.', 'sekolahane' ) . '</p>';
		endif;
		if( have_rows('home_content') ):
			while( have_rows('home_content') ): the_row();
				if( get_row_layout() == 'home_banner' ):
					get_template_part('tp/section/banner');
				endif;
			endwhile;
		endif;

	?>
</article>
