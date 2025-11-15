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
   echo '<div '. get_block_wrapper_attributes() . '>';
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
