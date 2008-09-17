<?php
/*
Plugin Name: Issue Manager
Plugin URI: http://code.google.com/p/c4lj/
Description: Allows an editor to publish an "issue", which is to say, all pending posts with a given category. Until a category is published, all posts with that category will remain in the pending state. The editor can determine what time to publish an issue, and in what order the posts should appear.
Version: 1.0
Author: Jonathan Brinley
Author URI: http://xplus3.net/
*/

function issue_manager_debug( $debug ) {
  echo '<div class="debug">';
  echo '<pre style="background-color: #CCCCCC;">';
  var_dump($debug);
  echo '</pre>';
  echo '</div>';
}
  
function issue_manager_manage_page(  ) {
  if ( function_exists('add_management_page') ) {
    add_management_page( 'Manage Issues', 'Issues', 'publish_posts', 'manage-issues', 'issue_manager_admin' );
  }
}
function issue_manager_admin(  ) {
  $published = get_option( 'im_published_categories' );
  $unpublished = get_option( 'im_unpublished_categories' );
  $categories = get_categories( 'orderby=name&hierarchical=0&hide_empty=0' );
  
  if ( $published === FALSE ) { $published = array(); update_option( 'im_published_categories', $published ); }
  if ( $unpublished === FALSE ) { $unpublished = array(); update_option( 'im_unpublished_categories', $unpublished ); }
  
  $cat_ID = isset($_GET['cat_ID'])?$_GET['cat_ID']:null;
  $action = isset($_GET['action'])?$_GET['action']:null;
    
  if ( $cat_ID ) {
    $cat_ID = (int)$cat_ID;
    switch($action) {
      case "publish":
        issue_manager_publish($cat_ID, $published, $unpublished);
        break;
      case "unpublish":
        issue_manager_unpublish($cat_ID, $published, $unpublished);
        break;
      case "ignore":
        $key = array_search($cat_ID, $published);
        if ( FALSE !== $key ) {
          array_splice($published, $key, 1);
          update_option( 'im_published_categories', $published );
        }
        $key = array_search($cat_ID, $unpublished);
        if ( FALSE !== $key ) {
          array_splice($unpublished, $key, 1);
          update_option( 'im_unpublished_categories', $unpublished );
        }
        break;
      default:
        break;
    }
  }
  include_once('im_admin_main.php');
}

function issue_manager_publish( $cat_ID, &$published, &$unpublished ) {
  $key = array_search( $cat_ID, $unpublished );
  if ( FALSE !== $key ) {
    array_splice( $unpublished, $key, 1 );
    update_option( 'im_unpublished_categories', $unpublished );
  }
  if ( !in_array( $cat_ID, $published ) ) {
    $published[] = $cat_ID;
    sort($published);
    update_option( 'im_published_categories', $published );
    
    $posts = get_posts( "numberposts=-1&post_status=pending&category=$cat_ID" );
    $counter = 0;
    foreach ( $posts as $post ) {
      wp_update_post( array(
        'ID' => $post->ID,
        'post_date' => date( 'Y-m-d H:i:s', strtotime(current_time('mysql'))-($counter*60) )
      ) );
      wp_publish_post($post->ID);
      $counter++;
    }
  }
}

function issue_manager_unpublish( $cat_ID, &$published, &$unpublished ) {
  $key = array_search( $cat_ID, $published );
  if ( FALSE !== $key ) {
    array_splice( $published, $key, 1 );
    update_option( 'im_published_categories', $published );
  }
  if ( !in_array( $cat_ID, $unpublished ) ) {
    $unpublished[] = $cat_ID;
    sort( $unpublished );
    update_option( 'im_unpublished_categories', $unpublished );
    
    $posts = get_posts( "numberposts=-1&post_status=publish&category=$cat_ID" );
    foreach ( $posts as $post ) {
      wp_update_post( array(
        'ID' => $post->ID,
        'post_status' => 'pending'
      ) );
    }
  }
}

function issue_manager_publish_intercept( $post_ID ) {
  $unpublished = get_option( 'im_unpublished_categories' );
  $publishable = TRUE;
  foreach ( get_the_category($post_ID) as $cat ) {
    if ( in_array( $cat->cat_ID, $unpublished ) ) {
      $publishable = FALSE;
      break;
    }
  }
  
  if ( !$publishable ) {
    wp_update_post( array(
      'ID' => $post_ID,
      'post_status' => 'pending'
    ) );
  }
  
}

add_action('admin_menu', 'issue_manager_manage_page');
add_action('publish_post', 'issue_manager_publish_intercept');