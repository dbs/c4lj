<?php
  $category = get_categories( "orderby=name&hierarchical=0&hide_empty=0&include=$cat_ID" );
  $posts = get_posts( "numberposts=-1&post_status=pending&category=$cat_ID" );
?>
<div class="wrap">
  <h2>Publishing Category: <?php echo $category[0]->cat_name; ?></h2>
  <p>Drag the post names into the order you want them to appear, from newest to oldest.</p>
  <ul class="im_article_list">
    <?php foreach ( $posts as $post ): ?>
    <li id="post-<?php echo $post->ID; ?>" style="cursor: move; background-color: #E4F2FD; padding: 0.25em;"><?php echo $post->post_title; ?></li>
    <?php endforeach; ?>
  </ul>
  <form id="im_publish_form" method="get" action="edit.php">
    <input type="hidden" name="page" id="im_publish_page" value="manage-issues" />
    <input type="hidden" name="action" id="im_publish_action" value="publish" />
    <input type="hidden" name="cat_ID" id="im_publish_cat_ID" value="<?php echo $cat_ID; ?>" />
    <input type="hidden" name="posts" id="im_publish_posts" value="" />
    <input type="submit" value="Publish Issue" />
  </form>
</div>