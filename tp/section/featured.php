<?php
defined( 'ABSPATH' ) || exit;
if( have_rows('ane_featured') ): ?>
<section class="section-featured">
    <div class="container">
        <ul>
            <?php while( have_rows('ane_featured') ): the_row();
                $link = get_sub_field('ane_link');
                $link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '';
                $link_title = is_array( $link ) && ! empty( $link['title'] ) ? $link['title'] : '';
                ?>
            <li>
                <a href="<?php echo esc_url( $link_url ); ?>">
                    <div class="item">
                        <?php
                        $image = get_sub_field('ane_icon');
                        $judul = get_sub_field('ane_title');
                        if( !empty( $judul ) ):
                        ?>
                        <div class="image">
                            <img src="<?php echo esc_url( (string) $image ); ?>" alt="<?php echo esc_attr( $judul ); ?>" title="<?php echo esc_attr( $judul ); ?>">
                        </div>
                        <?php endif; ?>
                        <div class="content">
                            <?php
                            $judul = get_sub_field('ane_title');
                            if( !empty( $judul ) ):
                            ?>
                            <h4><?php echo esc_html( $judul ); ?></h4>
                            <?php endif;
                            $deskripsi = get_sub_field('ane_deskripsi');
                            if( !empty( $deskripsi ) ):
                            ?>
                            <p><?php echo esc_html( $deskripsi ); ?></p>
                            <?php endif;
                            
                            if( !empty( $link_url ) ):
                             ?>
                            <a href="<?php echo esc_url( $link_url ); ?>" class="btn btn-primary"><?php echo esc_html( $link_title ); ?></a>
                            <?php endif; ?>
                        </div>

                    </div>
                </a>
            </li>

        <?php endwhile; ?></ul>
    </div>
</section>
<?php endif; ?>
