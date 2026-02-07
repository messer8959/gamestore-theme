<?php

function view_block_games_line($attributes)
{

   // return '<div>Games Line12</div>';


   $args = array(
      'post_type'      => 'product',
      'post_status'    => 'publish',
      'posts_per_page' => $attributes['count'],
      'orderby'        => 'date',
      'order'          => 'DESC',
   );

   $games_query = new WP_Query($args);
   ob_start();
   echo '<div ' . get_block_wrapper_attributes() . '>';
   if ($games_query->have_posts()) {
      echo '<div class="games-line-container"><div class="games-wrapper">';
      while ($games_query->have_posts()) {
         $games_query->the_post();
         $product = wc_get_product(get_the_ID());
         echo '<div class="game-item">';
         echo '<a href="' . get_the_permalink() . '">';
         echo $product->get_image('full'); // Display product image
         echo '</a>';
         echo '</div>';
      }
      echo '</div></div>';
   }
   echo '</div>';

   // Cleanup
   wp_reset_postdata();

   return ob_get_clean();
}

function view_block_recent_news($attributes)
{

   // return '<div>Games Line12</div>';


   $args = array(
      'post_type'      => 'news',
      'post_status'    => 'publish',
      'posts_per_page' => $attributes['count'],
      'orderby'        => 'date',
      'order'          => 'DESC',
   );

   $news_query = new WP_Query($args);

   $image_bg = ($attributes['image']) ? 'style="background-image: url(' . $attributes['image'] . ')"' : '';

   ob_start();
   echo '<div ' . get_block_wrapper_attributes() . $image_bg . '>';
   if ($news_query->have_posts()) {
      if ($attributes['title']) {
         echo '<h2>' . $attributes['title'] . '</h2>';
      }
      if ($attributes['description']) {
         echo '<p>' . $attributes['description'] . '</p>';
      }
      echo '<div class ="recent-news">';
      while ($news_query->have_posts()) {
         $news_query->the_post();
         echo '<div class ="news-item">';
         if (has_post_thumbnail()) {
            echo '<h3>' . get_the_title() . '</h3>';
            echo '<div class = "news-thumbnail">';
            echo '<img src = "' . get_the_post_thumbnail_url() . '" class="blur-image" alt="' . get_the_title() . '">';
            echo '<img src = "' . get_the_post_thumbnail_url() . '" class="original-image" alt="' . get_the_title() . '">';
            echo '</div>';
         }
         echo '<div class="news-excerpt">';
         the_excerpt();
         echo '</div>';
         echo '<a href="' . get_the_permalink() . '" class="read-more">Open the post</a>';
         echo  '</div>';
      }
      echo '</div>';
   }
   echo '</div>';

   // Cleanup
   wp_reset_postdata();

   return ob_get_clean();
}

function view_block_subscribe($attributes)
{

   $image_bg = ($attributes['image']) ? 'style="background-image: url(' . $attributes['image'] . ')"' : '';

   ob_start();
   echo '<div ' . get_block_wrapper_attributes(['class' => 'alignFull']) . $image_bg . '>';
   echo '<div class="subscribe-inner wrapper">';
   echo '<h2 class="subscribe-title">' . $attributes['title'] . '</h2>';
   echo '<p class="subscribe-description">' . $attributes['description'] . '</p>';
   echo '<div class="subscribe-shortcode">' . do_shortcode('[mc4wp_form id=232]') . '</div>';
   echo '</div>';
   echo '</div>';

   return ob_get_clean();
}

// fuction for featured games

function view_block_featured_products($attributes)
{

   ob_start();
   $featured_games = wc_get_products(array(
      'status' => 'publish',
      'limit' => $attributes['count'],
      'featured' => true,
   ));
   echo '<div ' . get_block_wrapper_attributes(array('class' => 'wrapper')) . '>';
   if ($attributes['title']) {
      echo '<h2>' . $attributes['title'] . '</h2>';
   }
   if ($attributes['description']) {
      echo '<p>' . $attributes['description'] . '</p>';
   }

   $platforms = array('Xbox', 'PlayStation', 'PC',);
   $platforms_html = '';


   if (!empty($featured_games)) {

      echo '<div class ="games-list">';
      foreach ($featured_games as $game) {
         $platforms_html = '';
         echo '<div class ="game-result">';
         echo '<a href="' . esc_url($game->get_permalink()) . '">';
         echo $game->get_image(); // Display product image
         echo '<div class ="game-meta">';
         echo '<div class="game-price">' . $game->get_price_html() . '</div>';
         echo '<h3>' . $game->get_name() . '</h3>';
         echo '<div class ="game-platforms">';
         echo '<div class ="platform_pc">';
         echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/pc.png" alt="PC Icon"/>';
         echo '</div>';
         echo '<div class ="platform_xbox">';
         echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/xbox.png" alt="Xbox Icon"/>';
         echo '</div>';
         echo '<div class ="platform_playstation">';
         echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/playstation.png" alt="Playstation Icon"/>';
         echo '</div>';
         foreach ($platforms as $platform) {
            $platforms_html .= (get_post_meta($game->get_id(), 'platform_' . strtolower($platform), true) ? '<div class="platform_' . strtolower($platform) . '">Xbox</div>' : '');
         }
         echo $platforms_html;
         echo '</div>';
         echo '</div>';
         echo '</a>';
         echo '</div>';
      }

      echo '</div>';
   } else {
      echo '<p>No featured products found.</p>';
   }
   echo '</div>';

   // Cleanup

   return ob_get_clean();



   // $args = array(
   //    'post_type'      => 'product',
   //    'post_status'    => 'publish',
   //    'posts_per_page' => $attributes['count'],
   //    'orderby'        => 'date',
   //    'order'          => 'DESC',
   // );

   // $products_query = new WP_Query($args);

   // ob_start();
   // echo '<div ' . get_block_wrapper_attributes() . '>';
   // if ($products_query->have_posts()) {
   //    if ($attributes['title']) {
   //       echo '<h2>' . $attributes['title'] . '</h2>';
   //    }
   //    if ($attributes['description']) {
   //       echo '<p>' . $attributes['description'] . '</p>';
   //    }
   //    echo '<div class ="featured-products">';
   //    while ($products_query->have_posts()) {
   //       $products_query->the_post();
   //       $product = wc_get_product(get_the_ID());
   //       echo '<div class ="product-item">';
   //       echo '<a href="' . get_the_permalink() . '">';
   //       echo $product->get_image('full'); // Display product image
   //       echo '</a>';
   //       echo '<h3>' . get_the_title() . '</h3>';
   //       echo '<span class="price">' . $product->get_price_html() . '</span>';
   //       echo '</div>';
   //    }
   //    echo '</div>';
   // }
   // echo '</div>';

   // // Cleanup
   // wp_reset_postdata();

   // return ob_get_clean();
}

function view_block_single_news()
{
   ob_start();

   $bg_img = get_the_post_thumbnail_url(get_the_ID(), 'full') ? 'style = "background-image: url(' . get_the_post_thumbnail_url(get_the_ID(), 'full',) . '); background-repeat: no-repeat; background-size: cover;"' : '';

   echo '<article ' . get_block_wrapper_attributes(array('class' => implode(' ', get_post_class('alignfull ')))) . '>';

   echo '<div class="featured-image-section" ' . $bg_img . '>';
   echo '<div class="wrapper">';
   echo '<h1 class="news-title">' . esc_html(get_the_title()) . '</h1>';
   echo '<div class="news-meta">';
   echo '<div class="news-date">
               <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8 2V5" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M16 2V5" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M3.5 9.09009H20.5" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M21 8.5V17C21 20 19.5 22 16 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M15.6947 13.7H15.7037" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M15.6947 16.7H15.7037" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M11.9955 13.7H12.0045" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M11.9955 16.7H12.0045" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M8.29431 13.7H8.30329" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M8.29431 16.7H8.30329" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

               ' . esc_html(get_the_date()) . '</div>';
   echo '<div class="news-author">
   <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M18.1399 21.62C17.2599 21.88 16.2199 22 14.9999 22H8.99986C7.77986 22 6.73986 21.88 5.85986 21.62C6.07986 19.02 8.74986 16.97 11.9999 16.97C15.2499 16.97 17.9199 19.02 18.1399 21.62Z" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M15 2H9C4 2 2 4 2 9V15C2 18.78 3.14 20.85 5.86 21.62C6.08 19.02 8.75 16.97 12 16.97C15.25 16.97 17.92 19.02 18.14 21.62C20.86 20.85 22 18.78 22 15V9C22 4 20 2 15 2ZM12 14.17C10.02 14.17 8.42 12.56 8.42 10.58C8.42 8.60002 10.02 7 12 7C13.98 7 15.58 8.60002 15.58 10.58C15.58 12.56 13.98 14.17 12 14.17Z" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M15.5799 10.58C15.5799 12.56 13.9799 14.17 11.9999 14.17C10.0199 14.17 8.41992 12.56 8.41992 10.58C8.41992 8.60002 10.0199 7 11.9999 7C13.9799 7 15.5799 8.60002 15.5799 10.58Z" stroke="var(--text-secondary)" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

   ' . esc_html(get_the_author()) . '</div>';
   echo '</div>';
   echo '</div>';
   echo '</div>';

   echo '<div class="wrapper news-container">';
   echo '<div class="news-social-share"> Share' . gamestore_social_share(get_the_ID()) . '</div>';
   echo '<div class = "news-content">' . get_the_content() . '</div>';
   echo '</div>';

   echo '</article>';



   return ob_get_clean();;
}

function view_block_single_genre($attributes)
{
   ob_start();

   $image_bg = ($attributes['imageBg']) ? 'style="background-image: url(' . $attributes['imageBg'] . ')"' : '';



   echo '<div class="featured-image-section" ' . $image_bg . '>';

   echo '<h1>' . single_term_title('', false) . '</h1>';

   echo '</div>';
   $term_name = single_term_title('', false);
   $featured_games = wc_get_products(array(
      'status' => 'publish',
      'limit' => 8,
      'featured' => true,
      'tax_query' => array(
         array(
            'taxonomy' => 'genre', // Название таксономии (например: product_cat, product_tag)
            'field'    => 'slug',
            'terms'    => $term_name, // Ярлык термина
         ),
      ),
   ));
   echo '<div ' . get_block_wrapper_attributes(array('class' => 'wrapper')) . '>';


   $platforms = array('Xbox', 'PlayStation', 'PC',);
   $platforms_html = '';


   if (!empty($featured_games)) {

      echo '<div class ="games-list">';
      foreach ($featured_games as $game) {
         $platforms_html = '';
         echo '<div class ="game-result">';
         echo '<a href="' . esc_url($game->get_permalink()) . '">';
         echo $game->get_image(); // Display product image
         echo '<div class ="game-meta">';
         echo '<div class="game-price">' . $game->get_price_html() . '</div>';
         echo '<h3>' . $game->get_name() . '</h3>';
         echo '<div class ="game-platforms">';
         echo '<div class ="platform_pc">';
         echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/pc.png" alt="PC Icon"/>';
         echo '</div>';
         echo '<div class ="platform_xbox">';
         echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/xbox.png" alt="Xbox Icon"/>';
         echo '</div>';
         echo '<div class ="platform_playstation">';
         echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/playstation.png" alt="Playstation Icon"/>';
         echo '</div>';
         foreach ($platforms as $platform) {
            $platforms_html .= (get_post_meta($game->get_id(), 'platform_' . strtolower($platform), true) ? '<div class="platform_' . strtolower($platform) . '">Xbox</div>' : '');
         }
         echo $platforms_html;
         echo '</div>';
         echo '</div>';
         echo '</a>';
         echo '</div>';
      }

      echo '</div>';
   } else {
      echo '<p>No featured products found.</p>';
   }
   echo '</div>';


   return ob_get_clean();;
}

function view_block_news_header($attributes)
{

   $image_bg = ($attributes['image']) ? 'style="background-image: url(' . $attributes['image'] . ')"' : '';

   ob_start();
   echo '<div ' . get_block_wrapper_attributes(['class' => 'alignFull news-header-block']) . $image_bg . '>';
   echo '<div class="wrapper">';
   echo '<h1 class="news-header-title">' . $attributes['title'] . '</h1>';
   echo '<p class="news-header-description">' . $attributes['description'] . '</p>';

   $terms_news = get_terms(array(
      'taxonomy' => 'news_category',
      'hide_empty' => false,
   ));

   if (!empty($terms_news) && is_wp_error($terms_news) == false) {
      echo '<div class="news-categories">';
      foreach ($terms_news as $term) {
         $icon_url = (get_term_meta($term->term_id, 'news_category_icon', true)) ? '<img src="' . wp_get_attachment_url(get_term_meta($term->term_id, 'news_category_icon', true)) . '">' : '';
         echo '<div class="news-cat-item">
         <a href="' . get_term_link($term) . '" class="news-category-item">' . $term->name . $icon_url . '</a>
         </div>';
      }
      echo '</div>';
   }

   echo '</div>';
   echo '</div>';

   return ob_get_clean();
}

function view_block_news_box()
{

   ob_start();
   echo '<div ' . get_block_wrapper_attributes() . '>';


   if (has_post_thumbnail()) {
      echo '<h3>' . get_the_title() . '</h3>';
      echo '<div class = "news-thumbnail">';
      echo '<img src = "' . get_the_post_thumbnail_url() . '" class="blur-image" alt="' . get_the_title() . '">';
      echo '<img src = "' . get_the_post_thumbnail_url() . '" class="original-image" alt="' . get_the_title() . '">';
      echo '</div>';
   }
   echo '<div class="news-excerpt">';
   the_excerpt();
   echo '</div>';
   echo '<a href="' . get_the_permalink() . '" class="read-more">Open the post</a>';
   echo  '</div>';

   return ob_get_clean();
}

function view_block_single_game()
{

   $game = wc_get_product(get_the_ID());

   if ($game) {

      $game_badge = (get_post_meta($game->get_ID(), '_game_image_id', true)) ? '<img src="' . wp_get_attachment_url(get_post_meta($game->get_ID(), '_game_image_id', true)) . '" alt="Game Cover" class="game-cover-badge"/>' : '';

      $publisher = get_post_meta($game->get_ID(), '_game_publisher', true) ? '<div class="label-text">Publisher</div><div class="item-text">' . get_post_meta($game->get_ID(), '_game_publisher', true) . '</div>' : 'Unknown Publisher';

      $single_player = get_post_meta($game->get_ID(), '_game_single_player', true) ? '<div class="label-text">Single Player</div><div class="item-text">' . get_post_meta($game->get_ID(), '_game_single_player', true) . '</div>' : 'nothing';

      $release_date = get_post_meta($game->get_ID(), '_game_release_date', true) ? '<div class="label-text">Released</div><div class="item-text">' . get_post_meta($game->get_ID(), '_game_release_date', true) . '</div>' : 'TBA';

      $game_full_description = get_post_meta($game->get_ID(), '_gamestore_full_description', true) ? '<div class="label-text">Game Description</div><div class="item-text">' . get_post_meta($game->get_ID(), '_gamestore_full_description', true) : 'No description available';

      $languages = wp_get_post_terms($game->get_ID(), 'language');
      $languages_html = '';
      if (!empty($languages) && !is_wp_error($languages)) {
         foreach ($languages as $language) {
            $languages_html .= '<div class="language-item">' . esc_html($language->name) . '</div>';
         }
      }

      $platforms = wp_get_post_terms($game->get_ID(), 'platform');
      $platforms_html = '';
      if (!empty($platforms) && !is_wp_error($platforms)) {
         $platforms_html .= '<div class="label-text">Platforms</div>';
         foreach ($platforms as $platform) {
            $platforms_html .= '<div class="item-text"><a href ="' . get_term_link($platform) . '">' . esc_html($platform->name) . '</a></div>';
         }
      }

      $genres = wp_get_post_terms($game->get_ID(), 'genre');
      $genres_html = '';
      if (!empty($genres) && !is_wp_error($genres)) {
         $genres_html .= '<div class="label-text">Genres</div>';
         foreach ($genres as $genre) {
            $genres_html .= '<div class="item-text"><a href ="' . get_term_link($genre) . '">' . esc_html($genre->name) . '</a></div>';
         }
      }

      $game_screens_images = $game->get_gallery_image_ids();
      $game_screens_html = '';

      if (!empty($game_screens_images)) {
         $game_screens_html .= '<div class="game-screenshots"><h4>Videos & Game Play:</h4><div class="game-single-slider"><div class="slider-wrapper">';
         foreach ($game_screens_images as $image_id) {
            $image_url = wp_get_attachment_image_url($image_id, 'large');
            $game_screens_html .= '<div class="game-screen slide-item"><img src="' . esc_url($image_url) . '" alt="Game Screenshot" class="game-screenshot"/></div>';
         }
         $game_screens_html .= '</div></div></div>';
      }

      ob_start();
      echo '<div ' . get_block_wrapper_attributes() . '>';
      echo '<div class="wrapper">';
      echo '<aside class="game-image">';
      echo '<div class="game-image-container">';
      echo $game->get_image('large');
      echo '</div>';
      echo '<div class ="game-platforms">';
      echo '<div class ="platform_pc">';
      echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/pc.png" alt="PC Icon"/>';
      echo '</div>';
      echo '<div class ="platform_xbox">';
      echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/xbox.png" alt="Xbox Icon"/>';
      echo '</div>';
      echo '<div class ="platform_playstation">';
      echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/playstation.png" alt="Playstation Icon"/>';
      echo '</div>';
      echo '</div>';
      echo '</aside>';
      echo '<div class ="game-content">';
      echo '<div class ="game-description-top">';
      echo '<h1 class="game-title">' . esc_html(get_the_title()) . '</h1>' . $game_badge;
      echo '</div>';
      echo '<div class = "game-languages">' . $languages_html . '</div>';
      echo '<div class = "game-description">' . $game->get_short_description() . '</div>';
      echo '<div class ="game-meta-data">';
      echo '<div class = "game-platforms-text">' . $platforms_html . '</div>';
      echo '<div class = "game-genres">' . $genres_html . '</div>';
      echo '<div class = "game-publisher">' . $publisher . '</div>';
      echo '<div class = "game-single-player">' . $single_player . '</div>';
      echo '<div class = "game-release-date">' . $release_date . '</div>';
      echo '</div>';
      echo '<div class ="game-price-button">';
      echo '<div class="game-price">' . $game->get_price_html() . '</div>';
      echo '<div class="game-add-to-cart"><a class="hero-button shadow" href="?add-to-cart=' . $game->get_id() . '">Purchase the Game</a></div>';
      echo '</div>';
      echo '<div class ="game-screens">';
      echo $game_screens_html;
      echo  '</div>';
      echo '<div class ="game-full-description">';
      echo $game_full_description;
      echo  '</div>';
      echo  '</div>';
      echo  '</div>';
      echo  '</div>';
      echo  '</div>';

      return ob_get_clean();
   }
}

function view_block_similar_products($attributes)
{

   global $post;

   $link_html = ($attributes['link']) ? '<a href="' . esc_url($attributes['link']) . '" class ="viev-all-link">' . $attributes['linkAnchor'] . '</a>' : null;
   if (!$post || !is_singular('product')) return;

   $product_id = $post->ID;
   $product = wc_get_product($product_id);

   if (!$product) return;

   $genres = wp_get_post_terms($product_id, "genre", array("fields" => "ids"));

   $similar_games = wc_get_products(array(
      'status' => 'publish',
      'limit' => $attributes['count'],
      'exclude' => array($product_id),
      'tax_query' => array(
         array(
            'taxonomy' => 'genre',
            'field' => 'term_id',
            'terms' => $genres,
         )
      )

   ));

   ob_start();
   echo '<div ' . get_block_wrapper_attributes(array('class' => 'wrapper')) . '>';

   echo '<div class="similar-top">';
   if ($attributes['title']) {
      echo '<h2>' . $attributes['title'] . '</h2>';
   }
   echo '<div class="right-similar-top">';
   echo $link_html;
   echo '</div>';
   echo '</div>';

   $platforms = array('Xbox', 'PlayStation', 'PC',);
   $platforms_html = '';


   if (!empty($similar_games)) {

      echo '<div class ="games-list similar-games-list">';
      foreach ($similar_games as $game) {
         $platforms_html = '';
         echo '<div class ="game-result">';
         echo '<a href="' . esc_url($game->get_permalink()) . '">';
         echo $game->get_image(); // Display product image
         echo '<div class ="game-meta">';
         echo '<div class="game-price">' . $game->get_price_html() . '</div>';
         echo '<h3>' . $game->get_name() . '</h3>';
         echo '<div class ="game-platforms">';
         echo '<div class ="platform_pc">';
         echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/pc.png" alt="PC Icon"/>';
         echo '</div>';
         echo '<div class ="platform_xbox">';
         echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/xbox.png" alt="Xbox Icon"/>';
         echo '</div>';
         echo '<div class ="platform_playstation">';
         echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/playstation.png" alt="Playstation Icon"/>';
         echo '</div>';
         foreach ($platforms as $platform) {
            $platforms_html .= (get_post_meta($game->get_id(), 'platform_' . strtolower($platform), true) ? '<div class="platform_' . strtolower($platform) . '">Xbox</div>' : '');
         }
         echo $platforms_html;
         echo '</div>';
         echo '</div>';
         echo '</a>';
         echo '</div>';
      }

      echo '</div>';
   } else {
      echo '<p>No similar products found.</p>';
   }
   echo '</div>';

   // Cleanup

   return ob_get_clean();
}

function view_block_product_header($attributes)
{

   $image_bg = ($attributes['image']) ? 'style="background-image: url(' . $attributes['image'] . ')"' : '';

   ob_start();
   echo '<div ' . get_block_wrapper_attributes(['class' => 'alignFull games-header-block']) . $image_bg . '>';
   echo '<div class="wrapper">';
   echo '<h1 class="games-header-title">' . $attributes['title'] . '</h1>';
   if ($attributes['styleType'] == 'archive') {
      $terms_news = get_terms(array(
         'taxonomy' => 'genre',
         'hide_empty' => false,
      ));

      if (!empty($terms_news) && is_wp_error($terms_news) == false) {
         echo '<div class="games-categories">';
         foreach ($terms_news as $term) {
            echo '<div class="games-cat-item">
         <a href="' . get_term_link($term) . '" class="games-category-item">' . $term->name . '</a>
         </div>';
         }
         echo '</div>';
      }
   } else {
      if (!empty($attributes['links'])) {
         echo '<div class="cart-links">';
         foreach ($attributes['links'] as $link) {
            echo '<div class="cart-link-item">
         <a href="' . $link['url'] . '" >' . $link['anchor'] . '</a>
         </div>';
         }
         echo '</div>';
      }
   }
   echo '</div>';
   echo '</div>';

   return ob_get_clean();
}

function view_block_bestseller_products($attributes)
{
   if (isset($attributes['productType']) && $attributes['productType'] == 'cross-seller') {

      $cross_sell_ids = array();

      $cart = WC()->cart->get_cart();
      if (!empty($cart)) {
         foreach ($cart as $cart_item) {
            $product_id = $cart_item['product_id'];
            $product_cross_sells = get_post_meta($product_id, '_crosssell_ids', true);

            if (!empty($product_cross_sells)) {
               $cross_sell_ids = array_merge($cross_sell_ids, $product_cross_sells);
            }
         }
      }

      $cross_sell_ids = array_unique($cross_sell_ids);

      $slider_games = wc_get_products(array(
         'status' => 'publish',
         'limit' => $attributes['count'],
         'include' => $cross_sell_ids,
      ));
   } else {


      $slider_games = wc_get_products(array(
         'status' => 'publish',
         'limit' => $attributes['count'],
         'meta_key' => 'total_sales',
         'orderby' => 'meta_value_num',
         'order' => 'DESC'
      ));
   }
   ob_start();
   echo '<div ' . get_block_wrapper_attributes(array('class' => 'wrapper')) . '>';

   if (!empty($slider_games)) {

      echo '<div class="bestseller-top">';
      if ($attributes['title']) {
         echo '<h2>' . $attributes['title'] . '</h2>';
      }
      echo '<div class="right-bestseller-top">';
      echo '</div>';
      echo '</div>';

      $platforms = array('Xbox', 'PlayStation', 'PC',);
      $platforms_html = '';

      echo '<div class ="games-list bestseller-games-list">';
      foreach ($slider_games as $game) {
         $platforms_html = '';
         echo '<div class ="game-result">';
         echo '<a href="' . esc_url($game->get_permalink()) . '">';
         echo $game->get_image(); // Display product image
         echo '<div class ="game-meta">';
         echo '<div class="game-price">' . $game->get_price_html() . '</div>';
         echo '<h3>' . $game->get_name() . '</h3>';
         echo '<div class ="game-platforms">';
         echo '<div class ="platform_pc">';
         echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/pc.png" alt="PC Icon"/>';
         echo '</div>';
         echo '<div class ="platform_xbox">';
         echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/xbox.png" alt="Xbox Icon"/>';
         echo '</div>';
         echo '<div class ="platform_playstation">';
         echo '<image src="' . plugin_dir_url(__FILE__) . 'assets/playstation.png" alt="Playstation Icon"/>';
         echo '</div>';
         foreach ($platforms as $platform) {
            $platforms_html .= (get_post_meta($game->get_id(), 'platform_' . strtolower($platform), true) ? '<div class="platform_' . strtolower($platform) . '">Xbox</div>' : '');
         }
         echo $platforms_html;
         echo '</div>';
         echo '</div>';
         echo '</a>';
         echo '</div>';
      }
      echo '</div>';
   }
   echo '</div>';

   // Cleanup

   return ob_get_clean();
}

function view_block_games_filter($attributes)
{
   $count = isset($attributes['count']) ? (int) $attributes['count'] : 16;
   $title = isset($attributes['title']) ? $attributes['title'] : '';

   $languages = get_terms(array(
      'taxonomy' => 'language',
      'hide_empty' => false
   ));
   $genres = get_terms(array(
      'taxonomy' => 'genre',
      'hide_empty' => false
   ));

   $platforms = get_terms(array(
      'taxonomy' => 'platform',
      'hide_empty' => false
   ));

   $single = ['Yes', 'No'];

   $publishers = ['Ubisoft', 'Bad Pixel', 'Relic Intertainment', 'EA Games', 'Rockstar', 'Creative Assembly'];

   $years = range(date('Y'), date('Y') - 20);

   $html = '';

   $games_posts = wc_get_products(array(
      'status' => 'publish',
      'limit' => $count,
   ));

   $html .= '<div ' . get_block_wrapper_attributes() . '>';
   $html .= '<div class="wrapper">';
   if ($title) {
      $html .= '<div class="filter-title-top">';
      $html .= '<h2 class = "games-box-title">' . $title . '</h2>';
      $html .= '<div class = "custom-sort"><span class = "label">Sort by:</span>';
      $html .= '<form method="POST" action="">';
      $html .= '<select name="sorting" id="sorting">';
      $html .= '<option value ="">Default</option>';
      $html .= '<option value ="latest">Sort by Latest</option>';
      $html .= '<option value ="price_low_high">Sort by Price: Low to High</option>';
      $html .= '<option value ="price_high_low">Sort by Price: High to Low</option>';
      $html .= '<option value ="popularity">Sort by Popularity</option>';
      $html .= '</select>';
      $html .= '</form>';
      $html .= '</div>';
      $html .= '</div>';
   }

   $html .= '<div class = "games-box-filter">';
   $html .= '<div class = "games-filter">';
   $html .= '<form method="POST" action="">';
   // Languages
   if (!empty($languages) && !is_wp_error($languages)) {
      $html .= '<div class = "games-filter-item">';
      $html .= '<h5>LANGUAGES</h5>';
      foreach ($languages as $language) {
         $html .= '<div class="filter-item"><input type="checkbox" id="language-' . $language->term_id . '" name="language-' . $language->term_id . '"><label for="language-' . $language->term_id . '">' . $language->name . '</label></div>';
      }
      $html .= '</div>';
   }

   //Genres
   if (!empty($genres) && !is_wp_error($genres)) {
      $html .= '<div class = "games-filter-item">';
      $html .= '<h5>GENRES</h5>';
      foreach ($genres as $genre) {
         $html .= '<div class="filter-item"><input type="checkbox" id="genre-' . $genre->term_id . '" name="genre-' . $genre->term_id . '"><label for="genre-' . $genre->term_id . '">' . $genre->name . '</label></div>';
      }
      $html .= '</div>';
   }

   //Platforms
   if (!empty($platforms) && !is_wp_error($platforms)) {
      $html .= '<div class = "games-filter-item-select">';
      $html .= '<select name="platforms" id="platforms">';
      $html .= '<option value ="">Platforms</option>';
      foreach ($platforms as $platform) {
         $html .= '<option value="' . $platform->term_id . '">' . $platform->name . '</option>';
      }
      $html .= '</select>';
      $html .= '</div>';
   }

   //Single Player
   if (!empty($single) && !is_wp_error($single)) {
      $html .= '<div class = "games-filter-item-select">';
      $html .= '<select name="singleplayer" id="singleplayer">';
      $html .= '<option value ="">Single Player</option>';
      foreach ($single as $sing) {
         $html .= '<option value="' . $sing . '">' . $sing . '</option>';
      }
      $html .= '</select>';
      $html .= '</div>';
   }

   //Publisher
   if (!empty($publishers) && !is_wp_error($publishers)) {
      $html .= '<div class = "games-filter-item-select">';
      $html .= '<select name="publisher" id="publisher">';
      $html .= '<option value ="">Publisher</option>';
      foreach ($publishers as $publisher) {
         $html .= '<option value="' . $publisher . '">' . $publisher . '</option>';
      }
      $html .= '</select>';
      $html .= '</div>';
   }

   //Released
   if (!empty($years) && !is_wp_error($years)) {
      $html .= '<div class = "games-filter-item-select">';
      $html .= '<select name="released" id="released">';
      $html .= '<option value ="">Release Date</option>';
      foreach ($years as $year) {
         $html .= '<option value="' . $year . '">' . $year . '</option>';
      }
      $html .= '</select>';
      $html .= '</div>';
   }

   //Reset Button
   $html .= '<div class = "games-filter-item-select">';
   $html .= '<button class = "hero-button shadow" type = "reset">Reset Filter</button>';
   $html .= '</div>';

   $html .= '<input type="hidden" name="post_per_page" value="' . esc_attr($count) . '"/>';

   $html .= '</form>';

   $html .= '</div>';
   $html .= '<div class="games-box-list">';
   if (!empty($games_posts)) {
      $html .= '<div class="games-list">';

      foreach ($games_posts as $game) {
         $html .= '<div class ="game-result">';
         $html .= '<a href="' . esc_url($game->get_permalink()) . '">';
         $html .= $game->get_image(); // Display product image
         $html .= '<div class ="game-meta">';
         $html .= '<div class="game-price">' . $game->get_price_html() . '</div>';
         $html .= '<h3 class ="game-name">' . $game->get_name() . '</h3>';
         $html .= '<div class ="game-platforms">';
         $html .= '<div class ="platform_pc">';
         $html .= '<image src="' . plugin_dir_url(__FILE__) . 'assets/pc.png" alt="PC Icon"/>';
         $html .= '</div>';
         $html .= '<div class ="platform_xbox">';
         $html .= '<image src="' . plugin_dir_url(__FILE__) . 'assets/xbox.png" alt="Xbox Icon"/>';
         $html .= '</div>';
         $html .= '<div class ="platform_playstation">';
         $html .= '<image src="' . plugin_dir_url(__FILE__) . 'assets/playstation.png" alt="Playstation Icon"/>';
         $html .= '</div>';
         $html .= '</div>';
         $html .= '</div>';
         $html .= '</a>';
         $html .= '</div>';
      }

      $html .= '</div>';
      $html .= '<div class ="load-more-container"><a class = "load-more-button hero-button shadow">Load More</a></div>';
   }
   $html .= '</div>';
   $html .= '</div>';
   $html .= '</div>';
   $html .= '</div>';

   return $html;
}

// fuction for contact form block 

function view_block_contact_form($attributes)
{

   ob_start();
   echo '<div ' . get_block_wrapper_attributes(array('class' => 'wrapper')) . '>';
   if ($attributes['title']) {
      echo '<h2>' . $attributes['title'] . '</h2>';
   }
   if ($attributes['description']) {
      echo '<p>' . $attributes['description'] . '</p>';
   }
   echo '<div class="form-inner">';
   echo '<div class="form-icon">';
   echo '</div>';
   echo '<form action="/submit" method="POST">';
   echo '<div>';
   echo  '<label for="name">Your Name</label>';
   echo  '<input type="text" id="name" name="user_name" required>';
   echo '</div>';

   echo '<div>';
   echo  '<label for="email">Your E-mail:</label>';
   echo  '<input type="email" id="email" name="user_email" required>';
   echo '</div>';

   echo '<div>';
   echo  '<label for="desc">Describe the Problem:</label>';
   echo  '<textarea id="desc" name="description" rows="5"></textarea>';
   echo '</div>';

   echo '<button class="hero-button shadow" type="submit">' . esc_html($attributes['buttonText']) . '</button>';
   echo '</form>';

   echo '</div>';

   // Cleanup

   return ob_get_clean();
}
