<article id="post-<?php the_ID(); ?>" <?php post_class('landing-page'); ?>>
	<?php
	if( have_rows('home_content') ):
		while( have_rows('home_content') ): the_row();

		if( get_row_layout() == 'home_box_slider' ):
		get_template_part('tp/home','slider');

		    endif;
		endwhile;
	endif; ?>

</article>
