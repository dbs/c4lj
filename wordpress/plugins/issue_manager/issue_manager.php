<?php
/*
Plugin Name: Issue Manager
Plugin URI: http://wordpress.org/#
Description: Allows an editor to publish an "issue", which is to say, all posts with a given category. Until a category is published, all posts with that category will remain in the draft state. The editor can determine what time to publish an issue, and in what order the posts should appear.
Version: 0.1
Author: Jonathan Brinley
Author URI: http://xplus3.net/
*/

$issue_manager_db_version = "0.1";
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
  
  issue_manager_debug($published);
  issue_manager_debug($unpublished);
  issue_manager_debug($categories);
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
    
    $posts = get_posts();
    issue_manager_debug($posts);
    
    $posts = get_posts( "numberposts=-1&category=$cat_ID" );
    issue_manager_debug($posts);
    foreach ( $posts as $post ) {
      if ( "pending" == $post->post_status ) {
        $publish_now = TRUE;
        foreach ( get_the_category($post->ID) as $cat ) {
          if ( in_array( $cat->cat_ID, $unpublished ) ) {
            $publish_now = FALSE;
            break;
          }
        }
        if ( $publish_now ) {
          wp_update_post( array(
            'ID' => $post->ID,
            'post_status' => 'publish',
            'post_date' => date("Y-m-d H:i:s")
          ) );
        }
      }
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
    
    $posts = get_posts( "numberposts=-1&category=$cat_ID" );
    foreach ( $posts as $post ) {
      if ( "publish" == $post->post_status || "future" == $post->post_status ) {
        wp_update_post( array(
          'ID' => $post->ID,
          'post_status' => 'pending'
        ) );
      }
    }
  }
}

function issue_manager_install(  ) {
}

function issue_manager_uninstall(  ) {
  
}

add_action('admin_menu', 'issue_manager_manage_page');
//register_activation_hook(__FILE__, 'issue_manager_install');
//register_deactivation_hook(__FILE__, 'issue_manager_uninstall');