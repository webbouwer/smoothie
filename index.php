<?php
/** Theme main index file */
require_once('functions.php');

// the current page/post data
global $post;

// determine header image
$header_image = get_header_image();
$header_height = 100;
if( !is_front_page() ){
$header_height = 40;
}

$default_image = 'https://avatars3.githubusercontent.com/u/36711733?s=400&u=222c42bbcb09f7639b152cabbe1091b640e78ff2&v=4';
if( ( !empty($header_image) && $header_image != 'remove-header') || has_post_thumbnail( $post->ID ) ){
    if( has_post_thumbnail( $post->ID ) && !is_front_page() && ( is_page() || is_single() ) ){
            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
            $header_image = esc_attr( $thumbnail_src[0] );
    }
    $headerstyle = ' style="background-image:url('. esc_url( $header_image ) .');background-size:cover;background-position:center;min-height:'.$header_height.'%;"';
}
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

    echo '<meta property="og:image" content="' . $header_image . '"/>';

    // include wp head
    wp_head();

    // https://css-tricks.com/perfect-full-page-background-image/
    $bgposition = get_theme_mod('background_position', 'bottom center');
    $bgattacht = get_theme_mod('background_attachment', 'fixed');
    $bgrepeat = get_theme_mod('background_repeat', 'no-repeat');
    $bgsize = get_theme_mod('background_size', 'cover');
    $bodybgstyle = ' style="background-image:url('.esc_url( get_background_image() ).');background-position:'.$bgposition.';background-attachment:'.$bgattacht.';background-size:'.$bgsize.';background-repeat:'.$bgrepeat.';"';
    ?>
    <!-- https://cdnjs.com/libraries/Swiper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.5/js/swiper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.5/css/swiper.min.css" />
    <script>


    </script>
    <?php




echo '</head>';
echo '<body '.$bodybgstyle.' '; body_class( 'swiper-container, swiper-container-v' ); echo '>';
?>

<div id="pagecontainer" class="swiper-wrapper">



    <div id="headercontainer" class="swiper-slide" data-hash="page-home"<?php echo $headerstyle; ?>>
        <div class="contentholder" data-swiper-parallax="-800">
            <div id="headerintrobox">
                <?php smoothie_theme_widgetarea_html( 'widgets-intro', $type = false ); ?>
            </div>
            <div id="headersubbox">
                <?php smoothie_theme_widgetarea_html( 'widgets-intro-sub', $type = false ); ?>
            </div>
            <div id="headerbottombox">
                <?php smoothie_theme_widgetarea_html( 'widgets-intro-bottom', $type = false ); ?>
            </div>
        </div>
    </div>

    <div id="maincontainer" class="swiper-slide" data-hash="slide-<?php echo $post->post_name; ?>">
        <div class="contentholder" data-swiper-parallax="-20">
            <div id="beforecontent">
            </div>
            <?php
                smoothie_loop_html();
            ?>
            <div id="aftercontent">
            </div>
        </div>
    </div>

    <?php
        smoothie_childpages_html();
    ?>

    <div id="footercontainer" class="swiper-slide" data-hash="page-end">
        <div class="contentholder" data-swiper-parallax="-800">
            Footer
        </div>
    </div>

</div>

<div id="topnavigation">

    <div id="upperbar">
                <?php
                smoothie_menu_html( 'top', false );
                ?>
            </div>

            <div id="topbar">
                <?php
                smoothie_toplogo_html();
                  smoothie_childpages_menuitems();
                //smoothie_page_menu();
                ?>

            </div>
    <div class="clr"></div>
</div>

<div id="sidebar">
    <?php
        smoothie_menu_html( 'side', true );
    ?>
</div>
<div class="swiper-pagination swiper-pagination-v"></div>


<?php
/**/
wp_footer();
?>

<script>

jQuery(function($) {

    $(document).ready(function($) {

    var sliderIndex = 0;
    var swiper_page_vertical = new Swiper('.swiper-container-v', {
      direction: 'vertical',
      slidesPerView: 'auto',//slidesPerView: 1,
      spaceBetween: 0,
      hashNavigation: {
        replaceState: true,
        watchState: true,
      },
      mousewheel: true,
      speed: 600,
      parallax: true,
      loop: true,
      pagination: {
        el: '.swiper-pagination-v',
        clickable: true,
      },
      on: {
        init: function () {
        },
      }
    });
    /* before and after swipe/scroll vertical */
    swiper_page_vertical.on('slideChangeTransitionStart', function () {
        var sindex = $('.swiper-slide-active').data("swiper-slide-index");
        var mindex = sindex + 1;
        //console.log('Moving to slide '+sindex);
        $('#pagemenu ul li').removeClass('active');
        $('#pagemenu ul li:nth-child('+mindex+')').addClass('active');

        $('.contentholder').css({ 'padding-top': '25px' });
        $('.swiper-slide-active .contentholder').css({ 'padding-top': $('#topnavigation').height() +1 });
    });

    swiper_page_vertical.on('slideChangeTransitionEnd', function () {
        var sindex = $('.swiper-slide-active').data("swiper-slide-index");
        console.log('Moved to slide '+sindex);
    });


    console.log('Starting at slide '+ swiper_page_vertical.activeIndex);

    });




    $('.contentholder').css({ 'padding-top': '25px' });
    $('swiper-slide-duplicate-active .contentholder,.swiper-slide-active .contentholder').css({ 'padding-top': $('#topnavigation').height() });



});

</script>
    <?php
echo '</body></html>';
?>
