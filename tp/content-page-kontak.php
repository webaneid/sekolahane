<?php
/**
 * Template part: Konten Halaman Kontak (tp/content-page-kontak.php).
 *
 * Menampilkan:
 * 1. Header Judul & Bento Info Kontak (Alamat, Telepon, Handphone/WA, Email)
 * 2. Customer Care Mobile (.kontak-cs-mobile) khusus layar mobile menggunakan
 *    komponen kartu agen modern (.cc-agent-item)
 * 3. Form Pesan (Contact Form 7 / the_content) & Peta Lokasi Google Maps (.acf-map)
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_company_name = (string) get_bloginfo( 'name' );
if ( have_rows( 'about_ane', 'option' ) ) {
	while ( have_rows( 'about_ane', 'option' ) ) {
		the_row();
		$sekolahane_cname = trim( (string) get_sub_field( 'company_name' ) );
		if ( '' !== $sekolahane_cname ) {
			$sekolahane_company_name = $sekolahane_cname;
		}
	}
}

$sekolahane_alamat = '';
$sekolahane_phone  = '';
$sekolahane_mobile = '';
$sekolahane_email  = '';

if ( have_rows( 'contact_ane', 'option' ) ) {
	while ( have_rows( 'contact_ane', 'option' ) ) {
		the_row();
		$sekolahane_a = trim( (string) get_sub_field( 'kontak_alamat' ) );
		$sekolahane_p = trim( (string) get_sub_field( 'kontak_telepon' ) );
		$sekolahane_m = trim( (string) get_sub_field( 'kontak_handphone' ) );
		$sekolahane_e = trim( (string) get_sub_field( 'kontak_email' ) );

		if ( '' !== $sekolahane_a ) {
			$sekolahane_alamat = $sekolahane_a;
		}
		if ( '' !== $sekolahane_p ) {
			$sekolahane_phone = $sekolahane_p;
		}
		if ( '' !== $sekolahane_m ) {
			$sekolahane_mobile = $sekolahane_m;
		}
		if ( '' !== $sekolahane_e ) {
			$sekolahane_email = $sekolahane_e;
		}
	}
}

$sekolahane_cs_title   = trim( (string) get_field( 'ane_cs_label', 'option' ) );
$sekolahane_cs_label   = '' !== $sekolahane_cs_title ? $sekolahane_cs_title : __( 'Layanan Informasi & Customer Care', 'sekolahane' );
$sekolahane_cs_welcome = trim( (string) get_field( 'ane_cs_welcome', 'option' ) );
$sekolahane_location   = get_field( 'gmap', 'option' );
$sekolahane_has_map    = ( is_array( $sekolahane_location ) && ! empty( $sekolahane_location['lat'] ) && ! empty( $sekolahane_location['lng'] ) );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-page-kontak' ); ?>>
	<header class="entry-header kontak-head">
		<span class="kontak-badge"><?php esc_html_e( 'Hubungi Kami', 'sekolahane' ); ?></span>
		<?php the_title( '<h1 class="post-title general-title">', '</h1>' ); ?>
	</header>

	<div class="kontak-konten">
		<div class="kontak-bento-grid">
			<div class="kontak-card kontak-card-alamat">
				<div class="kontak-card-icon">
					<?php echo sekolahane_icon( 'lokasi' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<div class="kontak-card-body">
					<span class="kontak-card-label"><?php esc_html_e( 'Alamat Resmi', 'sekolahane' ); ?></span>
					<h3><?php echo esc_html( $sekolahane_company_name ); ?></h3>
					<?php if ( '' !== $sekolahane_alamat ) : ?>
						<p><?php echo wp_kses_post( $sekolahane_alamat ); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<div class="kontak-card kontak-card-channels">
				<?php if ( '' !== $sekolahane_phone ) : ?>
					<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $sekolahane_phone ) ); ?>" class="kontak-channel-item">
						<span class="kontak-channel-icon">
							<?php echo sekolahane_icon( 'telepon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<span class="kontak-channel-meta">
							<small><?php esc_html_e( 'Telepon', 'sekolahane' ); ?></small>
							<strong><?php echo esc_html( $sekolahane_phone ); ?></strong>
						</span>
					</a>
				<?php endif; ?>

				<?php if ( '' !== $sekolahane_mobile ) : ?>
					<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $sekolahane_mobile ) ); ?>" class="kontak-channel-item">
						<span class="kontak-channel-icon">
							<?php echo sekolahane_icon( 'handphone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<span class="kontak-channel-meta">
							<small><?php esc_html_e( 'Handphone / WhatsApp', 'sekolahane' ); ?></small>
							<strong><?php echo esc_html( $sekolahane_mobile ); ?></strong>
						</span>
					</a>
				<?php endif; ?>

				<?php if ( '' !== $sekolahane_email ) : ?>
					<a href="<?php echo esc_url( 'mailto:' . sanitize_email( $sekolahane_email ) ); ?>" class="kontak-channel-item">
						<span class="kontak-channel-icon">
							<?php echo sekolahane_icon( 'email' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<span class="kontak-channel-meta">
							<small><?php esc_html_e( 'Email Resmi', 'sekolahane' ); ?></small>
							<strong><?php echo esc_html( $sekolahane_email ); ?></strong>
						</span>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php if ( have_rows( 'ane_cs', 'option' ) ) : ?>
		<section class="kontak-cs-mobile">
			<div class="kontak-section-head">
				<span class="kontak-cs-icon">
					<?php echo sekolahane_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</span>
				<div>
					<h2><?php echo esc_html( $sekolahane_cs_label ); ?></h2>
					<?php if ( '' !== $sekolahane_cs_welcome ) : ?>
						<p><?php echo esc_html( $sekolahane_cs_welcome ); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<ul class="kontak-cs-list">
				<?php
				while ( have_rows( 'ane_cs', 'option' ) ) :
					the_row();
					$sekolahane_wa = (string) preg_replace( '/[^0-9]/', '', (string) get_sub_field( 'ane_whatsapp' ) );
					if ( '' !== $sekolahane_wa && '0' === substr( $sekolahane_wa, 0, 1 ) ) {
						$sekolahane_wa = '62' . substr( $sekolahane_wa, 1 );
					}
					$sekolahane_image  = get_sub_field( 'ane_image' );
					$sekolahane_nama   = trim( (string) get_sub_field( 'ane_nama' ) );
					$sekolahane_area   = trim( (string) get_sub_field( 'ane_area' ) );
					$sekolahane_wa_url = 'https://wa.me/' . $sekolahane_wa;
					$sekolahane_avatar = '';
					if ( is_array( $sekolahane_image ) ) {
						if ( ! empty( $sekolahane_image['sizes']['kotak'] ) ) {
							$sekolahane_avatar = (string) $sekolahane_image['sizes']['kotak'];
						} elseif ( ! empty( $sekolahane_image['url'] ) ) {
							$sekolahane_avatar = (string) $sekolahane_image['url'];
						}
					}
					?>
					<li>
						<a href="<?php echo esc_url( $sekolahane_wa_url ); ?>" target="_blank" rel="noopener noreferrer" class="cc-agent-item">
							<div class="cc-agent-avatar">
								<?php if ( '' !== $sekolahane_avatar ) : ?>
									<img src="<?php echo esc_url( $sekolahane_avatar ); ?>" alt="<?php echo esc_attr( $sekolahane_nama ); ?>" loading="lazy">
								<?php else : ?>
									<span class="cc-agent-fallback" aria-hidden="true">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" focusable="false">
											<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
										</svg>
									</span>
								<?php endif; ?>
								<span class="cc-agent-status" aria-hidden="true"></span>
							</div>
							<div class="cc-agent-meta">
								<span class="cc-agent-name"><?php echo esc_html( $sekolahane_nama ); ?></span>
								<?php if ( '' !== $sekolahane_area ) : ?>
									<span class="cc-agent-role"><?php echo esc_html( $sekolahane_area ); ?></span>
								<?php endif; ?>
							</div>
							<span class="cc-agent-action" aria-hidden="true">
								<?php echo sekolahane_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
		</section>
	<?php endif; ?>

	<div class="row kontak-main-row">
		<div class="<?php echo esc_attr( $sekolahane_has_map ? 'col-lg-7 col-12' : 'col-lg-12 col-12' ); ?>">
			<div class="entry-content kontak-form-card">
				<div class="kontak-section-head">
					<h2><?php esc_html_e( 'Kirim Pesan', 'sekolahane' ); ?></h2>
					<p><?php esc_html_e( 'Silakan isi formulir di bawah ini dan tim kami akan segera merespons pesan Anda.', 'sekolahane' ); ?></p>
				</div>
				<div class="ane-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>

		<?php
		if ( $sekolahane_has_map ) :
			$sekolahane_lat     = (string) $sekolahane_location['lat'];
			$sekolahane_lng     = (string) $sekolahane_location['lng'];
			$sekolahane_address = isset( $sekolahane_location['address'] ) ? (string) $sekolahane_location['address'] : $sekolahane_alamat;
			$sekolahane_dir_url = 'https://www.google.com/maps?saddr=My+Location&daddr=' . rawurlencode( $sekolahane_lat . ',' . $sekolahane_lng );
			?>
			<div class="col-lg-5 col-12">
				<div class="kontak-map">
					<div class="acf-map">
						<div class="marker" data-lat="<?php echo esc_attr( $sekolahane_lat ); ?>" data-lng="<?php echo esc_attr( $sekolahane_lng ); ?>">
							<strong><?php echo esc_html( $sekolahane_company_name ); ?></strong><br>
							<a class="directions" href="<?php echo esc_url( $sekolahane_dir_url ); ?>" target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( 'Petunjuk Arah ke', 'sekolahane' ); ?> <?php echo esc_html( $sekolahane_address ); ?>
							</a>
						</div>
					</div>
					<a href="<?php echo esc_url( $sekolahane_dir_url ); ?>" target="_blank" rel="noopener noreferrer" class="kontak-map-btn">
						<?php echo sekolahane_icon( 'lokasi' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><?php esc_html_e( 'Buka Petunjuk Arah di Google Maps', 'sekolahane' ); ?></span>
					</a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</article>
