(function($) {
	$(document).on( 'click', '.eventSection a', function( event ) {
		event.preventDefault();

		$.ajax({
         url: loadpostcontentajax.ajaxurl,
         type: 'post',
         data: {
            action: 'load-post-content-ajax'
         },
         success: function( result ) {
            alert( result );
         }
      })
	})
})(jQuery);                                        