<?php
/*
Plugin Name: Issue Manager
Plugin URI: http://code.google.com/p/c4lj/
Description: Allows an editor to publish an "issue", which is to say, all pending posts with a given category. Until a category is published, all posts with that category will remain in the pending state.
Version: 1.1
Author: Jonathan Brinley
Author URI: http://xplus3.net/
*/
  
function issue_manager_manage_page(  ) {
  if ( function_exists('add_management_page') ) {
    $page = add_management_page( 'Manage Issues', 'Issues', 'publish_posts', 'manage-issues', 'issue_manager_admin' );
    add_action("admin_print_scripts-$page", 'issue_manager_script_prereqs');
    add_action("admin_head-$page", 'issue_manager_scripts');
  }
}
function issue_manager_admin(  ) {
  $published = get_option( 'im_published_categories' );
  $unpublished = get_option( 'im_unpublished_categories' );
  $categories = get_categories( 'orderby=name&hierarchical=0&hide_empty=0' );
  
  // Make sure the options exist
  if ( $published === FALSE ) { $published = array(); update_option( 'im_published_categories', $published ); }
  if ( $unpublished === FALSE ) { $unpublished = array(); update_option( 'im_unpublished_categories', $unpublished ); }
  
  // See if we have GET parameters
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
        // stop tracking the cat_ID
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
  // take the category out of the unpublished list
  $key = array_search( $cat_ID, $unpublished );
  if ( FALSE !== $key ) {
    array_splice( $unpublished, $key, 1 );
    update_option( 'im_unpublished_categories', $unpublished );
  }
  if ( !in_array( $cat_ID, $published ) ) {
    // add to the published list
    $published[] = $cat_ID;
    sort($published);
    update_option( 'im_published_categories', $published );
    
    // get all pending posts in the category
    $posts = get_posts( "numberposts=-1&post_status=pending&category=$cat_ID" );
    $counter = 0;
    foreach ( $posts as $post ) {
      // set the date to about now, keeping a minute gap so posts stay in order
      wp_update_post( array(
        'ID' => $post->ID,
        'post_date' => date( 'Y-m-d H:i:s', strtotime(current_time('mysql'))-($counter*60) )
      ) );
      // let WP work its magic to publish the post
      wp_publish_post($post->ID);
      $counter++;
    }
  }
}

function issue_manager_unpublish( $cat_ID, &$published, &$unpublished ) {
  // take the category out of the published list
  $key = array_search( $cat_ID, $published );
  if ( FALSE !== $key ) {
    array_splice( $published, $key, 1 );
    update_option( 'im_published_categories', $published );
  }
  if ( !in_array( $cat_ID, $unpublished ) ) {
    // add to the unpublished list
    $unpublished[] = $cat_ID;
    sort( $unpublished );
    update_option( 'im_unpublished_categories', $unpublished );
    
    // change all published posts in the category to pending
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
  // check if post is in an unpublished category
  foreach ( get_the_category($post_ID) as $cat ) {
    if ( in_array( $cat->cat_ID, $unpublished ) ) {
      $publishable = FALSE;
      break;
    }
  }
  // if post is in an unpublished category, change its status to 'pending' instead of 'publish'
  if ( !$publishable ) {
    wp_update_post( array(
      'ID' => $post_ID,
      'post_status' => 'pending'
    ) );
  }
}

function issue_manager_activation(  ) {
  // if option records don't already exist, create them
  if ( !get_option( 'im_published_categories' ) ) {
    add_option( 'im_published_categories', array() );
  }
  if ( !get_option( 'im_unpublished_categories' ) ) {
    add_option( 'im_unpublished_categories', array() );
  }
}
function issue_manager_deactivation(  ) {
  // they don't have to exist to be deleted
  delete_option( 'im_published_categories' );
  delete_option( 'im_unpublished_categories' );
}
function issue_manager_script_prereqs(  ) {
  wp_enqueue_script( 'jquery' );
}
function issue_manager_scripts(  ) {
  echo '<script type="text/javascript">';
  include_once('im_sort_articles.js.php');
  echo '</script>';
  wp_enqueue_script( 'thickbox' );
}

function issue_manager_article_list() {
  $cat_ID = isset($_POST['cat_ID'])?$_POST['cat_ID']:null;
  include_once('im_article_list.php');
  die();
}

add_action('admin_menu', 'issue_manager_manage_page');
add_action('publish_post', 'issue_manager_publish_intercept');

add_action('wp_ajax_issue_manager_article_list', 'issue_manager_article_list');


// Register hooks for activation/deactivation.
register_activation_hook( __FILE__, 'issue_manager_activation' );
register_deactivation_hook( __FILE__, 'issue_manager_deactivation' );