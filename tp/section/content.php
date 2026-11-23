<?php
/**
 * Template part: Section Profil Konten (`tp/section/content.php`).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="ane-profil-konten">
	<div class="container">
		<div class="row">
			<div class="col-md-5">
				<?php
				if ( has_post_thumbnail() ) {
					$sekolahane_thumb_id = (int) get_post_thumbnail_id( get_the_ID() );
					$sekolahane_size     = wp_is_mobile() ? 'thumbnail' : 'large';
					$sekolahane_thumb    = wp_get_attachment_image_src( $sekolahane_thumb_id, $sekolahane_size );
					$sekolahane_img_url  = ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[0] ) ) ? (string) $sekolahane_thumb[0] : '';
					$sekolahane_img_w    = ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[1] ) ) ? (int) $sekolahane_thumb[1] : 1000;
					$sekolahane_img_h    = ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[2] ) ) ? (int) $sekolahane_thumb[2] : 563;
					$sekolahane_srcset   = (string) wp_get_attachment_image_srcset( $sekolahane_thumb_id, $sekolahane_size );

					if ( '' !== $sekolahane_img_url ) {
						echo '<div class="ane-image"><img src="' . esc_url( $sekolahane_img_url ) . '"' . ( '' !== $sekolahane_srcset ? ' srcset="' . esc_attr( $sekolahane_srcset ) . '" sizes="(max-width: 767px) 400px, 500px"' : '' ) . ' width="' . esc_attr( (string) $sekolahane_img_w ) . '" height="' . esc_attr( (string) $sekolahane_img_h ) . '" alt="' . esc_attr( get_the_title() ) . '" title="' . esc_attr( get_the_title() ) . '" loading="lazy" decoding="async"></div>';
					}
				}
				?>
			</div>
			<div class="col-md-7">
				<div class="ane-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
