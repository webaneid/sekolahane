<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ane-single-guru'); ?>>
		<?php
			$imgurl = ane_dummy_kotak();
			if ( has_post_thumbnail() ) {
				$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'kotak' );
				if ( is_array( $thumbImg ) && ! empty( $thumbImg[0] ) ) {
					$imgurl = $thumbImg[0];
				}
			}
		?>
		<header class="entry-header">
			<div class="ane-image">
				<img src="<?php echo esc_url( $imgurl ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
			</div>
		</header>

		<div class="entry-content">
			<div class="ane-title">
				<?php the_title( '<h1 class="post-title">', '<span>' . esc_html( (string) get_field( 'ane_jabatan' ) ) . '</span></h1>' ); ?>
			</div>
			<div class="ane-content">
				<figure class="wp-block-table">
					<table>
						<tbody>
							<tr>
								<td>Pelajaran</td>
								<td>
									<div class="content-category">
										<?php
										$categories = get_the_terms( get_the_ID(), 'pelajaran' );
										if ( is_array( $categories ) ) {
											foreach ( $categories as $category ) {
												echo '<a class="post-cat" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
											}
										}
										?>
									</div>
								</td>
							</tr>
							<tr>
								<td>Kelas</td>
								<td>
									<div class="content-category">
										<?php
										$kelas = get_the_terms( get_the_ID(), 'Kelas' );
										if ( is_array( $kelas ) ) {
											foreach ( $kelas as $kel ) {
												echo '<a class="post-cat" href="' . esc_url( get_category_link( $kel->term_id ) ) . '">' . esc_html( $kel->name ) . '</a>';
											}
										}
										?>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</figure>

				<?php the_content();?>
				<div class="share-this">
				<?= fungsi_share_webane(); ?>
				</div>

				<div class="comments-form">
					<?= fungsi_komen_facebook_webane(); ?>
				</div>
			</div>
			<div class="konten-terkait-v2">
					<?php
						$terms    = get_the_terms( get_the_ID(), 'Kelas' );
						$term_ids = is_array( $terms ) ? wp_list_pluck( $terms, 'term_id' ) : array();
					 	$second_query = new WP_Query( array(
					      'post_type' => 'guru',
					      'tax_query' => array(
					                    array(
					                        'taxonomy' => 'Kelas',
					                        'field' => 'id',
					                        'terms' => $term_ids,
					                        'operator'=> 'IN'
					                     )),
					      'posts_per_page' => 4,
					      'ignore_sticky_posts' => 1,
					      'orderby' => 'rand',
					      'post__not_in'=>array( get_the_ID() )
					   ) );

				    if($second_query->have_posts()): ?>
					<h2><?php _e('Guru Kelas Yang Sama', 'sekolahane'); ?></h2>

						<div class="testimoni-slider owl-carousel">
							 <?php while ($second_query->have_posts() ) : $second_query->the_post();
							 get_template_part( 'tp/content', 'guru' );
						 	endwhile; wp_reset_postdata(); ?>
						</div>
				 	<?php endif; ?>


			</div>
			<div class="konten-terkait-v2">
				<?php
					$terms    = get_the_terms( get_the_ID(), 'pelajaran' );
					$term_ids = is_array( $terms ) ? wp_list_pluck( $terms, 'term_id' ) : array();
					$second_query = new WP_Query( array(
					  'post_type' => 'guru',
					  'tax_query' => array(
									array(
										'taxonomy' => 'pelajaran',
										'field' => 'id',
										'terms' => $term_ids,
										'operator'=> 'IN'
									 )),
					  'posts_per_page' => 4,
					  'ignore_sticky_posts' => 1,
					  'orderby' => 'rand',
					  'post__not_in'=>array( get_the_ID() )
				   ) );

				if($second_query->have_posts()): ?>
					<h2><?php _e('Guru Pelajaran Yang Sama', 'sekolahane'); ?></h2>

					<div class="testimoni-slider owl-carousel">
						 <?php while ($second_query->have_posts() ) : $second_query->the_post();
						 get_template_part( 'tp/content', 'guru' );
						endwhile; wp_reset_postdata(); ?>
					</div>
				<?php endif; ?>
			</div>

		</div>

</article>
