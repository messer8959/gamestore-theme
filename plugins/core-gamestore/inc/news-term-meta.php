<?php

// Add image upload field to Add Term form
function gamestore_news_category_add_form_fields( $taxonomy ) {
	?>
	<div class="form-field term-group">
		<label for="news-category-icon-id"><?php esc_html_e( 'Icon', 'core-gamestore' ); ?></label>
		<input type="hidden" id="news-category-icon-id" name="news_category_icon_id" class="news-category-icon-id" value="" />
		<div class="news-category-image-preview"></div>
		<p>
			<button class="button gamestore-upload-image-button" type="button"><?php esc_html_e( 'Upload/Add image', 'core-gamestore' ); ?></button>
			<button class="button gamestore-remove-image-button" type="button"><?php esc_html_e( 'Remove image', 'core-gamestore' ); ?></button>
		</p>    
	</div>
	<?php
}
add_action( 'news_category_add_form_fields', 'gamestore_news_category_add_form_fields', 10, 1 );

// Edit Term form field
function gamestore_news_category_edit_form_fields( $term ) {
	$term_id = $term->term_id;
	$image_id = get_term_meta( $term_id, 'news_category_icon', true );
	$image_html = '';
	if ( $image_id ) {
		$image_html = wp_get_attachment_image( $image_id, 'thumbnail' );
	}
	?>
	<tr class="form-field term-group-wrap">
		<th scope="row"><label for="news-category-icon-id"><?php esc_html_e( 'Icon', 'core-gamestore' ); ?></label></th>
		<td>
			<input type="hidden" id="news-category-icon-id" name="news_category_icon_id" class="news-category-icon-id" value="<?php echo esc_attr( $image_id ); ?>" />
			<div class="news-category-image-preview"><?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			<p>
				<button class="button gamestore-upload-image-button" type="button"><?php esc_html_e( 'Upload/Add image', 'core-gamestore' ); ?></button>
				<button class="button gamestore-remove-image-button" type="button"><?php esc_html_e( 'Remove image', 'core-gamestore' ); ?></button>
			</p>
		</td>
	</tr>
	<?php
}
add_action( 'news_category_edit_form_fields', 'gamestore_news_category_edit_form_fields', 10, 1 );

// Save term meta on create and edit
function gamestore_save_news_category_meta( $term_id ) {
	if ( isset( $_POST['news_category_icon_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$icon_id = intval( $_POST['news_category_icon_id'] );
		if ( $icon_id ) {
			update_term_meta( $term_id, 'news_category_icon', $icon_id );
		} else {
			delete_term_meta( $term_id, 'news_category_icon' );
		}
	}
}
add_action( 'created_news_category', 'gamestore_save_news_category_meta', 10, 1 );
add_action( 'edited_news_category', 'gamestore_save_news_category_meta', 10, 1 );

// Enqueue media scripts and add inline JS for the uploader on taxonomy screens
function gamestore_news_category_admin_scripts( $hook ) {
	$screen = get_current_screen();
	if ( ! $screen ) {
		return;
	}

	if ( isset( $screen->taxonomy ) && 'news_category' === $screen->taxonomy ) {
		wp_enqueue_media();

        if(isset($_GET['taxonomy']) && $_GET['taxonomy'] === 'news_category') {
            wp_enqueue_script( 'gamestore-news-category-term-meta', GAMESTORE_PLUGIN_URL . 'assets/js/news-term-meta.js', array( 'jquery' ), null, false );
        }

		wp_enqueue_script( 'jquery' );
	}
}
add_action( 'admin_enqueue_scripts', 'gamestore_news_category_admin_scripts' );

function news_category_add_icon_column( $columns ) {
	$new_columns = array();
	foreach ( $columns as $key => $value ) {
		$new_columns[ $key ] = $value;
		if ( 'name' === $key ) {
			$new_columns['news_category_icon'] = esc_html__( 'Icon', 'core-gamestore' );
		}
	}
	return $new_columns;
}

add_filter( 'manage_edit-news_category_columns', 'news_category_add_icon_column' );

function news_category_icon_column_content( $content, $column_name, $term_id ) {
	if ( 'news_category_icon' === $column_name ) {
		$image_id = get_term_meta( $term_id, 'news_category_icon', true );
		if ( $image_id ) {
			$content = wp_get_attachment_image( $image_id, array( 32, 32 ) );
		} else {
			$content = '';
		}
	}
	return $content;
}

add_filter( 'manage_news_category_custom_column', 'news_category_icon_column_content', 10, 3 );


