<?php
/*
Plugin Name: DOAJ Export
Version: 1.0
Description: Provides information about your posts formatted according to the DOAJ Article XML Schema
Plugin URI: http://code.google.com/p/c4lj/
Author: Jonathan Brinley
Author URI: http://xplus3.net/
Contributor: Eric Lease Morgan
Contributor URI: http://infomotions.com/
*/


function doaj_add_options_page(  ) {
  if ( function_exists('add_options_page') ) {
    add_options_page( 'Manage DOAJ Export', 'DOAJ Export', 'manage_options', __FILE__, 'doaj_options_page' );
  }
}
function doaj_options_page(  ) {
  include_once('doaj-options.php');
}

function doaj_export_activate(  ) {
  if ( isset( $_GET['doaj_export'] ) && $_GET['doaj_export'] == 1 ) {
    add_action( 'wp', 'doaj_export' );
  }
}

function doaj_export(  ) {
  if ( have_posts() ) {
    include_once('doaj-template.php');
  }
  die();
}


add_action('admin_menu', 'doaj_add_options_page');
add_action('init', 'doaj_export_activate');
?>
