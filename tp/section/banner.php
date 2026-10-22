<?php
defined( 'ABSPATH' ) || exit;
    $perusahaan= get_sub_field('home_banner_perusahaan');
    $url = get_sub_field('home_banner_url');
    $nama = get_sub_field('home_banner_name');
    $image = get_sub_field('home_banner_image');
    $mulai = ceil((strtotime((string) get_sub_field('home_banner_start')) - time())/(60*60*24));
    $akhir = ceil((strtotime((string) get_sub_field('Home_banner_end')) - time())/(60*60*24));
    $today = ceil((strtotime(gmdate('Y-m-d')) - time())/(60*60*24));
	$online  = $akhir - $today;
    if ($mulai == 0) {
        echo '<section class="section-banner" style="display: block">';
    }
    elseif ($online >= 0){
        echo '<section class="section-banner" style="display: block">';
    }
    else {
        echo '<section class="section-banner" style="display: none">';
    }
    $banner_label = $nama . ' by ' . $perusahaan;
?>
    <div class="container">
            <a href="<?php echo esc_url( (string) $url ); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( $banner_label ); ?>" alt="<?php echo esc_attr( $banner_label ); ?>">
                <div class="ane-image">
                    <img src="<?php echo esc_url( (string) $image ); ?>" title="<?php echo esc_attr( $banner_label ); ?>" alt="<?php echo esc_attr( $banner_label ); ?>">
                    <div class="banner-info">
                        ad by <?php echo esc_html( (string) $perusahaan ); ?>
                    </div>
                </div>
            </a>
    </div>
</section>
