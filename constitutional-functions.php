<?php

/**
* Plugin Name: Constitutional Functions
* Description: Custom functions outside of functions.php. This ensures that if you switch themes, you won't loose widgets and other custom things.
* Author: Josh Wright
* Version: 0.1
*/

        //Custom logo
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

?>
