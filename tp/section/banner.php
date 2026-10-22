<?php
    $perusahaan= get_sub_field('home_banner_perusahaan');
    $url = get_sub_field('home_banner_url');
    $nama = get_sub_field('home_banner_name');
    $image = get_sub_field('home_banner_image');
    $mulai = ceil((strtotime(get_sub_field('home_banner_start')) - time())/(60*60*24));
    $akhir = ceil((strtotime(get_sub_field('Home_banner_end')) - time())/(60*60*24));
    $today = ceil((strtotime(date('Y-m-d')) - time())/(60*60*24));
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
?>
    <div class="container">
            <a href="<?php echo $url; ?>" target="_blank" title="<?php echo $nama." by ".$perusahaan; ?>" alt="<?php echo $nama." by ".$perusahaan; ?>">
                <div class="ane-image">
                    <img src="<?= $image; ?>" title="<?php echo $nama." by ".$perusahaan; ?>" alt="<?php echo $nama." by ".$perusahaan; ?>">
                    <div class="banner-info">
                        ad by <?php echo $perusahaan; ?>
                    </div>
                </div>
            </a>
    </div>
</section>
