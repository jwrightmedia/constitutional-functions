<?php
/**
* Plugin Name: Constitutional Functions
* Description: Custom functions outside of functions.php. This ensures that if you switch themes, you won't lose widgets and other custom things.
* Author: Josh Wright
* Version: 0.5
*/

//REMOVE UNDERSCORES ENQUEUE SCRIPTS FROM FUNCTIONS.PHP AND MODIFY THIS WITH BODYSLUG

/**
 * Define Constants
 */

define( 'BASE_URL', get_template_directory_uri() . '/' );
define( 'BASE_DIR', get_template_directory() . '/' );

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
	'mobile' => __( 'Mobile Menu', 'bodyslug' ),
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
function bodyslug_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer' ),
		'id'            => 'footer-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'bodyslug_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bodyslug_scripts() {
	//This moves jQuery to the footer. Remove Lines 69, 70, 71 to leave it loading in it's default location.
	wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true ); 
    wp_enqueue_script( 'jquery' ); 
	$freshVersion = date("ymd-Gis");
	wp_enqueue_style( 'bodyslug-style', get_stylesheet_uri() );
	wp_enqueue_script( 'bodyslug-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	// Enqueue Bootstrap scripts and styles
	wp_enqueue_style('bodyslug-bootstrap.min', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style( 'bodyslug-font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
	wp_enqueue_style( 'bodyslug-custom-style', get_template_directory_uri() . '/bodyslug.css', [ 'bodyslug-style', 'bodyslug-font-awesome' ], $freshVersion, false );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bodyslug_scripts' );

function footer_script() {
	$freshVersion = date("ymd-Gis");
	wp_enqueue_script( 'bodyslug-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', [ 'jquery' ], '3.4.0', true );
	wp_enqueue_script( 'bodyslug-script', get_template_directory_uri() . '/js/script.js', [ 'jquery' ], $freshVersion, true );
}
add_action( 'wp_footer', 'footer_script' );

/* Save that JSON Locally */

add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_save_point( $path ) {
	// update path
	$path = get_stylesheet_directory() . '/acf-json';
	// return
	return $path;
}

/**
 * Files required by the theme
 */
//require_once(BASE_DIR . 'custom_post_type.php');
// Register Custom Navigation Walker - https://github.com/wp-bootstrap/wp-bootstrap-navwalker
//require_once('wp_bootstrap_navwalker.php');

?>
