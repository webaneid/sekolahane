<?php
/**
 * Template part: Halaman Profil Lembaga (`tp/pages/profil.php`).
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

$sekolahane_headline = get_field( 'ane_headline' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'landing-page ane-page-profil' ); ?>>
	<div class="container-fluid">
		<div class="row">
			<header class="entry-header">
				<img class="ane-overlay-bg" src="<?php echo esc_url( $sekolahane_img_url ); ?>"<?php echo '' !== $sekolahane_img_srcset ? ' srcset="' . esc_attr( $sekolahane_img_srcset ) . '" sizes="(max-width: 767px) 400px, 1000px"' : ''; ?> width="<?php echo esc_attr( (string) $sekolahane_img_w ); ?>" height="<?php echo esc_attr( (string) $sekolahane_img_h ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" fetchpriority="high" decoding="async">
				<div class="container">
					<div class="isi">
						<div class="text-isi">
							<?php the_title( '<h1 class="post-title general-title">', '</h1>' ); ?>
							<p><?php echo esc_html( (string) $sekolahane_headline ); ?></p>
						</div>
					</div>
				</div>
			</header>
		</div>
	</div>

	<div class="entry-content">
		<?php get_template_part( 'tp/section/angka' ); ?>
		<?php
		if ( have_rows( 'profil_content' ) ) :
			while ( have_rows( 'profil_content' ) ) :
				the_row();

				if ( 'home_featured' === get_row_layout() ) :
					get_template_part( 'tp/section/featured' );
				elseif ( 'home_cta' === get_row_layout() ) :
					get_template_part( 'tp/section/calltoaction' );
				elseif ( 'home_testimoni' === get_row_layout() ) :
					get_template_part( 'tp/section/testimoni' );
				elseif ( 'ane_content_profil' === get_row_layout() ) :
					get_template_part( 'tp/section/content' );
				elseif ( 'home_ekstrakurikuler' === get_row_layout() ) :
					get_template_part( 'tp/section/ekstra' );
				elseif ( 'home_guru' === get_row_layout() ) :
					get_template_part( 'tp/section/guru-v2' );
				elseif ( 'home_funfact' === get_row_layout() ) :
					get_template_part( 'tp/section/funfact' );
				elseif ( 'home_general_info' === get_row_layout() ) :
					get_template_part( 'tp/section/general-info' );
				elseif ( 'home_banner' === get_row_layout() ) :
					get_template_part( 'tp/section/banner' );
				endif;
			endwhile;
		endif;
		?>
		<div class="ane-mobile-list">
			<div class="container">
				<?php get_template_part( 'tp/mobile/menu-lembaga' ); ?>
			</div>
		</div>
	</div>
</article>
