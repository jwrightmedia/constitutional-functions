<?php
/**
* Plugin Name: Constitutional Functions
* Description: Custom functions outside of functions.php. This ensures that if you switch themes, you won't lose widgets and other custom things.
* Author: Josh Wright
* Version: 0.1
*/

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
    'primary' => __( 'Primary Menu', 'THEME_SLUG' ),
) );

register_nav_menus( array(
    'mobile' => __( 'Mobile Menu', 'THEME_SLUG' ),
) );


//Add the page slug to the <body> class
function add_slug_body_class( $classes ) {
    global $post;
        if ( isset( $post ) ) {
            $classes[] = $post->post_type . '-' . $post->post_name;
        }
    return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

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

?>
