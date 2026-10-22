<?php
    $image = get_sub_field('ane_background');
    if( !empty( $image ) ):
?>
<section class="home-cta" style="background-image: url('<?php echo $image; ?>')">
    <div class="ane-calltoaction">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-8">
                                <div class="text">
                                    <?php
                                    $judul = get_sub_field('ane_title');
                                    if( !empty( $judul ) ):
                                    ?>
                                    <h1><?php echo $judul; ?></h1>
                                    <?php endif;
                                    $deskripsi = get_sub_field('ane_deskripsi');
                                    if( !empty( $deskripsi ) ):
                                    ?>
                                    <p><?php echo $deskripsi; ?></p>
                                    <?php endif;
                                    $link = get_sub_field('ane_link');
                                    if( !empty( $link ) ):
                                     ?>
                                    <a href="<?php echo $link['url']; ?>" class="btn btn-alternatif"><?php echo $link['title']; ?></a>
                                    <?php endif; ?>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
</section>
<?php endif; ?>
