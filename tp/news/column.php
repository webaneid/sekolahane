<?php
defined( 'ABSPATH' ) || exit;
    // $ColumnItems = get_sub_field('column_item');
    if( have_rows('column_item') ):
?>
<section class="home-column">
    <div class="container">
        <div class="row justify-content-center pt-15">
            <?php while ( have_rows('column_item') ) : the_row();
                $ColumnCat = get_sub_field('column_cat');
                $ColumnTitle = get_sub_field('column_title');
            ?>
                <div class="col-md-4 prlm-0">
                    <div class="home-column-item">
                        <div class="section-title">
                            <div class="section-title-item">
                                <?php if(!empty($ColumnTitle)): ?>
                                    <a href="<?php echo esc_url( get_category_link( $ColumnCat->term_id ) ); ?>"><h1><?php echo esc_html( $ColumnTitle ); ?></h1></a>
                                <?php else: ?>
                                    <a href="<?php echo esc_url( get_category_link( $ColumnCat->term_id ) ); ?>"><h1><?php echo esc_html( $ColumnCat->name ); ?></h1></a>
                                <?php endif; ?>
                            </div>
                            <a class="lainnya" href="<?php echo esc_url( get_category_link( $ColumnCat->term_id ) ); ?>"><?php esc_html_e( 'Lainnya', 'sekolahane' ); ?> <?php echo sekolahane_icon( 'chevron-right-alt-2' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
                        </div>
                        <div class="kepalanya">
                            <?php $the_query = new WP_Query(array('post_type' => 'post','cat' => get_cat_ID(''. $ColumnCat->name .''),  'posts_per_page' => 1));
                            while ( $the_query->have_posts() ) : $the_query->the_post();
                                get_template_part( 'tp/content', 'overlay' );
                            endwhile; wp_reset_postdata();  ?>
                        </div>
                        <div class="badannya">
                            <?php $the_query = new WP_Query(array('post_type' => 'post', 'cat' => get_cat_ID(''. $ColumnCat->name .''), 'posts_per_page' => 4,'offset' => 1));
                            while ( $the_query->have_posts() ) : $the_query->the_post();
                                get_template_part( 'tp/content', 'list' );
                            endwhile; wp_reset_postdata();  ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>
