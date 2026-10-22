<?php
defined( 'ABSPATH' ) || exit;
$urlhome = home_url( '/' );
if( have_rows('ane_mobile_menu','option') ): ?>
<div id="footer-bar" class="footer-bar-1">
	<a href="<?php echo esc_url( $urlhome ); ?>"><i class="fa fa-home"></i><span>Home</span></a>
    <?php while( have_rows('ane_mobile_menu','option') ) : the_row();
        $link = get_sub_field('ane_link');
        $icon = get_sub_field('ane_icon');
        $link_url = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '';
        $link_title = is_array( $link ) && ! empty( $link['title'] ) ? $link['title'] : '';
    ?>
	<a href="<?php echo esc_url( $link_url ); ?>"><i class="fa <?php echo esc_attr( (string) $icon ); ?>"></i><span><?php echo esc_html( $link_title ); ?></span></a>
	<?php endwhile; ?>
</div>
<?php endif; ?>
