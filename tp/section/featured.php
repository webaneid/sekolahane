<?php if( have_rows('ane_featured') ): ?>
<section class="section-featured">
    <div class="container">
        <ul>
            <?php while( have_rows('ane_featured') ): the_row();
                $link = get_sub_field('ane_link'); ?>
            <li>
                <a href="<?php echo $link['url']; ?>">
                    <div class="item">
                        <?php
                        $image = get_sub_field('ane_icon');
                        $judul = get_sub_field('ane_title');
                        if( !empty( $judul ) ):
                        ?>
                        <div class="image">
                            <img src="<?= $image; ?>" alt="<?= $judul; ?>" title="<?= $judul; ?>">
                        </div>
                        <?php endif; ?>
                        <div class="content">
                            <?php
                            $judul = get_sub_field('ane_title');
                            if( !empty( $judul ) ):
                            ?>
                            <h4><?= $judul; ?></h4>
                            <?php endif;
                            $deskripsi = get_sub_field('ane_deskripsi');
                            if( !empty( $deskripsi ) ):
                            ?>
                            <p><?= $deskripsi; ?></p>
                            <?php endif;
                            
                            if( !empty( $link ) ):
                             ?>
                            <a href="<?php echo $link['url']; ?>" class="btn btn-primary"><?php echo $link['title']; ?></a>
                            <?php endif; ?>
                        </div>

                    </div>
                </a>
            </li>

        <?php endwhile; ?></ul>
    </div>
</section>
<?php endif; ?>
