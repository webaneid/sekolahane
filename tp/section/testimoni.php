<?php
/**
 * Template part: Section Testimoni (Home & Profil Lembaga).
 *
 * Mendukung 2 pengaturan ACF:
 * - ane_testimoni_style: 'modern' (Modern Editorial Card) | 'bubble' (Classic Glass Speech)
 * - ane_testimoni_margin: 'yes' (Pakai Margin Bawah) | 'no' (Tanpa Margin Bawah / Menempel)
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_judul      = (string) get_sub_field( 'ane_title' );
$sekolahane_deskripsi  = (string) get_sub_field( 'ane_deskripsi' );
$sekolahane_style_raw  = (string) get_sub_field( 'ane_testimoni_style' );
$sekolahane_margin_raw = (string) get_sub_field( 'ane_testimoni_margin' );

$sekolahane_style_map   = array(
	'modern' => 'testi-style-modern',
	'bubble' => 'testi-style-bubble',
);
$sekolahane_style_class = isset( $sekolahane_style_map[ $sekolahane_style_raw ] )
	? $sekolahane_style_map[ $sekolahane_style_raw ]
	: 'testi-style-modern';

$sekolahane_margin_map   = array(
	'yes' => 'testi-mb-yes',
	'no'  => 'testi-mb-no',
);
$sekolahane_margin_class = isset( $sekolahane_margin_map[ $sekolahane_margin_raw ] )
	? $sekolahane_margin_map[ $sekolahane_margin_raw ]
	: 'testi-mb-yes';

$sekolahane_section_classes = 'home-testimoni ' . $sekolahane_style_class . ' ' . $sekolahane_margin_class;
?>
<section class="<?php echo esc_attr( $sekolahane_section_classes ); ?>">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="home-title text-center">
					<?php
					if ( '' !== trim( $sekolahane_judul ) ) {
						echo '<h2>' . wp_kses_post( $sekolahane_judul ) . '</h2>';
					} else {
						echo '<h2>Testi<span>moni</span></h2>';
					}
					if ( '' !== trim( $sekolahane_deskripsi ) ) {
						echo '<p>' . esc_html( $sekolahane_deskripsi ) . '</p>';
					}
					?>
				</div>
			</div>
		</div>

		<div class="testimoni-item">
			<div class="testimoni-slider owl-carousel">
				<?php
				$sekolahane_query = new WP_Query(
					array(
						'post_type'      => 'testimoni',
						'posts_per_page' => 9,
					)
				);

				while ( $sekolahane_query->have_posts() ) :
					$sekolahane_query->the_post();
					get_template_part( 'tp/content', 'testimoni' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</div>
</section>
