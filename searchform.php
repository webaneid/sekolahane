	<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="text" class="form-control" placeholder="<?php echo esc_attr_x( 'Mencari Sesuatu?  &hellip;', 'placeholder', 'webane' ); ?>" value="<?php echo get_search_query(); ?>" name="s" >
		<button class="gradient"><i class="ane-search"></i></button>
	</form>
