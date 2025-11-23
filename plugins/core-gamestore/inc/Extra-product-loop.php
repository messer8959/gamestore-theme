<?php
                    $args = array(
                        'post_type'      => 'product',
                        'post_status'    => 'publish',
                        'posts_per_page' => 12,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    );

                    $games_query = new WP_Query($args);
                    ob_start();
                    if ($games_query->have_posts()) {

                        while ($games_query->have_posts()) {
                            $games_query->the_post();
                            $product = wc_get_product(get_the_ID());
                    ?>
                            <div class="game-result">
                                <a href="<?php echo get_the_permalink(); ?>">
                                    <div class="game-featured-image">
                                        <?php echo $product->get_image('full'); ?>
                                    </div>
                                    <div class="game-meta">
                                        <div class="game-price"><?php echo $product->get_price_html(); ?></div>
                                        <div class="game-title">
                                            <h3><?php echo get_the_title(); ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    <?php
                            // echo '<div class="game-result">';
                            // echo '<a href="' . get_the_permalink() . '">';
                            // echo '<div class = "game-featured-image"';
                            // echo $product->get_image('full');
                            // echo '</div>';
                            // echo '</div class="game-meta">';
                            // echo '<div class="game-title">' . get_the_title() . '</div>';
                            // echo '<div class="game-price">' . $product->get_price_html() . '</div>';
                            // echo '</div>';
                            // echo '</a>';
                            // echo '</div>';
                        }
                    }
                    echo '</div>';

                    // Cleanup
                    wp_reset_postdata();
                    ?>