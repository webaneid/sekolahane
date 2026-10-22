<?php
if ( ! is_active_sidebar( 'default-sidebar' ) ) {
	return;
}
?>
<aside class="col-sm-4 col-md-12 col-lg-4 col-12 p0-m" id="sticky-sidebar">
	<div class="right-sidebar sticky-top">
		<?php dynamic_sidebar( 'default-sidebar' ); ?>
	</div>
</aside>
