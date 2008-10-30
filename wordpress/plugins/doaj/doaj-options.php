<div class="wrap">
  <h2>Manage Author List</h2>
  <form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
    <table class="form-table">
      <tr valign="top">
        <th scope="row">
          <label for="doaj_publisher">Publisher</label>
        </th>
        <td>
          <input type="text" name="doaj_publisher" id="doaj_publisher" value="<?php echo get_option('doaj_publisher'); ?>" />
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">
          <label for="doaj_issn">ISSN</label>
        </th>
        <td>
          <input type="text" name="doaj_issn" id="doaj_issn" value="<?php echo get_option('doaj_issn'); ?>" />
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">
          <label for="doaj_eissn">eISSN</label>
        </th>
        <td>
          <input type="text" name="doaj_eissn" id="doaj_eissn" value="<?php echo get_option('doaj_eissn'); ?>" />
        </td>
      </tr>
    </table>
    <p class="submit">
      <input type="hidden" name="action" value="update" />
      <input type="hidden" name="page_options" value="doaj_publisher, doaj_issn, doaj_eissn" />
      <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
    </p>
  </form>
</div>