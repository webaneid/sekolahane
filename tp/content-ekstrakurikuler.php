<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ane-konten-overlay'); ?>>
	<?php
	if ( has_post_thumbnail() ) {
		$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );
		$imgurl = is_array( $thumbImg ) ? $thumbImg[0] : '';
		echo '<header class="entry-header" style="background-image:url(' . esc_url( $imgurl ) . ')">';
	}
	else {
		echo '<header class="entry-header" style="background-image:url(' . esc_url( sekolahane_dummy_tumbnail() ) . ')">';
	}
	?>
	<div class="post-content">
		<?php the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		 ?>
	</div>
</article>
