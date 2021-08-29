(function($) {
	$(document).on( 'click', '.eventSection a', function( event ) {
		event.preventDefault();
            
      $post_id = $(this).attr('id').replace('post_item_', '');
      console.log( $post_id );
     


		$.ajax({
         url: ajaxpagination.ajaxurl,
         type: 'post',
         data: {
				action: 'ajax_pagination',
				query_vars: ajaxpagination.query_vars,
				page: post
			},
         success: function( result ) {
            console.log( result );
         }
      })
	})
})(jQuery);    