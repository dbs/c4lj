jQuery(document).ready( function($) {
  $(".im_article_list").sortable({
    update: function() {
      post_IDs = new Array();
      $(".im_article_list li").each( function() {
        post_IDs.push($(this).attr('id').substring(5));
      });
      $("#im_publish_posts").val(post_IDs.join(','));
    }
  });
  
});