<?php
//popup view
function gamestore_footer_search_popup()
{
?>
    <div class="popup-games-search-container">
        <span id="close-search"></span>
        <div class="search-container">
            <div class="search-bar wrapper">
                <h2 class="search-label">Search</h2>
                <input type="text" name="game-title" id="popup-search-input" placeholder="Search for Games">
                <p class="search-popup-title">You might be interest</p>
            </div>
            <div class="search-results-wrapper">
                <div class="popup-search-results wrapper">
                    
                </div>
            </div>
        </div>
    </div>

<?php
}

add_action('wp_footer', 'gamestore_footer_search_popup');

// load latest 12 games

function load_latest_games()
{
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'rand',
    );

    $games_query = new WP_Query($args);

    $result = array();

    if ($games_query->have_posts()) {
        while ($games_query->have_posts()) {
            $games_query->the_post();
            $product = wc_get_product(get_the_ID());

            $result[] = array(
                'title' => get_the_title(),
                'link' => get_the_permalink(),
                'thumbnail' => $product->get_image('full'),
                'price' => $product->get_price_html(),
            );

        }
    } 
    wp_reset_postdata();

    wp_send_json_success($result);


    // $args = array(
    //     'post_type'      => 'product',
    //     'post_status'    => 'publish',
    //     'posts_per_page' => 2,
    //     'orderby'        => 'date',
    //     'order'          => 'DESC',
    // );

    // $games_query = new WP_Query($args);
    // ob_start();
    // echo '<div ' . get_block_wrapper_attributes() . '>';
    // if ($games_query->have_posts()) {
    //     echo '<div class="games-line-container"><div class="games-wrapper">';
    //     while ($games_query->have_posts()) {
    //         $games_query->the_post();
    //         $product = wc_get_product(get_the_ID());
    //         echo '<div class="game-item">';
    //         echo '<a href="' . get_the_permalink() . '">';
    //         echo $product->get_image('full'); // Display product image
    //         echo '</a>';
    //         echo '</div>';
    //     }
    //     echo '</div></div>';
    // }
    // echo '</div>';

    // // Cleanup
    // wp_reset_postdata();

}

add_action('wp_ajax_load_latest_games', 'load_latest_games');
add_action('wp_ajax_nopriv_load_latest_games', 'load_latest_games');

//Search by title

function search_games_by_title()
{
    $search_term = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';    

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        's' => $search_term
    );

    $games_query = new WP_Query($args);

    $result = array();

    if ($games_query->have_posts()) {
        while ($games_query->have_posts()) {
            $games_query->the_post();
            $product = wc_get_product(get_the_ID());

            $result[] = [
                'title' => get_the_title(),
                'link' => get_the_permalink(),
                'thumbnail' => $product->get_image('full'),
                'price' => $product->get_price_html(),
            ];

        }
    } else {
        // echo '<p>No games found.</p>';
    }
    wp_reset_postdata();

    wp_send_json_success($result);

}

add_action('wp_ajax_search_games_by_title', 'search_games_by_title');
add_action('wp_ajax_nopriv_search_games_by_title', 'search_games_by_title');