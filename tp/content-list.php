<?php
/**
 * Template part: Kartu Berita List Horizontal (`tp/content-list.php`).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_img_url = '';
if ( has_post_thumbnail() ) {
	$sekolahane_thumb = wp_get_attachment_image_src( (int) get_post_thumbnail_id( get_the_ID() ), 'kotak' );
	if ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[0] ) ) {
		$sekolahane_img_url = (string) $sekolahane_thumb[0];
	}
}
if ( '' === $sekolahane_img_url ) {
	$sekolahane_img_url = (string) sekolahane_dummy_tumbnail();
}

$sekolahane_categories = get_the_category();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-konten-lis' ); ?>>
	<header class="entry-header">
		<a href="<?php echo esc_url( (string) get_permalink() ); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
			<div class="ane-image">
				<img src="<?php echo esc_url( $sekolahane_img_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
			</div>
		</a>
	</header>
	<div class="entry-content">
		<div class="ane-meta">
			<ul>
				<?php if ( ! empty( $sekolahane_categories ) ) : ?>
					<li>
						<div class="content-category">
							<?php
							$sekolahane_first_cat = $sekolahane_categories[0];
							echo '<a href="' . esc_url( get_category_link( $sekolahane_first_cat->term_id ) ) . '">' . esc_html( $sekolahane_first_cat->name ) . '</a>';
							?>
						</div>
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
</article>
