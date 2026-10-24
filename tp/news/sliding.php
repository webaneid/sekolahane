<?php
defined( 'ABSPATH' ) || exit;
    $homekategori = get_sub_field('home_sliding_kategori');
    $judul = get_sub_field('custom_title');
?>
	<section class="home-sliding">
		<div class="container">
            <div class="row">
            <div class="col-md-12 prlm-0 tazakka-box">
                <div class="section-title">
                    <div class="section-title-item">
                        <?php if(!empty($judul)): ?>
                            <a href="<?php echo esc_url( get_category_link( $homekategori->term_id ) ); ?>"><h1><?php echo esc_html( $judul ); ?></h1></a>
                        <?php else: ?>
                            <a href="<?php echo esc_url( get_category_link( $homekategori->term_id ) ); ?>"><h1><?php echo esc_html( $homekategori->name ); ?></h1></a>
                        <?php endif; ?>
                    </div>
                    <a class="lainnya" href="<?php echo esc_url( get_category_link( $homekategori->term_id ) ); ?>"><?php esc_html_e( 'Lainnya', 'sekolahane' ); ?> <?php echo sekolahane_icon( 'chevron-right-alt-2' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
                </div>

				<div class="owl-carousel dot-style2" id="home-sliding">
                    <?php $the_query = new WP_Query(array('post_type' => 'post','cat' => get_cat_ID(''. $homekategori->name .''),  'posts_per_page' => 8));
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        get_template_part( 'tp/content', 'overlay' );
                    endwhile; wp_reset_postdata();  ?>
				</div>
			</div>
			</div>
		</div><!-- container end-->
	</section>
