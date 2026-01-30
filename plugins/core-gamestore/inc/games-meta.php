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

            woocommerce_wp_text_input(
                array(
                    'id'          => '_game_single_player',
                    'label'       => __('Single Player', 'core-gamestore'),
                    'description' => __('Enter the game mode for this game.', 'core-gamestore'),
                    'placeholder' => 'e.g., Yes / No',
                    'desc_tip'    => true

                )
            );

            woocommerce_wp_text_input(
                array(
                    'id'          => '_game_release_date',
                    'label'       => __('Release Date', 'core-gamestore'),
                    'description' => __('Enter the release date.', 'core-gamestore'),
                    'placeholder' => 'e.g., 2023-10-15',
                    'desc_tip'    => false,
                    'type'        => 'date',

                )
            );

            // Image upload field (Game Cover)
            $image_id = get_post_meta($post->ID, '_game_image_id', true);
            $image_src = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
            ?>

            <p class="form-field">
                <label for="_game_image_id"><?php _e('Game Cover', 'core-gamestore'); ?></label>
                <input type="hidden" id="_game_image_id" name="_game_image_id" value="<?php echo esc_attr($image_id); ?>" />
                <img id="_game_image_preview" src="<?php echo esc_url($image_src); ?>" style="max-width:150px;display:<?php echo $image_src ? 'block' : 'none'; ?>;margin-bottom:8px;" />
                <br />
                <button type="button" class="button" id="gamestore_upload_image_button"><?php _e('Upload / Select Image', 'core-gamestore'); ?></button>
                <button type="button" class="button" id="gamestore_remove_image_button" style="display:<?php echo $image_src ? 'inline-block' : 'none'; ?>;"><?php _e('Remove Image', 'core-gamestore'); ?></button>
            </p>

            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    var frame;
                    $('#gamestore_upload_image_button').on('click', function(e) {
                        e.preventDefault();
                        if (frame) {
                            frame.open();
                            return;
                        }
                        frame = wp.media({
                            title: '<?php echo esc_js(__('Select or Upload Game Cover', 'core-gamestore')); ?>',
                            button: {
                                text: '<?php echo esc_js(__('Use this image', 'core-gamestore')); ?>'
                            },
                            multiple: false
                        });
                        frame.on('select', function() {
                            var attachment = frame.state().get('selection').first().toJSON();
                            $('#_game_image_id').val(attachment.id);
                            $('#_game_image_preview').attr('src', attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url).show();
                            $('#gamestore_remove_image_button').show();
                        });
                        frame.open();
                    });

                    $('#gamestore_remove_image_button').on('click', function(e) {
                        e.preventDefault();
                        $('#_game_image_id').val('');
                        $('#_game_image_preview').attr('src', '').hide();
                        $(this).hide();
                    });
                });
            </script>


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

     // Save Single Player
    $game_publisher = isset($_POST['_game_single_player']) ? sanitize_text_field($_POST['_game_single_player']) : '';
    update_post_meta($post_id, '_game_single_player', $game_publisher);


    // Save Game Mode
    $game_mode = isset($_POST['_game_mode']) ? sanitize_text_field($_POST['_game_mode']) : '';
    update_post_meta($post_id, '_game_mode', $game_mode);

    // Save Release Date
    $game_release_date = isset($_POST['_game_release_date']) ? sanitize_text_field($_POST['_game_release_date']) : '';
    update_post_meta($post_id, '_game_release_date', $game_release_date);

    // Save Game Cover (image attachment ID)
    $game_image_id = isset($_POST['_game_image_id']) ? intval($_POST['_game_image_id']) : 0;
    if ($game_image_id) {
        update_post_meta($post_id, '_game_image_id', $game_image_id);
    } else {
        delete_post_meta($post_id, '_game_image_id');
    }

    // Save Platforms
    $platforms = array('pc', 'playstation', 'xbox');
    foreach ($platforms as $platform) {
        $platform_key = '_platform_' . $platform;
        $is_checked = isset($_POST[$platform_key]) ? 'yes' : 'no';
        update_post_meta($post_id, $platform_key, $is_checked);
    }
}


// Enqueue media scripts on product edit screen so media uploader works
add_action('admin_enqueue_scripts', 'gamestore_admin_enqueue');
function gamestore_admin_enqueue($hook)
{
    global $post;
    if (! isset($post)) {
        return;
    }
    if ($post->post_type !== 'product') {
        return;
    }
    wp_enqueue_media();
}

function woo_custom_description_metabox()
{
    add_meta_box(
        'woo_custom_description_metabox',
        __(
            'Game Description',
            'core-gamestore'
        ),
        'woo_custom_description_metabox_content',
        'product',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'woo_custom_description_metabox');

function woo_custom_description_metabox_content($post)
{
    $content = get_post_meta($post->ID, '_gamestore_full_description', true);

    wp_editor($content, '_gamestore_full_description', array('textarea_name' => '_gamestore_full_description'));
}

function save_custom_description($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (isset($_POST['post_type']) && 'product' === $_POST['post_type']) {
        if (! current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    if (! isset($_POST['_gamestore_full_description'])) {
        return;
    }

    update_post_meta($post_id, '_gamestore_full_description', $_POST['_gamestore_full_description']);
}
add_action('save_post', 'save_custom_description');