$(document).ready(function() {
   (function($) {
      $(document).on('click', '.eventSection a', function(event) {
         event.preventDefault();
         $post_id = $(this).attr('id').replace('post_item_', '');
         console.log($post_id);
         $.ajax({
            url: ajaxpagination.ajaxurl,
            type: 'post',
            data: {
               action: 'ajax_pagination',
               query_vars: $post_id,
            },
            success: function(data) {
               $stuff = JSON.parse(data);
               //alert($stuff.event_start_time);
               console.log($stuff);
               $('#primary').html($stuff.event_start_time);
               $('#primary').append($stuff.thumbnail_url);
               $('#colophon').html($stuff.ID);
            }
         })

         if ($("#ajaxpop").hasClass("show") !== true) {
            $("#ajaxpop").addClass("show");
         } else
         if ($("#ajaxpop").hasClass("show") == true) {
            console.log('here');
            $("#ajaxpop").removeClass("show");
         }



      })
   })
})(jQuery);