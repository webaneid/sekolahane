<?php
defined( 'ABSPATH' ) || exit;

$gambar = ane_dummy_tumbnail();
if ( has_post_thumbnail() ) {
	$thumb_img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
	if ( is_array( $thumb_img ) && ! empty( $thumb_img[0] ) ) {
		$gambar = $thumb_img[0];
	}
}
$sologan   = esc_html( (string) get_field( 'contact_sologan' ) );
$idcontact = (string) get_field( 'cf7_id' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-page-kontak' ); ?>>
	<div class="container">
		<header class="entry-header">
			<div class="row">
				<div class="col-md-6 post-tengah">
					<div class="ane-title">
						<div class="sub-judul">
							<?php the_title(); ?>
						</div>
						<h2><?php echo esc_html( $sologan ); ?></h2>
					</div>
				</div>
				<div class="col-md-6">
					<div class="ane-image">
						<img src="<?php echo esc_url( $gambar ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
					</div>
				</div>
			</div>
		</header>

	<div class="entry-content">
			<div class="row">
				<div class="col-md-7">
				<?php echo do_shortcode( '[contact-form-7 id="' . esc_attr( $idcontact ) . '" title="Contact form 1"]' ); ?>
				</div>
				<div class="col-md-5">
					<div class="widget">
						<div class="widget-title"><h4><?php esc_html_e( 'Lets have a cup of coffee', 'sekolahane' ); ?></h4></div>
						<?php
						$location = get_field( 'gmap', 'option' );
						if ( is_array( $location ) && ! empty( $location['lat'] ) && ! empty( $location['lng'] ) ) :
							$lat     = (string) $location['lat'];
							$lng     = (string) $location['lng'];
							$address = isset( $location['address'] ) ? (string) $location['address'] : '';
							?>
							<div class="acf-map">
								<div class="marker" data-lat="<?php echo esc_attr( $lat ); ?>" data-lng="<?php echo esc_attr( $lng ); ?>">
									<a class="directions" href="<?php echo esc_url( 'https://www.google.com/maps?saddr=My+Location&daddr=' . rawurlencode( $lat . ',' . $lng ) ); ?>"><?php esc_html_e( 'Get Directions to', 'sekolahane' ); ?> <?php echo esc_html( $address ); ?></a>
								</div>
							</div>
						<?php endif; ?>

						<div class="widget-title"><h4><?php esc_html_e( 'or just say hello here', 'sekolahane' ); ?></h4></div>

						<?php get_template_part( 'tp/content', 'sosmed' ); ?>
					</div>
				</div>
			</div>
	</div>

	<?php
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( '<i class="ane ane-pen"></i> Edit<span class="screen-reader-text"> %s</span>', 'sekolahane' ),
				get_the_title()
			),
			'<footer class="entry-edit"><span class="btn btn-dark">',
			'</span></footer><!-- .entry-footer -->'
		);
	?>

</div><!-- .container-## -->
</article><!-- #post-## -->
