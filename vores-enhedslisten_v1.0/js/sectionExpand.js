$(document).ready(function() {
   console.log('ready!');
   $('#expandCandidates').click(function() {
      console.log('clicked yup');
      if ($("#candidateGrid").hasClass("displayAll") !== true) {
         $("#candidateGrid").addClass("displayAll");
      } else if ($("#candidateGrid").hasClass("displayAll") = true) {
         console.log('here');
         $("#candidateGrid").removeClass("displayAll");
      }
   });
});