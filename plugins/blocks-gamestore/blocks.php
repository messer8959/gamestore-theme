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

// function for featured games

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
