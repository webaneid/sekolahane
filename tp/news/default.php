<?php
/**
 * Template part: Section Berita Default (`home_default`).
 *
 * Mendukung 2 pilihan gaya tata letak (`ane_default_style`):
 * - 'split' : Modern Split Magazine (1 Sorotan Utama di Kiri + 4 Berita List di Kanan)
 * - 'bento' : Bento News Grid (2 Sorotan Atas + 4 Berita List 2-Kolom di Bawah)
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_cat       = get_sub_field( 'pilih_kategori' );
$sekolahane_judul     = trim( (string) get_sub_field( 'custom_title' ) );
$sekolahane_style_raw = (string) get_sub_field( 'ane_default_style' );

$sekolahane_style_map   = array(
	'split' => 'news-default-split',
	'bento' => 'news-default-bento',
);
$sekolahane_style_key   = isset( $sekolahane_style_map[ $sekolahane_style_raw ] ) ? $sekolahane_style_raw : 'split';
$sekolahane_style_class = $sekolahane_style_map[ $sekolahane_style_key ];

$sekolahane_cat_id   = 0;
$sekolahane_cat_name = __( 'Berita Terbaru', 'sekolahane' );
$sekolahane_cat_url  = (string) get_post_type_archive_link( 'post' );

if ( $sekolahane_cat instanceof WP_Term ) {
	$sekolahane_cat_id   = (int) $sekolahane_cat->term_id;
	$sekolahane_cat_name = (string) $sekolahane_cat->name;
	$sekolahane_term_url = get_category_link( $sekolahane_cat_id );
	if ( is_string( $sekolahane_term_url ) && '' !== $sekolahane_term_url ) {
		$sekolahane_cat_url = $sekolahane_term_url;
	}
} elseif ( is_numeric( $sekolahane_cat ) && (int) $sekolahane_cat > 0 ) {
	$sekolahane_term_obj = get_term( (int) $sekolahane_cat, 'category' );
	if ( $sekolahane_term_obj instanceof WP_Term ) {
		$sekolahane_cat_id   = (int) $sekolahane_term_obj->term_id;
		$sekolahane_cat_name = (string) $sekolahane_term_obj->name;
		$sekolahane_term_url = get_category_link( $sekolahane_cat_id );
		if ( is_string( $sekolahane_term_url ) && '' !== $sekolahane_term_url ) {
			$sekolahane_cat_url = $sekolahane_term_url;
		}
	}
}

$sekolahane_heading = '' !== $sekolahane_judul ? $sekolahane_judul : $sekolahane_cat_name;

$sekolahane_base_args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
);
if ( $sekolahane_cat_id > 0 ) {
	$sekolahane_base_args['cat'] = $sekolahane_cat_id;
}
?>
<section class="home-default <?php echo esc_attr( $sekolahane_style_class ); ?>">
	<div class="container boxane">
		<div class="row">
			<div class="col-md-12 prlm-0">
				<div class="section-title">
					<div class="section-title-item">
						<a href="<?php echo esc_url( $sekolahane_cat_url ); ?>">
							<h1><?php echo esc_html( $sekolahane_heading ); ?></h1>
						</a>
					</div>
					<a class="lainnya" href="<?php echo esc_url( $sekolahane_cat_url ); ?>">
						<?php esc_html_e( 'Lihat Lainnya', 'sekolahane' ); ?>
						<?php echo sekolahane_icon( 'chevron-right-alt-2' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</div>
			</div>
		</div>

		<?php if ( 'bento' === $sekolahane_style_key ) : ?>
			<div class="ane-news-bento">
				<div class="ane-news-bento-top">
					<?php
					$sekolahane_top_args                   = $sekolahane_base_args;
					$sekolahane_top_args['posts_per_page'] = 2;
					$sekolahane_top_query                  = new WP_Query( $sekolahane_top_args );
					while ( $sekolahane_top_query->have_posts() ) :
						$sekolahane_top_query->the_post();
						get_template_part( 'tp/content', 'overlay' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
				<div class="ane-news-bento-bottom">
					<?php
					$sekolahane_bottom_args                   = $sekolahane_base_args;
					$sekolahane_bottom_args['posts_per_page'] = 4;
					$sekolahane_bottom_args['offset']         = 2;
					$sekolahane_bottom_query                  = new WP_Query( $sekolahane_bottom_args );
					while ( $sekolahane_bottom_query->have_posts() ) :
						$sekolahane_bottom_query->the_post();
						get_template_part( 'tp/content', 'list' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		<?php else : ?>
			<div class="ane-news-split">
				<div class="ane-news-featured">
					<?php
					$sekolahane_feat_args                   = $sekolahane_base_args;
					$sekolahane_feat_args['posts_per_page'] = 1;
					$sekolahane_feat_query                  = new WP_Query( $sekolahane_feat_args );
					while ( $sekolahane_feat_query->have_posts() ) :
						$sekolahane_feat_query->the_post();
						get_template_part( 'tp/content', 'overlay' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
				<div class="ane-news-list">
					<?php
					$sekolahane_list_args                   = $sekolahane_base_args;
					$sekolahane_list_args['posts_per_page'] = 4;
					$sekolahane_list_args['offset']         = 1;
					$sekolahane_list_query                  = new WP_Query( $sekolahane_list_args );
					while ( $sekolahane_list_query->have_posts() ) :
						$sekolahane_list_query->the_post();
						get_template_part( 'tp/content', 'list' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
