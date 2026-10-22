<?php
// 01. load css and js
function ane_load_css_and_js(){
	wp_enqueue_style( 'FontAne', get_template_directory_uri() . '/css/FontAne.css');
	wp_enqueue_style( 'FontsAwsome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'Google-Fonts', 'https://fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700,800,900', false );
	wp_enqueue_style( 'magnific-popup','https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css' );
	wp_enqueue_style( 'OwlCarouse','https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css' );
    wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');
	wp_enqueue_style( 'sekolahane-css', get_template_directory_uri() . '/css/main.min.css', array(), '1.0.6');

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery' ,'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js');
	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'magnific', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js' );
	wp_enqueue_script( 'OwlCarousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js' );
	wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
	wp_enqueue_script( 'googlemap', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBddpckvgjXaGHbHLkaPaCVQh7A0j44lj0', array('jquery'), true );
	wp_enqueue_script( 'sekolahane-js', get_template_directory_uri() . '/js/sekolahane.js');
}
add_action( 'wp_enqueue_scripts', 'ane_load_css_and_js' );
/*
	1. Google
*/
function ane_google_map_init() {

	acf_update_setting('google_api_key', 'AIzaSyBddpckvgjXaGHbHLkaPaCVQh7A0j44lj0');
}

add_action('acf/init', 'ane_google_map_init');

// 02. excerpt
function new_excerpt_length($length) {
	return 15;
}
add_filter('excerpt_length', 'new_excerpt_length', 15 );
function change_excerpt( $text )
{
    $pos = strrpos( $text, '[');
    if ($pos === false)
    {
        return $text;
    }

    return rtrim (substr($text, 0, $pos) );
}
add_filter('get_the_excerpt', 'change_excerpt');

// 03. Gallery options
add_filter('the_content', 'webane_popup_gallery');
function webane_popup_gallery($content) {
       global $post;
       $pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
       $replacement = '<a$1href=$2$3.$4$5 class="gallery-popup" title="'.$post->post_title.'"$6>';
       $content = preg_replace($pattern, $replacement, $content);
       return $content;
}

function sekolahane_caption( $attr, $content = null ) {
    $output = apply_filters( 'img_caption_shortcode', '', $attr, $content );
    if ( $output != '' )
        return $output;

    extract( shortcode_atts ( array(
    'id' => '',
    'align' => 'alignnone',
    'width'=> '',
    'caption' => ''
    ), $attr ) );

    if ( 1 > (int) $width || empty( $caption ) )
        return $content;

    if ( $id ) $id = 'id="' . $id . '" ';

    return '<figure ' . $id . 'class="wp-caption ' . $align . '" style="width: ' . $width . 'px">'
. do_shortcode( $content ) . '<figcaption class="wp-caption-text">' . $caption . '</figcaption></figure>';
}

add_shortcode( 'wp_caption', 'sekolahane_caption' );
add_shortcode( 'caption', 'sekolahane_caption' );
// 04-b. thumbnail error
function sekolahane_dummy_tumbnail ()
{
	$dummythumb = get_theme_mod( 'dummythumb', get_template_directory_uri().'/img/dummy-thumbnail.jpg' );

    return $dummythumb;
}

// embeded video
function ane_get_embedded_media($type = array())
{
    $content = do_shortcode(apply_filters('the_content', get_the_content()));
    $embed = get_media_embedded_in_content($content, $type);
    if (in_array('audio', $type)):
        $output = str_replace('?visual=true', '?visual=false', $embed[0]); else:
        $output = $embed[0];
    endif;

    return $output;
}
// Youtube Thumbnail Image
function ane_get_youtube_thumbnail($url, $size = ''){
    $thumbBaseUri = 'https://img.youtube.com/vi/';
    $id = '';
    $size = $size ? $size.'default.jpg': 'default.jpg';
    if(preg_match('/iframe/', $url)){
        $id = preg_replace('/[\s\S]*\/embed\/|"[\s\S]*|\?[\s\S]*/', '', $url);
    }
    elseif(preg_match('/youtu\.be/', $url) || $embed = preg_match('/embed/', $url)){
        $id = preg_replace("/^((?![^\/]+$).)*/", '', $url);
    }
    else{
        $id = preg_replace("/^((?![^\?v]+$).)*=|&[^\&]*/", '', $url);
    }

    return "$thumbBaseUri$id/$size";
}

//Dummy images
function ane_dummy_tumbnail ()
{
	$dummythumb = get_theme_mod( 'dummythumb', get_template_directory_uri().'/img/no-image.jpg' );

    return $dummythumb;
}
function ane_dummy_kotak ()
{
	$dummythumb = get_theme_mod( 'dummythumb', get_template_directory_uri().'/img/no-image-kotak.jpg' );

    return $dummythumb;
}
// paginasi
function ane_post_pagination( \WP_Query $wp_query = null, $echo = true ) {
	if ( null === $wp_query ) {
		global $wp_query;
	}
	$pages = paginate_links( [
			'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'format'       => '?paged=%#%',
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'total'        => $wp_query->max_num_pages,
			'type'         => 'array',
			'show_all'     => false,
			'end_size'     => 3,
			'mid_size'     => 1,
			'prev_next'    => true,
			'prev_text'    => __( '<i class="fa fa-chevron-left"></i>' ),
			'next_text'    => __( '<i class="fa fa-chevron-right"></i>' ),
			'add_args'     => false,
			'add_fragment' => ''
		]
	);
	if ( is_array( $pages ) ) {
		$pagination = '<div class="ane-paginasi"><ul>';
		foreach ( $pages as $page ) {
			$pagination .= '<li>' . str_replace( 'webane', 'webane', $page ) . '</li>';
		}
		$pagination .= '</ul></div>';
		if ( $echo ) {
			echo $pagination;
		} else {
			return $pagination;
		}
	}
	return null;
}

// related post
function ane_related_post ()
{
	global $post;
    $tags = wp_get_post_tags( $post->ID);
    $all_tags = $tags[0]->term_id;
    if ($tags) {
        $args=array(
			'tag__in' => array($all_tags),
			'post__not_in' => array($post->ID),
			'posts_per_page'=>5,
			'caller_get_posts'=>1,
            'orderby' => 'rand',
		);

        $related_query = new WP_Query($args);
        if( $related_query ->have_posts() ) { ?>
            <span><?php _e( 'Post Terkait', 'anelogistik' ); ?></span>
            <div class="isi-konten-terkait">
                <?php while ($related_query ->have_posts()) : $related_query ->the_post();

                        get_template_part( 'tp/content','list' );

                endwhile;?>
            </div>
        <?php }
        wp_reset_query();
    }
}

//newest post
function ane_newest_posts ()
{
	global $post;
    $args=array(
        'posts_per_page'=>5,
        'caller_get_posts'=>1,
    );

    $newest_query = new WP_Query($args);
    if( $newest_query ->have_posts() ) { ?>
        <span><?php _e( 'Konten Terbaru', 'sekolahane' ); ?></span>
        <div class="isi-konten">
            <?php while ($newest_query ->have_posts()) : $newest_query ->the_post();

                    get_template_part( 'tp/content','list' );

            endwhile;?>
        </div>
    <?php }
    wp_reset_query();
}

// next and prev posts
function ane_prev_next_post()
{
    global $post;

    $prev_post = get_previous_post(true);
    if ( has_post_thumbnail($prev_post) ) {
    $prev_thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($prev_post), 'kotak');
    $prev_img = $prev_thumbImg['0'];
    } else {
        $prev_img = ane_dummy_kotak();
    }

    $next_post = get_next_post(true);
    if ( has_post_thumbnail($next_post) ) {
    $next_thumbImg = wp_get_attachment_image_src( get_post_thumbnail_id($next_post), 'kotak');
    $next_img = $next_thumbImg['0'];
    } else {
        $next_img = ane_dummy_kotak();
    }
    $next_title = esc_html( get_the_title($next_post) );
    $prev_title = esc_html( get_the_title($prev_post) );

    $content = '<div class="row">';
    $content .= '<div class="col-md-6">';
    if (!empty( $prev_post )){
    $content .= '

                <div class="nav-header-prev">
                    <span><i class="fa fa-chevron-left"></i> Prev Post</span>
                </div>
                <article class="ane-konten-nav">
                    <div class="entry-header">
                        <a href="'. get_permalink( $prev_post->ID ) .'">
                            <div class="ane-image">
                                <img src="'.$prev_img.'" alt="'. $prev_post->post_title. '" title="'. $prev_post->post_title. '">
                            </div>
                        </a>
                    </div>
                    <div class="entry-content">
                        <a href="'. get_permalink( $prev_post->ID) .'">
                        '. $prev_post->post_title. '</a>
                    </div>
                </article>

                ';
    }
    $content .= '</div>';
    $content .= '<div class="col-md-6">';
    if (!empty( $next_post )) {
    $content .= '
                <div class="nav-header-prev text-right">
                    <span>Next Post <i class="fa fa-chevron-right"></i></span>
                </div>
                <article class="ane-konten-nav nav-next">
                    <div class="entry-header">
                        <a href="'. get_permalink( $next_post->ID ) .'">
                            <div class="ane-image">
                                <img src="'.$next_img.'" alt="'. $next_post->post_title. '" title="'. $next_post->post_title. '">
                            </div>
                        </a>
                    </div>
                    <div class="entry-content">
                        <a href="'. get_permalink( $next_post->ID ) .'">
                        '. $next_post->post_title. '</a>
                    </div>
                </article>

                ';
    }
    $content .= '</div>';
    $content .= '</div>';
    return $content;
    
}

// times ago
function times_ago($seconds = 1, $time=false){
	$time = "";
	$d = $seconds;
	//$seconds = (int)strtotime($seconds);
		if ( ! is_numeric($seconds)) $seconds = 1;
		if ( ! is_numeric($time)) $time = current_time('timestamp', $gmt = 0);
		//if ( ! is_numeric($time)) $time = time()+25200;
		if ($time <= $seconds) $seconds = 1;
		else $seconds = $time - $seconds;
		$str = '';
		$years = floor($seconds / 31536000);
		$months = floor($seconds / 2628000);
		$weeks = floor($seconds / 604800);
		$days = floor($seconds / 86400);
		$hours = floor($seconds / 3600);
	    $minutes = floor($seconds / 60);
		if ($years > 5) :
			$str = date_i18n( get_option('date_format'), strtotime(get_the_time("Y-m-d")));
			if($time) :
				$str .= " ". esc_html(get_the_time( )) ;
			endif;
		elseif ($years > 0) :
			$str =  sprintf( _n( '%s tahun lalu', '%s tahun lalu', $years, 'musi' ), $years );
		elseif ($months > 0) :
			$str =  sprintf( _n( '%s bulan lalu', '%s bulan lalu', $months, 'musi' ), $months );
		elseif ($weeks > 0) :
			$str =  sprintf( _n( '%s minggu lalu', '%s minggu lalu', $weeks, 'musi' ), $weeks );
		elseif ($days > 0) :
			$str =  sprintf( _n( '%s hari lalu', '%s hari lalu', $days, 'musi' ), $days );
		elseif ($hours > 0) :
			$str =  sprintf( _n( '%s jam lalu', '%s jam lalu', $hours, 'musi' ), $hours );
		elseif ($minutes > 0) :
			$str =  sprintf( _n( '%s menit lalu', '%s menit lalu', $minutes, 'musi' ), $minutes );
		else :
			$str =  sprintf( _n( '%s detik lalu', '%s detik lalu', $seconds, 'musi' ), $seconds );
		endif;
	return (trim($str));
}
function ane_load_times_ago()
{
	$timestamp = esc_attr( get_the_time( 'U' ) );

    return '
	<div class="meta-time">
		<i class="fa fa-clock-o"></i>
		'. times_ago($timestamp) . '
	</div>
	';
}
// fungsi share sosmed
function fungsi_share_webane()
{
	global $post;
	$content = '<div class="social-share-buttons mt-20">';

	$title = get_the_title();
	$permalink = get_permalink($post->ID);

	$twitterHandler = (get_option('twitter_handler') ? '&amp;via='.esc_attr(get_option('twitter_handler')) : '');

	$twitter = 'https://twitter.com/intent/tweet?text=Hey! Read this: '.$title.'&amp;url='.$permalink.$twitterHandler.'';
	$facebook = 'https://www.facebook.com/sharer/sharer.php?u='.$permalink;
	$google = 'https://plus.google.com/share?url='.$permalink;
	$whatsapp = 'whatsapp://send?text=Share:'.$permalink;
	$linkedin = 'http://www.linkedin.com/shareArticle?mini=true&url='.$permalink;

	$content .= '<ul>';
	$content .= '<li><div class="fb-like" data-href="'.$permalink.'" data-width="" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div></li>';

	$content .= '<li><a class="twitter" href="'.$twitter.'" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a></li>';
	$content .= '<li><a class="whatsapp" href="'.$whatsapp.'" target="_blank" rel="nofollow"><i class="fa fa-whatsapp"></i></a></li>';
	$content .= '<li><a class="linkedin" href="'.$linkedin.'" target="_blank" rel="nofollow"><i class="fa fa-linkedin"></i></a></li>';
	$content .= '</ul></div><!-- .webane-share -->';

	return $content;
}

// fungsi komen facebook
function fungsi_komen_facebook_webane()
{
    global $post;
$content = '';
$content .= '<script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v5.0&appId=150033455013036&autoLogAppEvents=1"></script>';
$content .='<div id="fb-root">
				<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1'.$appid.'&version=v2.3";
				fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));</script>
				<div class="fb-comments" data-href="'.get_permalink().'" data-numposts="10" data-width="100%">
				</div>
			</div>';
return $content;
}

// --== adding author bio ==-

function sekolahane_author_info_box( $content ) {
global $post;

if ( is_single() && isset( $post->post_author ) ) {
$display_name = get_the_author_meta( 'display_name', $post->post_author );
if ( empty( $display_name ) )
$display_name = get_the_author_meta( 'nickname', $post->post_author );
$user_description = get_the_author_meta( 'user_description', $post->post_author );
$user_website = get_the_author_meta('url', $post->post_author);
$user_posts = get_author_posts_url( get_the_author_meta( 'ID' , $post->post_author));

if ( ! empty( $display_name ) )
	$author_details = '<h2 class="author_name">Penulis: ' . $display_name . '</h2>';

if ( ! empty( $user_description ) )
$author_details .= '<div class="author_details">' . get_avatar( get_the_author_meta('user_email') , 90 ) . nl2br( $user_description ). '</div>';

$author_details .= '<div class="author_links"><a href="'. $user_posts .'">Semua tulisan ' . $display_name . '</a>';

if ( ! empty( $user_website ) ) {

$author_details .= ' | <a href="' . $user_website .'" target="_blank" rel="nofollow">Website</a></div>';

} else {

$author_details .= '</div>';
}

$content = $content . '<footer class="author_bio_section" >' . $author_details . '</footer>';
}
return $content;
}

add_action( 'the_content', 'sekolahane_author_info_box' );
remove_filter('pre_user_description', 'wp_filter_kses');

function fungsi_breadcrumbs_webane()
{
    // Set variables for later use
    $here_text        = __( 'You are currently here!' );
    $home_link        = home_url('/');
    $home_text        = __( '<i class="fa fa-home"></i>' );
    $link_before      = '<li class="parent-page">';
    $link_after       = '</li>';
    $link_attr        = ' rel="v:url" property="v:title"';
    $link             = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
    $delimiter        = '';              // Delimiter between crumbs
    $before           = '<li>'; // Tag before the current crumb
    $after            = '</li>';                // Tag after the current crumb
    $page_addon       = '';                       // Adds the page number if the query is paged
    $breadcrumb_trail = '';
    $category_links   = '';

    /**
     * Set our own $wp_the_query variable. Do not use the global variable version due to
     * reliability
     */
    $wp_the_query   = $GLOBALS['wp_the_query'];
    $queried_object = $wp_the_query->get_queried_object();

    // Handle single post requests which includes single pages, posts and attatchments
    if ( is_singular() )
    {
        /**
         * Set our own $post variable. Do not use the global variable version due to
         * reliability. We will set $post_object variable to $GLOBALS['wp_the_query']
         */
        $post_object = sanitize_post( $queried_object );

        // Set variables
        $title          = apply_filters( 'the_title', $post_object->post_title );
        $parent         = $post_object->post_parent;
        $post_type      = $post_object->post_type;
        $post_id        = $post_object->ID;
        $post_link      = $before . $title . $after;
        $parent_string  = '';
        $post_type_link = '';

        if ( 'post' === $post_type )
        {
            // Get the post categories
            $categories = get_the_category( $post_id );
            if ( $categories ) {
                // Lets grab the first category
                $category  = $categories[0];

                $category_links = get_category_parents( $category, true, $delimiter );
                $category_links = str_replace( '<a',   $link_before . '<a' . $link_attr, $category_links );
                $category_links = str_replace( '</a>', '</a>' . $link_after,             $category_links );
            }
        }

        if ( !in_array( $post_type, ['post', 'page', 'attachment'] ) )
        {
            $post_type_object = get_post_type_object( $post_type );
            $archive_link     = esc_url( get_post_type_archive_link( $post_type ) );

            $post_type_link   = sprintf( $link, $archive_link, $post_type_object->labels->singular_name );
        }

        // Get post parents if $parent !== 0
        if ( 0 !== $parent )
        {
            $parent_links = [];
            while ( $parent ) {
                $post_parent = get_post( $parent );

                $parent_links[] = sprintf( $link, esc_url( get_permalink( $post_parent->ID ) ), get_the_title( $post_parent->ID ) );

                $parent = $post_parent->post_parent;
            }

            $parent_links = array_reverse( $parent_links );

            $parent_string = implode( $delimiter, $parent_links );
        }

        // Lets build the breadcrumb trail
        if ( $parent_string ) {
            $breadcrumb_trail = $parent_string . $delimiter . $post_link;
        } else {
            $breadcrumb_trail = $post_link;
        }

        if ( $post_type_link )
            $breadcrumb_trail = $post_type_link . $delimiter . $breadcrumb_trail;

        if ( $category_links )
            $breadcrumb_trail = $category_links . $breadcrumb_trail;
    }

    // Handle archives which includes category-, tag-, taxonomy-, date-, custom post type archives and author archives
    if( is_archive() )
    {
        if (    is_category()
             || is_tag()
             || is_tax()
        ) {
            // Set the variables for this section
            $term_object        = get_term( $queried_object );
            $taxonomy           = $term_object->taxonomy;
            $term_id            = $term_object->term_id;
            $term_name          = $term_object->name;
            $term_parent        = $term_object->parent;
            $taxonomy_object    = get_taxonomy( $taxonomy );
            $current_term_link  = $before . $taxonomy_object->labels->singular_name . ': ' . $term_name . $after;
            $parent_term_string = '';

            if ( 0 !== $term_parent )
            {
                // Get all the current term ancestors
                $parent_term_links = [];
                while ( $term_parent ) {
                    $term = get_term( $term_parent, $taxonomy );

                    $parent_term_links[] = sprintf( $link, esc_url( get_term_link( $term ) ), $term->name );

                    $term_parent = $term->parent;
                }

                $parent_term_links  = array_reverse( $parent_term_links );
                $parent_term_string = implode( $delimiter, $parent_term_links );
            }

            if ( $parent_term_string ) {
                $breadcrumb_trail = $parent_term_string . $delimiter . $current_term_link;
            } else {
                $breadcrumb_trail = $current_term_link;
            }

        } elseif ( is_author() ) {

            $breadcrumb_trail = __( 'Author archive for ') .  $before . $queried_object->data->display_name . $after;

        } elseif ( is_date() ) {
            // Set default variables
            $year     = $wp_the_query->query_vars['year'];
            $monthnum = $wp_the_query->query_vars['monthnum'];
            $day      = $wp_the_query->query_vars['day'];

            // Get the month name if $monthnum has a value
            if ( $monthnum ) {
                $date_time  = DateTime::createFromFormat( '!m', $monthnum );
                $month_name = $date_time->format( 'F' );
            }

            if ( is_year() ) {

                $breadcrumb_trail = $before . $year . $after;

            } elseif( is_month() ) {

                $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ), $year );

                $breadcrumb_trail = $year_link . $delimiter . $before . $month_name . $after;

            } elseif( is_day() ) {

                $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ),             $year       );
                $month_link       = sprintf( $link, esc_url( get_month_link( $year, $monthnum ) ), $month_name );

                $breadcrumb_trail = $year_link . $delimiter . $month_link . $delimiter . $before . $day . $after;
            }

        } elseif ( is_post_type_archive() ) {

            $post_type        = $wp_the_query->query_vars['post_type'];
            $post_type_object = get_post_type_object( $post_type );

            $breadcrumb_trail = $before . $post_type_object->labels->singular_name . $after;

        }
    }

    // Handle the search page
    if ( is_search() ) {
        $breadcrumb_trail = __( 'Pencarian untuk: ' ) . $before . get_search_query() . $after;
    }

    // Handle 404's
    if ( is_404() ) {
        $breadcrumb_trail = $before . __( 'Error 404' ) . $after;
    }

    // Handle paged pages
    if ( is_paged() ) {
        $current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
        $page_addon   = $before . sprintf( __( ' ( Page %s )' ), number_format_i18n( $current_page ) ) . $after;
    }

    $breadcrumb_output_link  = '';
    $breadcrumb_output_link .= '<ul>';
    if (    is_home()
         || is_front_page()
    ) {
        // Do not show breadcrumbs on page one of home and frontpage
        if ( is_paged() ) {
            $breadcrumb_output_link .= '<li class="parent-page"> <a href="' . $home_link . '">' . $home_text . '</a></li>';
            $breadcrumb_output_link .= $page_addon;
        }
    } else {
        $breadcrumb_output_link .= '<li><a href="' . $home_link . '" rel="v:url" property="v:title">' . $home_text . '</a></li>';
        $breadcrumb_output_link .= $delimiter;
        $breadcrumb_output_link .= $breadcrumb_trail;
        $breadcrumb_output_link .= $page_addon;
    }
    $breadcrumb_output_link .= '</ul><!-- .breadcrumbs -->';

    return $breadcrumb_output_link;
}

function panggil_breadcrumb() {
global $webane;
?>
   <div class="breadcrumb-area pt-15 pb-15">
       <div class="container">
           <div class="row">
               <div class="col-lg-12">
                   <!--=======  breadcrumb container  =======-->

                   <div class="breadcrumb-container">
                       <?php echo fungsi_breadcrumbs_webane(); ?>
                   </div>

               </div>
           </div>
       </div>
   </div>
<?php }

// default logo on login form
function webane_load_login_form_logo() { ?>
    <style type="text/css">
        .login {background: #73ab01;}
        #login h1 a, .login h1 a {
            background-image: url(https://4.bp.blogspot.com/-jF3KjigDQCY/W7-WgeouSoI/AAAAAAAAAYc/zLuvSenN5oI7fuC_TnDIf14n9FUW40tXwCLcBGAs/s1600/login.png);
        }
        #login {
            background-color: #fff;
            width: 100%;
            overflow: hidden;
            -webkit-box-shadow: 0 25px 70px rgba(0, 0, 0, 0.07);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.07);
        }
        #login .button-primary {
            margin-top: 10px; display: block; width: 100%; background:#73ab01; color:#fff; border-color:#fff;
        }
        #login input[type="text"], #login input[type="password"] {border:0; border-bottom: 1px solid #73ab01}

    </style>
<?php }
add_action( 'login_enqueue_scripts', 'webane_load_login_form_logo' );

/**
 * Create the function to output the contents of your Dashboard Widget.
 */
function wpexplorer_dashboard_widget_function() {
    https://webane.com/rss/
	echo "Hello there, I'm a great Dashboard Widget. Edit me!";
}
add_action('wp_dashboard_setup', 'my_dashboard_widgets');
function my_dashboard_widgets() {
     global $wp_meta_boxes;
     unset(
          $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'],
          $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'],
          $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']
     );
     wp_add_dashboard_widget( 'dashboard_custom_feed', 'Greating From Webane' , 'dashboard_custom_feed_output' );
}

function dashboard_custom_feed_output() {
     echo '<div class="rss-widget">';
     wp_widget_rss_output(array(
          'url' => 'http://webane.com/feed/',
          'title' => 'Webane Indonesia',
          'items' => 10,
          'show_summary' => 0,
          'show_author' => 0,
          'show_date' => 1,
          'target'    => '_blank',
     ));
     echo '</div>';
}
// Custom Admin footer
function wpexplorer_remove_footer_admin () {
	echo '<span id="footer-thankyou">Designed with love by <a href="http://webane.com/" target="_blank" rel="nofollow">Webane Indonesia</a> Powered By Wordpress</span>';
}
add_filter( 'admin_footer_text', 'wpexplorer_remove_footer_admin' );
// fungsi iklan webane
function webane_ads_on_admin()
{
	$imageku = 'https://4.bp.blogspot.com/-J2K6WKNTj2E/W7-WgY1y9uI/AAAAAAAAAYg/GSYOwtOOJEEydFWCbxxfTGK5XtAM1cI7wCLcBGAs/s1600/webane-indonesia-ads.jpg';
	$output = '<a href="https://webane.com"><img style="width:100%;" src="'.$imageku.'"></a>';

	add_settings_error('webane_ads_on_admin', esc_attr( 'settings_updated' ), $output, 'notice-warning');

	settings_errors( 'webane_ads_on_admin' );
}
add_action( 'admin_notices', 'webane_ads_on_admin' );
// Fungsi design by
function webane_load_designed_by()
{
$webane_site = 'https://webane.com';
$content = '| Designed with love by <a href="'.$webane_site.'" target="_blank" rel="nofollow" title="Web Design Webane Indonesia" alt="Web Design Webane Indonesia" rel="nofollow">Webane Indonesia</a>';
return $content;
}
// year copyright
function webane_load_dynamic_copyright_year() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results("
	SELECT
	YEAR(min(post_date_gmt)) AS firstdate,
	YEAR(max(post_date_gmt)) AS lastdate
	FROM
	$wpdb->posts
	WHERE
	post_status = 'publish'
	");
	$output = '';
	if($copyright_dates) {
		$copyright = "&copy; " . $copyright_dates[0]->firstdate;
		if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
		$copyright .= '-' . $copyright_dates[0]->lastdate;
		}
		$output = $copyright;
	}
	return $output;
}

/**
 * Use ACF image field as avatar
 * @author Mike Hemberger
 * @link http://thestizmedia.com/acf-pro-simple-local-avatars/
 * @uses ACF Pro image field (tested return value set as Array )
 */
add_filter('get_avatar', 'sekolahane_acf_profile_avatar', 10, 5);
function sekolahane_acf_profile_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = '';

    // Get user by id or email
    if ( is_numeric( $id_or_email ) ) {
        $id   = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );
    } elseif ( is_object( $id_or_email ) ) {
        if ( ! empty( $id_or_email->user_id ) ) {
            $id   = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }
    } else {
        $user = get_user_by( 'email', $id_or_email );
    }
    if ( ! $user ) {
        return $avatar;
    }
    // Get the user id
    $user_id = $user->ID;
    // Get the file id
    $image_id = get_user_meta($user_id, 'gravatar_ane', true); // CHANGE TO YOUR FIELD NAME
    // Bail if we don't have a local avatar
    if ( ! $image_id ) {
        return $avatar;
    }
    // Get the file size
    $image_url  = wp_get_attachment_image_src( $image_id, 'kotak' ); // Set image size by name
    // Get the file url
    $avatar_url = $image_url[0];
    // Get the img markup
    $avatar = '<img alt="' . $alt . '" src="' . $avatar_url . '" class="avatar avatar-' . $size . '" height="' . $size . '" width="' . $size . '"/>';
    // Return our new avatar
    return $avatar;
}

//post view =====
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
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

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

// acf option -====

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

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Mobile Menu',
		'menu_title'	=> 'Mobile Menu',
		'parent_slug'	=> 'webane-theme-general-settings',
	));


}
