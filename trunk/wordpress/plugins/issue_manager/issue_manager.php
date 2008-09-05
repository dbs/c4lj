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
function issue_manager_manage_page(  ) {
  if ( function_exists('add_management_page') ) {
    add_management_page( 'Manage Issues', 'Issues', 'publish_posts', 'manage-issues', 'issue_manager_admin' );
  }
}
function issue_manager_admin(  ) {
  $published = (array) get_option( 'im_published_categories' );
  $unpublished = (array) get_option( 'im_unpublished_categories' );
  $categories = (array) get_categories( 'orderby=name&hierarchical=0' );
  
  echo '<p style="color: red;">'.$_GET['cat_ID'].'</p>';
  wp_reset_vars(array('action', 'cat_ID'));
  echo '<p style="color: red;">'.$cat_ID.'</p>';
  if ( $cat_ID ) {
    $cat_ID = (int)$cat_ID;
    switch($action) {
      case "publish":
        if ( !in_array($cat_ID, $published) ) {
          include_once('im_admin_publish.php');
        } else {
          include_once('im_admin_main.php');
        }
        break;
      case "unpublish":
        issue_manager_unpublish($cat_ID);
        include_once('im_admin_main.php');
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
        include_once('im_admin_main.php');
        break;
      default:
        include_once('im_admin_main.php');
        break;
    }
  } else {
    include_once('im_admin_main.php');
  }
}

function issue_manager_unpublish($cat_ID) {
  $key = array_search($cat_ID, $published);
  if ( FALSE !== $key ) {
    array_splice($published, $key, 1);
    update_option( 'im_published_categories', $published );
  }
  if ( !in_array($cat_ID, $unpublished) ) {
    $unpublished[] = $cat_ID;
    sort($unpublished);
    update_option( 'im_unpublished_categories', $unpublished );
    
    $posts = get_posts("numberposts=-1&category=$cat_ID");
    foreach ( $posts as $post ) {
      if ( "publish" == $post->post_status || "future" == $post->post_status ) {
        wp_update_post( array(
          'ID' => $post->ID,
          'post_status' => 'draft'
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