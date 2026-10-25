<?php
/**
 * Template part untuk menampilkan Section Fitur Sekolah (Featured Box).
 *
 * Mendukung pengaturan:
 * - Posisi terhadap Hero (ane_featured_position: overlap | below)
 * - Gaya Desain (ane_featured_style: default | flat)
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_pos_raw   = (string) get_sub_field( 'ane_featured_position' );
$sekolahane_pos_map   = array(
	'overlap' => 'featured-pos-overlap',
	'below'   => 'featured-pos-below',
);
$sekolahane_pos_class = isset( $sekolahane_pos_map[ $sekolahane_pos_raw ] ) ? $sekolahane_pos_map[ $sekolahane_pos_raw ] : 'featured-pos-overlap';

$sekolahane_style_raw   = (string) get_sub_field( 'ane_featured_style' );
$sekolahane_style_map   = array(
	'default' => 'featured-style-default',
	'flat'    => 'featured-style-flat',
);
$sekolahane_style_class = isset( $sekolahane_style_map[ $sekolahane_style_raw ] ) ? $sekolahane_style_map[ $sekolahane_style_raw ] : 'featured-style-default';

if ( have_rows( 'ane_featured' ) ) :
	?>
	<section class="section-featured <?php echo esc_attr( $sekolahane_pos_class . ' ' . $sekolahane_style_class ); ?>">
		<div class="container">
			<ul>
				<?php
				while ( have_rows( 'ane_featured' ) ) :
					the_row();

					$sekolahane_image     = trim( (string) get_sub_field( 'ane_icon' ) );
					$sekolahane_judul     = trim( wp_strip_all_tags( (string) get_sub_field( 'ane_title' ) ) );
					$sekolahane_deskripsi = trim( wp_strip_all_tags( (string) get_sub_field( 'ane_deskripsi' ) ) );

					$sekolahane_link        = get_sub_field( 'ane_link' );
					$sekolahane_link_url    = '';
					$sekolahane_link_title  = '';
					$sekolahane_link_target = '_self';

					if ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['url'] ) ) {
						$sekolahane_link_url    = trim( (string) $sekolahane_link['url'] );
						$sekolahane_link_title  = isset( $sekolahane_link['title'] ) ? trim( wp_strip_all_tags( (string) $sekolahane_link['title'] ) ) : '';
						$sekolahane_link_title  = '' !== $sekolahane_link_title ? $sekolahane_link_title : __( 'Selengkapnya', 'sekolahane' );
						$sekolahane_link_target = ! empty( $sekolahane_link['target'] ) ? (string) $sekolahane_link['target'] : '_self';
					}
					?>
					<li>
						<div class="item">
							<?php if ( '' !== $sekolahane_image ) : ?>
								<div class="image">
									<img src="<?php echo esc_url( $sekolahane_image ); ?>" alt="<?php echo esc_attr( $sekolahane_judul ); ?>" title="<?php echo esc_attr( $sekolahane_judul ); ?>">
								</div>
							<?php endif; ?>

							<div class="content">
								<?php if ( '' !== $sekolahane_judul ) : ?>
									<h4>
										<?php if ( '' !== $sekolahane_link_url ) : ?>
											<a href="<?php echo esc_url( $sekolahane_link_url ); ?>" target="<?php echo esc_attr( $sekolahane_link_target ); ?>"><?php echo esc_html( $sekolahane_judul ); ?></a>
										<?php else : ?>
											<?php echo esc_html( $sekolahane_judul ); ?>
										<?php endif; ?>
									</h4>
								<?php endif; ?>

								<?php if ( '' !== $sekolahane_deskripsi ) : ?>
									<p><?php echo esc_html( $sekolahane_deskripsi ); ?></p>
								<?php endif; ?>

								<?php if ( '' !== $sekolahane_link_url ) : ?>
									<a href="<?php echo esc_url( $sekolahane_link_url ); ?>" target="<?php echo esc_attr( $sekolahane_link_target ); ?>" class="btn btn-primary"><?php echo esc_html( $sekolahane_link_title ); ?></a>
								<?php endif; ?>
							</div>
						</div>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>
