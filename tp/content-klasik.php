<?php
/**
 * Template part: Kartu Berita Klasik (`tp/content-klasik.php`).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_img_url    = '';
$sekolahane_img_srcset = '';
$sekolahane_img_w      = 700;
$sekolahane_img_h      = 394;
$sekolahane_has_yt     = false;

if ( has_post_thumbnail() ) {
	$sekolahane_thumb_id = (int) get_post_thumbnail_id( get_the_ID() );
	$sekolahane_size     = wp_is_mobile() ? 'thumbnail' : 'medium';
	$sekolahane_thumb    = wp_get_attachment_image_src( $sekolahane_thumb_id, $sekolahane_size );
	if ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[0] ) ) {
		$sekolahane_img_url = (string) $sekolahane_thumb[0];
		$sekolahane_img_w   = ! empty( $sekolahane_thumb[1] ) ? (int) $sekolahane_thumb[1] : 700;
		$sekolahane_img_h   = ! empty( $sekolahane_thumb[2] ) ? (int) $sekolahane_thumb[2] : 394;
	}
	$sekolahane_img_srcset = (string) wp_get_attachment_image_srcset( $sekolahane_thumb_id, $sekolahane_size );
} else {
	$sekolahane_embed   = ane_get_embedded_media( array( 'video', 'iframe' ) );
	$sekolahane_img_url = (string) ane_get_youtube_thumbnail( $sekolahane_embed, 'mq' );
	$sekolahane_img_w   = 320;
	$sekolahane_img_h   = 180;
	$sekolahane_has_yt  = true;
}

if ( '' === $sekolahane_img_url ) {
	$sekolahane_img_url = (string) sekolahane_dummy_tumbnail();
}

$sekolahane_categories = get_the_category();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-konten-klasik' ); ?>>
	<header class="entry-header">
		<a href="<?php echo esc_url( (string) get_permalink() ); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
			<div class="ane-image">
				<img src="<?php echo esc_url( $sekolahane_img_url ); ?>"<?php echo '' !== $sekolahane_img_srcset ? ' srcset="' . esc_attr( $sekolahane_img_srcset ) . '" sizes="(max-width: 767px) 400px, 700px"' : ''; ?> width="<?php echo esc_attr( (string) $sekolahane_img_w ); ?>" height="<?php echo esc_attr( (string) $sekolahane_img_h ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async">
			</div>
		</a>
		<?php if ( $sekolahane_has_yt ) : ?>
			<div class="icon-content"></div>
		<?php endif; ?>
	</header>
	<div class="post-content">
		<?php
		the_title(
			sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( (string) get_permalink() ) ),
			'</a></h2>'
		);
		?>
		<div class="post-meta-info">
			<ul>
				<?php if ( ! empty( $sekolahane_categories ) ) : ?>
					<li>
						<div class="content-category">
							<?php
							foreach ( $sekolahane_categories as $sekolahane_cat ) {
								echo '<a href="' . esc_url( get_category_link( $sekolahane_cat->term_id ) ) . '">' . esc_html( $sekolahane_cat->name ) . '</a>';
							}
							?>
						</div>
					</li>
				<?php endif; ?>
				<li><?php echo wp_kses_post( (string) ane_load_times_ago() ); ?></li>
			</ul>
		</div>
		<?php the_excerpt(); ?>
	</div>
</article>
