<?php
echo '<body '.smoothie_body_bgstyle().' '; body_class(); echo '>';


smoothie_menu_html( 'top', false );

smoothie_menu_html( 'side', true );


smoothie_menu_html( 'main', false );

smoothie_body_title();

smoothie_body_loop();

smoothie_childpages_html();


smoothie_menu_html( 'bottom', false );