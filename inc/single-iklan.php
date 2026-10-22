<?php

add_filter( 'the_content', 'sekolahane_iklan_single_post_google' );
function sekolahane_iklan_single_post_google( $content ) {
	$ad_code = '<div class="kabarane-iklan-google">
					<div class="row justify-content-center">
					    <div class="col-md-5">
						 <!--- masukan kode google -->
                    	</div>
                    </div>
				</div>';
    if ( is_singular('post') && ! is_admin() ) {
        return prefix_insert_after_paragraph( $ad_code, 8, $content );
    }

    return $content;
}


add_filter( 'the_content', 'sekolahane_iklan_single_post_umum' );
function sekolahane_iklan_single_post_umum( $content ) {
	while( have_rows('banner_post','option') ): the_row();
	$banner = esc_attr (get_sub_field('iklan_image') );
    $url = esc_attr (get_sub_field('url_iklan') );
	$nama = esc_attr (get_sub_field('iklan_nama') );
    $akhir = ceil((strtotime(get_sub_field('iklan_berakhir', 'option')) - time())/(60*60*24));
	$mulai = ceil((strtotime(get_sub_field('iklan_mulai')) - time())/(60*60*24));
	$today = ceil((strtotime(date('Y-m-d')) - time())/(60*60*24));
	$online  = $akhir - $today;

	if ($mulai == 0) {
        $ad_code = '
		<div class="post-banner" style="display: block">
		<a href="' .$url. '" target="_blank" alt="'. $nama .'" 	title="'. $nama .'">
		<img class="img-fluid" src="' .$banner. '" alt="'. $nama .'" title="'. $nama .'">
		</a>
		<div class="post-banner-info">'. $nama .'</div>
		</div>
		';
    }
    elseif ($online >= 0){
		$ad_code = '
		<div class="post-banner" style="display: block">
		<a href="' .$url. '" target="_blank" alt="'. $nama .'" 	title="'. $nama .'">
		<img class="img-fluid" src="' .$banner. '" alt="'. $nama .'" title="'. $nama .'">
		</a>
		<div class="post-banner-info">'. $nama .'</div>
		</div>
		';
    }
    else {
		$ad_code = '
		<div class="post-banner" style="display: none">
		<a href="' .$url. '" target="_blank" alt="'. $nama .'" 	title="'. $nama .'">
		<img class="img-fluid" src="' .$banner. '" alt="'. $nama .'" title="'. $nama .'">
		</a>
		<div class="post-banner-info">'. $nama .'</div>
		</div>
		';
    }
    if ( is_singular('post') && ! is_admin() ) {
        return prefix_insert_after_paragraph( $ad_code, 2, $content );
    }
endwhile;

    return $content;
}

// fungsi paragraf webane

function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
    $closing_p = '</p>';
    $paragraphs = explode( $closing_p, $content );
    foreach ($paragraphs as $index => $paragraph) {

        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }

        if ( $paragraph_id == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
    }

    return implode( '', $paragraphs );
}
