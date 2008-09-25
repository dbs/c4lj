<?php
/*
Template Name: Article Submission
*/
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>

			<div id="content">
        <form method='post' action=''>
          <div>
            <label for="article_author">Author(s)</label>
            <input type="text" value="" name="author" id="article_author" />
          </div>
          <div>
            <label for="article_email">Email Address</label>
            <input type="text" value="" name="email" id="article_email" />
          </div>
          <div>
            <label for="article_title">Title</label>
            <input type="text" value="" name="email" id="article_title" />
          </div>
          <div>
            <label for="article_abstract">Abstract</label>
            <textarea name="abstract" id="article_abstract"></textarea>
          </div>
          <div>
            <input type="checkbox" name="copyright" id="article_copyright" />
            <label for="article_copyright">Authors retain copyright on their works, but articles we publish in the journal must be licensed by their authors under a <a href="http://creativecommons.org/licenses/by/3.0/">CC-BY license</a>. By checking this box, you agree to a CC-BY license for your article, should we publish it.</label>
          </div>
        
        </form>
      </div>

<?php get_footer(); ?>