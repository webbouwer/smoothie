<?php


// body tag class
function smoothie_body_class( $classes ) {
    $classes[] = 'smoothie-theme'; // 'frontpage-'.get_theme_mod('settings_frontpage_type');
    return $classes;
}
add_filter( 'body_class', 'smoothie_body_class' );

// body background (image) style
function smoothie_body_bgstyle(){
    $bodybgstyle = '';
    if( get_background_image() ){ // https://css-tricks.com/perfect-full-page-background-image/
    $bgposition = get_theme_mod('background_position', 'bottom center');
    $bgattacht = get_theme_mod('background_attachment', 'fixed');
    $bgrepeat = get_theme_mod('background_repeat', 'no-repeat');
    $bgsize = get_theme_mod('background_size', 'cover');
    $bodybgstyle = ' style="background-image:url('.esc_url( get_background_image() ).');background-position:'.$bgposition.';background-attachment:'.$bgattacht.';background-size:'.$bgsize.';background-repeat:'.$bgrepeat.';"';
    }
    return $bodybgstyle;
}
