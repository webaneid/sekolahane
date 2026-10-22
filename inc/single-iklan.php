<?php
defined( 'ABSPATH' ) || exit;

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
	$banner = esc_url( (string) get_sub_field( 'iklan_image' ) );
    $url = esc_url( (string) get_sub_field( 'url_iklan' ) );
	$nama_attr = esc_attr( (string) get_sub_field( 'iklan_nama' ) );
	$nama_html = esc_html( (string) get_sub_field( 'iklan_nama' ) );
    $akhir = ceil((strtotime((string) get_sub_field('iklan_berakhir', 'option')) - time())/(60*60*24));
	$mulai = ceil((strtotime((string) get_sub_field('iklan_mulai')) - time())/(60*60*24));
	$today = ceil((strtotime(gmdate('Y-m-d')) - time())/(60*60*24));
	$online  = $akhir - $today;

	$display_style = ( 0 == $mulai || $online >= 0 ) ? 'block' : 'none';
	$ad_code = '
		<div class="post-banner" style="display: ' . $display_style . '">
		<a href="' . $url . '" target="_blank" rel="noopener noreferrer" alt="' . $nama_attr . '" title="' . $nama_attr . '">
		<img class="img-fluid" src="' . $banner . '" alt="' . $nama_attr . '" title="' . $nama_attr . '">
		</a>
		<div class="post-banner-info">' . $nama_html . '</div>
		</div>
		';

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
