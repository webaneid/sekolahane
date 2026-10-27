<?php
defined( 'ABSPATH' ) || exit;
if( have_rows('ane_data_sekolah') ): ?>
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
                        <?php echo sekolahane_icon( (string) $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                    <div class="ms-4 lh-1">
                        <h2 class="mb-0 fw-bold"><?php echo esc_html( (string) $jml ); ?></h2>
                        <p class="mb-0"><?php echo esc_html( (string) $title ); ?></p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>
