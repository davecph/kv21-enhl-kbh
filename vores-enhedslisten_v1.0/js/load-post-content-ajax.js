(function($) {
	$(document).on( 'click', '.eventSection a', function( event ) {
		event.preventDefault();
		alert( 'Clicked Link' );
	})
})(jQuery);