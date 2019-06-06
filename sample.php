<?php
//Custom logo - Uses header upload
$defaults = array(
    'default-image'          => '',
    'random-default'         => false,
    'width'                  => 0,
    'height'                 => 0,
    'flex-height'            => true,
    'flex-width'             => true,
    'default-text-color'     => '',
    'header-text'            => false,
    'uploads'                => true,
    'wp-head-callback'       => '',
    'admin-head-callback'    => '',
    'admin-preview-callback' => '',
    );
add_theme_support( 'custom-header', $defaults );

//Replicate for additional menus

register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'bodyslug' ),
) );

register_nav_menus( array(
    'mobile' => __( 'Mobile Menu', 'bodyslug' ),
) );

//Add <body> class

/**
 * Adds classes to the array of body classes.
 *
 * @uses body_class() filter
 */
function bodyslug_body_classes( $classes ) {
    $classes[] = 'cbp-spmenu-push';
    return $classes;
}
add_filter( 'body_class', 'bodyslug_body_classes' );

// Replaces the excerpt "more" text by a link - for use if you want to change the wording

function new_excerpt_more($more) {
       global $post;
    return '... <a class="moretag" href="'. get_permalink($post->ID) . '"> More</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

//Add the page slug to the <body> class
function add_slug_body_class( $classes ) {
    global $post;
        if ( isset( $post ) ) {
            $classes[] = $post->post_type . '-' . $post->post_name;
        }
    return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

/*
* Enable support for Post Thumbnails on posts and pages.
*
* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
*/
add_theme_support( 'post-thumbnails' );

if (class_exists('MultiPostThumbnails')) {
    new MultiPostThumbnails(
        array(
            'label' => 'Main Featured Text',
            'id' => 'text-image',
            'post_type' => 'page'
        )
    );
    new MultiPostThumbnails(
        array(
            'label' => 'Mobile Featured Text',
            'id' => 'mobile-image',
            'post_type' => 'page'
        )
    );
}

//Replicate for additional widget areas

function bodyslug_widgets_init2() {
    register_sidebar( array(
        'name'          => __( 'Home - 1 - About' ),
        'id'            => 'home-1',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'bodyslug_widgets_init2' );

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     return $classes;
}

//REMOVE UNDERSCORES ENQUEUE SCRIPTS FROM FUNCTIONS.PHP AND MODIFY THIS WITH THEME_SLUG - TESTING

/**
 * Enqueue scripts and styles.
 */
function bodyslug_scripts() {
    wp_enqueue_style('bodyslug-bootstrap.min', get_template_directory_uri() . '/css/bootstrap.min.css');

    wp_enqueue_style( 'bodyslug-style', get_stylesheet_uri() );

    wp_enqueue_script( 'bodyslug-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

    wp_enqueue_script( 'bodyslug-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'bodyslug_scripts' );

/**
 * Run Shortcode inside contact form 7 plugin.
 */
add_filter( 'wpcf7_form_elements', 'do_shortcode' );

add_filter('wp_nav_menu_items', 'do_shortcode');

//Allow SVG upload into WP Media Uploader

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
    return $mimes;
    }
add_filter('upload_mimes', 'cc_mime_types');

add_filter( 'wp_check_filetype_and_ext', function($filetype_ext_data, $file, $filename, $mimes) {
    if ( substr($filename, -4) === '.svg' ) {
        $filetype_ext_data['ext'] = 'svg';
        $filetype_ext_data['type'] = 'image/svg+xml';
    }
    return $filetype_ext_data;
}, 100, 4 );

// Register Custom Navigation Walker - https://github.com/wp-bootstrap/wp-bootstrap-navwalker
require_once('wp_bootstrap_navwalker.php');

//Clean up wp_head

//Remove JQuery migrate

function remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
	$script = $scripts->registered['jquery'];
		if ( $script->deps ) { // Check whether the script has any dependencies
		     $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		}
	}
}
add_action( 'wp_default_scripts', 'remove_jquery_migrate' );

function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );        
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );          
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
* Filter function used to remove the tinymce emoji plugin.
*
 * @param    array  $plugins 
 * @return   array  Difference betwen the two arrays
*/

function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
	    return array_diff( $plugins, array( 'wpemoji' ) );
	}
	return array();
}

/**
* Remove emoji CDN hostname from DNS prefetching hints.
*
* @param  array  $urls          URLs to print for resource hints.
* @param  string $relation_type The relation type the URLs are printed for.
* @return array                 Difference betwen the two arrays.
*/

function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
	    // Strip out any URLs referencing the WordPress.org emoji location
	    $emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
	    foreach ( $urls as $key => $url ) {
	        if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
	            unset( $urls[$key] );
	        }
	    }
	}
	return $urls;
}

remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action( 'wp_head', 'rest_output_link_wp_head');
remove_action( 'wp_head', 'wp_oembed_add_discovery_links');
remove_action( 'template_redirect', 'rest_output_link_header', 11 );

function my_deregister_scripts(){
	wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

function remove_block_css(){
	wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );
?>
