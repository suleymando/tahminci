<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function kolay_kuponlar_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Register Navigation Menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'kolay-kuponlar' ),
    ) );
}
add_action( 'after_setup_theme', 'kolay_kuponlar_setup' );

function kolay_kuponlar_scripts() {
    wp_enqueue_style( 'kolay-kuponlar-style', get_stylesheet_uri() );
    // FontAwesome for icons
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' );
}
add_action( 'wp_enqueue_scripts', 'kolay_kuponlar_scripts' );

// Helper function to get match data
function get_kupon_matches($post_id) {
    return get_post_meta($post_id, '_kkc_matches', true);
}
