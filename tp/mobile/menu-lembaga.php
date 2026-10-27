<?php
defined( 'ABSPATH' ) || exit;
if( have_rows('ane_list_lembaga','option') ): ?>
    <nav class="ane-mobile-nav">
        <ul>
            <?php while( have_rows('ane_list_lembaga','option') ) : the_row();
                $link = get_sub_field('ane_link');
                $icon = get_sub_field('ane_icon');
                $link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '';
                $link_title = is_array( $link ) && ! empty( $link['title'] ) ? $link['title'] : '';
            ?>
        <li>
            <a href="<?php echo esc_url( $link_url ); ?>"><?php echo sekolahane_icon( (string) $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $link_title ); ?></span></a>
        </li>
        <?php endwhile; ?>
        </ul>
    </nav>
<?php endif; ?>
