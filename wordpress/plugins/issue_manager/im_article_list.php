<?php
  $category = get_categories( "orderby=name&hierarchical=0&hide_empty=0&include=$cat_ID" );
  $posts = get_posts( "numberposts=-1&post_status=pending&category=$cat_ID" );
?>
<div class="wrap">
  <h2>Publishing Category: <?php echo $category->cat_name; ?></h2>
  
  <table class="widefat">
    <thead>
      <tr>
        <th scope="col">Title</th>
      </tr>
    </thead>
    <?php $alt = ' class="alternate"'; ?>
    <?php foreach ( $posts as $post ): ?>
      <?php setup_postdata($post); ?>
      <tr id="post-<?php the_ID(); ?>"<?php echo $alt; ?>>
        <td><?php echo $post->post_title; ?></td>
      </tr>
      <?php $alt = empty( $alt ) ? ' class="alternate"' : ''; ?>
    <?php endforeach; ?>
  
  </table>
</div>