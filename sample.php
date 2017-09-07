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
    'primary' => __( 'Primary Menu', 'SITE_SLUG' ),
) );

register_nav_menus( array(
    'mobile' => __( 'Mobile Menu', 'SITE_SLUG' ),
) );

//Add <body> class

/**
 * Adds classes to the array of body classes.
 *
 * @uses body_class() filter
 */
function textdomain_body_classes( $classes ) {
    $classes[] = 'cbp-spmenu-push';
    return $classes;
}
add_filter( 'body_class', 'textdomain_body_classes' );

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

function lkcm4k_widgets_init2() {
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
add_action( 'widgets_init', 'lkcm4k_widgets_init2' );

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
function THEMESLUG_scripts() {
    wp_enqueue_style('bootstrap.min', get_template_directory_uri() . '/css/bootstrap.min.css');

    wp_enqueue_style( 'THEMESLUG-style', get_stylesheet_uri() );

    wp_enqueue_script( 'THEMESLUG-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

    wp_enqueue_script( 'THEMESLUG-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'THEMESLUG_scripts' );

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

?>
