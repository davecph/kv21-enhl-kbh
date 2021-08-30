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
            $content = JSON.parse(data);
            //alert($content.event_start_time);
            console.log($content);
            if ($content.thumbnail_url !== false) {
               $('#ajaxpop #coverImg').attr("style", "--bg-img:url(" + $content.thumbnail_url + ")");
            } else
            if ($content.thumbnail_url == false) {
               $('#ajaxpop #coverImg').attr("style", "");
            }
            endif;
            $("#coverImg").removeClass("event_party");
            $("#coverImg").removeClass("event_activist");
            $("#coverImg").removeClass("event_debate");
            $("#coverImg").addClass($content.event_type);
            $('#ajaxpop  .headerContainer').html("<h1>" + $content.post_title + "</h1>");
            $('#ajaxpop  .factbox').html('<h6>Tidspunkt</h6><h6><span class="fw-light">' + $content.event_start_time + ' – ' + $content.event_end_time + '</span><h6></h6>');
            if ($content.eventtype == 'event_party') {
               $('#ajaxpop  .factbox').append('<h5>Fest</h5>');
            } else
            if ($content.eventtype == 'event_party') {
               $('#ajaxpop  .factbox').append('<h5>Fest</h5>');
            } else
            if ($content.eventtype == 'event_party') {
               $('#ajaxpop  .factbox').append('<h5>Fest</h5>');
            } endif;
            $('#ajaxpop .entry-content').html($content.post_content);
         }
      })
      if ($("#ajaxpop").hasClass("show") !== true) {
         $("#ajaxpop").addClass("show");
         $("body").addClass("noScroll");
      } else
      if ($("#ajaxpop").hasClass("show") == true) {
         console.log('here');
         $("#ajaxpop").removeClass("show");
      }
   })
})(jQuery);
(function($) {
   $(document).on('click', '.ajaxpop-close', function(event) {
      event.preventDefault();
      if ($("#ajaxpop").hasClass("show") == true) {
         console.log('here');
         $("#ajaxpop").removeClass("show");
         $("body").removeClass("noScroll");
      }
   })
})(jQuery);
(function($) {
   $(document).on('click', '.ajaxpop-cover', function(event) {
      event.preventDefault();
      if ($("#ajaxpop").hasClass("show") == true) {
         console.log('here');
         $("#ajaxpop").removeClass("show");
         $("body").removeClass("noScroll");
      }
   })
})
(jQuery);