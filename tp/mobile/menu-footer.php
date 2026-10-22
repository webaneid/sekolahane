<?php
$urlhome = home_url( '/' );
if( have_rows('ane_mobile_menu','option') ): ?>
<div id="footer-bar" class="footer-bar-1">
	<a href="<?php echo $urlhome; ?>"><i class="fa fa-home"></i><span>Home</span></a>
    <?php while( have_rows('ane_mobile_menu','option') ) : the_row();
        $link = get_sub_field('ane_link');
        $icon = get_sub_field('ane_icon');
    ?>
	<a href="<?php echo $link['url']; ?>"><i class="fa <?= $icon ?>"></i><span><?php echo $link['title']; ?></span></a>
	<?php endwhile; ?>
</div>
<?php endif; ?>
