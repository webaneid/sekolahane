var $ = jQuery.noConflict();
$(document).ready(function(){
	$.ajax({
		type:"GET",
		url:postViewsCache.admin_ajax_url,
		data:"postviews_id="+postViewsCache.post_id+"&action=postviews",
		cache:!1,
	});
});