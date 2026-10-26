<?php
/**
 * Template part: Kartu Berita Overlay (`tp/content-overlay.php`).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_img_url = '';
if ( has_post_thumbnail() ) {
	$sekolahane_thumb = wp_get_attachment_image_src( (int) get_post_thumbnail_id( get_the_ID() ), 'large' );
	if ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[0] ) ) {
		$sekolahane_img_url = (string) $sekolahane_thumb[0];
	}
} else {
	$sekolahane_embed = ane_get_embedded_media( array( 'video', 'iframe' ) );
	$sekolahane_yt    = ane_get_youtube_thumbnail( $sekolahane_embed, 'maxres' );
	if ( is_string( $sekolahane_yt ) && '' !== $sekolahane_yt ) {
		$sekolahane_img_url = $sekolahane_yt;
	}
}

if ( '' === $sekolahane_img_url ) {
	$sekolahane_img_url = (string) sekolahane_dummy_tumbnail();
}

$sekolahane_categories = get_the_category();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-konten-overlay' ); ?>>
	<header class="entry-header" style="background-image:url('<?php echo esc_url( $sekolahane_img_url ); ?>')">
		<a href="<?php echo esc_url( (string) get_permalink() ); ?>" class="ane-overlay-permalink" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>
		<div class="post-content">
			<div class="ane-meta">
				<ul>
					<?php if ( ! empty( $sekolahane_categories ) ) : ?>
						<li>
							<?php
							$sekolahane_first_cat = $sekolahane_categories[0];
							echo '<a class="post-cat" href="' . esc_url( get_category_link( $sekolahane_first_cat->term_id ) ) . '">' . esc_html( $sekolahane_first_cat->name ) . '</a>';
							?>
						</li>
					<?php endif; ?>
					<li><?php echo wp_kses_post( (string) ane_load_times_ago() ); ?></li>
				</ul>
			</div>
			<?php
			the_title(
				sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( (string) get_permalink() ) ),
				'</a></h2>'
			);
			?>
		</div>
	</header>
</article>
