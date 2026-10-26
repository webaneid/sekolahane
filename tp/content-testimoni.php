<?php
/**
 * Template part: Kartu Item Testimoni (Slider Home/Profil & Halaman Arsip Testimoni).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_isi         = (string) get_field( 'ane_testimoni' );
$sekolahane_jabatan     = (string) get_field( 'ane_jabatan' );
$sekolahane_archive_url = get_post_type_archive_link( 'testimoni' );
if ( ! is_string( $sekolahane_archive_url ) || '' === $sekolahane_archive_url ) {
	$sekolahane_archive_url = home_url( '/testimoni/' );
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-konten-testimoni' ); ?>>
	<header>
		<div class="ane-testi-quote-icon" aria-hidden="true">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" focusable="false">
				<path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
			</svg>
		</div>
		<div class="ane-testi-text">
			<?php echo wp_kses_post( $sekolahane_isi ); ?>
		</div>
	</header>
	<div class="post-content">
		<div class="fotonya">
			<?php
			if ( has_post_thumbnail() ) {
				$sekolahane_thumb = wp_get_attachment_image_src( (int) get_post_thumbnail_id( get_the_ID() ), 'kotak' );
				if ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[0] ) ) {
					echo '<img src="' . esc_url( $sekolahane_thumb[0] ) . '" alt="' . esc_attr( get_the_title() ) . '" loading="lazy">';
				}
			} else {
				?>
				<span class="ane-testi-avatar-fallback" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" focusable="false">
						<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
					</svg>
				</span>
				<?php
			}
			?>
		</div>
		<div class="orangnya">
			<h6>
				<a href="<?php echo esc_url( $sekolahane_archive_url ); ?>" rel="bookmark"><?php the_title(); ?></a>
				<?php if ( '' !== trim( $sekolahane_jabatan ) ) : ?>
					<span><?php echo esc_html( $sekolahane_jabatan ); ?></span>
				<?php endif; ?>
			</h6>
		</div>
	</div>
</article>
