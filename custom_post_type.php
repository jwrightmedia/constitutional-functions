<?php
/* Custom Post Type
*  Separate file for adding custom post types to your theme.
*  -Includes a single custom taxonomy example for category and tag
*  -Comment out "taxonomies" line 127 if not using any taxonomies.
*  -Use Find and Replace to add POSTTYPENAME and BODYSLUG across the file.
*  Version 1.1
*/

// Register CATEGORYNAME to 'POSTTYPENAME' - remove if not using category

function register_cpt_category1() {

	/**
	 * Taxonomy: CATEGORYNAME
	 */

	$labels = array(
		"name" => __( "CATEGORYNAME", "BODYSLUG" ),
		"singular_name" => __( "CATEGORYNAME", "BODYSLUG" ),
	);

	$args = array(
		"label" => __( "CATEGORYNAME", "BODYSLUG" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "CATEGORYNAME",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'CATEGORYNAME', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "CATEGORYNAME",
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "CATEGORYNAME", array( "POSTTYPENAME" ), $args );
}

add_action( 'init', 'register_cpt_category1' );

// Register TAGNAME to 'POSTTYPENAME' - remove if not using tag

function register_cpt_tag1() {

	/**
	 * Taxonomy: TAGNAME
	 */

	$labels = array(
		"name" => __( "TAGNAME", "BODYSLUG" ),
		"singular_name" => __( "TAGNAME", "BODYSLUG" ),
	);

	$args = array(
		"label" => __( "TAGNAME", "BODYSLUG" ),
		"labels" => $labels,
		"public" => true,
		"hierarchical" => false,
		"label" => "TAGNAME",
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'TAGNAME', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "TAGNAME",
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		"show_in_quick_edit" => false,
	);
	register_taxonomy( "TAGNAME", array( "POSTTYPENAME" ), $args );
}

add_action( 'init', 'register_cpt_tag1' );


// Register Custom Post Type: 'POSTTYPENAME'

function register_cpt() {

	/**
	 * Post Type: POSTTYPENAME
	 */

	$labels = array(
		"name" => __( "POSTTYPENAME", "BODYSLUG" ),
		"singular_name" => __( "POSTTYPENAME", "BODYSLUG" ),
		"menu_name" => __( "POSTTYPENAME", "BODYSLUG" ),
		"all_items" => __( "All POSTTYPENAME", "BODYSLUG" ),
		"add_new" => __( "Add New", "BODYSLUG" ),
		"add_new_item" => __( "Add New POSTTYPENAME", "BODYSLUG" ), //SINGULAR
		"edit_item" => __( "Edit POSTTYPENAME", "BODYSLUG" ), //SINGULAR
		"new_item" => __( "New POSTTYPENAME", "BODYSLUG" ), //SINGULAR
		"view_item" => __( "View POSTTYPENAME Page", "BODYSLUG" ), //SINGULAR
		"view_items" => __( "View POSTTYPENAME", "BODYSLUG" ),
		"search_items" => __( "Search POSTTYPENAME", "BODYSLUG" ),
		"not_found" => __( "No POSTTYPENAME Found", "BODYSLUG" ),
		"not_found_in_trash" => __( "No POSTTYPENAME Found in Trash", "BODYSLUG" ),
		"archives" => __( "POSTTYPENAME Archives", "BODYSLUG" ), //SINGULAR
	);

	$args = array(
		"label" => __( "POSTTYPENAME", "BODYSLUG" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "POSTTYPENAME", "with_front" => true ), //SINGULAR
		"query_var" => true,
		"menu_position" => 20,
		"menu_icon" => "dashicons-id-alt",
		"supports" => array( "title", "editor", "thumbnail", "excerpt", "custom-fields", "page-attributes" ),
		"taxonomies" => array( "CATEGORYNAME", "TAGNAME" ), //REPLACE WITH TAXONOMY NAMES - Find and Replace should take care of these, but double-check!!
	);

	register_post_type( "POSTTYPENAME", $args ); //SINGULAR
}

add_action( 'init', 'register_cpt' );
