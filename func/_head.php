<?php
// page title

function smoothie_body_title(){

    echo '<div class="page-title"><h3>'.smoothie_get_page_title().'</h3></div>';

}

function smoothie_get_page_title(){

    global $post;
    // page id (or reference id)
    $pid = $post->ID;
    if( is_home() ){
    $pid = get_option( 'page_for_posts' );
    }
    $page_title = get_the_title( $pid );
    return $page_title;

}

?>
