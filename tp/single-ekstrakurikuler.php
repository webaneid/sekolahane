<article id="post-<?php the_ID(); ?>" <?php post_class('ane-page-default'); ?>>
<div class="container-fluid">
	<div class="row">
		<?php
			if ( has_post_thumbnail() ) {
				$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
				$imgurl = $thumbImg['0'];
				echo '<header class="entry-header" style="background-image:url('.$imgurl.')"></header>';
			}
		?>

	</div>
	<div class="row">
		<?php panggil_breadcrumb ();?>
	</div>

</div>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-9">
				<div class="entry-content">
					<div class="ane-content">
						<div class="ane-title">
							<?php the_title( sprintf( '<h1 class="post-title general-title">', esc_url( get_permalink() ) ), '</h1>' ); ?>
						</div>

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
						 	$second_query = new WP_Query( array(
						      'post_type' => 'ekstrakurikuler',
						      'posts_per_page' => 4,
						      'ignore_sticky_posts' => 1,
						      'orderby' => 'rand',
						      'post__not_in'=>array($post->ID)
						   ) );

					    if($second_query->have_posts()): ?>
						<h2><?php _e('Ekstrakurikuler Lain', 'sekolahane'); ?></h2>

							<div class="testimoni-slider owl-carousel">
								 <?php while ($second_query->have_posts() ) : $second_query->the_post();
								 	get_template_part( 'tp/content', 'ekstrakurikuler' );
								endwhile; wp_reset_query(); ?>
							</div>
					 	<?php endif; ?>

					</div>

				</div>


			</div>

		</div>

	</div>




</article>
