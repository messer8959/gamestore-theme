<?php

function gamestore_styles() {
	// Дереєструєм jquery
	wp_deregister_script('jquery');
	// Реєструєм свою версію jquery
	wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js');
	// Підключаєм свою версію jquery
	wp_enqueue_script('jquery');

	wp_enqueue_style('gamestore-general',	get_template_directory_uri() . '/assets/css/gamestore.css',[],wp_get_theme()->get( 'Version' ));
	wp_enqueue_style('gamestore-cart',	get_template_directory_uri() . '/assets/css/cart.css',[],wp_get_theme()->get( 'Version' ));
	wp_enqueue_script('gamestore-theme-related',	get_template_directory_uri() . '/assets/js/gamestore-theme-related.js',[],wp_get_theme()->get( 'Version' ),true);
	wp_localize_script( 'gamestore-theme-related', 'gamestore_params',
			array( 'ajaxurl' => admin_url('admin-ajax.php' ),
			 ) );	
	// // //Swiper css
	// wp_enqueue_style('swiper-bundle',	get_template_directory_uri() . '/assets/css/swiper-bundle.min.css',[],wp_get_theme()->get( 'Version' ));
	// wp_enqueue_script('swiper-bundle',	get_template_directory_uri() . '/assets/js/swiper.js',[],wp_get_theme()->get( 'Version' ),true);

	// Slick css
	wp_enqueue_style('slick-bundle',	get_template_directory_uri() . '/assets/css/slick.css',[],wp_get_theme()->get( 'Version' ));
	wp_enqueue_script('slick-bundle',	get_template_directory_uri() . '/assets/js/slick.js',array('jquery'),wp_get_theme()->get( 'Version' ),true);
  }
add_action( 'wp_enqueue_scripts', 'gamestore_styles' );

function gamestore_google_font() {
	$font_url = '';
	$font = 'Urbanist';
	$font_extra = 'ital,wght@0,400;0,700;1,400;1,700';

	if('off' !== _x('on', 'Google font: on or off', 'gamestore')) {
		$query_args = array(
			'family' => urldecode($font.':'.$font_extra),
			'subset' => urldecode('latin,latin-ext'),
			'display' => urldecode('swap'),
		);
		$font_url = add_query_arg($query_args, '//fonts.googleapis.com/css2');
	}

	return $font_url;
}

function gamestore_google_font_script() {
	wp_enqueue_style('gamestore-google-font', gamestore_google_font(), [], '1.0.0');
}

add_action('wp_enqueue_scripts', 'gamestore_google_font_script');

//Load assets in Gutenberg 

function gamestore_gutenberg_styles() {
	wp_enqueue_style('gamestore-google-font', gamestore_google_font(), [], '1.0.0');

	add_editor_style('assets/css/editor-style.css');
	add_editor_style('assets/css/cart.css');
}

add_action('enqueue_block_editor_assets', 'gamestore_gutenberg_styles');


//Enable Gutenberg for products
function gutenberg_activate_on_products($can_edit, $post_type) {
	if ($post_type === 'product') {
		return true;
	}
	return $can_edit;
}

add_filter('use_block_editor_for_post_type', 'gutenberg_activate_on_products', 10, 2);

function enable_taxonomy_rest( $args ) {
	$args['show_in_rest'] = true;
	return $args;
}

add_filter('woocommerce_taxonomy_args_product_cat', 'enable_taxonomy_rest');
add_filter('woocommerce_taxonomy_args_product_tag', 'enable_taxonomy_rest');
add_filter('woocommerce_product_description_heading', '__return_null');
