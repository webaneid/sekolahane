<article id="post-<?php the_ID(); ?>" <?php post_class('ane-page-default ane-page-kelembagaan'); ?>>
<div class="container-fluid">
	<div class="row">
		<?php
			if ( has_post_thumbnail() ) {
				$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
				$imgurl = $thumbImg['0'];
				echo '<header class="entry-header" style="background-image:url('.$imgurl.')"></header>';
			}
			else {
				echo '<header class="entry-header" style="background-image:url('.ane_dummy_tumbnail().')"></header>';
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
						<?php get_template_part ('tp/mobile/menu-lembaga'); ?>
						<div class="share-this">
						<?= fungsi_share_webane(); ?>
						</div>

						<div class="comments-form">
							<?= fungsi_komen_facebook_webane(); ?>
						</div>
					</div>
				</div>

			</div>

		</div>

	</div>




</article>
