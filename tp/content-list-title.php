<article id="post-<?php the_ID(); ?>" <?php post_class('ane-konten-lis-title'); ?>>
		<?php the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			$timestamp = esc_attr( get_the_time( 'U' ) );
		 ?>
</article>
