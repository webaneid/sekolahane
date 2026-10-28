<?php
/**
 * Template part: Section General Info (Home & Profil Lembaga).
 *
 * Mendukung 3 pilihan desain tata letak (sekolahane_ginfo_layout):
 * 1. left   : Default 2 Kolom (Gambar 3:4 di Kiri, Teks & Listing di Kanan, vertikal rata tengah)
 * 2. right  : 2 Kolom (Teks & Listing di Kiri, Gambar 3:4 di Kanan, vertikal rata tengah)
 * 3. center : 3 Kolom Showcase (Header Judul & Deskripsi di Atas, Listing 01-02 di Kiri, Gambar 3:4 di Tengah, Listing 03-04 di Kanan)
 *
 * Di perangkat mobile (<= 767px), urutan tampilan selalu konsisten:
 * 1. Foto (rasio 3:4, padding kiri-kanan 15px, border-radius 16px)
 * 2. Judul
 * 3. Deskripsi
 * 4. Listing (jika ada)
 * 5. Tombol CTA (jika ada)
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_layout_raw = (string) get_sub_field( 'sekolahane_ginfo_layout' );
$sekolahane_style_raw  = (string) get_sub_field( 'sekolahane_ginfo_style' );
$sekolahane_margin_raw = (string) get_sub_field( 'sekolahane_ginfo_margin' );

$sekolahane_layout_map   = array(
	'left'   => 'ginfo-layout-left',
	'right'  => 'ginfo-layout-right',
	'center' => 'ginfo-layout-center',
);
$sekolahane_layout_class = isset( $sekolahane_layout_map[ $sekolahane_layout_raw ] )
	? $sekolahane_layout_map[ $sekolahane_layout_raw ]
	: 'ginfo-layout-left';

$sekolahane_style_map   = array(
	'putih'  => 'ginfo-style-putih',
	'terang' => 'ginfo-style-terang',
	'gelap'  => 'ginfo-style-gelap',
);
$sekolahane_style_class = isset( $sekolahane_style_map[ $sekolahane_style_raw ] )
	? $sekolahane_style_map[ $sekolahane_style_raw ]
	: 'ginfo-style-putih';

$sekolahane_margin_map   = array(
	'yes' => 'ginfo-mb-yes',
	'no'  => 'ginfo-mb-no',
);
$sekolahane_margin_class = isset( $sekolahane_margin_map[ $sekolahane_margin_raw ] )
	? $sekolahane_margin_map[ $sekolahane_margin_raw ]
	: 'ginfo-mb-yes';

$sekolahane_img_raw = get_sub_field( 'sekolahane_ginfo_image' );
$sekolahane_img_url = '';
if ( is_string( $sekolahane_img_raw ) && '' !== trim( $sekolahane_img_raw ) ) {
	$sekolahane_img_url = trim( $sekolahane_img_raw );
} elseif ( is_array( $sekolahane_img_raw ) && ! empty( $sekolahane_img_raw['url'] ) ) {
	$sekolahane_img_url = trim( (string) $sekolahane_img_raw['url'] );
}
if ( '' === $sekolahane_img_url ) {
	$sekolahane_img_url = sekolahane_dummy_tumbnail();
}

$sekolahane_judul       = trim( (string) get_sub_field( 'ane_title' ) );
$sekolahane_judul_plain = trim( wp_strip_all_tags( $sekolahane_judul ) );
$sekolahane_deskripsi   = trim( (string) get_sub_field( 'ane_deskripsi' ) );

$sekolahane_link        = get_sub_field( 'ane_link' );
$sekolahane_link_url    = ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['url'] ) ) ? trim( (string) $sekolahane_link['url'] ) : '';
$sekolahane_link_title  = ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['title'] ) ) ? trim( wp_strip_all_tags( (string) $sekolahane_link['title'] ) ) : '';
$sekolahane_link_target = ( is_array( $sekolahane_link ) && ! empty( $sekolahane_link['target'] ) ) ? trim( (string) $sekolahane_link['target'] ) : '';

$sekolahane_items     = array();
$sekolahane_max_items = ( 'ginfo-layout-center' === $sekolahane_layout_class ) ? 4 : 8;

if ( have_rows( 'sekolahane_ginfo_items' ) ) {
	$sekolahane_idx = 0;
	while ( have_rows( 'sekolahane_ginfo_items' ) ) {
		the_row();
		if ( $sekolahane_idx >= $sekolahane_max_items ) {
			break;
		}
		$sekolahane_ititle     = trim( (string) get_sub_field( 'sekolahane_item_title' ) );
		$sekolahane_idesc      = trim( wp_strip_all_tags( (string) get_sub_field( 'sekolahane_item_desc' ) ) );
		$sekolahane_itype      = (string) get_sub_field( 'sekolahane_icon_type' );
		$sekolahane_custom_raw = get_sub_field( 'sekolahane_custom_svg' );
		$sekolahane_custom_url = '';

		if ( is_string( $sekolahane_custom_raw ) && '' !== trim( $sekolahane_custom_raw ) ) {
			$sekolahane_custom_url = trim( $sekolahane_custom_raw );
		} elseif ( is_array( $sekolahane_custom_raw ) && ! empty( $sekolahane_custom_raw['url'] ) ) {
			$sekolahane_custom_url = trim( (string) $sekolahane_custom_raw['url'] );
		}

		if ( '' === $sekolahane_ititle && '' === $sekolahane_idesc ) {
			continue;
		}

		++$sekolahane_idx;
		$sekolahane_items[] = array(
			'num'        => sprintf( '%02d', $sekolahane_idx ),
			'icon_type'  => $sekolahane_itype,
			'custom_url' => $sekolahane_custom_url,
			'title'      => $sekolahane_ititle,
			'desc'       => $sekolahane_idesc,
		);
	}
}

$sekolahane_section_classes = 'section-general-info ' . $sekolahane_layout_class . ' ' . $sekolahane_style_class . ' ' . $sekolahane_margin_class;
?>
<section class="<?php echo esc_attr( $sekolahane_section_classes ); ?>">
	<div class="container">
		<?php if ( 'ginfo-layout-center' === $sekolahane_layout_class ) : ?>
			<div class="ginfo-center-wrap">
				<?php if ( '' !== $sekolahane_judul || '' !== $sekolahane_deskripsi ) : ?>
					<div class="ginfo-center-head">
						<?php if ( '' !== $sekolahane_judul ) : ?>
							<div class="ginfo-head-title">
								<h2><?php echo wp_kses_post( $sekolahane_judul ); ?></h2>
							</div>
						<?php endif; ?>
						<?php if ( '' !== $sekolahane_deskripsi ) : ?>
							<div class="ginfo-head-desc">
								<p><?php echo wp_kses_post( $sekolahane_deskripsi ); ?></p>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="ginfo-center-stage">
					<div class="ginfo-center-col ginfo-col-left">
						<?php
						foreach ( array_slice( $sekolahane_items, 0, 2 ) as $sekolahane_item ) :
							?>
							<div class="ginfo-card">
								<div class="ginfo-card-badge">
									<?php if ( 'number' === $sekolahane_item['icon_type'] ) : ?>
										<span class="ginfo-badge-num"><?php echo esc_html( $sekolahane_item['num'] ); ?></span>
									<?php elseif ( 'custom' === $sekolahane_item['icon_type'] && '' !== $sekolahane_item['custom_url'] ) : ?>
										<span class="ginfo-badge-icon ginfo-badge-custom">
											<img src="<?php echo esc_url( $sekolahane_item['custom_url'] ); ?>" alt="<?php echo esc_attr( $sekolahane_item['title'] ); ?>" loading="lazy">
										</span>
									<?php else : ?>
										<span class="ginfo-badge-icon">
											<?php
											$sekolahane_svg_name = in_array( $sekolahane_item['icon_type'], array( 'check', 'star', 'shield' ), true ) ? $sekolahane_item['icon_type'] : 'check';
											echo sekolahane_icon( $sekolahane_svg_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											?>
										</span>
									<?php endif; ?>
								</div>
								<div class="ginfo-card-body">
									<?php if ( '' !== $sekolahane_item['title'] ) : ?>
										<h3><?php echo esc_html( $sekolahane_item['title'] ); ?></h3>
									<?php endif; ?>
									<?php if ( '' !== $sekolahane_item['desc'] ) : ?>
										<p><?php echo esc_html( $sekolahane_item['desc'] ); ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="ginfo-media">
						<div class="ginfo-media-frame">
							<img src="<?php echo esc_url( $sekolahane_img_url ); ?>" alt="<?php echo esc_attr( '' !== $sekolahane_judul_plain ? $sekolahane_judul_plain : get_bloginfo( 'name' ) ); ?>" loading="lazy">
						</div>
					</div>

					<div class="ginfo-center-col ginfo-col-right">
						<?php
						foreach ( array_slice( $sekolahane_items, 2, 2 ) as $sekolahane_item ) :
							?>
							<div class="ginfo-card">
								<div class="ginfo-card-badge">
									<?php if ( 'number' === $sekolahane_item['icon_type'] ) : ?>
										<span class="ginfo-badge-num"><?php echo esc_html( $sekolahane_item['num'] ); ?></span>
									<?php elseif ( 'custom' === $sekolahane_item['icon_type'] && '' !== $sekolahane_item['custom_url'] ) : ?>
										<span class="ginfo-badge-icon ginfo-badge-custom">
											<img src="<?php echo esc_url( $sekolahane_item['custom_url'] ); ?>" alt="<?php echo esc_attr( $sekolahane_item['title'] ); ?>" loading="lazy">
										</span>
									<?php else : ?>
										<span class="ginfo-badge-icon">
											<?php
											$sekolahane_svg_name = in_array( $sekolahane_item['icon_type'], array( 'check', 'star', 'shield' ), true ) ? $sekolahane_item['icon_type'] : 'check';
											echo sekolahane_icon( $sekolahane_svg_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											?>
										</span>
									<?php endif; ?>
								</div>
								<div class="ginfo-card-body">
									<?php if ( '' !== $sekolahane_item['title'] ) : ?>
										<h3><?php echo esc_html( $sekolahane_item['title'] ); ?></h3>
									<?php endif; ?>
									<?php if ( '' !== $sekolahane_item['desc'] ) : ?>
										<p><?php echo esc_html( $sekolahane_item['desc'] ); ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<?php if ( '' !== $sekolahane_link_url && '' !== $sekolahane_link_title ) : ?>
					<div class="ginfo-actions ginfo-actions-center">
						<a href="<?php echo esc_url( $sekolahane_link_url ); ?>" class="btn btn-primary ginfo-btn"<?php echo '_blank' === $sekolahane_link_target ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
							<span><?php echo esc_html( $sekolahane_link_title ); ?></span>
							<?php echo sekolahane_icon( 'chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		<?php else : ?>
			<div class="ginfo-split-row">
				<div class="ginfo-media">
					<div class="ginfo-media-frame">
						<img src="<?php echo esc_url( $sekolahane_img_url ); ?>" alt="<?php echo esc_attr( '' !== $sekolahane_judul_plain ? $sekolahane_judul_plain : get_bloginfo( 'name' ) ); ?>" loading="lazy">
					</div>
				</div>

				<div class="ginfo-content">
					<?php if ( '' !== $sekolahane_judul || '' !== $sekolahane_deskripsi ) : ?>
						<div class="home-title ginfo-header">
							<?php if ( '' !== $sekolahane_judul ) : ?>
								<h2><?php echo wp_kses_post( $sekolahane_judul ); ?></h2>
							<?php endif; ?>
							<?php if ( '' !== $sekolahane_deskripsi ) : ?>
								<p><?php echo wp_kses_post( $sekolahane_deskripsi ); ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $sekolahane_items ) ) : ?>
						<div class="ginfo-list">
							<?php foreach ( $sekolahane_items as $sekolahane_item ) : ?>
								<div class="ginfo-list-item">
									<div class="ginfo-card-badge">
										<?php if ( 'number' === $sekolahane_item['icon_type'] ) : ?>
											<span class="ginfo-badge-num"><?php echo esc_html( $sekolahane_item['num'] ); ?></span>
										<?php elseif ( 'custom' === $sekolahane_item['icon_type'] && '' !== $sekolahane_item['custom_url'] ) : ?>
											<span class="ginfo-badge-icon ginfo-badge-custom">
												<img src="<?php echo esc_url( $sekolahane_item['custom_url'] ); ?>" alt="<?php echo esc_attr( $sekolahane_item['title'] ); ?>" loading="lazy">
											</span>
										<?php else : ?>
											<span class="ginfo-badge-icon">
												<?php
												$sekolahane_svg_name = in_array( $sekolahane_item['icon_type'], array( 'check', 'star', 'shield' ), true ) ? $sekolahane_item['icon_type'] : 'check';
												echo sekolahane_icon( $sekolahane_svg_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												?>
											</span>
										<?php endif; ?>
									</div>
									<div class="ginfo-card-body">
										<?php if ( '' !== $sekolahane_item['title'] ) : ?>
											<h3><?php echo esc_html( $sekolahane_item['title'] ); ?></h3>
										<?php endif; ?>
										<?php if ( '' !== $sekolahane_item['desc'] ) : ?>
											<p><?php echo esc_html( $sekolahane_item['desc'] ); ?></p>
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( '' !== $sekolahane_link_url && '' !== $sekolahane_link_title ) : ?>
						<div class="ginfo-actions">
							<a href="<?php echo esc_url( $sekolahane_link_url ); ?>" class="btn btn-primary ginfo-btn"<?php echo '_blank' === $sekolahane_link_target ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
								<span><?php echo esc_html( $sekolahane_link_title ); ?></span>
								<?php echo sekolahane_icon( 'chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
