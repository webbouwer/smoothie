<?php
// theme html output menu's by name (str or array, default primary)
function smoothie_menu_html( $menu, $primary = false ){
    if( $menu != '' || is_array( $menu ) ){
        $chk = 0;
        if( is_array( $menu ) ){
            // multi menu
            foreach( $menu as $nm ){
                if( has_nav_menu( $nm ) ){
                    echo '<div id="'.$nm.'menubox"><nav><div class="innerpadding">';
                    wp_nav_menu( array( 'theme_location' => $nm, 'menu_class' => 'nav-menu') );
                    echo '<div class="clr"></div></div></nav></div>';
                    $chk++;
                }
            }
        }else if( has_nav_menu( $menu ) ){
            // single menu
            echo '<div id="'.$menu.'menubox"><nav><div class="innerpadding">';
            wp_nav_menu( array( 'theme_location' => $menu , 'menu_class' => 'nav-menu' ) );
            echo '<div class="clr"></div></div></nav></div>';
            $chk++;
        }
        if( $chk == 0 && $primary ){
            // default pages menu
            if( is_customize_preview() ){
            echo '<div id="area-default-menu" class="customizer-placeholder">Default menu</div>';
            }
            echo '<div id="'.$menu.'menubox" class="default-menu"><nav><div class="innerpadding">';
            wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); // wp_page_menu();
            echo '<div class="clr"></div></div></nav></div>';
        }
    }
}
