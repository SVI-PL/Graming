<?php
/*
  Plugin Name: Star Rating Field For Contact Form 7
  Description: This plugin allows create star rating For Contact Form 7  plugin.
  Version: 1.0
  Copyright: 2023
  Text Domain: star-rating-for-contact-form-7
*/


if (!defined('ABSPATH')) {
    die('-1');
}


// define for base name
define('SRFFCF7_BASE_NAME', plugin_basename(__FILE__));


// define for plugin file
define('srffcf7_plugin_file', __FILE__);


// define for plugin dir path
define('SRFFCF7_PLUGIN_DIR',plugins_url('', __FILE__));



// Include function files
include_once('inc/filter.php');
include_once('inc/form-tag.php');
include_once('inc/mail-tags.php');
include_once('inc/tag.php');


function SRFFCF7_load_script_style(){
    wp_enqueue_script( 'jquery-raty', SRFFCF7_PLUGIN_DIR . '/asset/jquery.rating/jquery.raty.js', array('jquery'), '2.0');
    wp_enqueue_script( 'jquery-rating', SRFFCF7_PLUGIN_DIR. '/asset/js/custom.raty.js', array('jquery'), '1.0');
    
    wp_localize_script( 'jquery-rating', 'student_ajax', array( 'ajax_urla' => SRFFCF7_PLUGIN_DIR) );

    wp_enqueue_style( 'jquery-rating-style', SRFFCF7_PLUGIN_DIR. '/asset/jquery.rating/jquery.raty.css', '', '3.0' );

}
add_action( 'wp_enqueue_scripts', 'SRFFCF7_load_script_style' );



