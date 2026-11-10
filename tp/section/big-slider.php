<?php
/**
 * Section Hero Big Slider (Landing Page).
 *
 * Mendukung pengaturan posisi teks (kiri/tengah/kanan), overlay gelap atau asli,
 * teks opsional yang aman (hanya muncul bila diisi), serta opsi marking lengkungan bawah.
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_raw_curve  = get_sub_field( 'ane_slider_curve' );
$sekolahane_show_curve = ( null === $sekolahane_raw_curve || '' === $sekolahane_raw_curve ) ? true : (bool) $sekolahane_raw_curve;
?>
<section class="home-slider v2<?php echo $sekolahane_show_curve ? ' has-curve' : ' no-curve'; ?>">
	<div class="home-big-slider owl-carousel">
		<?php
		if ( have_rows( 'home_slider' ) ) :
			$sekolahane_slide_idx = 0;
			while ( have_rows( 'home_slider' ) ) :
				the_row();
				$sekolahane_bg          = trim( (string) get_sub_field( 'ane_background' ) );
				$sekolahane_judul       = trim( wp_strip_all_tags( (string) get_sub_field( 'ane_title' ) ) );
				$sekolahane_deskripsi   = trim( wp_strip_all_tags( (string) get_sub_field( 'ane_deskripsi' ) ) );
				$sekolahane_link        = get_sub_field( 'ane_link' );
				$sekolahane_link_url    = ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['url'] ) ) ? trim( (string) $sekolahane_link['url'] ) : '';
				$sekolahane_link_title  = ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['title'] ) ) ? trim( wp_strip_all_tags( (string) $sekolahane_link['title'] ) ) : '';
				$sekolahane_link_target = ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['target'] ) ) ? trim( (string) $sekolahane_link['target'] ) : '';

				$sekolahane_align_map   = array(
					'left'   => 'text-pos-left',
					'center' => 'text-pos-center',
					'right'  => 'text-pos-right',
				);
				$sekolahane_align_raw   = (string) get_sub_field( 'ane_text_align' );
				$sekolahane_align_class = isset( $sekolahane_align_map[ $sekolahane_align_raw ] ) ? $sekolahane_align_map[ $sekolahane_align_raw ] : 'text-pos-left';

				$sekolahane_overlay_raw   = (string) get_sub_field( 'ane_overlay' );
				$sekolahane_overlay_class = ( 'none' === $sekolahane_overlay_raw ) ? 'no-overlay' : 'has-overlay';

				$sekolahane_has_text = ( '' !== $sekolahane_judul || '' !== $sekolahane_deskripsi || ( '' !== $sekolahane_link_url && '' !== $sekolahane_link_title ) );
				$sekolahane_item_cls = 'home-slider-item ' . $sekolahane_align_class . ' ' . $sekolahane_overlay_class;
				$sekolahane_img_alt  = '' !== $sekolahane_judul ? $sekolahane_judul : (string) get_bloginfo( 'name' );

				$sekolahane_img_src    = $sekolahane_bg;
				$sekolahane_img_srcset = '';
				$sekolahane_img_w      = 1280;
				$sekolahane_img_h      = 720;

				if ( '' !== $sekolahane_bg ) {
					$sekolahane_att_id = sekolahane_get_attachment_id_from_url( $sekolahane_bg );
					if ( $sekolahane_att_id > 0 ) {
						$sekolahane_size = wp_is_mobile() ? 'medium' : 'large';
						$sekolahane_data = wp_get_attachment_image_src( $sekolahane_att_id, $sekolahane_size );
						if ( is_array( $sekolahane_data ) && ! empty( $sekolahane_data[0] ) ) {
							$sekolahane_img_src = (string) $sekolahane_data[0];
							$sekolahane_img_w   = ! empty( $sekolahane_data[1] ) ? (int) $sekolahane_data[1] : 1000;
							$sekolahane_img_h   = ! empty( $sekolahane_data[2] ) ? (int) $sekolahane_data[2] : 563;
						}
						$sekolahane_img_srcset = (string) wp_get_attachment_image_srcset( $sekolahane_att_id, $sekolahane_size );
					}
				}
				?>
				<div class="<?php echo esc_attr( $sekolahane_item_cls ); ?>">
					<?php if ( '' !== $sekolahane_img_src ) : ?>
						<?php if ( 0 === $sekolahane_slide_idx ) : ?>
							<img class="home-slider-bg" src="<?php echo esc_url( $sekolahane_img_src ); ?>"<?php echo '' !== $sekolahane_img_srcset ? ' srcset="' . esc_attr( $sekolahane_img_srcset ) . '" sizes="(max-width: 767px) 240px, 100vw"' : ''; ?> width="<?php echo esc_attr( (string) $sekolahane_img_w ); ?>" height="<?php echo esc_attr( (string) $sekolahane_img_h ); ?>" alt="<?php echo esc_attr( $sekolahane_img_alt ); ?>" fetchpriority="high" decoding="async">
						<?php else : ?>
							<img class="home-slider-bg" src="<?php echo esc_url( $sekolahane_img_src ); ?>"<?php echo '' !== $sekolahane_img_srcset ? ' srcset="' . esc_attr( $sekolahane_img_srcset ) . '" sizes="(max-width: 767px) 240px, 100vw"' : ''; ?> width="<?php echo esc_attr( (string) $sekolahane_img_w ); ?>" height="<?php echo esc_attr( (string) $sekolahane_img_h ); ?>" alt="<?php echo esc_attr( $sekolahane_img_alt ); ?>" loading="lazy" fetchpriority="low" decoding="async">
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( $sekolahane_has_text ) : ?>
						<div class="container">
							<div class="text">
								<div class="text-content">
									<?php if ( '' !== $sekolahane_judul ) : ?>
										<h1><?php echo esc_html( $sekolahane_judul ); ?></h1>
									<?php endif; ?>

									<?php if ( '' !== $sekolahane_deskripsi ) : ?>
										<p><?php echo esc_html( $sekolahane_deskripsi ); ?></p>
									<?php endif; ?>

									<?php if ( '' !== $sekolahane_link_url && '' !== $sekolahane_link_title ) : ?>
										<a href="<?php echo esc_url( $sekolahane_link_url ); ?>" class="btn btn-primary"<?php echo '_blank' === $sekolahane_link_target ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
											<?php echo esc_html( $sekolahane_link_title ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<?php
				++$sekolahane_slide_idx;
			endwhile;
		endif;
		?>
	</div>

	<?php if ( $sekolahane_show_curve ) : ?>
		<div class="pemanis-slider center_curve_alt bottom" aria-hidden="true">
			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" preserveAspectRatio="none" viewBox="0 0 100 100" focusable="false">
				<path d="M 0 0 L0 100 L100 100 L100 0 Q 50 200 0 0"></path>
			</svg>
		</div>
	<?php endif; ?>
</section>
