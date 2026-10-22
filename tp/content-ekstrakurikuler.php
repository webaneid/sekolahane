<article id="post-<?php the_ID(); ?>" <?php post_class('ane-konten-overlay'); ?>>
	<?php
	if ( has_post_thumbnail() ) {
		$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
		$imgurl = $thumbImg['0'];
		echo '<header class="entry-header" style="background-image:url('.$imgurl.')">';
	}
	else {
		echo '<header class="entry-header" style="background-image:url('.sekolahane_dummy_tumbnail().')">';
	}
	?>
	<div class="post-content">
		<?php the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		 ?>
	</div>
</article>
