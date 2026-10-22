<?php
function kabarane_customize_color()
{
?>
<style type="text/css">
    .body {
        color: <?php echo get_theme_mod( 'warna_gelap' ,  ' #0c1201 ' ); ?>!important;
    }
    a {
        color: <?php echo get_theme_mod( 'warna_aktif' ,  ' #70aa05 ' ); ?>!important;
    }
    a:hover {
        color: <?php echo get_theme_mod( 'warna_aktif_hover' ,  ' #086649 ' ); ?> !important;
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
        background-color: <?php echo get_theme_mod( 'warna_utama' ,  ' #70aa05 ' ); ?>!important;
    }
    .bg-gelap{
        background-color: <?php echo get_theme_mod( 'warna_gelap' ,  ' #0c1201 ' ); ?>!important;
    }
    .section-guru .home-title h2 span,
    .halaman-testimoni,
    .section-featured,
    .wp-block-latest-posts,
    .bg-terang {
        background-color: <?php echo get_theme_mod( 'warna_terang' ,  ' #f7feea ' ); ?>!important;
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
        background-color: <?php echo get_theme_mod( 'warna_utama' ,  ' #70aa05 ' ); ?>!important;
        color: <?php echo get_theme_mod( 'warna_terang' ,  ' #f7feea ' ); ?>!important;
    }
    .wpcf7-submit:hover[type="submit"],
    .pagination-area ul li a:hover,
    .wp-block-file .wp-block-file__button:hover,
    .bga-utama a:hover {
        background-color: <?php echo get_theme_mod( 'warna_gelap' ,  ' #0c1201 ' ); ?>!important;
        color: #fff !important;
    }
    .pagination-area ul li span,
    .bga-gelap a {
        background-color: <?php echo get_theme_mod( 'warna_gelap' ,  ' #0c1201 ' ); ?>!important;
        color: #fff !important;
    }
    .btn-primary,
    .pagination-area ul li span:hover,
    .bga-gelap a:hover {
        background-color: <?php echo get_theme_mod( 'warna_utama' ,  ' #70aa05 ' ); ?>!important;
        color: <?php echo get_theme_mod( 'warna_terang' ,  ' #f7feea ' ); ?>!important;
    }
    .main-menu li ul li a,
    .pagination-area ul li a.prev,
    .pagination-area ul li a.next,
    .bga-terang a {
        background-color: <?php echo get_theme_mod( 'warna_terang' ,  ' #f7feea ' ); ?>!important;
        color: <?php echo get_theme_mod( 'warna_gelap' ,  ' #0c1201 ' ); ?>!important;
    }
    .btn-primary:hover,
    .pagination-area ul li a.prev:hover,
    .pagination-area ul li a.next:hover {
        background-color:<?php echo get_theme_mod( 'warna_gelap' ,  ' #0c1201 ' ); ?>!important;
        color: <?php echo get_theme_mod( 'warna_terang' ,  ' #f7feea ' ); ?>!important;
    }
    .bga-putih a {
        background-color: #fff!important;
    }
    *,
    .b-1,.bb-1,.bt-1,.br-1,.bl-1 {
        border-color: <?php echo get_theme_mod( 'warna_terang' ,  ' #f7feea ' ); ?>!important;
    }
    .section-featured ul li  {
        border-color: <?php echo get_theme_mod( 'warna_utama' ,  ' #70aa05 ' ); ?>!important;
    }
    .section-guru .home-title h2 span,
    .single-post .entry-content>ul>li::before,
    .c-utama {
        color: <?php echo get_theme_mod( 'warna_utama' ,  ' #70aa05 ' ); ?>!important;
    }
    .c-gelap{
        color: <?php echo get_theme_mod( 'warna_gelap' ,  ' #0c1201 ' ); ?>!important;
    }
    .home-title h2 span,
    .section-featured ul li:nth-child(2),
    blockquote::before,
    .c-terang {
        color: <?php echo get_theme_mod( 'warna_terang' ,  ' #f7feea ' ); ?>!important;
    }
    .c-putih {
        color: #fff!important;
    }

    .ca-utama a{
        color: <?php echo get_theme_mod( 'warna_utama' ,  ' #70aa05 ' ); ?>!important;
    }
    .ca-utama a:hover{
        color: <?php echo get_theme_mod( 'warna_gelap' ,  ' #0c1201 ' ); ?>!important;
    }
    ul.main-menu >li> a,
    .ca-gelap a{
        color: <?php echo get_theme_mod( 'warna_gelap' ,  ' #0c1201 ' ); ?>!important;
    }
    .ca-gelap a:hover{
        color: <?php echo get_theme_mod( 'warna_utama' ,  ' #70aa05 ' ); ?>!important;
    }

    .mobile-page .konten-klasik .post-title a,
    .ca-terang a {
        color: <?php echo get_theme_mod( 'warna_terang' ,  ' #f7feea ' ); ?>!important;
    }
    .ca-terang a:hover {
        color: <?php echo get_theme_mod( 'warna_utama' ,  ' #70aa05 ' ); ?>!important;
    }
    .ca-putih a {
        color: #fff!important;
    }
    .ca-putih a:hover {
        color: <?php echo get_theme_mod( 'warna_utama' ,  ' #70aa05 ' ); ?>!important;
    }
    .post-title a {
        color: <?php echo get_theme_mod( 'warna_judul' ,  ' #182501 ' ); ?>!important;
    }
    .content-overlay .entry-header .entry-header-meta .post-title a:hover,
    .post-title a:hover {
        color: <?php echo get_theme_mod( 'warna_judul_hover' ,  ' #3f6003 ' ); ?>!important;
    }
    .section-featured ul li:nth-child(2),
    ul.main-menu >li> a:hover,
    .gradient {
        background-image: -webkit-linear-gradient(70deg, <?php echo get_theme_mod( 'bg_menu_1' ,  ' #086649 ' ); ?> 0%, <?php echo get_theme_mod( 'bg_menu_2' ,  ' #70aa05 ' ); ?>  100%);
        background-image: -o-linear-gradient(70deg, <?php echo get_theme_mod( 'bg_menu_1' ,  ' #086649 ' ); ?> 0%, <?php echo get_theme_mod( 'bg_menu_2' ,  ' #70aa05 ' ); ?>  100%);
        background-image: linear-gradient(20deg, <?php echo get_theme_mod( 'bg_menu_1' ,  ' #086649 ' ); ?> 0%, <?php echo get_theme_mod( 'bg_menu_2' ,  ' #70aa05 ' ); ?>  100%);
    }
    ul.main-menu >li> a:hover,
    .search-form button {
        color: <?php echo get_theme_mod( 'warna_menu' ,  ' #ffffff ' ); ?>  !important;
    }
    .footer-bg {
        background-image: -webkit-linear-gradient(70deg, <?php echo get_theme_mod( 'warna_footer_1' ,  ' #086649 ' ); ?> 0%, <?php echo get_theme_mod('warna_footer_2', '#70aa05'); ?> 100%);
        background-image: -o-linear-gradient(70deg, <?php echo get_theme_mod( 'warna_footer_1' ,  ' #086649 ' ); ?> 0%, <?php echo get_theme_mod('warna_footer_2', '#70aa05'); ?> 100%);
        background-image: linear-gradient(20deg, <?php echo get_theme_mod( 'warna_footer_1' ,  ' #086649 ' ); ?> 0%, <?php echo get_theme_mod('warna_footer_2', '#70aa05'); ?> 100%);
        color: <?php echo get_theme_mod('warna_footer', '#f1f1f1'); ?>;
    }
    .footer-bg a {
        color: <?php echo get_theme_mod('warna_footer', '#ffffff'); ?>!important;
    }
    @media (max-width: 767px) {
        .if-mobile .konten-klasik .post-title a {
            color: <?php echo get_theme_mod( 'warna_terang' ,  ' #f7feea ' ); ?>!important;
        }
        .if-mobile .konten-klasik {
            background-color: <?php echo get_theme_mod( 'warna_utama' ,  ' #70aa05 ' ); ?>!important;
            color: <?php echo get_theme_mod( 'warna_terang' ,  ' #f7feea ' ); ?>!important;
        }
    }

 </style>
<?php
}
add_action( 'wp_head', 'kabarane_customize_color');
