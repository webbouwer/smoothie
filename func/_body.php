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
    if (have_posts()) :
		while (have_posts()) : the_post();
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
                $post = get_post($post->id);
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
            echo '</div>';
        endwhile;
    endif;
    wp_reset_query();
}

// theme html output menu's by name (str or array, default primary)
function smoothie_menu_html( $menu, $primary = false ){
    if( $menu != '' || is_array( $menu ) ){
        $chk = 0;
        if( is_array( $menu ) ){
            // multi menu
            foreach( $menu as $nm ){
                if( has_nav_menu( $nm ) ){
                    echo '<div id="'.$nm.'menubox"><div id="'.$nm.'menu" class=""><nav><div class="innerpadding">';
                    wp_nav_menu( array( 'theme_location' => $nm ) );
                    echo '<div class="clr"></div></div></nav></div></div>';
                    $chk++;
                }
            }
        }else if( has_nav_menu( $menu ) ){
            // single menu
            echo '<div id="'.$menu.'menubox"><div id="'.$menu.'menu" class=""><nav><div class="innerpadding">';
            wp_nav_menu( array( 'theme_location' => $menu , 'menu_class' => 'nav-menu' ) );
            echo '<div class="clr"></div></div></nav></div></div>';
            $chk++;
        }
        if( $chk == 0 && $primary ){
            // default pages menu
            if( is_customize_preview() ){
            echo '<div id="area-default-menu" class="customizer-placeholder">Default menu</div>';
            }
            wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); // wp_page_menu();
        }
    }
}
