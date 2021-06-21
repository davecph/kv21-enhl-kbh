$(document).ready(function() {
   console.log('ready!');
   if ($("#uniNav").hasClass("collapsed") !== true && $("#uniNav").hasClass("expanded") !== true) {
      $("#uniNav").addClass("collapsed"); // ensures that the class .collapsed is present 
   }
   $('#uniNav-activateBtn').click(function() {
      console.log('clicked');
      if ($("#uniNav").hasClass("collapsed") == true) {
         $("#uniNav").removeClass("collapsed");
         $("#uniNav").addClass("expanded");
      } else if ($("#uniNav").hasClass("expanded") == true) {
         $("#uniNav").addClass("collapsed");
         $("#uniNav").removeClass("expanded");
      }
   });
   $('#uniNav-closeBtn').click(function() {
      if ($("#uniNav").hasClass("expanded") == true) {
         $("#uniNav").addClass("collapsed");
         $("#uniNav").removeClass("expanded");
      }
   });
});