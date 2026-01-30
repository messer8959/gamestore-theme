<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register product taxonomies: Languages, Genres, Platform
 */
function gamestore_register_product_taxonomies() {
	$textdomain = 'core-gamestore';

	// Languages (non-hierarchical, like tags)
	$labels = array(
		'name'                       => _x( 'Languages', 'taxonomy general name', $textdomain ),
		'singular_name'              => _x( 'Language', 'taxonomy singular name', $textdomain ),
		'search_items'               => __( 'Search Languages', $textdomain ),
		'all_items'                  => __( 'All Languages', $textdomain ),
		'edit_item'                  => __( 'Edit Language', $textdomain ),
		'update_item'                => __( 'Update Language', $textdomain ),
		'add_new_item'               => __( 'Add New Language', $textdomain ),
		'new_item_name'              => __( 'New Language Name', $textdomain ),
		'menu_name'                  => __( 'Languages', $textdomain ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'language' ),
		'show_in_rest'          => true,
	);

	register_taxonomy( 'language', array( 'product' ), $args );

	// Genres (hierarchical, like categories)
	$labels = array(
		'name'              => _x( 'Genres', 'taxonomy general name', $textdomain ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name', $textdomain ),
		'search_items'      => __( 'Search Genres', $textdomain ),
		'all_items'         => __( 'All Genres', $textdomain ),
		'parent_item'       => __( 'Parent Genre', $textdomain ),
		'parent_item_colon' => __( 'Parent Genre:', $textdomain ),
		'edit_item'         => __( 'Edit Genre', $textdomain ),
		'update_item'       => __( 'Update Genre', $textdomain ),
		'add_new_item'      => __( 'Add New Genre', $textdomain ),
		'new_item_name'     => __( 'New Genre Name', $textdomain ),
		'menu_name'         => __( 'Genres', $textdomain ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => false,
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'genre' ),
		'show_in_rest'          => true,
	);

	register_taxonomy( 'genre', array( 'product' ), $args );

	// Platform (hierarchical)
	$labels = array(
		'name'              => _x( 'Platforms', 'taxonomy general name', $textdomain ),
		'singular_name'     => _x( 'Platform', 'taxonomy singular name', $textdomain ),
		'search_items'      => __( 'Search Platforms', $textdomain ),
		'all_items'         => __( 'All Platforms', $textdomain ),
		'parent_item'       => __( 'Parent Platform', $textdomain ),
		'parent_item_colon' => __( 'Parent Platform:', $textdomain ),
		'edit_item'         => __( 'Edit Platform', $textdomain ),
		'update_item'       => __( 'Update Platform', $textdomain ),
		'add_new_item'      => __( 'Add New Platform', $textdomain ),
		'new_item_name'     => __( 'New Platform Name', $textdomain ),
		'menu_name'         => __( 'Platforms', $textdomain ),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => false,
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'platform' ),
		'show_in_rest'          => true,
	);

	register_taxonomy( 'platform', array( 'product' ), $args );
}

add_action( 'init', 'gamestore_register_product_taxonomies', 0 );

