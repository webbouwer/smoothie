<?php
/**
 * Template Name: Blank Page
 * Theme main index file
 */
require_once('functions.php');

/* html head body/html start tag */
get_template_part( 'assets/head');
?>

<div id="pagecontainer">

<?php

/* header */
get_template_part('html/header');

/* content */
get_template_part('html/sidebar');

// _loop.php
smoothie_postloop_html();

// _child.php
smoothie_childpages_html();

get_template_part('html/footer');

?>

</div>


<?php
/* html body footer body/html close tag */
get_template_part( 'assets/footer');

?>
