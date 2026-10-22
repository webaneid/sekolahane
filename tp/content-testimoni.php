<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-konten-testimoni' ); ?>>
	<header>
		<?php $isi = (string) get_field( 'ane_testimoni' ); ?>
		<span><?php echo wp_kses_post( $isi ); ?></span>
	</header>
	<div class="post-content">
		<div class="fotonya">
			<?php
			if ( has_post_thumbnail() ) {
				$thumb_img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'kotak' );
				if ( is_array( $thumb_img ) && ! empty( $thumb_img[0] ) ) {
					echo '<img src="' . esc_url( $thumb_img[0] ) . '" alt="Testimoni">';
				}
			}
			?>
		</div>
		<div class="orangnya">
			<h6><?php the_title( '<a href="' . esc_url( home_url( '/testimoni' ) ) . '" rel="bookmark">', '</a>' ); ?>
				<?php $jabatan = (string) get_field( 'ane_jabatan' ); ?>
				<span><?php echo esc_html( $jabatan ); ?></span>
			</h6>
		</div>
	</div>
</article>
