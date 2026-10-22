<?php
defined( 'ABSPATH' ) || exit;
?>
<section class="ane-profil-konten">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <?php if ( has_post_thumbnail() ) {
    				$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
    				$imgurl = is_array( $thumbImg ) ? $thumbImg[0] : '';
                    $title = get_the_title();
    				echo '<div class="ane-image"><img src="' . esc_url( $imgurl ) . '" alt="' . esc_attr( $title ) . '" title="' . esc_attr( $title ) . '"></div>';
    			} ?>
            </div>
            <div class="col-md-7">
                <div class="ane-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>

    </div>
</section>
