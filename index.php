<?php

require_once('functions.php');

/* html head */
get_template_part( 'html/head');

/* html body open tag */
get_template_part( 'html/body' );

/* static html elements */


/* header */

// _menu.php
smoothie_menu_html( 'top', true );
// _menu.php
smoothie_menu_html( 'main', false );
// _title.php
smoothie_body_title();


/* content */

// _menu.php
smoothie_menu_html( 'side', false );
// _body.php
smoothie_body_loop();
// _child.php
smoothie_childpages_html();



/* footer */

// _menu.php
smoothie_menu_html( 'bottom', false );


/* html body footer body/html close tag */
get_template_part( 'html/footer');

?>
