<?php
/*
Plugin Name: C4LJ Permissions
Plugin URI: http://journal.code4lib.org/
Description: Lets authors see pending posts
Version: 1.1
Author: Jonathan Brinley
Author URI: http://xplus3.net/
*/

/* Capabilities list in WP 2.3.3
    switch_themes
    edit_themes
    activate_plugins
    edit_plugins
    edit_users
    edit_files
    manage_options
    moderate_comments
    manage_categories
    manage_links
    upload_files
    import
    unfiltered_html
    edit_posts
    edit_others_posts
    edit_published_posts
    publish_posts
    edit_pages
    read
    level_10
    level_9
    level_8
    level_7
    level_6
    level_5
    level_4
    level_3
    level_2
    level_1
    level_0
    edit_others_pages
    edit_published_pages
    publish_pages
    delete_pages
    delete_others_pages
    delete_published_pages
    delete_posts
    delete_others_posts
    delete_published_posts
    delete_private_posts
    edit_private_posts
    read_private_posts
    delete_private_pages
    edit_private_pages
    read_private_pages
    delete_users
    create_users
    unfiltered_upload
    manage_roles
    administrator
*/
?>
<?php
if ( !class_exists("DoNotPublish") ) {
	class c4ljPermissions {
		function c4ljPermissions() { //constructor
			
		}
		
		function show_author_preview($capabilities, $caps, $args) {
			// $capabilities = list of users capabilities
			// $caps = array($args[0]) = array(capability in question)
			//prevents publishing unless user is administrator
			//TODO: make an options screen for this, to pick users
			if ( $args[1] == 17 && !is_admin() ) {
				$capabilities["edit_others_posts"] = true;
			}
			return $capabilities;
		}
		
	}
} //End Class DoNotPublish

if ( class_exists("c4ljPermissions") ) {
	$c4ljp = new c4ljPermissions();
}

if ( isset($c4ljp) ) {
	//Actions
	//Filters
	add_filter('user_has_cap', array(&$c4ljp, 'show_author_preview'), 2, 3);
}
?>