<?php
  $category = get_categories( "orderby=name&hierarchical=0&hide_empty=0&include=$cat_ID" );
  $posts = get_posts( "numberposts=-1&post_status=pending&category=$cat_ID" );
?>
<div class="wrap">
  <h2>Publishing Category: <?php echo $category[0]->cat_name; ?></h2>
  
  <ul class="im_article_list">
    <?php foreach ( $posts as $post ): ?>
    <li id="post-<?php echo $post->ID; ?>" style="cursor: move; background-color: #E4F2FD;"><?php echo $post->post_title; ?></li>
    <?php endforeach; ?>
  </ul>
</div>