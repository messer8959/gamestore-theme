<?php

function filter_games_ajax_handler()
{

    $posts_per_page = isset($_POST['post_per_page']) ? intval($_POST['post_per_page']) : 8;
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $platforms = isset($_POST['platforms']) ? sanitize_text_field($_POST['platforms']) : '';
    $publisher = isset($_POST['publisher']) ? sanitize_text_field($_POST['publisher']) : '';
    $singleplayer = isset($_POST['singleplayer']) ?sanitize_text_field($_POST['singleplayer']) : '';
    $release = isset($_POST['released']) ? sanitize_text_field($_POST['released']) : '';
    $languages = isset($_POST['languages']) ? sanitize_text_field($_POST['languages']) : '';
    $genres = isset($_POST['genres']) ? sanitize_text_field($_POST['genres']) : '';
    $sort = isset($_POST['sort']) ? sanitize_text_field($_POST['sort']) : '';

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
        'paged' => $paged,
        // 'tax_query' => array(
        //     array(
        //         'taxonomy' => 'genre',
        //         'field' => 'term_id',
        //         'terms' => $genres
        //     )
        // )
        // 'meta_query' => array(
        //     array(
        //         'key' => '_game_publisher',
        //         'value' => $publisher,
        //         'compare' => '=',
        //     ),
        // ),

    );

    if ($platforms) {
        $args['tax_query'][] = array(
            'taxonomy' => 'platform',
            'field' => 'term_id',
            'terms' => $platforms
        );
    }

    if ($languages) {
        $languages = explode(',', $languages);
        $args['tax_query'][] = array(
            'taxonomy' => 'language',
            'field' => 'term_id',
            'terms' => $languages
        );
    } 
    if($genres) {
        $args['tax_query'][] = array(
            'taxonomy' => 'genre',
            'field' => 'term_id', 
            'terms' => $genres
        );
    }
    if($publisher) {
        $args['meta_query'][] = array(
            'key' => '_game_publisher',
            'value' => $publisher,
            'compare' => '='
        );
    }
    if($singleplayer) {
        $args['meta_query'][] = array(
            'key' => '_game_single_player',
            'value' => $singleplayer,
            'compare' => '='
        );
    }
    if($release) {
        $args['meta_query'][] = array(   
            'key' => '_game_release_date',
            'value' => array("{$release}-01-01", "{$release}-12-31"),
            'compare' => 'BETWEEN',
            'type' => 'DATE'
        );
    }

    //Sorting
    switch($sort) {
        case 'latest':
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
        case 'price_low_high':
            $args['meta_key'] = '_regular_price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            break;
        case 'price_high_low':  
            $args['meta_key'] = '_regular_price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        case 'popularity':
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        default: 
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
    }


   

    $filtered_games = get_posts($args);

    $html = '';

    if (!empty($filtered_games)) {
        // $html .= print_r($args);
        foreach ($filtered_games as $post) {
            $game = wc_get_product($post->ID);
            $html .= '<div class ="game-result">';
            $html .= '<a href="' . esc_url($game->get_permalink()) . '">';
            $html .= $game->get_image(); // Display product image
            $html .= '<div class ="game-meta">';
            $html .= '<div class="game-price">' . $game->get_price_html() . '</div>';
            $html .= '<h3 class ="game-name">' . $game->get_name() . '</h3>';
            $html .= '<div class ="game-platforms">';
            //  $html .= '<div class ="platform_pc">';
            //  $html .= '<image src="' . plugin_dir_url(__FILE__) . 'assets/pc.png" alt="PC Icon"/>';
            //  $html .= '</div>';
            //  $html .= '<div class ="platform_xbox">';
            //  $html .= '<image src="' . plugin_dir_url(__FILE__) . 'assets/xbox.png" alt="Xbox Icon"/>';
            //  $html .= '</div>';
            //  $html .= '<div class ="platform_playstation">';
            //  $html .= '<image src="' . plugin_dir_url(__FILE__) . 'assets/playstation.png" alt="Playstation Icon"/>';
            //  $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</a>';
            $html .= '</div>';
        }
    } else {
        echo 'Nothing';
    }

    echo $html;

    wp_die();
}


add_action('wp_ajax_filter_games', 'filter_games_ajax_handler');
add_action('wp_ajax_nopriv_filter_games', 'filter_games_ajax_handler');
