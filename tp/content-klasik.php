<article id="post-<?php the_ID(); ?>" <?php post_class('ane-konten-klasik'); ?>>
		<header class="entry-header">
				<?php if ( has_post_thumbnail() ) {
				$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
				$imgurl = $thumbImg['0'];
				echo '<a href="'. get_permalink( $post->ID ).'"><div class="ane-image"><img src="'. $imgurl .'" alt="' . esc_html( get_the_title() ). '" title="' . esc_html( get_the_title() ). '"></div></a>';
				}
				else {
					$url = ane_get_embedded_media( array('video','iframe') );
					$size = 'mq'; // default, hq, mq, sd, maxres
					$urls = ane_get_youtube_thumbnail($url, $size);
					echo '<a href="'. get_permalink( $post->ID ).'"><div class="ane-image"><img src="' .$urls.'" alt="' . esc_html( get_the_title() ). '" title="' . esc_html( get_the_title() ). '"></div></a><div class="icon-content"></div>';
				}
				?>
		</header>
		<div class="post-content">
			<?php the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			 ?>
			 <div class="post-meta-info">
 			   <ul>
 				  <li>
 					  <div class="content-category">
 						  <?php $categories = get_the_category();
 							  foreach ($categories as $category){
 							  echo '<a href="' . get_category_link($category->term_id) . '">' . $category->cat_name . '</a>';
 							  }
 						  ?>
 					  </div>
 				  </li>
 				  <li><?php echo ane_load_times_ago(); ?></li>
 			   </ul>
 			</div>
			<?php the_excerpt(); ?>
		</div>
</article>
