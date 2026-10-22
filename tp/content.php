<article id="post-<?php the_ID(); ?>" <?php post_class('ane-konten-default'); ?>>
	<div class="row">
		<div class="col-md-5 col-5 post-tengah prm-5">
			<header class="entry-header">
				<?php if ( has_post_thumbnail() ) {
				$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
				$imgurl = $thumbImg['0'];
				echo '<a href="'. get_permalink( $post->ID ).'"><div class="ane-image"><img src="'. $imgurl .'"></div></a>';
				}
				else {
					echo '<a href="'. get_permalink( $post->ID ).'"><div class="img-100"><img src="https://dummyimage.com/700x394/f1f1f1/545454.jpg&text=Set+Your+Featured+Image+(700x394+pixel)" alt="' . esc_html( get_the_title() ). '"></div></a></a><div class="icon-content"></div>';
				}
				?>
			</header>
		</div>

		<div class="col-md-7 col-7 p-0 post-tengah">
			<div class="post-content">
				<?php the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
				 ?>
				 <div class="ane-meta">
	 				<ul>
	 					<li><?php $categories = get_the_category();
	 						foreach ($categories as $category){
	 						echo '<a class="post-cat" href="' . get_category_link($category->term_id) . '">' . $category->cat_name . '</a>';
	 						}
	 						$timestamp = esc_attr( get_the_time( 'U' ) );
	 					?></li>
	 					<li><?php echo ane_load_times_ago(); ?></li>
	 				</ul>
	 			</div>
				 <div class="hidden-mobile">
				 	<?php the_excerpt(); ?>
				 </div>
			</div>
		</div>
	</div>
</article>
