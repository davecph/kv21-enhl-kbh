(function($) {
	$(document).on( 'click', '.eventSection a', function( event ) {
		event.preventDefault();
      console.log($(event.target));


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