<?php
/**
 * Template part: Section Funfact (Home & Profil Lembaga).
 *
 * Menampilkan maksimal 4 item angka funfact (4 kolom di desktop, 2 kolom di mobile)
 * dengan 3 pilihan gaya warna brand:
 * - putih  : Putih Bersih (.funfact-style-putih)
 * - terang : Terang / Soft Brand (.funfact-style-terang)
 * - gelap  : Gelap / Dark Brand (.funfact-style-gelap)
 *
 * Setiap item terdiri dari:
 * - sekolahane_number : Angka utama (mis. 2, 45, 1200)
 * - sekolahane_prefix : Prefix / teks tambahan (mis. thn+, +, %)
 * - sekolahane_label  : Label keterangan (mis. Pengalaman)
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_judul      = trim( (string) get_sub_field( 'ane_title' ) );
$sekolahane_deskripsi  = trim( wp_strip_all_tags( (string) get_sub_field( 'ane_deskripsi' ) ) );
$sekolahane_style_raw  = (string) get_sub_field( 'sekolahane_funfact_style' );
$sekolahane_margin_raw = (string) get_sub_field( 'sekolahane_funfact_margin' );

$sekolahane_style_map   = array(
	'putih'  => 'funfact-style-putih',
	'terang' => 'funfact-style-terang',
	'gelap'  => 'funfact-style-gelap',
);
$sekolahane_style_class = isset( $sekolahane_style_map[ $sekolahane_style_raw ] )
	? $sekolahane_style_map[ $sekolahane_style_raw ]
	: 'funfact-style-putih';

$sekolahane_margin_map   = array(
	'yes' => 'funfact-mb-yes',
	'no'  => 'funfact-mb-no',
);
$sekolahane_margin_class = isset( $sekolahane_margin_map[ $sekolahane_margin_raw ] )
	? $sekolahane_margin_map[ $sekolahane_margin_raw ]
	: 'funfact-mb-yes';

if ( ! have_rows( 'sekolahane_funfact_items' ) ) {
	return;
}

$sekolahane_section_classes = 'section-funfact ' . $sekolahane_style_class . ' ' . $sekolahane_margin_class;
?>
<section class="<?php echo esc_attr( $sekolahane_section_classes ); ?>">
	<div class="container">
		<?php if ( '' !== $sekolahane_judul || '' !== $sekolahane_deskripsi ) : ?>
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="home-title text-center funfact-header">
						<?php if ( '' !== $sekolahane_judul ) : ?>
							<h2><?php echo wp_kses_post( $sekolahane_judul ); ?></h2>
						<?php endif; ?>
						<?php if ( '' !== $sekolahane_deskripsi ) : ?>
							<p><?php echo esc_html( $sekolahane_deskripsi ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="funfact-grid">
			<?php
			$sekolahane_count = 0;
			while ( have_rows( 'sekolahane_funfact_items' ) ) :
				the_row();
				if ( $sekolahane_count >= 4 ) {
					break;
				}
				$sekolahane_number = trim( (string) get_sub_field( 'sekolahane_number' ) );
				$sekolahane_prefix = trim( (string) get_sub_field( 'sekolahane_prefix' ) );
				$sekolahane_label  = trim( (string) get_sub_field( 'sekolahane_label' ) );

				if ( '' === $sekolahane_number && '' === $sekolahane_label ) {
					continue;
				}
				++$sekolahane_count;
				?>
				<div class="funfact-card">
					<div class="funfact-value">
						<?php if ( '' !== $sekolahane_number ) : ?>
							<span class="funfact-number"><?php echo esc_html( $sekolahane_number ); ?></span>
						<?php endif; ?>
						<?php if ( '' !== $sekolahane_prefix ) : ?>
							<span class="funfact-prefix"><?php echo esc_html( $sekolahane_prefix ); ?></span>
						<?php endif; ?>
					</div>
					<?php if ( '' !== $sekolahane_label ) : ?>
						<p class="funfact-label"><?php echo esc_html( $sekolahane_label ); ?></p>
					<?php endif; ?>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</section>
