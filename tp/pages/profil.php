<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('landing-page ane-page-profil'); ?>>
<div class="container-fluid">
	<div class="row">
		<?php
			if ( has_post_thumbnail() ) {
				$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
				$imgurl = $thumbImg['0'];
				echo '<header class="entry-header" style="background-image:url('.$imgurl.')">';
			}
			else {
				echo '<header class="entry-header" style="background-image:url('.ane_dummy_tumbnail().')">';
			}
		?>
            <div class="container">
                <div class="isi">
                    <div class="text-isi">
                        <?php the_title( '<h1 class="post-title general-title">', '</h1>' );
                        $headline = get_field ('ane_headline');
                            echo '<p>'.esc_html( (string) $headline ).'</p>';
                        ?>
                    </div>
                </div>
            </div>
        </header>

	</div>
</div>

<div class="entry-content">
    <?php get_template_part('tp/section/angka'); ?>
    <?php
    if( have_rows('profil_content') ):
        while( have_rows('profil_content') ): the_row();

            if( get_row_layout() == 'home_featured' ):
            get_template_part('tp/section/featured');

                elseif( get_row_layout() == 'home_cta' ):
                get_template_part('tp/section/calltoaction');

                elseif( get_row_layout() == 'home_testimoni' ):
                get_template_part('tp/section/testimoni');

                elseif( get_row_layout() == 'ane_content_profil' ):
                get_template_part('tp/section/content');

                elseif( get_row_layout() == 'home_ekstrakurikuler' ):
                get_template_part('tp/section/ekstra');

                elseif( get_row_layout() == 'home_guru' ):
                get_template_part('tp/section/guru-v2');

                elseif( get_row_layout() == 'home_banner' ):
                get_template_part('tp/section/banner');

            endif;
        endwhile;
    endif;
	?>
	<div class="ane-mobile-list">
		<div class="container">
			<?php get_template_part ('tp/mobile/menu-lembaga'); ?>
		</div>
	</div>
</div>
</article>
