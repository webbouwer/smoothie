<?php
function smoothie_global_active_id(){
    // the current page/post data
    global $post;
    // page id (or reference id)
    $pid = $post->ID;
    if( is_home() ){
    $pid = get_option( 'page_for_posts' );
    }
    global $pid;
}
add_action( 'init', 'smoothie_global_active_pid' );

function smoothie_page_type(){
    global $wp_query;
    $type = 'notfound';

    if ( $wp_query->is_page ) {
        $type = is_front_page() ? 'front' : 'page';
    } elseif ( $wp_query->is_home ) {
        $type = 'home';
    } elseif ( $wp_query->is_single ) {
        $type = ( $wp_query->is_attachment ) ? 'attachment' : 'single';
    } elseif ( $wp_query->is_category ) {
        $type = 'category';
    } elseif ( $wp_query->is_tag ) {
        $type = 'tag';
    } elseif ( $wp_query->is_tax ) {
        $type = 'tax';
    } elseif ( $wp_query->is_archive ) {
        if ( $wp_query->is_day ) {
            $type = 'day';
        } elseif ( $wp_query->is_month ) {
            $type = 'month';
        } elseif ( $wp_query->is_year ) {
            $type = 'year';
        } elseif ( $wp_query->is_author ) {
            $type = 'author';
        } else {
            $type = 'archive';
        }
    } elseif ( $wp_query->is_search ) {
        $type = 'search';
    } elseif ( $wp_query->is_404 ) {
        $type = 'notfound';
    }

    return $type;
}


// register global variables (data/options/customizer)
$wp_global_data = array();

// all post data global
function smoothie_theme_get_postdata(){
        $args = array(
            //'tag'               => json_encode($this->tagfilter),
            //'category_name'     => json_encode($this->catfilter),
            'post_type'         => 'post', // 'any',  = incl pages
            //'post__not_in'    => $this->loadedID,
            'post_status'       => 'publish',
            'orderby'           => 'date',
            'order'             => 'DESC',      // 'DESC', 'ASC' or 'RAND'
            'posts_per_page'  => -1,
            //'posts_offset'      => $ppload,
            //'suppress_filters'  => false,
        );
        $query = new WP_Query( $args );
        $response = array();
        $count = array();
        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
                // post text
                $excerpt_length = 120; // words
                $post = get_post($post->id);
                $fulltext = $post->post_content;//  str_replace( '<!--more-->', '',);
                $content = apply_filters('the_content', $fulltext );
                $excerpt = truncate( $content, $excerpt_length, '', false, true );  // get_the_excerpt()
                $response[] = array(
                    'id' => get_the_ID(),
                    'link' => get_the_permalink(),
                    'title' => get_the_title(),
                    'image' => get_the_post_thumbnail(),
                    'excerpt' => $excerpt,
                    'content' => $content,
                    'cats' => wp_get_post_terms( get_the_ID(), 'category', array("fields" => "slugs")),
                    'tags' => wp_get_post_terms( get_the_ID(), 'post_tag', array("fields" => "slugs")),
                    'date' => get_the_date(),
                    'timestamp' => strtotime(get_the_date()),
                    'author' => get_the_author(),
                    'custom_field_keys' => get_post_custom_keys()
                );
            endwhile;
        else:
           $response[0] = 'No posts found';
        endif;
        wp_reset_query();
        ob_clean();
        //wp_die();
        return $response;
}


// all post data global
function smoothie_theme_get_pagedata(){
        $args = array(
            //'tag'               => json_encode($this->tagfilter),
            //'category_name'     => json_encode($this->catfilter),
            'post_type'         => 'page', // 'any',  = incl pages
            //'post__not_in'      => $this->loadedID,
            'post_status'       => 'publish',
            'orderby'           => 'date',
            'order'             => 'DESC',      // 'DESC', 'ASC' or 'RAND'
            'posts_per_page'  => -1,
            //'posts_offset'      => $ppload,
            //'suppress_filters'  => false,
        );
        $query = new WP_Query( $args );
        $response = array();
        $count = array();
        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
                // post text
                $excerpt_length = 120; // words
                $post = get_post($post->id);
                $fulltext = $post->post_content;//  str_replace( '<!--more-->', '',);
                $content = apply_filters('the_content', $fulltext );
                $excerpt = truncate( $content, $excerpt_length, '', false, true );  // get_the_excerpt()
                $response[] = array(
                    'id' => get_the_ID(),
                    'link' => get_the_permalink(),
                    'title' => get_the_title(),
                    'image' => get_the_post_thumbnail(),
                    'excerpt' => $excerpt,
                    'content' => $content,
                    'cats' => wp_get_post_terms( get_the_ID(), 'category', array("fields" => "slugs")),
                    'tags' => wp_get_post_terms( get_the_ID(), 'post_tag', array("fields" => "slugs")),
                    'date' => get_the_date(),
                    'timestamp' => strtotime(get_the_date()),
                    'author' => get_the_author(),
                    'custom_field_keys' => get_post_custom_keys()
                );
            endwhile;
        else:
           $response[0] = 'No posts found';
        endif;
        wp_reset_query();
        ob_clean();
        //wp_die();
        return $response;
}




function smoothie_theme_get_customizer(){
    return json_encode( get_theme_mods() );
}
function smoothie_theme_get_all_posts(){
    return json_encode( smoothie_theme_get_postdata() );
}
function smoothie_theme_get_all_pages(){
    return json_encode( smoothie_theme_get_pagedata() );
}
function smoothie_theme_get_all_tags(){
    return json_encode( get_terms( 'post_tag' ) );
}
function smoothie_theme_get_all_categories(){
    return json_encode( get_categories( array("type"=>"post") ) );
}
// data for global js
$wp_global_data['customdata']   = smoothie_theme_get_customizer();
$wp_global_data['postdata']     = smoothie_theme_get_all_posts();
$wp_global_data['pagedata']     = smoothie_theme_get_all_pages();
$wp_global_data['tagdata']      = smoothie_theme_get_all_tags();
$wp_global_data['catdata']      = smoothie_theme_get_all_categories();
// register global customizer variables
function smoothie_theme_global_js() {
    // add jquery
    wp_enqueue_script("jquery"); // default wp jquery
    wp_register_script( 'custom_global_js', get_template_directory_uri().'/js/global.js', 99, '1.0', false); // register the script
    global $wp_global_data; // get global data var
	wp_localize_script( 'custom_global_js', 'site_data', $wp_global_data ); // localize the global data list for the script
    // localize the script with specific data.
    //$color_array = array( 'color1' => get_theme_mod('color1'), 'color2' => '#000099' );
    //wp_localize_script( 'custom_global_js', 'object_name', $color_array );
    // The script can be enqueued now or later.
    wp_enqueue_script( 'custom_global_js');
}
add_action('wp_enqueue_scripts', 'smoothie_theme_global_js');

/**
* Truncates text.
*
* Cuts a string to the length of $length and replaces the last characters
* with the ending if the text is longer than length.
*
* @param string  $text String to truncate.
* @param integer $length Length of returned string, including ellipsis.
* @param string  $ending Ending to be appended to the trimmed string.
* @param boolean $exact If false, $text will not be cut mid-word
* @param boolean $considerHtml If true, HTML tags would be handled correctly
* @return string Trimmed string.
*/
function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
    if ($considerHtml) {
        // if the plain text is shorter than the maximum length, return the whole text
        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        // splits all html-tags to scanable lines
        preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
            $total_length = strlen($ending);
            $open_tags = array();
            $truncate = '';
        foreach ($lines as $line_matchings) {
            // if there is any html-tag in this line, handle it and add it (uncounted) to the output
            if (!empty($line_matchings[1])) {
                // if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
                if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                    // do nothing
                // if tag is a closing tag (f.e. </b>)
                } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                    // delete tag from $open_tags list
                    $pos = array_search($tag_matchings[1], $open_tags);
                    if ($pos !== false) {
                        unset($open_tags[$pos]);
                    }
                // if tag is an opening tag (f.e. <b>)
                } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                    // add tag to the beginning of $open_tags list
                    array_unshift($open_tags, strtolower($tag_matchings[1]));
                }
                // add html-tag to $truncate'd text
                $truncate .= $line_matchings[1];
            }
            // calculate the length of the plain text part of the line; handle entities as one character
            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
            if ($total_length+$content_length> $length) {
                // the number of characters which are left
                $left = $length - $total_length;
                $entities_length = 0;
                // search for html entities
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                    // calculate the real length of all entities in the legal range
                    foreach ($entities[0] as $entity) {
                        if ($entity[1]+1-$entities_length <= $left) {
                            $left--;
                            $entities_length += strlen($entity[0]);
                        } else {
                            // no more characters left
                            break;
                        }
                    }
                }
                $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                // maximum lenght is reached, so get off the loop
                break;
            } else {
                $truncate .= $line_matchings[2];
                $total_length += $content_length;
            }
            // if the maximum length is reached, get off the loop
            if($total_length>= $length) {
                break;
            }
        }
    } else {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = substr($text, 0, $length - strlen($ending));
        }
    }
    // if the words shouldn't be cut in the middle...
    if (!$exact) {
        // ...search the last occurance of a space...
        $spacepos = strrpos($truncate, ' ');
        if (isset($spacepos)) {
            // ...and cut the text in this position
            $truncate = substr($truncate, 0, $spacepos);
        }
    }
    // add the defined ending to the text
    $truncate .= $ending;
    if($considerHtml) {
			$truncate .= '.. ';
        // close all unclosed html-tags
        foreach ($open_tags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }
    return $truncate;
}
