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


    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'lkcm4k' ),
    ) );

    register_nav_menus( array(
        'mobile' => __( 'Mobile Menu', 'lkcm4k' ),
    ) );

    register_nav_menus( array(
        'hunting' => __( 'Hunting Gallery Menu', 'lkcm4k' ),
    ) );

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

function lkcm4k_widgets_init3() {
    register_sidebar( array(
        'name'          => __( 'Home - 2 - Image 1' ),
        'id'            => 'home-2',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init3' );

function lkcm4k_widgets_init4() {
    register_sidebar( array(
        'name'          => __( 'Home - 3 -  Book' ),
        'id'            => 'home-3',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init4' );

function lkcm4k_widgets_init5() {
    register_sidebar( array(
        'name'          => __( 'Home - 4 -  Image 2' ),
        'id'            => 'home-4',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init5' );

function lkcm4k_widgets_init6() {
    register_sidebar( array(
        'name'          => __( 'Home - 5 -  Learn More 1' ),
        'id'            => 'home-5',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init6' );

function lkcm4k_widgets_init7() {
    register_sidebar( array(
        'name'          => __( 'Home - 6 -  Image 3' ),
        'id'            => 'home-6',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init7' );

function lkcm4k_widgets_init8() {
    register_sidebar( array(
        'name'          => __( 'Home - 6 -  Learn More 2' ),
        'id'            => 'home-7',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init8' );

function lkcm4k_widgets_init9() {
    register_sidebar( array(
        'name'          => __( 'Horses - Description 1' ),
        'id'            => 'horse-1',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init9' );

function lkcm4k_widgets_init10() {
    register_sidebar( array(
        'name'          => __( 'Horses - Slider 1' ),
        'id'            => 'horse-2',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init10' );

function lkcm4k_widgets_init11() {
    register_sidebar( array(
        'name'          => __( 'Horses - Description 2' ),
        'id'            => 'horse-3',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init11' );

function lkcm4k_widgets_init12() {
    register_sidebar( array(
        'name'          => __( 'Horses - Slider 2' ),
        'id'            => 'horse-4',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init12' );

function lkcm4k_widgets_init13() {
    register_sidebar( array(
        'name'          => __( 'Horses - Description 3' ),
        'id'            => 'horse-5',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init13' );

function lkcm4k_widgets_init14() {
    register_sidebar( array(
        'name'          => __( 'Horses - Slider 3' ),
        'id'            => 'horse-6',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init14' );

function lkcm4k_widgets_init15() {
    register_sidebar( array(
        'name'          => __( 'Home - Slider' ),
        'id'            => 'home-8',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'lkcm4k_widgets_init15' );

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     return $classes;
}

?>