<?php
/*
Plugin Name: C4LJ Remove Parents
Plugin URI: http://wordpress.org/#
Description: Remove parent directories & "category" from category permalinks.
Author: Jonathan Brinley
Version: 0.1
Author URI: http://xplus3.net/
*/
/*
	This plugin is _heavily_ derived from the Remove Parents plugin,
	developed by Alekc, available at http://wordpress.org/extend/plugins/remove-parents/
*/
/*  Copyright 2007  Jonathan Brinley  (email : jonathanbrinley@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
function kill_parent_cats($namedcatpath) {
	$result = $namedcatpath;
	$bloghome = get_bloginfo( 'home' );
	$catbase = get_category_base();
	
	//removing parent cats
	//domain/$catbase/parent_category/subcat
	if (preg_match('%' . $bloghome . $catbase . '/.*/(.*?)$%i', $namedcatpath)) {
		$result =  preg_replace('%' . $bloghome . $catbase . '/.*/(.*?)$%i', $bloghome . $catbase . '/$1', $namedcatpath);
	}
	return $result;	
}
function get_category_base() {
	global $wp_rewrite;
	return $wp_rewrite->category_base;
}
add_filter('category_link', 'kill_parent_cats');
?>