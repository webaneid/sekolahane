<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="ane-mobile-list">
<?php if( have_rows('ane_mobile_landingpage','option') ): ?>
    <nav class="ane-mobile-nav">
        <ul>
            <?php while( have_rows('ane_mobile_landingpage','option') ) : the_row();
                $kategori = get_sub_field('pilih_kategori');
                $link = get_sub_field('ane_link');
                $icon = get_sub_field('ane_icon');
                $link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '';
                $link_title = is_array( $link ) && ! empty( $link['title'] ) ? $link['title'] : '';
                if( !empty( $kategori ) ):
            ?>
        <li>
            <a href="<?php echo esc_url( get_category_link( $kategori->term_id ) ); ?>"><i class="fa <?php echo esc_attr( (string) $icon ); ?>"></i><span><?php echo esc_html( $kategori->name ); ?></span></a>
        </li>
        <?php else: ?>
            <li>
                <a href="<?php echo esc_url( $link_url ); ?>"><i class="fa <?php echo esc_attr( (string) $icon ); ?>"></i><span><?php echo esc_html( $link_title ); ?></span></a>
            </li>
        <?php endif; endwhile; ?>
        </ul>
    </nav>
<?php endif; ?>
</div>
