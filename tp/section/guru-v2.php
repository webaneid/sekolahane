<?php
defined( 'ABSPATH' ) || exit;
?>
	<section class="home-guru">
		<div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 post-tengah">
                    <div class="home-title text-left">
                        <?php
                            $urlhome = home_url();
                            $judul   = get_sub_field('ane_title');
                            if( !empty( $judul ) ){
    							echo '<h2>'. esc_html( (string) $judul ) .'</h2>';
    						}
    						else {
    							echo '<h2>Dewan <span>Guru</span></h2>';
    						}
                            $deskripsi  = get_sub_field('ane_deskripsi');
                            if( !empty( $deskripsi ) ) {
    							echo '<p>'. esc_html( (string) $deskripsi ) .'</p>';
							}
                        ?>
						<a href="<?php echo esc_url( $urlhome . '/guru' ); ?>" alt="Semua Guru">
						<button class="btn btn-primary" type="button" name="button"><?php _e('Semua Guru','sekolahane'); ?></button>
						</a>
                    </div>
                </div>
				<div class="col-md-6">
					<div class="ane-list-guru">
	                    <?php $the_query = new WP_Query(array('post_type' => 'guru', 'posts_per_page' => 4));
	                    while ( $the_query->have_posts() ) : $the_query->the_post();
	                        get_template_part( 'tp/content', 'guru' );
	                    endwhile; wp_reset_postdata();  ?>
					</div>
				</div>
            </div>

		</div><!-- container end-->
	</section>
