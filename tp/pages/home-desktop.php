<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('landing-page'); ?>>
	<?php
	if( have_rows('home_content') ):
		while( have_rows('home_content') ): the_row();

		if( get_row_layout() == 'home_box_slider' ):
		get_template_part('tp/section/big-slider');

			elseif( get_row_layout() == 'home_featured' ):
			get_template_part('tp/section/featured');

			elseif( get_row_layout() == 'home_cta' ):
			get_template_part('tp/section/calltoaction');

			elseif( get_row_layout() == 'home_testimoni' ):
			get_template_part('tp/section/testimoni');

			elseif( get_row_layout() == 'home_ekstrakurikuler' ):
			get_template_part('tp/section/ekstra');

			elseif( get_row_layout() == 'home_guru' ):
			get_template_part('tp/section/guru');

			elseif( get_row_layout() == 'home_funfact' ):
			get_template_part('tp/section/funfact');

			elseif( get_row_layout() == 'home_banner' ):
			get_template_part('tp/section/banner');

					elseif( get_row_layout() == 'home_default' ):
		            get_template_part('tp/news/default');

					elseif( get_row_layout() == 'home_sliding' ):
		            get_template_part('tp/news/sliding');

					elseif( get_row_layout() == 'news_columns' ):
		            get_template_part('tp/news/column');

					elseif( get_row_layout() == 'home_classic' ):
		            get_template_part('tp/news/classic');

		    endif;
		endwhile;
	endif; ?>
</article>
