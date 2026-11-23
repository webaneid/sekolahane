<?php
/**
 * Template part: Single Post Format Video (`tp/single-video.php`).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_categories = get_the_category();
$sekolahane_tanggal    = get_the_date( 'l, j F Y' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-post-single' ); ?>>
	<header class="entry-header">
		<div class="ane-kategori">
			<?php
			if ( ! empty( $sekolahane_categories ) ) {
				foreach ( $sekolahane_categories as $sekolahane_cat ) {
					echo '<a class="post-cat" href="' . esc_url( get_category_link( $sekolahane_cat->term_id ) ) . '">' . esc_html( $sekolahane_cat->name ) . '</a>';
				}
			}
			?>
		</div>
		<?php the_title( '<h1 class="post-title">', '</h1>' ); ?>
		<div class="ane-meta">
			<ul>
				<li><?php echo sekolahane_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( (string) $sekolahane_tanggal ); ?></li>
				<li><?php echo sekolahane_icon( 'eye' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( (string) get_views( (int) get_the_ID() ) ); ?></li>
			</ul>
		</div>
	</header>
	<div class="entry-content">
		<div class="ane-image">
			<?php
			if ( has_post_thumbnail() ) {
				$sekolahane_thumb_id = (int) get_post_thumbnail_id( get_the_ID() );
				$sekolahane_size     = wp_is_mobile() ? 'thumbnail' : 'large';
				$sekolahane_thumb    = wp_get_attachment_image_src( $sekolahane_thumb_id, $sekolahane_size );
				$sekolahane_img_url  = ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[0] ) ) ? (string) $sekolahane_thumb[0] : '';
				$sekolahane_img_w    = ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[1] ) ) ? (int) $sekolahane_thumb[1] : 1000;
				$sekolahane_img_h    = ( is_array( $sekolahane_thumb ) && ! empty( $sekolahane_thumb[2] ) ) ? (int) $sekolahane_thumb[2] : 563;
				$sekolahane_srcset   = (string) wp_get_attachment_image_srcset( $sekolahane_thumb_id, $sekolahane_size );

				if ( '' !== $sekolahane_img_url ) {
					echo '<img src="' . esc_url( $sekolahane_img_url ) . '"' . ( '' !== $sekolahane_srcset ? ' srcset="' . esc_attr( $sekolahane_srcset ) . '" sizes="(max-width: 767px) 400px, 1000px"' : '' ) . ' width="' . esc_attr( (string) $sekolahane_img_w ) . '" height="' . esc_attr( (string) $sekolahane_img_h ) . '" alt="' . esc_attr( get_the_title() ) . '" fetchpriority="high" decoding="async">';
				}
				$sekolahane_thumb_post = get_post( $sekolahane_thumb_id );
				if ( $sekolahane_thumb_post instanceof WP_Post && '' !== $sekolahane_thumb_post->post_excerpt ) {
					echo '<span class="featured-image-caption">' . wp_kses_post( $sekolahane_thumb_post->post_excerpt ) . '</span>';
				}
			} else {
				$sekolahane_embed = ane_get_embedded_media( array( 'video', 'iframe' ) );
				$sekolahane_yt    = (string) ane_get_youtube_thumbnail( $sekolahane_embed, 'maxres' );
				if ( '' !== $sekolahane_yt ) {
					echo '<img src="' . esc_url( $sekolahane_yt ) . '" width="1280" height="720" alt="' . esc_attr( get_the_title() ) . '" fetchpriority="high" decoding="async">';
				}
			}
			?>
		</div>
		<div class="ane-content">
			<?php the_content(); ?>
			<div class="post-tags">
				<?php
				if ( get_the_tag_list() ) {
					echo '<span>Post Tags</span>';
					echo wp_kses_post( (string) get_the_tag_list( '<ul><li>', '</li><li>', '</li></ul>' ) );
				}
				?>
			</div>
			<div class="share-this">
				<?php echo fungsi_share_webane(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<div class="post-nav">
				<?php echo wp_kses_post( ane_prev_next_post() ); ?>
			</div>
			<div class="terkait-newest">
				<div class="row">
					<div class="col-md-6">
						<div class="related-post">
							<?php ane_related_post(); ?>
						</div>
					</div>
					<div class="col-md-6">
						<div class="newest-post">
							<?php ane_newest_posts(); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="comments-form">
				<?php echo fungsi_komen_facebook_webane(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</div>
</article>
