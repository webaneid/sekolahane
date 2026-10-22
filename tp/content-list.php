<article id="post-<?php the_ID(); ?>" <?php post_class('ane-konten-lis'); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() ) {
		$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'kotak');
		$imgurl = $thumbImg['0'];
		echo '<a href="'. get_permalink( $post->ID ).'"><div class="ane-image"><img src="'. $imgurl .'" alt="' . esc_html( get_the_title() ). '" title="' . esc_html( get_the_title() ). '"></div></a>';
		}

		?>
	</header>
	<div class="entry-content">
		<?php the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			$timestamp = esc_attr( get_the_time( 'U' ) );
		 ?>
		 <div class="ane-meta">
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
	</div>
</article>
