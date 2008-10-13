jQuery(document).ready( function($) {
  $('a.im-publish').addClass('thickbox').each( function(i) {
    catID = $(this).parent().parent().attr('id').substring(4);
    query = "KeepThis=true&amp;TB_iframe=true&amp;height=400&amp;width=600&amp;modal=true&amp;action=issue_manager_article_list&amp;cat_ID="+catID;
    $(this).attr('href', "<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php?"+query);
  });
});
/*
  $('a.im-publish').click( function() {
    catID = $(this).parent().parent().attr('id').substring(4);
    
    $.post(
      "<?php bloginfo( 'wpurl' ); ?>/wp-admin/admin-ajax.php",
      {
        action: "issue_manager_article_list",
        cat_ID: catID
      },
      im_load_article_list
    );
    return false;
  });
});

function im_load_article_list(data) {
  jQuery(data).appendTo("#wpwrap").hide();
}*/