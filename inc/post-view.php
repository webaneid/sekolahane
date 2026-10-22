<?php
defined( 'ABSPATH' ) || exit;
function get_views($postID = ''){
	if($GLOBALS ):
		if($postID =='') :
			global $post;
			$postID = $post->ID ;
		endif;
		$count_key = 'musi_views';
	    	$count = get_post_meta($postID, $count_key, true);
		$count = @number_format($count);
	    	if($count==''):
	        	delete_post_meta($postID, $count_key);
	        	add_post_meta($postID, $count_key, '0');
	        	$count = 0;
	    	endif;
			$count_views =  sprintf( _n( '%s view', '%s views', $count, 'musi' ), $count );
    		return $count_views;
    	else:
    		return false;
    	endif;
}

function set_views($postID = '') {
	if( $GLOBALS && (!defined('WP_CACHE') || !WP_CACHE) ) :
		if($postID =='') :
			global $post;
			$postID = $post->ID ;
		endif;
	    	$count_key = 'musi_views';
	    	$count = get_post_meta($postID, $count_key, true);
		if($count==''):
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		else:
			$count++;
			update_post_meta($postID, $count_key, $count);
		endif;
	else:
		return false;
	endif;
}

// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

add_filter('manage_posts_columns', 'musi_column_views');
add_action('manage_posts_custom_column', 'musi_custom_column_views',5,2);

function musi_column_views($defaults){
   	$defaults['musi_post_views'] = __('Views');
   	return $defaults;
}

function musi_custom_column_views($column_name, $id){
	if($column_name === 'musi_post_views'):
        	echo get_views(get_the_ID());
    	endif;
}

add_action('wp_enqueue_scripts', 'musi_postview_cache_count_enqueue');
function musi_postview_cache_count_enqueue() {
	global $post;
	if ( is_single() && (defined('WP_CACHE') && WP_CACHE) && $GLOBALS) :
		wp_register_script('musi-postviews-cache', get_template_directory_uri() . '/js/postviews-cache.js', array( 'jquery' ) );
		wp_localize_script('musi-postviews-cache', 'postViewsCache', array('admin_ajax_url' => admin_url('admin-ajax.php', (is_ssl() ? 'https' : 'http')), 'post_id' => $post->ID));
		wp_enqueue_script('musi-postviews-cache');
	endif;
}

add_action('wp_ajax_postviews', 'musi_increment_views');
add_action('wp_ajax_nopriv_postviews', 'musi_increment_views');
function musi_increment_views() {
	global $wpdb;
	if(!empty($_GET['postviews_id']) && (defined('WP_CACHE') && WP_CACHE) && $GLOBALS):
		$post_id = intval($_GET['postviews_id']);
		if($post_id > 0) :
			$count_key = 'musi_views';
			$count = get_post_meta($post_id, $count_key, true);
			if($count==''):
				$count = 0;
				delete_post_meta($post_id, $count_key);
				add_post_meta($post_id, $count_key, '0');
			else:
				$count++;
				update_post_meta($post_id, $count_key, $count);
			endif;
		endif;
	endif;
	exit();
}
?>
