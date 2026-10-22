<?php

	if ( has_post_thumbnail() ) {
		$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'kotak');
			$thumbImgUrl = $thumbImg['0'];
		}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ane-konten-testimoni'); ?>>
	<header>
		<?php $isi = get_field('ane_testimoni'); ?>
		<span><?php echo $isi; ?></span>
	</header>
	<div class="post-content">
		<div class="fotonya">
			<?php
			if ( has_post_thumbnail() ) {
				$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'kotak');
					$photo = $thumbImg['0'];
				echo '<img src="' .$photo. '" alt="Testimoni">';
			}
			?>
		</div>
		<div class="orangnya">
			<h6><?php the_title( sprintf( '<a href="/testimoni" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); ?>
				<?php $jabatan = get_field('ane_jabatan'); ?>
				<span><?php echo $jabatan; ?></span>
			</h6>
		</div>
	</div>
</article>
