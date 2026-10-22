<?php
defined( 'ABSPATH' ) || exit;
function kabarane_customize_color()
{
	$warna_gelap       = esc_attr( get_theme_mod( 'warna_gelap', '#0c1201' ) );
	$warna_aktif       = esc_attr( get_theme_mod( 'warna_aktif', '#70aa05' ) );
	$warna_aktif_hover = esc_attr( get_theme_mod( 'warna_aktif_hover', '#086649' ) );
	$warna_utama       = esc_attr( get_theme_mod( 'warna_utama', '#70aa05' ) );
	$warna_terang      = esc_attr( get_theme_mod( 'warna_terang', '#f7feea' ) );
	$warna_judul       = esc_attr( get_theme_mod( 'warna_judul', '#182501' ) );
	$warna_judul_hover = esc_attr( get_theme_mod( 'warna_judul_hover', '#3f6003' ) );
	$bg_menu_1         = esc_attr( get_theme_mod( 'bg_menu_1', '#086649' ) );
	$bg_menu_2         = esc_attr( get_theme_mod( 'bg_menu_2', '#70aa05' ) );
	$warna_menu        = esc_attr( get_theme_mod( 'warna_menu', '#ffffff' ) );
	$warna_footer_1    = esc_attr( get_theme_mod( 'warna_footer_1', '#086649' ) );
	$warna_footer_2    = esc_attr( get_theme_mod( 'warna_footer_2', '#70aa05' ) );
	$warna_footer      = esc_attr( get_theme_mod( 'warna_footer', '#f1f1f1' ) );
	$warna_footer_link = esc_attr( get_theme_mod( 'warna_footer', '#ffffff' ) );
?>
<style type="text/css">
    .body {
        color: <?php echo $warna_gelap; ?>!important;
    }
    a {
        color: <?php echo $warna_aktif; ?>!important;
    }
    a:hover {
        color: <?php echo $warna_aktif_hover; ?> !important;
    }
    .section-guru,
    .owl-nav .owl-prev,
    .owl-nav .owl-next,
    .home-title h2 span,
    .section-title::before,
    .entry-content>h4::before,
    .entry-content>h3::after,
    .entry-content h2::before,
    .entry-content h2::after,
    .general-title::before,
    .general-title::after,
    .bg-utama {
        background-color: <?php echo $warna_utama; ?>!important;
    }
    .bg-gelap{
        background-color: <?php echo $warna_gelap; ?>!important;
    }
    .section-guru .home-title h2 span,
    .halaman-testimoni,
    .section-featured,
    .wp-block-latest-posts,
    .bg-terang {
        background-color: <?php echo $warna_terang; ?>!important;
    }
    .bg-putih {
        background-color: #fff!important;
    }
    .mobile-page .konten-klasik,
    .wpcf7-submit[type="submit"],
    .pagination-area ul li a,
    .wp-block-file .wp-block-file__button,
    .main-menu li ul li a:hover,
    .bga-utama a {
        background-color: <?php echo $warna_utama; ?>!important;
        color: <?php echo $warna_terang; ?>!important;
    }
    .wpcf7-submit:hover[type="submit"],
    .pagination-area ul li a:hover,
    .wp-block-file .wp-block-file__button:hover,
    .bga-utama a:hover {
        background-color: <?php echo $warna_gelap; ?>!important;
        color: #fff !important;
    }
    .pagination-area ul li span,
    .bga-gelap a {
        background-color: <?php echo $warna_gelap; ?>!important;
        color: #fff !important;
    }
    .btn-primary,
    .pagination-area ul li span:hover,
    .bga-gelap a:hover {
        background-color: <?php echo $warna_utama; ?>!important;
        color: <?php echo $warna_terang; ?>!important;
    }
    .main-menu li ul li a,
    .pagination-area ul li a.prev,
    .pagination-area ul li a.next,
    .bga-terang a {
        background-color: <?php echo $warna_terang; ?>!important;
        color: <?php echo $warna_gelap; ?>!important;
    }
    .btn-primary:hover,
    .pagination-area ul li a.prev:hover,
    .pagination-area ul li a.next:hover {
        background-color:<?php echo $warna_gelap; ?>!important;
        color: <?php echo $warna_terang; ?>!important;
    }
    .bga-putih a {
        background-color: #fff!important;
    }
    *,
    .b-1,.bb-1,.bt-1,.br-1,.bl-1 {
        border-color: <?php echo $warna_terang; ?>!important;
    }
    .section-featured ul li  {
        border-color: <?php echo $warna_utama; ?>!important;
    }
    .section-guru .home-title h2 span,
    .single-post .entry-content>ul>li::before,
    .c-utama {
        color: <?php echo $warna_utama; ?>!important;
    }
    .c-gelap{
        color: <?php echo $warna_gelap; ?>!important;
    }
    .home-title h2 span,
    .section-featured ul li:nth-child(2),
    blockquote::before,
    .c-terang {
        color: <?php echo $warna_terang; ?>!important;
    }
    .c-putih {
        color: #fff!important;
    }

    .ca-utama a{
        color: <?php echo $warna_utama; ?>!important;
    }
    .ca-utama a:hover{
        color: <?php echo $warna_gelap; ?>!important;
    }
    ul.main-menu >li> a,
    .ca-gelap a{
        color: <?php echo $warna_gelap; ?>!important;
    }
    .ca-gelap a:hover{
        color: <?php echo $warna_utama; ?>!important;
    }

    .mobile-page .konten-klasik .post-title a,
    .ca-terang a {
        color: <?php echo $warna_terang; ?>!important;
    }
    .ca-terang a:hover {
        color: <?php echo $warna_utama; ?>!important;
    }
    .ca-putih a {
        color: #fff!important;
    }
    .ca-putih a:hover {
        color: <?php echo $warna_utama; ?>!important;
    }
    .post-title a {
        color: <?php echo $warna_judul; ?>!important;
    }
    .content-overlay .entry-header .entry-header-meta .post-title a:hover,
    .post-title a:hover {
        color: <?php echo $warna_judul_hover; ?>!important;
    }
    .section-featured ul li:nth-child(2),
    ul.main-menu >li> a:hover,
    .gradient {
        background-image: -webkit-linear-gradient(70deg, <?php echo $bg_menu_1; ?> 0%, <?php echo $bg_menu_2; ?>  100%);
        background-image: -o-linear-gradient(70deg, <?php echo $bg_menu_1; ?> 0%, <?php echo $bg_menu_2; ?>  100%);
        background-image: linear-gradient(20deg, <?php echo $bg_menu_1; ?> 0%, <?php echo $bg_menu_2; ?>  100%);
    }
    ul.main-menu >li> a:hover,
    .search-form button {
        color: <?php echo $warna_menu; ?>  !important;
    }
    .footer-bg {
        background-image: -webkit-linear-gradient(70deg, <?php echo $warna_footer_1; ?> 0%, <?php echo $warna_footer_2; ?> 100%);
        background-image: -o-linear-gradient(70deg, <?php echo $warna_footer_1; ?> 0%, <?php echo $warna_footer_2; ?> 100%);
        background-image: linear-gradient(20deg, <?php echo $warna_footer_1; ?> 0%, <?php echo $warna_footer_2; ?> 100%);
        color: <?php echo $warna_footer; ?>;
    }
    .footer-bg a {
        color: <?php echo $warna_footer_link; ?>!important;
    }
    @media (max-width: 767px) {
        .if-mobile .konten-klasik .post-title a {
            color: <?php echo $warna_terang; ?>!important;
        }
        .if-mobile .konten-klasik {
            background-color: <?php echo $warna_utama; ?>!important;
            color: <?php echo $warna_terang; ?>!important;
        }
    }

 </style>
<?php
}
add_action( 'wp_head', 'kabarane_customize_color');
