<div class="ane-mobile-list">
<?php if( have_rows('ane_mobile_landingpage','option') ): ?>
    <nav class="ane-mobile-nav">
        <ul>
            <?php while( have_rows('ane_mobile_landingpage','option') ) : the_row();
                $kategori = get_sub_field('pilih_kategori');
                $link = get_sub_field('ane_link');
                $icon = get_sub_field('ane_icon');
                if( !empty( $kategori ) ):
            ?>
        <li>
            <a href="<?php echo get_category_link($kategori->term_id); ?>"><i class="fa <?= $icon ?>"></i><span><?php echo esc_html( $kategori->name ); ?></span></a>
        </li>
        <?php else: ?>
            <li>
                <a href="<?php echo $link['url']; ?>"><i class="fa <?= $icon ?>"></i><span><?php echo $link['title']; ?></span></a>
            </li>
        <?php endif; endwhile; ?>
        </ul>
    </nav>
<?php endif; ?>
</div>
