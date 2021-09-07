$(document).ready(function() {
   console.log('ready!!!!');
   $('[id*="expand_btn_"]').click(function() {
      
      $item_id = $(this).attr('id').replace('expand_btn_', '');
      
      $item_id = '#expand_section_'+$item_id;
      
      if ($($item_id).hasClass("displayAll") !== true) {
         $($item_id).addClass("displayAll");
      } else
      if ($($item_id).hasClass("displayAll") == true) {
         console.log('here');
         $($item_id).removeClass("displayAll");
      }
   });
});