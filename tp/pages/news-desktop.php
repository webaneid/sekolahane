<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('landing-page ane-page-blog'); ?>>
	<?php
	if( have_rows('blog_content') ):
		while( have_rows('blog_content') ): the_row();

			if( get_row_layout() == 'home_default' ):
			get_template_part('tp/news/default');

				elseif( get_row_layout() == 'home_sliding' ):
		        get_template_part('tp/news/sliding');

				elseif( get_row_layout() == 'news_columns' ):
		        get_template_part('tp/news/column');

				elseif( get_row_layout() == 'home_classic' ):
		        get_template_part('tp/news/classic');

				elseif( get_row_layout() == 'home_banner' ):
				get_template_part('tp/section/banner');

				elseif( get_row_layout() == 'home_cta' ):
				get_template_part('tp/section/calltoaction');

		    endif;
		endwhile;
	endif; ?>
</article>
