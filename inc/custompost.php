<?php
function sekolahane_Custom_Post_Type() {
	// Guru
	$labels = array(
		'name' 					=> 'Guru',
		'singular_name' 		=> 'Guru',
		'menu_name'				=> 'Guru',
		'all_items'        	 	=> 'Semua Guru',
		'add_new_item'      	=> 'Tambah Guru Baru',
		'add_new'           	=> 'Tambah Guru Baru',
		'new_item'          	=> 'Guru Baru',
		'edit_item'         	=> 'Edit Guru',
		'update_item'       	=> 'Update Guru',
		'search_items'      	=> 'Cari Guru',
		'featured_image'        => 'Foto Guru',
		'set_featured_image'    => 'Upload Foto Guru',
		'remove_featured_image' => 'Hapus Foto Guru',
		'use_featured_image'    => 'Jadikan Foto Guru',
		'name_admin_bar'		=> 'Guru',
	);
	$args = array(
		'labels'			=> $labels,
		'show_ui'			=> true,
		'show_in_menu'		=> true,
		'capability_type'	=> 'post',
		'public'            => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'has_archive'       => true,
		'hierarchical'		=> true,
		'show_in_rest'       => true,
		'menu_position'		=> 10,
		'menu_icon'			=> 'dashicons-businessman',
		'supports'			=> array( 'title', 'editor', 'thumbnail')

	);
	register_post_type( 'guru', $args );

	//Ekstrakurikuler
	$labels = array(
		'name' 					=> 'Ekstrakurikuler',
		'singular_name' 		=> 'Ekstrakurikuler',
		'menu_name'				=> 'Ekstrakurikuler',
		'all_items'        	 	=> 'Semua Ekstrakurikuler',
		'add_new_item'      	=> 'Tambah Ekstrakurikuler Baru',
		'add_new'           	=> 'Tambah Ekstrakurikuler Baru',
		'new_item'          	=> 'Ekstrakurikuler Baru',
		'edit_item'         	=> 'Edit Ekstrakurikuler',
		'update_item'       	=> 'Update Ekstrakurikuler',
		'search_items'      	=> 'Cari Ekstrakurikuler',
		'featured_image'        => 'Foto Ekstrakurikuler',
		'set_featured_image'    => 'Upload Foto Ekstrakurikuler',
		'remove_featured_image' => 'Hapus Foto Ekstrakurikuler',
		'use_featured_image'    => 'Jadikan Foto Ekstrakurikuler',
		'name_admin_bar'		=> 'Ekstrakurikuler',
	);
	$args = array(
		'labels'				=> $labels,
		'show_ui'				=> true,
		'show_in_menu'			=> true,
		'capability_type'		=> 'post',
		'public'            	=> true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'has_archive'       	=> true,
		'hierarchical'			=> true,
		'show_in_rest'			=> true,
		'menu_position'			=> 12,
		'menu_icon'				=> 'dashicons-groups',
		'supports'				=> array( 'title', 'editor', 'thumbnail')
	);
	register_post_type( 'ekstrakurikuler', $args );

	//Testimonials
	$labels = array(
		'name' 					=> 'Testimoni',
		'singular_name' 		=> 'Testimoni',
		'menu_name'				=> 'Testimoni',
		'all_items'        	 	=> 'Semua Testimoni',
		'add_new_item'      	=> 'Tambah Testimoni Baru',
		'add_new'           	=> 'Tambah Testimoni Baru',
		'new_item'          	=> 'Testimoni Baru',
		'edit_item'         	=> 'Edit Testimoni',
		'update_item'       	=> 'Update Testimoni',
		'search_items'      	=> 'Cari Testimoni',
		'featured_image'        => 'Foto Testimoni',
		'set_featured_image'    => 'Upload Foto Testimoni',
		'remove_featured_image' => 'Hapus Foto Testimoni',
		'use_featured_image'    => 'Jadikan Foto Testimoni',
		'name_admin_bar'		=> 'Testimoni',
	);
	$args = array(
		'labels'				=> $labels,
		'show_ui'				=> true,
		'show_in_menu'			=> true,
		'capability_type'		=> 'page',
		'public'            	=> true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'has_archive'       	=> true,
		'hierarchical'			=> true,
		'menu_position'			=> 13,
		'menu_icon'				=> 'dashicons-admin-comments',
		'supports'				=> array( 'title', 'thumbnail')
	);
	register_post_type( 'testimoni', $args );

}
add_action( 'init', 'sekolahane_Custom_Post_Type' );

//change title
function sekolahane_change_title_text( $title ){
     $screen = get_current_screen();

     if  ( 'guru' == $screen->post_type ) {
          $title = 'Nama Guru';
     }
	 if  ( 'ekstrakurikuler' == $screen->post_type ) {
          $title = 'Nama Ekstrakurikuler';
     }

	 if  ( 'testimoni' == $screen->post_type ) {
          $title = 'Nama Pemberi Testimoni';
     }

     return $title;
}
add_filter( 'enter_title_here', 'sekolahane_change_title_text' );

// Taxonomi
function sekolahane_taxonomies() {
// Pelajaran
	$labels = array(
		'name' => 'Pelajaran',
		'singular_name' => 'Pelajaran',
		'search_items' => 'Cari Pelajaran',
		'all_items' => 'Semua Pelajaran',
		'parent_item' => 'Parent Pelajaran',
		'parent_item_colon' => 'Parent Pelajaran:',
		'edit_item' => 'Edit Pelajaran',
		'update_item' => 'Update Pelajaran',
		'add_new_item' => 'Tambah Pelajaran',
		'new_item_name' => 'Jenis Pelajaran',
		'menu_name' => 'Pelajaran'
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'pelajaran' )
	);
	register_taxonomy('pelajaran', array('guru'), $args);
// Kelas
	$labels = array(
		'name' => 'Kelas',
		'singular_name' => 'Kelas',
		'search_items' => 'Cari Kelas',
		'all_items' => 'Semua Kelas',
		'parent_item' => 'Parent Kelas',
		'parent_item_colon' => 'Parent Kelas:',
		'edit_item' => 'Edit Kelas',
		'update_item' => 'Update Kelas',
		'add_new_item' => 'Tambah Kelas',
		'new_item_name' => 'Kelas Baru',
		'menu_name' => 'Kelas'
	);

	$args = array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'show_in_rest' => true,
		'rewrite' => array( 'slug' => 'kelas' )
	);
	register_taxonomy('Kelas', array('guru'), $args);
}

add_action( 'init' , 'sekolahane_taxonomies' );

// add Custom Posts to feeds
function sekolahane_custom_post_feed( $query ) {
        if ( $query->is_feed() )
            $query->set( 'post_type', array( 'post', 'guru', 'ekstrakurikuler' ) );
        return $query;
}
add_filter( 'pre_get_posts', 'sekolahane_custom_post_feed' );
