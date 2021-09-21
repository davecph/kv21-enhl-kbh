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
            $("#ajaxpop #coverImg").removeClass("event_party");
            $("#ajaxpop #coverImg").removeClass("event_activist");
            $("#ajaxpop #coverImg").removeClass("event_debate");
            $("#ajaxpop #coverImg").addClass($content.event_type);
            $('#ajaxpop  .headerContainer').html("<h1>" + $content.post_title + "</h1>");
            if ($content.event_type == 'event_party') {
               $('#ajaxpop  .factbox').html('<h5>Fest</h5>');
            } else
            if ($content.event_type == 'event_debate') {
               $('#ajaxpop  .factbox').html('<h5>Debat</h5>');
            } else
            if ($content.event_type == 'event_activist') {
               $('#ajaxpop  .factbox').html('<h5>Aktivisme</h5>');
            }
            $('#ajaxpop  .factbox').append('<h6>' + $content.event_start_time + ' – ' + $content.event_end_time + '</h6>');
            if ($content.location_type == true) {
               $('#ajaxpop  .factbox').append('<p>Eventen foregår online</p>');
               $('#ajaxpop  .factbox').append('<a class="btn btn-success" target="_blank" href="' + $content.location_type_online_url + '">Klik her for at deltage</a>');
            } else {
               $('#ajaxpop  .factbox').append('<h6>' + $content.event_venue + '</h6>');
               $('#ajaxpop  .factbox').append('<p>' + $content.temp_address + '</p>')
            };
            /* $candidates = $content.tag_candidates;
            console.log($candidates);
            $candidates.forEach(function(item) {
               $('#ajaxpop  .factbox').append(the_post_title(item));
           }); */
           $('#ajaxpop .entry-content').html($content.short_description);
            $('#ajaxpop .entry-content').append($content.post_content);
         }
      })
      if ($("#ajaxpop").hasClass("show") !== true) {
         $("#ajaxpop").addClass("show");
         $("body").addClass("noScroll");
      } else
      if ($("#ajaxpop").hasClass("show") == true) {
         $("body").removeClass("noScroll");
         $("#ajaxpop").removeClass("show");
      }
   })
})(jQuery);

(function($) {
   $(document).on('click', '.ajaxpop-close', function(event) {
      event.preventDefault();
      if ($("#ajaxpop").hasClass("show") == true) {
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