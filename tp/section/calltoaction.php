<?php
/**
 * Template part: Section Call to Action / Banner Ajakan (Home & Profil Lembaga).
 *
 * Mendukung pengaturan ACF:
 * - ane_cta_style  : 'bento' (Floating Bento Split) | 'glass' (Full-Width Glass Stage) | 'frame' (Asymmetric Image Frame)
 * - ane_cta_margin : 'yes' (Pakai Margin Bawah) | 'no' (Tanpa Margin Bawah / Menempel)
 * - ane_cta_wa     : 'yes' (Tampilkan Tombol WA Otomatis) | 'no' (Sembunyikan)
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_image      = trim( (string) get_sub_field( 'ane_background' ) );
$sekolahane_judul      = trim( (string) get_sub_field( 'ane_title' ) );
$sekolahane_deskripsi  = trim( (string) get_sub_field( 'ane_deskripsi' ) );
$sekolahane_link       = get_sub_field( 'ane_link' );
$sekolahane_style_raw  = (string) get_sub_field( 'ane_cta_style' );
$sekolahane_margin_raw = (string) get_sub_field( 'ane_cta_margin' );
$sekolahane_wa_toggle  = (string) get_sub_field( 'ane_cta_wa' );

if ( '' === $sekolahane_judul && '' === $sekolahane_deskripsi && '' === $sekolahane_image ) {
	return;
}

$sekolahane_style_map   = array(
	'bento' => 'cta-style-bento',
	'glass' => 'cta-style-glass',
	'frame' => 'cta-style-frame',
);
$sekolahane_style_key   = isset( $sekolahane_style_map[ $sekolahane_style_raw ] ) ? $sekolahane_style_raw : 'bento';
$sekolahane_style_class = $sekolahane_style_map[ $sekolahane_style_key ];

$sekolahane_margin_map   = array(
	'yes' => 'cta-mb-yes',
	'no'  => 'cta-mb-no',
);
$sekolahane_margin_class = isset( $sekolahane_margin_map[ $sekolahane_margin_raw ] )
	? $sekolahane_margin_map[ $sekolahane_margin_raw ]
	: 'cta-mb-yes';

$sekolahane_bg_class = '' !== $sekolahane_image ? 'cta-has-bg' : 'cta-no-bg';

$sekolahane_wa_raw = '';
if ( 'no' !== $sekolahane_wa_toggle ) {
	$sekolahane_sosmed  = get_field( 'sosmed_ane', 'option' );
	$sekolahane_contact = get_field( 'contact_ane', 'option' );

	if ( is_array( $sekolahane_sosmed ) && ! empty( $sekolahane_sosmed['sosmed_wa'] ) ) {
		$sekolahane_wa_raw = (string) preg_replace( '/[^0-9]/', '', (string) $sekolahane_sosmed['sosmed_wa'] );
	} elseif ( is_array( $sekolahane_contact ) && ! empty( $sekolahane_contact['kontak_handphone'] ) ) {
		$sekolahane_wa_raw = (string) preg_replace( '/[^0-9]/', '', (string) $sekolahane_contact['kontak_handphone'] );
	}

	if ( '' !== $sekolahane_wa_raw && '0' === substr( $sekolahane_wa_raw, 0, 1 ) ) {
		$sekolahane_wa_raw = '62' . substr( $sekolahane_wa_raw, 1 );
	}
}

$sekolahane_link_url    = '';
$sekolahane_link_title  = '';
$sekolahane_link_target = '_self';
if ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['url'] ) ) {
	$sekolahane_link_url    = (string) $sekolahane_link['url'];
	$sekolahane_link_title  = ! empty( $sekolahane_link['title'] ) ? (string) $sekolahane_link['title'] : __( 'Selengkapnya', 'sekolahane' );
	$sekolahane_link_target = ! empty( $sekolahane_link['target'] ) ? (string) $sekolahane_link['target'] : '_self';
}

$sekolahane_section_classes = 'home-cta ' . $sekolahane_style_class . ' ' . $sekolahane_margin_class . ' ' . $sekolahane_bg_class;

$sekolahane_cta_src    = $sekolahane_image;
$sekolahane_cta_srcset = '';
$sekolahane_cta_w      = 1000;
$sekolahane_cta_h      = 563;
$sekolahane_cta_alt    = '' !== $sekolahane_judul ? wp_strip_all_tags( $sekolahane_judul ) : (string) get_bloginfo( 'name' );

if ( '' !== $sekolahane_image ) {
	$sekolahane_cta_att_id = sekolahane_get_attachment_id_from_url( $sekolahane_image );
	if ( $sekolahane_cta_att_id > 0 ) {
		$sekolahane_cta_size = wp_is_mobile() ? 'thumbnail' : 'large';
		$sekolahane_cta_data = wp_get_attachment_image_src( $sekolahane_cta_att_id, $sekolahane_cta_size );
		if ( is_array( $sekolahane_cta_data ) && ! empty( $sekolahane_cta_data[0] ) ) {
			$sekolahane_cta_src = (string) $sekolahane_cta_data[0];
			$sekolahane_cta_w   = ! empty( $sekolahane_cta_data[1] ) ? (int) $sekolahane_cta_data[1] : 1000;
			$sekolahane_cta_h   = ! empty( $sekolahane_cta_data[2] ) ? (int) $sekolahane_cta_data[2] : 563;
		}
		$sekolahane_cta_srcset = (string) wp_get_attachment_image_srcset( $sekolahane_cta_att_id, $sekolahane_cta_size );
	}
}
?>
<section class="<?php echo esc_attr( $sekolahane_section_classes ); ?>">
	<?php if ( 'glass' === $sekolahane_style_key && '' !== $sekolahane_cta_src ) : ?>
		<img class="ane-cta-bg" src="<?php echo esc_url( $sekolahane_cta_src ); ?>"<?php echo '' !== $sekolahane_cta_srcset ? ' srcset="' . esc_attr( $sekolahane_cta_srcset ) . '" sizes="(max-width: 767px) 400px, 100vw"' : ''; ?> width="<?php echo esc_attr( (string) $sekolahane_cta_w ); ?>" height="<?php echo esc_attr( (string) $sekolahane_cta_h ); ?>" alt="<?php echo esc_attr( $sekolahane_cta_alt ); ?>" loading="lazy" decoding="async">
	<?php endif; ?>
	<div class="ane-calltoaction">
		<div class="container">
			<div class="ane-cta-box">
				<?php if ( 'bento' === $sekolahane_style_key && '' !== $sekolahane_cta_src ) : ?>
					<img class="ane-cta-bg" src="<?php echo esc_url( $sekolahane_cta_src ); ?>"<?php echo '' !== $sekolahane_cta_srcset ? ' srcset="' . esc_attr( $sekolahane_cta_srcset ) . '" sizes="(max-width: 767px) 400px, 1000px"' : ''; ?> width="<?php echo esc_attr( (string) $sekolahane_cta_w ); ?>" height="<?php echo esc_attr( (string) $sekolahane_cta_h ); ?>" alt="<?php echo esc_attr( $sekolahane_cta_alt ); ?>" loading="lazy" decoding="async">
				<?php endif; ?>
				<div class="ane-cta-glow" aria-hidden="true"></div>
				<div class="ane-cta-inner">
					<div class="ane-cta-main">
						<div class="text ane-cta-copy">
							<?php if ( '' !== $sekolahane_judul ) : ?>
								<h1><?php echo wp_kses_post( $sekolahane_judul ); ?></h1>
							<?php endif; ?>
							<?php if ( '' !== $sekolahane_deskripsi ) : ?>
								<p><?php echo wp_kses_post( $sekolahane_deskripsi ); ?></p>
							<?php endif; ?>
						</div>

						<?php if ( '' !== $sekolahane_link_url || '' !== $sekolahane_wa_raw ) : ?>
							<div class="ane-cta-actions">
								<?php if ( '' !== $sekolahane_link_url ) : ?>
									<a href="<?php echo esc_url( $sekolahane_link_url ); ?>" target="<?php echo esc_attr( $sekolahane_link_target ); ?>" class="btn btn-alternatif ane-cta-btn-primary">
										<span><?php echo esc_html( $sekolahane_link_title ); ?></span>
										<?php echo sekolahane_icon( 'chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</a>
								<?php endif; ?>

								<?php if ( '' !== $sekolahane_wa_raw ) : ?>
									<a href="<?php echo esc_url( 'https://wa.me/' . $sekolahane_wa_raw ); ?>" target="_blank" rel="noopener noreferrer" class="ane-cta-btn-wa">
										<?php echo sekolahane_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										<span><?php esc_html_e( 'Chat WhatsApp', 'sekolahane' ); ?></span>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>

					<?php if ( 'frame' === $sekolahane_style_key && '' !== $sekolahane_cta_src ) : ?>
						<div class="ane-cta-frame-media">
							<img src="<?php echo esc_url( $sekolahane_cta_src ); ?>"<?php echo '' !== $sekolahane_cta_srcset ? ' srcset="' . esc_attr( $sekolahane_cta_srcset ) . '" sizes="(max-width: 767px) 400px, 500px"' : ''; ?> width="<?php echo esc_attr( (string) $sekolahane_cta_w ); ?>" height="<?php echo esc_attr( (string) $sekolahane_cta_h ); ?>" alt="<?php echo esc_attr( $sekolahane_cta_alt ); ?>" loading="lazy" decoding="async">
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
