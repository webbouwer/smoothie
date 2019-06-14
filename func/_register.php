<?php

// register options
function smoothie_theme_support() {
    // https://developer.wordpress.org/reference/functions/add_theme_support/
	add_theme_support( 'custom-background' ); // https://codex.wordpress.org/Custom_Headers#Adding_Theme_Support
    add_theme_support( 'custom-header' ); // https://codex.wordpress.org/Custom_Headers#Adding_Theme_Support
    add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'smoothie_theme_support' );
// register menu's
function smoothie_register_menus() {
	register_nav_menus(
		array(
		'top' => __( 'Top menu' , 'smoothie' ),
		'main' => __( 'Main menu' , 'smoothie' ),
		'side' => __( 'Side menu' , 'smoothie' ),
		'bottom' => __( 'Bottom menu' , 'smoothie' )
		)
	);
}
add_action( 'init', 'smoothie_register_menus' );
// register style sheet
function smoothie_theme_stylesheet(){
    $stylesheet = get_template_directory_uri().'/style.css';
    echo '<link rel="stylesheet" id="wp-theme-main-style"  href="'.$stylesheet.'" type="text/css" media="all" />';
}
add_action( 'wp_head', 'smoothie_theme_stylesheet', 9999 );
// register style sheet function for editor
function smoothie_editor_styles() {
    add_editor_style( 'style.css' );
}
add_action( 'admin_init', 'smoothie_editor_styles' );
