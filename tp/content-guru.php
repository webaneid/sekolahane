<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ane-konten-guru'); ?>>
	<a href="<?php echo esc_url( get_permalink() ); ?>">
		<header class="entry-header">
			<div class="ane-image">
				<?php
				if ( has_post_thumbnail() ) {
					$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'kotak' );
					$imgurl = is_array( $thumbImg ) ? $thumbImg[0] : '';
					echo '<img src="' . esc_url( $imgurl ) . '" alt="Guru">';
				}
				else {
					echo '<img src="' . esc_url( sekolahane_dummy_tumbnail() ) . '" alt="Guru">';
				}
				?>
			</div>
		</header><!-- .entry-header -->

		<div class="entry-content text-center">
			<h2><?php the_title(); ?></h2>
			<p><?php echo esc_html( (string) get_field( 'ane_jabatan' ) ); ?></p>
		</div><!-- .entry-content -->
	</a>

</article>
