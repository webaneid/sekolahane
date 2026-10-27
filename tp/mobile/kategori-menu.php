<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="ane-mobile-list">
<?php if( have_rows('ane_menu_kategori','option') ): ?>
    <nav class="ane-mobile-nav">
        <ul>
            <?php while( have_rows('ane_menu_kategori','option') ) : the_row();
                $kategori = get_sub_field('pilih_kategori');
                $icon = get_sub_field('ane_icon');
            ?>
        <li>
            <a href="<?php echo esc_url( get_category_link( $kategori->term_id ) ); ?>"><?php echo sekolahane_icon( (string) $icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $kategori->name ); ?></span></a>
        </li>
        <?php endwhile; ?>
        </ul>
    </nav>
<?php endif; ?>
</div>
