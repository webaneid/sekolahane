	<section class="home-ekstrakurikuler">
		<div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="home-title text-center">
                        <?php
                            $judul = get_sub_field('ane_title');
                            if( !empty( $judul ) ){
    							echo '<h2>'. $judul .'</h2>';
    						}
    						else {
    							echo '<h2>Ekstra<span>kurikuler</span></h2>';
    						}
                            $deskripsi  = get_sub_field('ane_deskripsi');
                            if( !empty( $deskripsi ) ) {
    							echo '<p>'. esc_attr($deskripsi) .'</p>';
    						}
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12">
				<div class="owl-carousel dot-style2" id="home-sliding">
                    <?php $the_query = new WP_Query(array('post_type' => 'ekstrakurikuler', 'posts_per_page' => 8));
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        get_template_part( 'tp/content', 'ekstrakurikuler' );
                    endwhile; wp_reset_postdata();  ?>
				</div>
			</div>
			</div>
		</div><!-- container end-->
	</section>
