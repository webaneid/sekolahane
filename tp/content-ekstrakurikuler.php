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

$sekolahane_thumb_url = '';
if ( has_post_thumbnail() ) {
	$sekolahane_thumb = wp_get_attachment_image_src( (int) get_post_thumbnail_id( get_the_ID() ), 'large' );
	if ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[0] ) ) {
		$sekolahane_thumb_url = (string) $sekolahane_thumb[0];
	}
}
if ( '' === $sekolahane_thumb_url ) {
	$sekolahane_thumb_url = (string) sekolahane_dummy_tumbnail();
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-ekstra-card' ); ?>>
	<a href="<?php echo esc_url( (string) get_permalink() ); ?>" class="ane-ekstra-link" rel="bookmark">
		<div class="ane-ekstra-thumb" style="background-image: url('<?php echo esc_url( $sekolahane_thumb_url ); ?>');"></div>
		<div class="ane-ekstra-body">
			<h3 class="post-title"><?php echo esc_html( get_the_title() ); ?></h3>
			<span class="ane-ekstra-arrow" aria-hidden="true">
				<?php echo sekolahane_icon( 'chevron-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</span>
		</div>
	</a>
</article>
