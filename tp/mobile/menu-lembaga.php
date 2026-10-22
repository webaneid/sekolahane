<?php if( have_rows('ane_list_lembaga','option') ): ?>
    <nav class="ane-mobile-nav">
        <ul>
            <?php while( have_rows('ane_list_lembaga','option') ) : the_row();
                $link = get_sub_field('ane_link');
                $icon = get_sub_field('ane_icon');
            ?>
        <li>
            <a href="<?php echo $link['url']; ?>"><i class="fa <?= $icon ?>"></i><span><?php echo $link['title']; ?></span></a>
        </li>
        <?php endwhile; ?>
        </ul>
    </nav>
<?php endif; ?>
