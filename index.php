<?php
/**
 * Theme main index file
 */
require_once('functions.php');

// the current page/post data
global $post;

// determine header image
$header_image = get_header_image();

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php
    if ( ! isset( $content_width ) ) $content_width = 360; // mobile first
    echo
    //'<link rel="canonical" href="'.home_url(add_query_arg(array(),$wp->request)).'">'
	'<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />'
	.'<link rel="shortcut icon" href="images/favicon.ico" />'
	// tell devices wich screen size to use by default
	.'<meta name="viewport" content="initial-scale=1.0, width=device-width" />'
	.'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
    // more info for og api's
    echo '<meta property="og:title" content="' . get_the_title() . '"/>'
        .'<meta property="og:type" content="website"/>'
		.'<meta property="og:url" content="' . get_permalink() . '"/>'
		.'<meta property="og:site_name" content="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'"/>'
		.'<meta property="og:description" content="'.get_bloginfo( 'description' ).'"/>';
    $default_image = 'https://avatars3.githubusercontent.com/u/36711733?s=400&u=222c42bbcb09f7639b152cabbe1091b640e78ff2&v=4';
    if( !has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
        if( !empty($header_image) ){
            $default_image = get_header_image();
        }else{
            $default_image = get_theme_mod( 'smoothie_theme_identity_logo', $default_image );
        }
    }else{
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
        $default_image = esc_attr( $thumbnail_src[0] );
    }
    echo '<meta property="og:image" content="' . $default_image . '"/>';

    // include wp head
    wp_head();

    // https://css-tricks.com/perfect-full-page-background-image/
    $bgposition = get_theme_mod('background_position', 'bottom center');
    $bgattacht = get_theme_mod('background_attachment', 'fixed');
    $bgrepeat = get_theme_mod('background_repeat', 'no-repeat');
    $bgsize = get_theme_mod('background_size', 'cover');
    $bodybgstyle = ' style="background-image:url('.esc_url( get_background_image() ).');background-position:'.$bgposition.';background-attachment:'.$bgattacht.';background-size:'.$bgsize.';background-repeat:'.$bgrepeat.';"';
    $headerstyle = ' style="background-image:url('.esc_url( $header_image ) .');background-size:cover;background-position:center;"';

echo '</head>';
echo '<body '.$bodybgstyle.' '; body_class(); echo '>';
?>
    <div id="pagecontainer" class="site">


        <div id="topcontent"<?php echo $headerstyle; ?>>

            <div class="outerspace">
            <?php
            smoothie_theme_toplogo_html();
            smoothie_theme_menu_html( 'top' , true  );
            smoothie_theme_widgetarea_html( 'widgets-top-sidebar' );
            ?>
            </div>
        </div>
        <div id="maincontent">
            <div class="outerspace">

                <?php
                if( is_customize_preview() ){
                    echo '<div id="area-main-menu" class="customizer-placeholder">Main menu</div>';
                }
                smoothie_theme_menu_html( array( 'main' ) );
                ?>

                <div id="maincontentbar">
                    <?php
                    if( is_customize_preview() ){
                        echo '<div id="area-page-main-content" class="customizer-placeholder">Page main content</div>';
                    }
                    smoothie_theme_loop_html();
                    ?>
                </div>
                <div id="mainsidebar">
                    <?php
                    if( is_customize_preview() ){
                        echo '<div id="area-side-menu" class="customizer-placeholder">Side menu</div>';
                    }
                    smoothie_theme_menu_html( 'side' );

                    smoothie_theme_widgetarea_html( 'sidebar' );

                    ?>
                </div>
                <div class="clr"></div>

            </div>
        </div>
        <div id="bottomcontent">
            <div class="outerspace">
            <?php
            if( is_customize_preview() ){
                echo '<div id="area-bottom-menu" class="customizer-placeholder">Bottom menu</div>';
            }
            smoothie_theme_menu_html( 'bottom' );

            smoothie_theme_widgetarea_html( 'widgets-bottom-sidebar' );
            ?>
            </div>
        </div>
    </div>
<?php
    wp_footer();
    echo '</body></html>';
?>


