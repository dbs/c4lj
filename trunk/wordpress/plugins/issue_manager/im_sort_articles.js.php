jQuery(document).ready( function($) {
  $('a.im-publish').click( function() {
    catID = $(this).parent().parent().attr('id').substring(4);
    $.post(
      im_wpurl+"/wp-admin/admin-ajax.php",
      {
        action: "issue_manager_article_list",
        cat_ID: catID
      },
      function(data) { alert(data); }
    );
    return false;
  });
});