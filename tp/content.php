<?php
/**
 * Template part: Kartu Berita Default (`tp/content.php`).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_img_url    = (string) sekolahane_dummy_tumbnail();
$sekolahane_img_srcset = '';
$sekolahane_img_w      = 400;
$sekolahane_img_h      = 225;

if ( has_post_thumbnail() ) {
	$sekolahane_thumb_id = (int) get_post_thumbnail_id( get_the_ID() );
	$sekolahane_thumb    = wp_get_attachment_image_src( $sekolahane_thumb_id, 'thumbnail' );
	if ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[0] ) ) {
		$sekolahane_img_url = (string) $sekolahane_thumb[0];
		$sekolahane_img_w   = ! empty( $sekolahane_thumb[1] ) ? (int) $sekolahane_thumb[1] : 400;
		$sekolahane_img_h   = ! empty( $sekolahane_thumb[2] ) ? (int) $sekolahane_thumb[2] : 225;
	}
	$sekolahane_img_srcset = (string) wp_get_attachment_image_srcset( $sekolahane_thumb_id, 'thumbnail' );
}

$sekolahane_categories = get_the_category();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-konten-default' ); ?>>
	<div class="row">
		<div class="col-md-5 col-5 post-tengah prm-5">
			<header class="entry-header">
				<a href="<?php echo esc_url( (string) get_permalink() ); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
					<div class="ane-image">
						<img src="<?php echo esc_url( $sekolahane_img_url ); ?>"<?php echo '' !== $sekolahane_img_srcset ? ' srcset="' . esc_attr( $sekolahane_img_srcset ) . '" sizes="(max-width: 767px) 160px, 320px"' : ''; ?> width="<?php echo esc_attr( (string) $sekolahane_img_w ); ?>" height="<?php echo esc_attr( (string) $sekolahane_img_h ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async">
					</div>
				</a>
			</header>
		</div>

		<div class="col-md-7 col-7 p-0 post-tengah">
			<div class="post-content">
				<?php
				the_title(
					sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( (string) get_permalink() ) ),
					'</a></h2>'
				);
				?>
				<div class="ane-meta">
					<ul>
						<?php if ( ! empty( $sekolahane_categories ) ) : ?>
							<li>
								<?php
								foreach ( $sekolahane_categories as $sekolahane_cat ) {
									echo '<a class="post-cat" href="' . esc_url( get_category_link( $sekolahane_cat->term_id ) ) . '">' . esc_html( $sekolahane_cat->name ) . '</a>';
								}
								?>
							</li>
						<?php endif; ?>
						<li><?php echo wp_kses_post( (string) ane_load_times_ago() ); ?></li>
					</ul>
				</div>
				<div class="hidden-mobile">
					<?php the_excerpt(); ?>
				</div>
			</div>
		</div>
	</div>
</article>
