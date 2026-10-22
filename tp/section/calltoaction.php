<?php
defined( 'ABSPATH' ) || exit;
    $image = get_sub_field('ane_background');
    if( !empty( $image ) ):
?>
<section class="home-cta" style="background-image: url('<?php echo esc_url( (string) $image ); ?>')">
    <div class="ane-calltoaction">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-8">
                                <div class="text">
                                    <?php
                                    $judul = get_sub_field('ane_title');
                                    if( !empty( $judul ) ):
                                    ?>
                                    <h1><?php echo wp_kses_post( $judul ); ?></h1>
                                    <?php endif;
                                    $deskripsi = get_sub_field('ane_deskripsi');
                                    if( !empty( $deskripsi ) ):
                                    ?>
                                    <p><?php echo wp_kses_post( $deskripsi ); ?></p>
                                    <?php endif;
                                    $link = get_sub_field('ane_link');
                                    if( is_array( $link ) && ! empty( $link['url'] ) ):
                                     ?>
                                    <a href="<?php echo esc_url( $link['url'] ); ?>" class="btn btn-alternatif"><?php echo esc_html( $link['title'] ?? '' ); ?></a>
                                    <?php endif; ?>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
</section>
<?php endif; ?>
