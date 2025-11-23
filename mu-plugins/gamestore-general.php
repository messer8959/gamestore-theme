<?php

/**
 * Plugin Name:       General
 * Description:       Core code for GameStore
 * Version:           1.0
 * Author:            WPcat
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

function gamestore_remove_dashboard_vidgets()
{
    global $wp_meta_boxes;

    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['normal']['high']['rank_math_dashgboard_widget']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']);
}
add_action('wp_dashboard_setup', 'gamestore_remove_dashboard_vidgets');


// Allow load SVG files from library
add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

// Fix SVG display in media library
add_filter('wp_check_filetype_and_ext', function () {
    echo '<style>
        .attachment .thumbnail img[src$=".svg"], 
        .media-icon img[src$=".svg"] {
            width: 100% !important;
            height: auto !important;
        }
    </style>';
}, 10, 4);



/**
 * Register custom post type "News" and taxonomy "News Category"
 */
add_action( 'init', function() {
    
    // Register Post Type "News"
    register_post_type( 'news', array(
        'label'               => __( 'News', 'gamestore' ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'rest_base'           => 'news',
        'has_archive'         => true,
        'hierarchical'        => false,
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'author', 'custom-fields' ),
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-newspaper',
        'capability_type'     => 'post',
        'rewrite'             => array(
            'slug' => 'news',
            'with_front' => true,
        ),
    ) );


    // Register Taxonomy "News Category"
    register_taxonomy( 'news_category', 'news', array(
        'label'             => __( 'News Category', 'gamestore' ),
        'public'            => true,
        'publicly_queryable' => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_rest'      => true,
        'rest_base'         => 'news_categories',
        'hierarchical'      => true,
        'rewrite'           => array(
            'slug' => 'news-category',
            'with_front' => true,
        ),
        'show_in_quick_edit' => true,
        'meta_box_cb'       => 'post_categories_meta_box',
    ) );

} );

/**
 * Flush rewrite rules on activation (add this to theme/plugin activation hook)
 */
register_activation_hook( __FILE__, function() {
    // Call init hook to register post type and taxonomy
    do_action( 'init' );
    flush_rewrite_rules();
} );

/**
 * Flush rewrite rules on deactivation
 */
register_deactivation_hook( __FILE__, function() {
    flush_rewrite_rules();
} );