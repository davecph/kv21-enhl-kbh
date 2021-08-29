(function($) {
	$(document).on( 'click', '.eventSection a', function( event ) {
		event.preventDefault();
      console.log($(event.target));

      
         var post_id = $(this).attr('id');
        var post_id = post_id.replace('post_item_', ''); 
        console.log( post_id );
     


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