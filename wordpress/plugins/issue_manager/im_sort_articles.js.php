jQuery(document).ready( function() {
  jQuery('a.im-publish').click( function() {
    catID = jQuery(this).parent().parent().attr('id').substring(4);
    jQuery.get(
      "<?php ?>",
      {
        page: "manage-issues",
        action: "list",
        cat_ID: catID
      },
      function(data) { alert(data); }
    );
    return false;
  });
});