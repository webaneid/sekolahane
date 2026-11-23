<?php
/**
 * Template part: Single CPT Guru (`tp/single-guru.php`).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_img_url    = (string) ane_dummy_kotak();
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
<article id="post-<?php the_ID(); ?>" <?php post_class( 'ane-single-guru' ); ?>>
	<header class="entry-header">
		<div class="ane-image">
			<img src="<?php echo esc_url( $sekolahane_img_url ); ?>"<?php echo '' !== $sekolahane_img_srcset ? ' srcset="' . esc_attr( $sekolahane_img_srcset ) . '" sizes="400px"' : ''; ?> width="<?php echo esc_attr( (string) $sekolahane_img_w ); ?>" height="<?php echo esc_attr( (string) $sekolahane_img_h ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" fetchpriority="high" decoding="async">
		</div>
	</header>

	<div class="entry-content">
		<div class="ane-title">
			<?php the_title( '<h1 class="post-title">', '<span>' . esc_html( (string) get_field( 'ane_jabatan' ) ) . '</span></h1>' ); ?>
		</div>
		<div class="ane-content">
			<figure class="wp-block-table">
				<table>
					<tbody>
						<tr>
							<td>Pelajaran</td>
							<td>
								<div class="content-category">
									<?php
									$sekolahane_pelajaran = get_the_terms( get_the_ID(), 'pelajaran' );
									if ( is_array( $sekolahane_pelajaran ) ) {
										foreach ( $sekolahane_pelajaran as $sekolahane_item_pel ) {
											echo '<a class="post-cat" href="' . esc_url( get_category_link( $sekolahane_item_pel->term_id ) ) . '">' . esc_html( $sekolahane_item_pel->name ) . '</a>';
										}
									}
									?>
								</div>
							</td>
						</tr>
						<tr>
							<td>Kelas</td>
							<td>
								<div class="content-category">
									<?php
									$sekolahane_kelas = get_the_terms( get_the_ID(), 'Kelas' );
									if ( is_array( $sekolahane_kelas ) ) {
										foreach ( $sekolahane_kelas as $sekolahane_item_kel ) {
											echo '<a class="post-cat" href="' . esc_url( get_category_link( $sekolahane_item_kel->term_id ) ) . '">' . esc_html( $sekolahane_item_kel->name ) . '</a>';
										}
									}
									?>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</figure>

			<?php the_content(); ?>
			<div class="share-this">
				<?php echo fungsi_share_webane(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>

			<div class="comments-form">
				<?php echo fungsi_komen_facebook_webane(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>

		<div class="konten-terkait-v2">
			<?php
			$sekolahane_terms_kelas    = get_the_terms( get_the_ID(), 'Kelas' );
			$sekolahane_term_ids_kelas = is_array( $sekolahane_terms_kelas ) ? wp_list_pluck( $sekolahane_terms_kelas, 'term_id' ) : array();
			$sekolahane_query_kelas    = new WP_Query(
				array(
					'post_type'           => 'guru',
					// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					'tax_query'           => array(
						array(
							'taxonomy' => 'Kelas',
							'field'    => 'id',
							'terms'    => $sekolahane_term_ids_kelas,
							'operator' => 'IN',
						),
					),
					'posts_per_page'      => 4,
					'ignore_sticky_posts' => 1,
					'orderby'             => 'rand',
					'post__not_in'        => array( (int) get_the_ID() ),
				)
			);

			if ( $sekolahane_query_kelas->have_posts() ) :
				?>
				<h2><?php esc_html_e( 'Guru Kelas Yang Sama', 'sekolahane' ); ?></h2>

				<div class="testimoni-slider owl-carousel">
					<?php
					while ( $sekolahane_query_kelas->have_posts() ) :
						$sekolahane_query_kelas->the_post();
						get_template_part( 'tp/content', 'guru' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			<?php endif; ?>
		</div>

		<div class="konten-terkait-v2">
			<?php
			$sekolahane_terms_pel    = get_the_terms( get_the_ID(), 'pelajaran' );
			$sekolahane_term_ids_pel = is_array( $sekolahane_terms_pel ) ? wp_list_pluck( $sekolahane_terms_pel, 'term_id' ) : array();
			$sekolahane_query_pel    = new WP_Query(
				array(
					'post_type'           => 'guru',
					// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					'tax_query'           => array(
						array(
							'taxonomy' => 'pelajaran',
							'field'    => 'id',
							'terms'    => $sekolahane_term_ids_pel,
							'operator' => 'IN',
						),
					),
					'posts_per_page'      => 4,
					'ignore_sticky_posts' => 1,
					'orderby'             => 'rand',
					'post__not_in'        => array( (int) get_the_ID() ),
				)
			);

			if ( $sekolahane_query_pel->have_posts() ) :
				?>
				<h2><?php esc_html_e( 'Guru Pelajaran Yang Sama', 'sekolahane' ); ?></h2>

				<div class="testimoni-slider owl-carousel">
					<?php
					while ( $sekolahane_query_pel->have_posts() ) :
						$sekolahane_query_pel->the_post();
						get_template_part( 'tp/content', 'guru' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</article>
