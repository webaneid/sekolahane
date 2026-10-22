<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ane-konten-overlay'); ?>>
	<?php if ( has_post_thumbnail() ) {
	$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
	$imgurl = $thumbImg['0'];
	echo '<header class="entry-header" style="background-image:url('.$imgurl.')">';
	}
	else {
		$url = ane_get_embedded_media( array('video','iframe') );
		$size = 'maxres'; // default, hq, mq, sd, maxres
		$urls = ane_get_youtube_thumbnail($url, $size);
		echo '<header class="entry-header" style="background-image:url('.$urls.')">';
	}
	?>
		<div class="post-content">
			<?php the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			 ?>
			 <div class="ane-meta">
				<ul>
					<li><?php $categories = get_the_category();
						foreach ($categories as $category){
						echo '<a class="post-cat" href="' . esc_url( get_category_link($category->term_id) ) . '">' . esc_html( $category->name ) . '</a>';
						}
						$timestamp = esc_attr( get_the_time( 'U' ) );
					?></li>
					<li><?php echo ane_load_times_ago(); ?></li>
				</ul>
			</div>
		</div>
	</header>
</article>
