<?php
function panggil_konten_terkait() {
	global $post; ?>
<div class="konten-terkait">
	<?php
	$tags = wp_get_post_tags($post->ID);
	if ($tags) {

		$first_tag = $tags[0]->term_id;
		$args=array(
			'tag__in' => array($first_tag),
			'post__not_in' => array($post->ID),
			'posts_per_page'=>5,
			'caller_get_posts'=>1
		);
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() ) { ?>
			<h2 class="general-title"><?php _e( 'Konten Terkait', 'rentcarane' ); ?></h2>
			<div class="isi-konten-terkait">
				<?php while ($my_query->have_posts()) : $my_query->the_post();
					$detect = new Mobile_Detect();

					if( !$detect->isTablet() ) {
						get_template_part( 'tp/content','list' );

					}
					else {
						get_template_part( 'tp/content', get_post_format() );
					}
				endwhile;?>
			</div>
		<?php }
		wp_reset_query();
} ?>

</div>
<?php }
