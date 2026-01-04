<?php
    add_filter('woocommerce_product_data_tabs', 'add_gamestore_tab');
    function add_gamestore_tab($tabs)
    {
        $tabs['gamestore'] = array(
            'label'    => __('GameStore', 'gamestore'),
            'target'   => 'gamestore_product_data',
            'class'    => array('show_if_simple', 'show_if_variable'),
            'priority' => 21,
        );
        return $tabs;
    }

    add_action('woocommerce_product_data_panels', 'add_gemastore_tab_content');
    function add_gemastore_tab_content()
    {


        global $post;
    ?>
     <div id="gamestore_product_data" class="panel woocommerce_options_panel">
         <div class="options_group">
             <?php
                woocommerce_wp_text_input(
                    array(
                        'id'          => '_game_publisher',
                        'label'       => __('Publisher', 'core-gamestore'),
                        'description' => __('Enter the platform for this game.', 'core-gamestore'),
                        'placeholder' => 'e.g., Ubisoft',
                        'desc_tip'    => true,

                    )
                );

                //Multicheckbox fild 
                ?>

             <p class="form-field"><label>
                     <?php __('Platforms', 'core-gamestore');
                        $platforms = array('PC', 'PlayStation', 'Xbox');
                        foreach ($platforms as $platform) {
                            woocommerce_wp_checkbox(
                                array(
                                    'id'          => '_platform_' . strtolower($platform),
                                    'label'       => $platform,
                                    'description' => __('Check if this game is available on ' . $platform . '.', 'core-gamestore'),
                                    'desc_tip'    => true,
                                )
                            );
                        }
                        ?>
                 </label>
             </p>;

             <?php

                ?>
         </div>
     </div>
 <?php
    }

    add_action('woocommerce_process_product_meta', 'save_gamestore_tab_fields');
    function save_gamestore_tab_fields($post_id)
    {
        // Save Publisher
        $game_publisher = isset($_POST['_game_publisher']) ? sanitize_text_field($_POST['_game_publisher']) : '';
        update_post_meta($post_id, '_game_publisher', $game_publisher);

        // Save Platforms
        $platforms = array('pc', 'playstation', 'xbox');
        foreach ($platforms as $platform) {
            $platform_key = '_platform_' . $platform;
            $is_checked = isset($_POST[$platform_key]) ? 'yes' : 'no';
            update_post_meta($post_id, $platform_key, $is_checked);
        }
    }
