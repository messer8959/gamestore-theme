<?php

function gamestore_social_share( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $title_raw = get_the_title( $post_id );
    $permalink = get_permalink( $post_id );

    $title = rawurlencode( html_entity_decode( $title_raw, ENT_COMPAT, 'UTF-8' ) );
    $url   = rawurlencode( $permalink );

    $image_url = '';
    if ( has_post_thumbnail( $post_id ) ) {
        $thumb_id  = get_post_thumbnail_id( $post_id );
        $image_url = wp_get_attachment_url( $thumb_id );
    }
    $image = rawurlencode( $image_url );

    $share_urls = array(
        'twitter'   => 'https://twitter.com/intent/tweet?text=' . $title . '&url=' . $url,
        'facebook'  => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
        'pinterest' => 'https://pinterest.com/pin/create/button/?url=' . $url . '&media=' . $image . '&description=' . $title,
        'email'     => 'mailto:?subject=' . rawurlencode( $title_raw ) . '&body=' . rawurlencode( $permalink ),
    );

    $out = '<div class="social-share-buttons">';
    foreach ( $share_urls as $key => $href ) {
        $label = ucfirst( $key );
        $out  .= '<a class="gamestore-social-share__link gamestore-social-share__link--' . $key . '"';
        $out  .= ' href="' . esc_url( $href ) . '"';
        $out  .= ' target="_blank" rel="noopener noreferrer nofollow"';
        $out  .= ' title="' . esc_attr( sprintf( __( 'Share on %s', 'core-gamestore' ), $label ) ) . '">';
        $out  .= esc_html( $label );
        $out  .= '</a>';
    }
    $out .= '</div>';

    return $out;
}