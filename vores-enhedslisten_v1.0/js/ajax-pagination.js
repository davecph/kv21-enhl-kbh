(function($) {
	$(document).on( 'click', '.eventSection a', function( event ) {
		event.preventDefault();
		$.ajax({
         url: ajaxpagination.ajaxurl,
         type: 'post',
         data: {
            action: 'ajax_pagination'
         },
         success: function( result ) {
            alert( result );
         }
      })
	})
})(jQuery);