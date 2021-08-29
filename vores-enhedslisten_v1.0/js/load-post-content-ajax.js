(function($) {
	$(document).on( 'click', 'a#post_item', function( event ) {
		event.preventDefault();
		alert( 'Clicked Link' );
	})
})(jQuery);