<?php
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Webane General Information',
		'menu_title'	=> 'Webane Settings',
		'menu_slug' 	=> 'webane-theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Your Banners Settings',
		'menu_title'	=> 'Your Banners',
		'parent_slug'	=> 'webane-theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Customer Care',
		'menu_title'	=> 'Customer Care',
		'parent_slug'	=> 'webane-theme-general-settings',
	));


}
