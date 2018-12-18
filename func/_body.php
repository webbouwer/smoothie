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

// theme html loop output
function smoothie_body_loop(){

    global $post;

    if (have_posts()) :

    echo '<div id="maincontent" class="mainpage-container swiper-slide" data-hash="slide-'.$post->post_name.'">';

		while (have_posts()) : the_post();

                $post = get_post($post->id);
            /*
            if( get_post_type() ) : {
                get_template_part( 'html/body', get_post_type() );
                elseif :
                get_template_part( 'html/body', get_post_format() );
                endif;
            }
            */

            echo '<div class="post-container">';

                // post title section
                $title_html = '<a href="'.get_the_permalink().'" target="_self" title="'.get_the_title().'">'.get_the_title().'</a>';
                echo '<div class="post-title">';
                if(is_page()){
                    echo '<h1>'.$title_html.'</h1>';
                }else if( is_single() ){
                    echo '<h1>'.$title_html.'</h1>';
                }else{
                    echo '<h2>'.$title_html.'</h2>';
                }
                echo '</div>';
                // post content section
                $excerpt_length = 120; // char count
                $fulltext = $post->post_content;//  str_replace( '<!--more-->', '',);
                $content = apply_filters('the_content', $fulltext );
                $excerpt = truncate( $content, $excerpt_length, '', false, true );  // get_the_excerpt()
                if(is_page()){
                    echo '<div class="post-content">';
                    echo $content;
                    echo '</div>';
                }else if( is_single() ){
                    echo '<div class="post-content">';
                    echo $content;
                    echo '</div>';
                    previous_post_link('%link', __('previous', 'resource' ), TRUE);
                    next_post_link('%link', __('next', 'resource' ), TRUE);
                }else{
                    echo '<div class="post-content post-excerpt">';
                    echo $excerpt;
                    echo '</div>';
                }
            echo '<div class="clr"></div></div>';
        endwhile;
        echo '<div class="clr"></div></div>';
    endif;
    wp_reset_query();
}

