<?php
/**
 * Template part: Section Banner Iklan (`tp/section/banner.php`).
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;

$sekolahane_perusahaan   = (string) get_sub_field( 'home_banner_perusahaan' );
$sekolahane_url          = (string) get_sub_field( 'home_banner_url' );
$sekolahane_nama         = (string) get_sub_field( 'home_banner_name' );
$sekolahane_image        = (string) get_sub_field( 'home_banner_image' );
$sekolahane_mulai        = ceil( ( (int) strtotime( (string) get_sub_field( 'home_banner_start' ) ) - time() ) / DAY_IN_SECONDS );
$sekolahane_akhir        = ceil( ( (int) strtotime( (string) get_sub_field( 'Home_banner_end' ) ) - time() ) / DAY_IN_SECONDS );
$sekolahane_today        = ceil( ( (int) strtotime( gmdate( 'Y-m-d' ) ) - time() ) / DAY_IN_SECONDS );
$sekolahane_online       = $sekolahane_akhir - $sekolahane_today;
$sekolahane_banner_style = ( 0.0 === $sekolahane_mulai || $sekolahane_online >= 0 ) ? 'display: block' : 'display: none';
$sekolahane_banner_label = $sekolahane_nama . ' by ' . $sekolahane_perusahaan;
?>
<section class="section-banner" style="<?php echo esc_attr( $sekolahane_banner_style ); ?>">
	<div class="container">
		<a href="<?php echo esc_url( $sekolahane_url ); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( $sekolahane_banner_label ); ?>">
			<div class="ane-image">
				<img src="<?php echo esc_url( $sekolahane_image ); ?>" width="1140" height="240" loading="lazy" decoding="async" title="<?php echo esc_attr( $sekolahane_banner_label ); ?>" alt="<?php echo esc_attr( $sekolahane_banner_label ); ?>">
				<div class="banner-info">
					ad by <?php echo esc_html( $sekolahane_perusahaan ); ?>
				</div>
			</div>
		</a>
	</div>
</section>
