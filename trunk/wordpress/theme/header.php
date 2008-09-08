<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
		<title><?php bloginfo('name'); ?><?php wp_title('-'); ?></title>
	
		<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
	
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen, print" />
		<!--[if IE]>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/fix-ie.css" type="text/css" media="screen" />
		<![endif]-->
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/print.css" type="text/css" media="print" />
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Syndication Feed" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />


<?php wp_head(); ?>
	</head>
	<body>
		<div id="page">
			<div id="header">
				<div id="headerbackground">
					<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
					<h2 id="issn">ISSN 1940-5758</h2>
				</div>
			</div>