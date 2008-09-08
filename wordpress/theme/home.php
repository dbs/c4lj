<?php get_header(); ?>
<?php get_sidebar(); ?>

			<div id="content" class="listpage">
				<h1 class="pagetitle">Issue 2</h1>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php if ( in_category( c4lj_current_issue_id() ) ): ?>
					<?php include (TEMPLATEPATH . '/excerpt.php'); ?>
					<?php endif; ?>
				<?php endwhile; endif; ?>
			</div>

<?php get_footer(); ?>