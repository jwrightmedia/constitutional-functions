<?php /*
* 
* Sample file for default usage + additional code snippets 
*
*/

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
    'primary' => __( 'Primary Menu', 'BODYSLUG' ),
    'mobile' => __( 'Mobile Menu', 'BODYSLUG' ),
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
function BODYSLUG_widgets_init() {
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
add_action( 'widgets_init', 'BODYSLUG_widgets_init' );

/**
 * Enqueue scripts and styles.
 */

function BODYSLUG_scripts() {
    //This moves jQuery to the footer.
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true ); 
    wp_enqueue_script( 'jquery' ); 
    $freshVersion = date("ymd-Gis");
    wp_enqueue_style( 'BODYSLUG-style', get_stylesheet_uri() );

    // Enqueue Bootstrap scripts and styles
    wp_enqueue_style('BODYSLUG-bootstrap.min', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style( 'BODYSLUG-font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
    wp_enqueue_style( 'BODYSLUG-custom-style', get_template_directory_uri() . '/BODYSLUG.css', [ 'BODYSLUG-style', 'BODYSLUG-font-awesome' ], $freshVersion, false );


    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    if ( is_page( 'gallery' ) ) {
        //If you need to load scripts on a specific page
    }
    /*} else {
        // if you want to show on other pages is not used. 
    }*/
}
add_action( 'wp_enqueue_scripts', 'BODYSLUG_scripts' );

function BODYSLUG_footer_script() {
    $freshVersion = date("ymd-Gis");
    wp_enqueue_script( 'BODYSLUG-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', [ 'jquery' ], '3.4.0', true );
    wp_enqueue_script( 'BODYSLUG-script', get_template_directory_uri() . '/js/main.js', [ 'jquery' ], $freshVersion, true );
}
add_action( 'wp_footer', 'BODYSLUG_footer_script' );

/* Save that JSON Locally */

add_filter('acf/settings/save_json', 'my_acf_json_save_point');

function my_acf_json_save_point( $path ) {
    // update path
    $path = get_stylesheet_directory() . '/acf-json';
    // return
    return $path;
}

//Add Custom Colors to ACF Color Picker (Shout out to Kristin Falkner)

function jwm_acf_input_admin_footer() { ?>
<script type="text/javascript">
    (function($) {
        acf.add_filter('color_picker_args', function( args, $field ){
        // add the hexadecimal codes here for the colors you want to appear as swatches
            args.palettes = ['#3C4D85', '#FE5000', '#FFC700', '#EB9514', '#FFB800', '#FAF6E8', '#EBF5F7', '#757678']
        // return colors
            return args;
        });
    })(jQuery);
</script>
<?php }
add_action('acf/input/admin_footer', 'jwm_acf_input_admin_footer');

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

/**
 * Files required by the theme
 */

require_once(BASE_DIR . 'custom_post_type.php');

// Register Custom Navigation Walker - https://github.com/wp-bootstrap/wp-bootstrap-navwalker
require_once('wp_bootstrap_navwalker.php');

//////////////////////////////////////////////////
/**
 * Additional non-default used script examples.
 */
//////////////////////////////////////////////////

?> <!--Note extra closing ?> here -->

<?php 
function login_page_style() { 
?> 
<style type="text/css">
body.login{
    background-color: #f1f1f1;
} 
body.login #login {
    padding-top: 50px;
}
body.login div#login h1 a {
    background-image: url(wp-content/themes/BODYSLUG/img/login.png); 
    width: 215px;
    height: 250px;
    background-size: 100%;
    padding-bottom: 0px; 
} 
</style>
<?php 
} add_action( 'login_enqueue_scripts', 'login_page_style' );?>

<?php

// Replaces the excerpt "more" text by a link - for use if you want to change the wording
function new_excerpt_more($more) {
       global $post;
    return '... <a class="moretag" href="'. get_permalink($post->ID) . '"> More</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

/*
* Enable support for Post Thumbnails on posts and pages.
*
* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
*
* Plugin must be installed: https://wordpress.org/plugins/multiple-post-thumbnails/
*
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

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     return $classes;
}

/**
 * Run Shortcode inside Contact Form 7 plugin.
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

// Previous/Next link add classes

add_filter('next_posts_link_attributes', 'posts_link_attributes_1');
add_filter('previous_posts_link_attributes', 'posts_link_attributes_2');

function posts_link_attributes_1() {
    return 'data-hover="Older Posts" class="btn btn-primary btn-page pull-right"';
}
function posts_link_attributes_2() {
    return 'data-hover="Newer Posts" class="btn btn-primary btn-page pull-left"';
}

// Modify Archive Title

add_filter( 'get_the_archive_title', function ($title) {    
    if ( is_category() ) {    
            $title = single_cat_title( '', false );    
        } elseif ( is_tag() ) {    
            $title = single_tag_title( '', false );    
        } elseif ( is_author() ) {    
            $title = '<span class="vcard">' . get_the_author() . '</span>' ;    
        } elseif ( is_tax() ) { //for custom post types
            $title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
        }    
    return $title;    
});

//Featured Post function

function sm_custom_meta() {
    add_meta_box( 'sm_meta', __( 'Featured Post?', 'sm-textdomain' ), 'sm_meta_callback', 'post' );
}
function sm_meta_callback( $post ) {
    $featured = get_post_meta( $post->ID );
    ?>
 
    <p>
    <div class="sm-row-content">
        <label for="meta-checkbox">
            <input type="checkbox" name="meta-checkbox" id="meta-checkbox" value="yes" <?php if ( isset ( $featured['meta-checkbox'] ) ) checked( $featured['meta-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Feature this post on homepage', 'sm-textdomain' )?>
        </label>
        
    </div>
</p>
 
    <?php
}
add_action( 'add_meta_boxes', 'sm_custom_meta' );

function sm_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'sm_nonce' ] ) && wp_verify_nonce( $_POST[ 'sm_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
 // Checks for input and saves
if( isset( $_POST[ 'meta-checkbox' ] ) ) {
    update_post_meta( $post_id, 'meta-checkbox', 'yes' );
} else {
    update_post_meta( $post_id, 'meta-checkbox', '' );
}
 
}
add_action( 'save_post', 'sm_meta_save' );

//Add Options page - Advanced Custom Fields required

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Site Settings',
        'menu_title'    => 'Site Settings',
        'menu_slug'     => 'site-settings',
        'capability'    => 'edit_posts',
        'position' => '2',
        'autoload' => true,
        'update_button' => __('Save Options', 'acf'),
        'updated_message' => __("Options Saved", 'acf'),
        'redirect'      => false
    ));
}

// Breadcrumbs
function custom_breadcrumbs() {
       
    // Settings
    $separator          = '&#8250;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Home';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">Home</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat"><a href="/wip/news/">News</a></li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }
}

/* Add spans around time on Events Calendar Shortcode */

function tecs_add_span_around_time( $output, $atts, $post ) {
    $event = null;
    $before = $after = '';
    if ( is_null( $event ) ) {
        global $post;
        $event = $post;
    }

    if ( is_numeric( $event ) ) {
        $event = get_post( $event );
    }

    $inner                    = '<span class="tribe-event-date-start">';
    $format                   = '';
    $date_without_year_format = tribe_get_date_format();
    $date_with_year_format    = tribe_get_date_format( true );
    $time_format              = get_option( 'time_format' );
    $datetime_separator       = tribe_get_option( 'dateTimeSeparator', ' @ ' );
    $time_range_separator     = tribe_get_option( 'timeRangeSeparator', ' - ' );

    $settings = array(
        'show_end_time' => true,
        'time'          => true,
    );

    $settings = wp_parse_args( apply_filters( 'tribe_events_event_schedule_details_formatting', $settings ), $settings );
    if ( ! $settings['time'] ) {
        $settings['show_end_time'] = false;
    }

    /**
     * @var $show_end_time
     * @var $time
     */
    extract( $settings );

    $format = $date_with_year_format;

    // if it starts and ends in the current year then there is no need to display the year
    if ( tribe_get_start_date( $event, false, 'Y' ) === date( 'Y' ) && tribe_get_end_date( $event, false, 'Y' ) === date( 'Y' ) ) {
        $format = $date_without_year_format;
    }

    if ( tribe_event_is_multiday( $event ) ) { // multi-date event

        $format2ndday = apply_filters( 'tribe_format_second_date_in_range', $format, $event );

        if ( tribe_event_is_all_day( $event ) ) {
            $inner .= tribe_get_start_date( $event, true, $format );
            $inner .= '</span><span class="timerange_separator">' . $time_range_separator . '</span>';
            $inner .= '<span class="tribe-event-date-end">';

            $end_date_full = tribe_get_end_date( $event, true, Tribe__Date_Utils::DBDATETIMEFORMAT );
            $end_date_full_timestamp = strtotime( $end_date_full );

            // if the end date is <= the beginning of the day, consider it the previous day
            if ( $end_date_full_timestamp <= strtotime( tribe_beginning_of_day( $end_date_full ) ) ) {
                $end_date = tribe_format_date( $end_date_full_timestamp - DAY_IN_SECONDS, false, $format2ndday );
            } else {
                $end_date = tribe_get_end_date( $event, false, $format2ndday );
            }

            $inner .= $end_date;
        } else {
            $inner .= tribe_get_start_date( $event, false, $format ) . ( $time ? '<span class="datetime_separator">' . $datetime_separator . '</span><span class="tecs_time tecs_start_time">' . tribe_get_start_date( $event, false, $time_format ) . '</span>' : '' );
            $inner .= '</span><span class="timerange_separator">' . $time_range_separator . '</span>';
            $inner .= '<span class="tribe-event-date-end">';
            $inner .= tribe_get_end_date( $event, false, $format2ndday ) . ( $time ? '<span class="datetime_separator">' . $datetime_separator . '</span><span class="tecs_time tecs_end_time">' . tribe_get_end_date( $event, false, $time_format ) . '</span>' : '' );
        }
    } elseif ( tribe_event_is_all_day( $event ) ) { // all day event
        $inner .= tribe_get_start_date( $event, true, $format );
    } else { // single day event
        if ( tribe_get_start_date( $event, false, 'g:i A' ) === tribe_get_end_date( $event, false, 'g:i A' ) ) { // Same start/end time
            $inner .= tribe_get_start_date( $event, false, $format ) . ( $time ? '<span class="datetime_separator">' . $datetime_separator . '</span><span class="tecs_time tecs_start_time">' . tribe_get_start_date( $event, false, $time_format ) . '</span>' : '' );
        } else { // defined start/end time
            $inner .= tribe_get_start_date( $event, false, $format ) . ( $time ? '<span class="datetime_separator">' . $datetime_separator . '</span><span class="tecs_time tecs_start_time">' . tribe_get_start_date( $event, false, $time_format ) . '</span>' : '' );
            $inner .= '</span>' . ( $show_end_time ? '<span class="timerange_separator">' . $time_range_separator . '</span>' : '' );
            $inner .= '<span class="tribe-event-time">';
            $inner .= ( $show_end_time ? '<span class="tecs_time tecs_end_time">' . tribe_get_end_date( $event, false, $time_format ) . '</span>' : '' );
        }
    }

    $inner .= '</span>';

    /**
     * Provides an opportunity to modify the *inner* schedule details HTML (ie before it is
     * wrapped).
     *
     * @param string $inner_html  the output HTML
     * @param int    $event_id    post ID of the event we are interested in
     */
    $inner = apply_filters( 'tribe_events_event_schedule_details_inner', $inner, $event->ID );

    // Wrap the schedule text
    $schedule = $before . $inner . $after;

    /**
     * Provides an opportunity to modify the schedule details HTML for a specific event after
     * it has been wrapped in the before and after markup.
     *
     * @param string $schedule  the output HTML
     * @param int    $event_id  post ID of the event we are interested in
     * @param string $before    part of the HTML wrapper that was prepended
     * @param string $after     part of the HTML wrapper that was appended
     */
    return $schedule;
}
add_filter( 'ecs_event_list_details', 'tecs_add_span_around_time', 10, 3 );

?>