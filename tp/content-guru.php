<?php
/**
 * Template part: Kartu CPT Guru (`tp/content-guru.php`).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_img_url    = (string) sekolahane_dummy_tumbnail();
$sekolahane_img_srcset = '';
$sekolahane_img_w      = 400;
$sekolahane_img_h      = 400;

if ( has_post_thumbnail() ) {
	$sekolahane_thumb_id = (int) get_post_thumbnail_id( get_the_ID() );
	$sekolahane_thumb    = wp_get_attachment_image_src( $sekolahane_thumb_id, 'kotak' );
	if ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[0] ) ) {
		$sekolahane_img_url = (string) $sekolahane_thumb[0];
		$sekolahane_img_w   = ! empty( $sekolahane_thumb[1] ) ? (int) $sekolahane_thumb[1] : 400;
		$sekolahane_img_h   = ! empty( $sekolahane_thumb[2] ) ? (int) $sekolahane_thumb[2] : 400;
	}
	$sekolahane_img_srcset = (string) wp_get_attachment_image_srcset( $sekolahane_thumb_id, 'kotak' );
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-konten-guru' ); ?>>
	<a href="<?php echo esc_url( (string) get_permalink() ); ?>">
		<header class="entry-header">
			<div class="ane-image">
				<img src="<?php echo esc_url( $sekolahane_img_url ); ?>"<?php echo '' !== $sekolahane_img_srcset ? ' srcset="' . esc_attr( $sekolahane_img_srcset ) . '" sizes="(max-width: 767px) 180px, 280px"' : ''; ?> width="<?php echo esc_attr( (string) $sekolahane_img_w ); ?>" height="<?php echo esc_attr( (string) $sekolahane_img_h ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async">
			</div>
		</header>

		<div class="entry-content text-center">
			<h2><?php the_title(); ?></h2>
			<p><?php echo esc_html( (string) get_field( 'ane_jabatan' ) ); ?></p>
		</div>
	</a>
</article>
