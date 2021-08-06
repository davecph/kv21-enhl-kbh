$(document).ready(function() {
   console.log('ready!');
   $('#expandCandidates').click(function() {
      console.log('clicked yup!');
      if ($("#candidateGrid").hasClass("displayAll") !== true) {
         $("#candidateGrid").addClass("displayAll");
      } else 
      if ($("#candidateGrid").hasClass("displayAll") == true) {
         console.log('here');
         $("#candidateGrid").removeClass("displayAll");
      }
   });
});


$(document).ready(function() {
   $(document).click(function(event){
      $(event.target).closest(".clickable").each(function(){
        // "this" is your "clickable" clicked
        console.log('stuff');
      });
    });
});