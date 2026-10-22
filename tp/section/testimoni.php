<?php
defined( 'ABSPATH' ) || exit;
?>
<section class="home-testimoni">
	<div class="container">
		<div class="row justify-content-center">
            <div class="col-md-8">
                <div class="home-title text-center">
                    <?php
                        $judul = get_sub_field('ane_title');
                        if( !empty( $judul ) ){
							echo '<h2>' . wp_kses_post( $judul ) . '</h2>';
						}
						else {
							echo '<h2>Testi<span>moni</span></h2>';
						}
                        $deskripsi  = get_sub_field('ane_deskripsi');
                        if( !empty( $deskripsi ) ) {
							echo '<p>' . esc_html( $deskripsi ) . '</p>';
						}
                    ?>
                </div>
            </div>
        </div>

		<div class="testimoni-item">
			<div class="testimoni-slider owl-carousel">
				<?php
				$the_query = new WP_Query(array('post_type' => 'testimoni', 'posts_per_page' => 9 ));

				while ( $the_query->have_posts() ) : $the_query->the_post();

					get_template_part( 'tp/content', 'testimoni' );

				endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</section>
