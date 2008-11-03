<?php
/*
Plugin Name: DOAJ Export
Version: 1.0.3
Description: Provides information about your posts formatted according to the DOAJ Article XML Schema
Plugin URI: http://xplus3.net/
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

function doaj_add_feed(  ) {
  global $wp_rewrite;
  add_feed('doaj', 'doaj_export');
  add_action('generate_rewrite_rules', 'doaj_rewrite_rules');
  $wp_rewrite->flush_rules();
}

function doaj_rewrite_rules( $wp_rewrite ) {
  $new_rules = array(
    'feed/(.+)' => 'index.php?feed='.$wp_rewrite->preg_index(1)
  );
  $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}

function doaj_export(  ) {
  include_once('doaj-template.php');
}


add_action('admin_menu', 'doaj_add_options_page');
add_action('init', 'doaj_add_feed');
?>
