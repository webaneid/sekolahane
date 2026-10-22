<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ane-page-default'); ?>>
<div class="container-fluid">
	<div class="row">
		<?php
			if ( has_post_thumbnail() ) {
				$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
				$imgurl = is_array( $thumbImg ) ? $thumbImg[0] : '';
				echo '<header class="entry-header" style="background-image:url(' . esc_url( $imgurl ) . ')"></header>';
			}
			else {
				echo '<header class="entry-header" style="background-image:url(' . esc_url( sekolahane_dummy_tumbnail() ) . ')"></header>';
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
							<?php the_title( '<h1 class="post-title general-title">', '</h1>' ); ?>
						</div>

						<?php the_content();?>
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
