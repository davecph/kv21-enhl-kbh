$(document).ready(function() {
   console.log('ready!');

   $('#expandCandidates').click(function() {
      console.log('clicked');
      if ($("#candidateGrid").hasClass("displayAll") !== true) {
         
         $("#candidateGrid").addClass("displayAll");
      } else if ($("#candidateGrid").hasClass("displayAll") == true) {
         
         $("#candidateGrid").removeClass("displayAll");
      }
   });
   
});