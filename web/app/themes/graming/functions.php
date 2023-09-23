<?php
/**
 * Graming functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Graming
 */

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

// Sets up theme defaults and registers support for various WordPress features.
function graming_setup() {
	add_theme_support( 'title-tag' );
//Add menu
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'graming' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
}
add_action( 'after_setup_theme', 'graming_setup' );


// Register widget area.
function graming_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'graming' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'graming' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'graming_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function graming_scripts() {
	wp_enqueue_style( 'graming-style', get_stylesheet_uri(), array(), _S_VERSION );
	
	wp_enqueue_script("jquery");
	wp_enqueue_script( 'graming-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
}add_action( 'wp_enqueue_scripts', 'graming_scripts' );