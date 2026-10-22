<section class="home-slider v2">
    <div class="home-big-slider owl-carousel">
        <?php if( have_rows('home_slider') ):
            while( have_rows('home_slider') ): the_row();
            $bg = get_sub_field('ane_background');
            ?>
                <div class="home-slider-item" style="background: url('<?= $bg; ?>');">
                    <div class="container">
                        <?php
                        $judul = get_sub_field('ane_title');
                            if( !empty( $judul ) ): ?>
                            <div class="text">
                                <div class="text-content">
                                    <h1><?= $judul; ?> </h1>
                                    <?php
                                        $deskripsi = get_sub_field('ane_deskripsi');
                                        if( !empty( $deskripsi ) ): ?>
                                        <p><?= $deskripsi; ?></p>
                                    <?php
                                            endif;
                                            $link = get_sub_field('ane_link');
                                            if( !empty( $link ) ): ?>
                                            <a href="<?php echo $link['url']; ?>"><button class="btn btn-primary"><?php echo $link['title']; ?></button></a>
                                        <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>


                    </div>
                </div>
        <?php endwhile;endif; ?>
    </div>
    <!-- container end-->
    <div class="pemanis-slider center_curve_alt bottom">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" preserveAspectRatio="none" viewBox="0 0 100 100">
        <path d="M 0 0 L0 100 L100 100 L100 0 Q 50 200 0 0"></path>
        </svg>
    </div>
</section>
