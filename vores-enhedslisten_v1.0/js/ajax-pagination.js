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
				page: $post_id
			},
         success: function( html ) {
				$('#main').find( 'article' ).remove();
				$('#main nav').remove();
				$('#main').append( html );
			}
      })
	})
})(jQuery); 