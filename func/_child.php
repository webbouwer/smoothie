<?php
/* smoothie childpages */
function smoothie_childpages_html(){
    if (have_posts()) :
        while (have_posts()) : the_post();
            if( is_page() ){
                $page_ID = get_the_ID();
                //$values = get_post_custom( $page_ID );
                //$post_obj = $wp_query->get_queried_object();
                //$childparentcontent = get_post_meta($page_ID, "meta-box-display-parentcontent", true);
                $childpagedisplay = get_post_meta($page_ID, "meta-box-display-childpages", true);
                if( isset($childpagedisplay) && $childpagedisplay != 'none'){
                    $args = array(
                    'post_parent' => $page_ID,
                    'post_type'   => 'page',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'order' => 'ASC'
                    );
                    $childpages = get_children( $args );
                    if( $childpages ){
                        $content = '';
                        foreach($childpages as $c => $page){
                            //print_r($page);
                            $contentimagedata = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ),'full', false );
                            $contentimage = $contentimagedata[0];
                            $pieces = get_extended($page->post_content); //print_r($pieces);
                            $content .= '<div id="'.$page->post_name.'" class="childpage-container swiper-slide" data-hash="slide-'.$page->post_name.'"><div class="contentholder" data-swiper-parallax="-800">';
                            $content .= '<div class="subtitle"><h3><a href="'.get_permalink($page->ID).'" title="'.$page->post_title.'" target="_self">'.$page->post_title.'</a></h3></div>';
                            $content .= apply_filters('the_content',  $pieces['main'] );
                            $content .= '<div class="clr"></div></div></div>';
                        }
                        echo $content;
                    }
                }
            }
        endwhile;
    endif;
    wp_reset_query();
} // end childpage content
