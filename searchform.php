<?php
/**
 * Form pencarian theme Sekolah Ane.
 *
 * @package Sekolahane
 */

defined( 'ABSPATH' ) || exit;
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" class="form-control" placeholder="<?php echo esc_attr_x( 'Mencari Sesuatu? &hellip;', 'placeholder', 'sekolahane' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	<button class="gradient"><i class="ane-search"></i></button>
</form>
