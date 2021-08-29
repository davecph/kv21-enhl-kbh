(function($) {
	$(document).on( 'click', '.eventSection a', function( event ) {
		event.preventDefault();
      console.log($(event.target));

      
         var id = $(this).attr('id');
        id = cycle(id.replace('post_item_', '')); 
        console.log( id );
     


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