<?php
  $cat = get_categories('include='.$cat_ID);
  if ( !isset($cat[0]) ):
    echo "<h2>Category $cat_ID Does Not Exist</h2>";
  else:
    $cat = $cat[0];
?>
<h2>Publish "<?php echo $cat->cat_name; ?>"</h2>

<form method="POST" action="">
  <?php wp_nonce_field('issue-manager-publish_'.$cat_ID); ?>
  <div id='timestampdiv'><?php touch_time(TRUE,0,4); ?></div>
  <table class="widefat">
    <thead>
      <tr>
        <th scope="col">Post Name</th>
        <th scope="col"></th>
        <th scope="col"></th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
    <?php
      $alt = ' class="alternate"';
      $posts = get_posts("numberposts=-1&category=$cat_ID");
      foreach ( $posts as $post ):?>
        <tr id="post-<?php echo $post->ID; ?>"<?php echo $alt; ?>>
          <td><?php echo $post->post_title; ?></td>
        </tr>
        <?php $alt = empty( $alt ) ? ' class="alternate"' : ''; ?>
      <?php endforeach;
    ?>
    </tbody>
  </table>
  <p class="submit">
    <input class="button" type="submit" value="Publish" name="publish" />
  </p>

</form>
<?php endif; ?>