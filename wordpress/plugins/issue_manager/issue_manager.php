<?php
/*
Plugin Name: Issue Manager
Plugin URI: http://wordpress.org/#
Description: Allows an editor to publish an "issue", which is to say, all posts with a given category. Until a category is published, all posts with that category will remain in the draft state. The editor can determine what time to publish an issue, and in what order the posts should appear.
Version: 0.1
Author: Jonathan Brinley
Author URI: http://xplus3.net/
*/

function issue_manager_admin() {
  
}

add_management_page('Manage Issues', 'Issues', 'publish_posts', __FILE__, 'issue_manager_admin');