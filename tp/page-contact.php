<?php
	if ( has_post_thumbnail() ) {
		$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
			$gambar = $thumbImg['0'];
		}
	$sologan = esc_attr (get_field('contact_sologan') );
	$idcontact = get_field('cf7_id');
	$perusahaan = get_field('company_name', 'option');
	$alamat = get_field('alamat_lengkap', 'option');
	$telp = get_field('contact_telephone', 'option');
	$haribuka = get_field('hari_buka', 'option');
	$jambuka = get_field('jam_buka', 'option');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ane-page-kontak'); ?>>
	<div class="container">
		<header class="entry-header">
			<div class="row">
				<div class="col-md-6 post-tengah">
					<div class="ane-title">
						<div class="sub-judul">
							<?php the_title(); ?>
						</div>
						<h2><?php echo $sologan; ?></h2>
					</div>
				</div>
				<div class="col-md-6">
					<div class="ane-image">
						<img src="<?php echo $gambar; ?>">
					</div>
				</div>
			</div>
		</header>

	<div class="entry-content">
			<div class="row">
				<div class="col-md-7">
				<?php echo do_shortcode( '[contact-form-7 id="'.$idcontact.'" title="Contact form 1"]' ); ?>
				</div>
				<div class="col-md-5">
					<div class="widget">
						<div class="widget-title"><h4><?php esc_html_e( 'Lets have a cup of coffee' ); ?></h4></div>
						<?php

								$location = get_field('gmap', 'option');

								if( !empty($location) ):
								?>
								<div class="acf-map">
									<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
										 <a class="directions" href="https://www.google.com/maps?saddr=My+Location&daddr=<?php echo $location['lat'] . ',' . $location['lng']; ?>"><?php _e('Get Directions to','roots'); ?> <?php echo $location['address']; ?></a> <!-- Output the title -->
									</div>
								</div>

								<?php endif; ?>

								<div class="widget-title"><h4><?php esc_html_e( 'or just say hello here' ); ?></h4></div>

								<?php panggil_sosial_media(); ?>
					</div>
				</div>
			</div>
	</div>

	<?php
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( '<i class="ane ane-pen"></i> Edit<span class="screen-reader-text"> </span>', 'twentysixteen' ),
				get_the_title()
			),
			'<footer class="entry-edit"><span class="btn btn-dark">',
			'</span></footer><!-- .entry-footer -->'
		);
	?>

</div><!-- .container-## -->
</article><!-- #post-## -->
