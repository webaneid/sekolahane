<?php
defined( 'ABSPATH' ) || exit;
    $homekategori = get_sub_field('pilih_kategori');
    $judul = get_sub_field('custom_title');
?>
<section class="home-default">
    <div class="container boxane">
        <div class="row">
            <div class="col-md-12 prlm-0">
                <div class="section-title">

                    <div class="section-title-item">
                        <?php if(!empty($judul)): ?>
                            <a href="<?php echo esc_url( get_category_link( $homekategori->term_id ) ); ?>"><h1><?php echo esc_html( $judul ); ?></h1></a>
                        <?php else: ?>
                            <a href="<?php echo esc_url( get_category_link( $homekategori->term_id ) ); ?>"><h1><?php echo esc_html( $homekategori->name ); ?></h1></a>
                        <?php endif; ?>
                    </div>
                    <a class="lainnya" href="<?php echo esc_url( get_category_link( $homekategori->term_id ) ); ?>"><?php esc_html_e( 'Lihat Lainnya', 'sekolahane' ); ?> <?php echo sekolahane_icon( 'chevron-right-alt-2' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
                </div>
            </div>
        </div>
        <div class="ane-col-73">
            <div class="ane-kiri">
                <div class="ane-kiri-1">
                    <?php $the_query = new WP_Query(array('post_type' => 'post','cat' => get_cat_ID(''. $homekategori->name .''),  'posts_per_page' => 1));
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        get_template_part( 'tp/content', 'overlay' );
                    endwhile; wp_reset_postdata();  ?>
                </div>
                
                <div class="ane-kiri-2">
                    <?php $the_query = new WP_Query(array('post_type' => 'post', 'cat' => get_cat_ID(''. $homekategori->name .''), 'posts_per_page' => 5,'offset' => 1));
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        get_template_part( 'tp/content', 'list' );
                    endwhile; wp_reset_postdata();  ?>
                </div>
            </div>
            
            <div class="ane-kanan">
                <div class="konten-populer">
                        <h1>Populer</h1>
                        <div class="isinya">
                            <ol>
                                <?php $the_query = new WP_Query(array('post_type' => 'post', 'cat' => get_cat_ID(''. $homekategori->name .''), 'posts_per_page' => 8,'orderby'   => 'meta_value_num','meta_key'   => 'musi_views',));
                                while ( $the_query->have_posts() ) : $the_query->the_post();
                                    echo '<li>';
                                    get_template_part( 'tp/content', 'list-title' );
                                    echo '</li>';
                                endwhile; wp_reset_postdata();  ?>
                            </ol>
                        </div>

                    </div>

            </div>

        </div>
    </div>
</section>
