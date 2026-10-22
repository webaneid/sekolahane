<?php if( have_rows('ane_data_sekolah') ): ?>
<section class="ane-data">
    <div class="container">
        <div class="row">
            <?php while( have_rows('ane_data_sekolah') ): the_row();
                $icon = get_sub_field('ane_icon');
                $title = get_sub_field('ane_title');
                $jml = get_sub_field('ane_jumlah');

            ?>
            <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                <div class="d-flex align-items-center justify-content-center py-4">
                    <div>
                        <i class="fa <?php echo $icon ?>"></i>
                    </div>
                    <div class="ms-4 lh-1">
                        <h2 class="mb-0 fw-bold"><?php echo $jml; ?></h2>
                        <p class="mb-0"><?php echo $title ?></p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>
