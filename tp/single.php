<?php
/**
 * Template part: Konten Single Post Desktop (`tp/single.php`).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_post_id = (int) get_the_ID();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-post-single' ); ?>>
	<header class="entry-header">
		<div class="ane-kategori">
			<?php
			$sekolahane_categories = get_the_category();
			foreach ( $sekolahane_categories as $sekolahane_category ) {
				echo '<a class="post-cat" href="' . esc_url( get_category_link( $sekolahane_category->term_id ) ) . '">' . esc_html( $sekolahane_category->name ) . '</a>';
			}
			?>
		</div>
		<?php
		the_title( '<h1 class="post-title">', '</h1>' );
		$sekolahane_tanggal = get_the_date( 'l, j F Y' );
		?>
		<div class="ane-meta">
			<ul>
				<li><?php echo sekolahane_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( (string) $sekolahane_tanggal ); ?></li>
				<li><?php echo sekolahane_icon( 'eye' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( (string) get_views( $sekolahane_post_id ) ); ?></li>
			</ul>
		</div>
	</header>
	<div class="entry-content">
		<div class="ane-image">
			<?php
			if ( has_post_thumbnail( $sekolahane_post_id ) ) {
				$sekolahane_thumb_id  = (int) get_post_thumbnail_id( $sekolahane_post_id );
				$sekolahane_thumb_img = wp_get_attachment_image_src( $sekolahane_thumb_id, 'large' );
				$sekolahane_img_url   = ( is_array( $sekolahane_thumb_img ) && ! empty( $sekolahane_thumb_img[0] ) ) ? (string) $sekolahane_thumb_img[0] : '';
				$sekolahane_img_w     = ( is_array( $sekolahane_thumb_img ) && ! empty( $sekolahane_thumb_img[1] ) ) ? (int) $sekolahane_thumb_img[1] : 1000;
				$sekolahane_img_h     = ( is_array( $sekolahane_thumb_img ) && ! empty( $sekolahane_thumb_img[2] ) ) ? (int) $sekolahane_thumb_img[2] : 563;
				$sekolahane_srcset    = (string) wp_get_attachment_image_srcset( $sekolahane_thumb_id, 'large' );

				if ( '' !== $sekolahane_img_url ) {
					echo '<img src="' . esc_url( $sekolahane_img_url ) . '"' . ( '' !== $sekolahane_srcset ? ' srcset="' . esc_attr( $sekolahane_srcset ) . '" sizes="(max-width: 767px) 400px, 1000px"' : '' ) . ' width="' . esc_attr( (string) $sekolahane_img_w ) . '" height="' . esc_attr( (string) $sekolahane_img_h ) . '" alt="' . esc_attr( get_the_title() ) . '" fetchpriority="high" decoding="async">';
				}

				$sekolahane_thumb_post = get_post( $sekolahane_thumb_id );
				if ( $sekolahane_thumb_post instanceof WP_Post && '' !== trim( $sekolahane_thumb_post->post_excerpt ) ) {
					echo '<span class="featured-image-caption">' . wp_kses_post( $sekolahane_thumb_post->post_excerpt ) . '</span>';
				}
			} else {
				$sekolahane_embed = ane_get_embedded_media( array( 'video', 'iframe' ) );
				$sekolahane_yt    = ane_get_youtube_thumbnail( $sekolahane_embed, 'mq' );
				if ( '' !== $sekolahane_yt ) {
					echo '<div class="image-header"><img src="' . esc_url( $sekolahane_yt ) . '" width="320" height="180" alt="' . esc_attr( get_the_title() ) . '" fetchpriority="high" decoding="async"></div>';
				}
			}
			?>
		</div>
		<div class="ane-content">
			<?php the_content(); ?>
			<div class="post-tags">
				<?php
				if ( get_the_tag_list() ) {
					echo '<span>' . esc_html__( 'Post Tags', 'sekolahane' ) . '</span>';
					echo wp_kses_post( (string) get_the_tag_list( '<ul><li>', '</li><li>', '</li></ul>' ) );
				}
				?>
			</div>
			<div class="share-this">
				<?php echo fungsi_share_webane(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<div class="post-nav">
				<?php echo wp_kses_post( (string) ane_prev_next_post() ); ?>
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
