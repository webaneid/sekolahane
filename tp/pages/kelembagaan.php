<?php
/**
 * Template part: Halaman Kelembagaan (`tp/pages/kelembagaan.php`).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_img_url    = (string) sekolahane_dummy_tumbnail();
$sekolahane_img_srcset = '';
$sekolahane_img_w      = 1000;
$sekolahane_img_h      = 563;

if ( has_post_thumbnail() ) {
	$sekolahane_thumb_id = (int) get_post_thumbnail_id( get_the_ID() );
	$sekolahane_size     = wp_is_mobile() ? 'thumbnail' : 'large';
	$sekolahane_thumb    = wp_get_attachment_image_src( $sekolahane_thumb_id, $sekolahane_size );
	if ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[0] ) ) {
		$sekolahane_img_url = (string) $sekolahane_thumb[0];
		$sekolahane_img_w   = ! empty( $sekolahane_thumb[1] ) ? (int) $sekolahane_thumb[1] : 1000;
		$sekolahane_img_h   = ! empty( $sekolahane_thumb[2] ) ? (int) $sekolahane_thumb[2] : 563;
	}
	$sekolahane_img_srcset = (string) wp_get_attachment_image_srcset( $sekolahane_thumb_id, $sekolahane_size );
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-page-default ane-page-kelembagaan' ); ?>>
	<div class="container-fluid">
		<div class="row">
			<header class="entry-header">
				<img class="ane-overlay-bg" src="<?php echo esc_url( $sekolahane_img_url ); ?>"<?php echo '' !== $sekolahane_img_srcset ? ' srcset="' . esc_attr( $sekolahane_img_srcset ) . '" sizes="(max-width: 767px) 400px, 1000px"' : ''; ?> width="<?php echo esc_attr( (string) $sekolahane_img_w ); ?>" height="<?php echo esc_attr( (string) $sekolahane_img_h ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" fetchpriority="high" decoding="async">
			</header>
		</div>
		<div class="row">
			<?php panggil_breadcrumb(); ?>
		</div>
	</div>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-9">
				<div class="entry-content">
					<div class="ane-content">
						<div class="ane-title">
							<?php the_title( '<h1 class="post-title general-title">', '</h1>' ); ?>
						</div>

						<?php the_content(); ?>
						<?php get_template_part( 'tp/mobile/menu-lembaga' ); ?>
						<div class="share-this">
							<?php echo fungsi_share_webane(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>

						<div class="comments-form">
							<?php echo fungsi_komen_facebook_webane(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>
