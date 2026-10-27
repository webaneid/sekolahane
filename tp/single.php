<?php
defined( 'ABSPATH' ) || exit;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ane-post-single'); ?>>
	<header class="entry-header">
				<div class="ane-kategori">
						<?php $categories = get_the_category();
							foreach ($categories as $category){
							echo '<a class="post-cat" href="' . esc_url( get_category_link($category->term_id) ) . '">' . esc_html( $category->name ) . '</a>';
							}
						?>
				</div>
				<?php the_title( '<h1 class="post-title">', '</h1>' );
				$tanggal = get_the_date( 'l, j F Y' );
				?>
				<div class="ane-meta">
					<ul>
						<li><?php echo sekolahane_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( (string) $tanggal ); ?></li>
						<li><?php echo sekolahane_icon( 'eye' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> <?php echo esc_html( (string) get_views( $post->ID ) ); ?></li>
					</ul>
				</div>
	</header>
	<div class="entry-content">

		<div class="ane-image">
			<?php
				if ( has_post_thumbnail() ) {
					$thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
					$imgurl = $thumbImg['0'];
					echo '<img src="' .$imgurl.'" alt="' . esc_html( get_the_title() ). '">';
					if (get_post(get_post_thumbnail_id())->post_excerpt) {
						echo '<span class="featured-image-caption">
							'. wp_kses_post(get_post(get_post_thumbnail_id())->post_excerpt) .'
						</span>';
					}
				}
				else {
					$url = ane_get_embedded_media( array('video','iframe') );
					$size = 'mq'; // default, hq, mq, sd, maxres
					$urls = ane_get_youtube_thumbnail($url, $size);
					echo '<div class="image-header"><img src="' .$urls.'" alt="' . esc_html( get_the_title() ). '"></div>';
				}
			?>
		</div>
		<div class="ane-content">
			<?php the_content(); ?>
			<div class="post-tags">

				<?php
					if ( get_the_tag_list() ) {
						echo '<span>Post Tags</span>';
						echo get_the_tag_list( '<ul><li>', '</li><li>', '</li></ul>' );
					}
				?>
			</div>
			<div class="share-this">
				<?php echo fungsi_share_webane(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<div class="post-nav">
				<?php echo ane_prev_next_post(); ?>
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
				<?= fungsi_komen_facebook_webane(); ?>
			</div>

		</div>
	</div>
</article>
