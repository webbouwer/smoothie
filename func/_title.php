<?php

function smoothie_body_title(){

    global $post;
    // page id (or reference id)
    $pid = $post->ID;
    if( is_home() ){
    $pid = get_option( 'page_for_posts' );
    }
    $page_title = get_the_title( $pid );

    echo '<div class="page-title"><h3>'.$page_title.'</h3></div>';

}
