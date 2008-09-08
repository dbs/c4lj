<?php
function c4lj_current_issue() {
  $issue_parent = get_category_by_slug('issues');
  var_dump($issue_parent);
  $categories = get_categories( "child_of=$issue_parent->cat_ID&orderby=ID&order=desc&hierarchical=0" );
  var_dump($categories);
  
  $published = get_option( 'im_published_categories' );
  
  foreach ( $categories as $cat ) {
    if ( in_array( $cat_ID, $published ) ) {
      return '<a href="'.get_category_link($cat->cat_ID).'">'.$cat->cat_name.', '.$cat->category_description.'</a>';
    }
  }
}

function c4lj_recent_issues() {
  $issue_parent = get_category_by_slug('issues');
  $categories = get_categories( "child_of=$issue_parent->cat_ID&orderby=ID&order=desc&hierarchical=0" );
  
  $published = get_option( 'im_published_categories' );
  
  $count = 0;
  $out = '';
  foreach ( $categories as $cat ) {
    if ( $count < 5 ) {
      if ( in_array( $cat_ID, $published ) ) {
        if ( $count > 0 ) {
          $out .= '<li><a href="'.get_category_link($cat->cat_ID).'">'.$cat->cat_name.', '.$cat->category_description.'</a></li>';
        }
        $count++;
      }
    }
  }
  return $out;
}