			<div id="meta">
				<div id="about">
					<h2>About</h2>
					<ul>
						<?php wp_list_pages('title_li=&sort_column=menu_order&meta_key=section&meta_value=about'); ?>
						<li><a href="http://code4lib.org/">Code4Lib</a></li>
					</ul>
				</div>
				<div id="forauthors">
					<h2>For Authors</h2>
					<ul>
						<?php wp_list_pages('title_li=&sort_column=menu_order&meta_key=section&meta_value=authors'); ?>
					</ul>
				</div>
			</div>
			
			<div id="archives">
				<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
					<div>
						<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" tabindex="1" />
						<input type="submit" value="Search" id="searchsubmit" tabindex="2" />
					</div>
				</form>
				
				<h2>Current Issue</h2>
					<ul>
						<li><a href="<?php echo get_option('home'); ?>/issues/issue2">Issue 2, 2008-03-24</a></li>
					</ul>
					
				<h2>Past Issues</h2>
					<ul>
						<li><a href="<?php echo get_option('home'); ?>/issues/issue1">Issue 1, 2007-12-17</a></li>
					</ul>

				<!--<ul>
					<?php 
						$category_params = array('show_option_all' => '',
														'orderby' => 'name',
														'order' => 'ASC',
														'show_last_updated' => 0,
														'style' => 'list',
														'show_count' => 0,
														'hide_empty' => 1,
														'use_desc_for_title' => 1,
														'child_of' => 4,
														'feed' => '',
														'feed_image' => '', 
														'exclude' => '',
														'hierarchical' => true,
														'title_li' => __('<h2>Previous Issues</h2>'),
														'number' => 4);
						//wp_list_categories($category_params);
					?>
					<li><a href="">See all issues</a></li>
				</ul>
				-->
			</div>
			<?php wp_meta(); ?>
			
