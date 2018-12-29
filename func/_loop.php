<?php
// theme html loop output
function smoothie_postloop_html(){

    global $post;

    if (have_posts()) :

    echo '<div id="'.$post->post_name.'" class="mainpage-container swiper-slide" data-hash="slide-'.$post->post_name.'">';

		while (have_posts()) : the_post();

            $post = get_post($post->id);
            if(is_page()){
            echo '<div class="page-container">';
            }else if( is_single() ){
            echo '<div class="post-container">';
            }else{
            echo '<div class="list-element-container">';
            }
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
