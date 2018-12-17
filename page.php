<?php
/** Theme main index file */
require_once('functions.php');

// the current page/post data
global $post;
// page id (or reference id)
$pid = $post->ID;
if( is_home() ){
    $pid = get_option( 'page_for_posts' );
}
$page_title = get_the_title( $pid );

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
      <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.5/css/swiper.min.css" /> -->
      <script>


      </script>
      <?php

echo '</head>';
echo '<body '.$bodybgstyle.' '; body_class(); echo '>';
?>
  <?php get_template_part('navigation'); ?>

      <!-- content -->
      <div id="bodycontainer" class="swiper-container swiper-container-v">
          <div id="pagecontainer" class="swiper-wrapper">

        <?php if( is_front_page() ){ ?>
          <!-- header content -->
          <div id="headercontainer" class="swiper-slide" data-hash="page-home" <?php echo $headerstyle; ?>>

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
          <?php } ?>



          <!-- page/post content -->
          <div id="maincontainer" class="swiper-slide" data-hash="slide-<?php echo $post->post_name; ?>">

              <?php if( !is_front_page() ){ ?>
          <div id="headercontainer"<?php echo $headerstyle; ?>>
                <div class="contentholder" data-swiper-parallax="-800">
                  <div id="headertitlebox">
                   <h1><?php  echo $page_title; ?></h1>
                  </div>
                </div>
          </div>

          <?php } ?>

            <div class="contentholder" data-swiper-parallax="-10">
              <div id="beforecontent">
              </div>
                <?php smoothie_loop_html(); ?>
                <div id="aftercontent">
                </div>
            </div>
          </div>

        <!-- child content -->
        <?php smoothie_childpages_html(); ?>

        <!-- footer content -->
        <div id="footercontainer" class="swiper-slide" data-hash="page-end">
            <div class="contentholder" data-swiper-parallax="-800">
                Footer
            </div>
        </div>

    </div>
</div>
<script>
jQuery(document).ready(function(){


        var menu = <?php echo smoothie_childpages_menuitems(); ?>;

        var swiperV = new Swiper('.swiper-container-v', {
          direction: 'vertical',
          slidesPerView: 1, // slidesPerView: 'auto', //
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
              el: '.swipe-menu',
                    clickable: true,
                renderBullet: function (index, className) {
                  return '<span class="' + className + '">' + (menu[index]) + '</span>';
                },
            },
            /*pagination: {
            el: '.swiper-pagination-v',
            clickable: true,
          },*/
        });

	});
</script>
<?php
/**/
wp_footer();
echo '</body></html>';
?>
