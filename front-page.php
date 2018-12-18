<?php

require_once('functions.php');

get_template_part( 'html/head');

echo '<body '.smoothie_body_bgstyle().' '; body_class(); echo '>';


smoothie_menu_html( 'top', false );

smoothie_menu_html( 'side', false );


smoothie_menu_html( 'main', true );

smoothie_body_title();

smoothie_body_loop();

smoothie_childpages_html();

smoothie_menu_html( 'bottom', false );




get_template_part( 'html/footer');

?>
