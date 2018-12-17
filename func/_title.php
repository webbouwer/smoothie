<?php

function smoothie_body_title(){
    $page_title = get_the_title( $pid );
    echo '<div class="page-title"><h3>'.$page_title.'</h3></div>';
}
