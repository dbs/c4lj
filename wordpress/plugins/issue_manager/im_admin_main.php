<h2>Manage Issues</h2>

<table class="widefat">
  <thead>
    <tr>
      <th scope="col">Category Name</th>
      <th scope="col"></th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <?php $alt = ' class="alternate"'; ?>
  <?php foreach ( $categories as $cat ): ?>
    <?php
      if ( in_array($cat->cat_ID, $published) )
        $status = "published";
      elseif ( in_array($cat->cat_ID, $unpublished) )
        $status = "unpublished";
      else
        $status = "ignored";
    ?>
    <tr id="cat-<?php echo $cat->cat_ID; ?>"<?php echo $alt; ?>>
      <td><strong><a title='Edit the status of "<?php echo $cat->cat_name; ?>"' href="?action=edit&cat_ID=<?php echo $cat->cat_ID; ?>"><?php echo $cat->cat_name; ?></a></strong></td>
      <td><?php
        if ( "published" == $status ) { echo "Published"; }
        else { echo "<a href='?action=publish&cat_ID=$cat->cat_ID'>Publish</a>"; }
      ?></td>
      <td><?php
        if ( "unpublished" == $status ) { echo "Unpublished"; }
        else { echo "<a href='?action=unpublish&cat_ID=$cat->cat_ID'>Unpublish</a>"; }
      ?></td>
      <td><?php
        if ( "ignored" == $status ) { echo "Ignored"; }
        else { echo "<a href='?action=ignore&cat_ID=$cat->cat_ID'>Ignore</a>"; }
      ?></td>
    </tr>
    <?php $alt = empty( $alt ) ? ' class="alternate"' : ''; ?>
  <?php endforeach; ?>
  </tbody>
</table>