(function($) {
	$(document).on( 'click', '.eventSection a', function( event ) {
		event.preventDefault();
      console.log($(event.target));

      
         $post_id = $(this).attr('id').replace('post_item_', '');
        
        console.log( $post_id );
     


		$.ajax({
         url: ajaxpagination.ajaxurl,
         type: 'post',
         data: {
            action: 'ajax_pagination'
         },
         success: function( result ) {
            console.log( result );
         }
      })
	})
})(jQuery); 