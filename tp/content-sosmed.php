<?php if( have_rows('sosmed_ane','option') ): ?>
<div class="ane-sosmed">
    <ul>
        <?php
            while( have_rows('sosmed_ane','option') ): the_row();
            $facebook = get_sub_field('sosmed_fb');
            $whatsapp = get_sub_field('sosmed_wa');
            $instagram = get_sub_field('sosmed_ig');
            $twitter = get_sub_field('sosmed_tw');
            $youtube = get_sub_field('sosmed_youtube');

            if( !empty( $whatsapp ) ):
        ?>
        <li><a class="whatsapp" href="https://wa.me/<?= $whatsapp;?>" target="_blank"><i class="ane-whatsapp"></i></a></li>
        <?php
            endif;
            if( !empty( $facebook ) ):
        ?>
            <li><a class="facebook" href="<?= $facebook; ?>"><i class="ane-facebook"></i></a></li>
            <?php
                endif;
                if( !empty( $twitter ) ):
            ?>
            <li><a class="twitter" href="https://twitter.com/<?= $twitter; ?>" target="_blank"><i class="ane-twitter"></i></a></li>
            <?php
                endif;
                if( !empty( $youtube ) ):
            ?>
            <li><a class="youtube" href="<?= $youtube; ?>"><i class="ane-youtube"></i></a></li>
            <?php
                endif;
                if( !empty( $instagram ) ):
            ?>
            <li><a class="instagram" href="https://instagram.com/<?= $instagram; ?>" target="_blank"><i class="ane-instagram"></i></a></li>
            <?php endif; ?>
        <?php endwhile; ?>
    </ul>
</div>
<?php endif; ?>
