<?php
/** Theme main index file */
require_once('functions.php');


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
  Test


<?php
/**/
wp_footer();
echo '</body></html>';
?>
