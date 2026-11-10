<?php
/**
 * Template part untuk menampilkan kartu item Ekstrakurikuler.
 *
 * Dipakai pada slider Ekstrakurikuler di halaman depan (tp/section/ekstra.php)
 * dan halaman arsip Ekstrakurikuler (archive-ekstrakurikuler.php).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_thumb_url    = '';
$sekolahane_thumb_srcset = '';
$sekolahane_thumb_w      = 700;
$sekolahane_thumb_h      = 394;

if ( has_post_thumbnail() ) {
	$sekolahane_thumb_id = (int) get_post_thumbnail_id( get_the_ID() );
	$sekolahane_size     = wp_is_mobile() ? 'thumbnail' : 'medium';
	$sekolahane_thumb    = wp_get_attachment_image_src( $sekolahane_thumb_id, $sekolahane_size );
	if ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[0] ) ) {
		$sekolahane_thumb_url = (string) $sekolahane_thumb[0];
		$sekolahane_thumb_w   = ! empty( $sekolahane_thumb[1] ) ? (int) $sekolahane_thumb[1] : 700;
		$sekolahane_thumb_h   = ! empty( $sekolahane_thumb[2] ) ? (int) $sekolahane_thumb[2] : 394;
	}
	$sekolahane_thumb_srcset = (string) wp_get_attachment_image_srcset( $sekolahane_thumb_id, $sekolahane_size );
}
if ( '' === $sekolahane_thumb_url ) {
	$sekolahane_thumb_url = (string) sekolahane_dummy_tumbnail();
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-ekstra-card' ); ?>>
	<a href="<?php echo esc_url( (string) get_permalink() ); ?>" class="ane-ekstra-link" rel="bookmark">
		<img class="ane-ekstra-thumb" src="<?php echo esc_url( $sekolahane_thumb_url ); ?>"<?php echo '' !== $sekolahane_thumb_srcset ? ' srcset="' . esc_attr( $sekolahane_thumb_srcset ) . '" sizes="(max-width: 767px) 400px, 700px"' : ''; ?> width="<?php echo esc_attr( (string) $sekolahane_thumb_w ); ?>" height="<?php echo esc_attr( (string) $sekolahane_thumb_h ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async">
		<div class="ane-ekstra-body">
			<h3 class="post-title"><?php echo esc_html( get_the_title() ); ?></h3>
			<span class="ane-ekstra-arrow" aria-hidden="true">
				<?php echo sekolahane_icon( 'chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</span>
		</div>
	</a>
</article>
