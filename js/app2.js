	

  

  var debriefToggle = function() {
    switch ($(this).val()) {
      case "0":
        $("#debriefingText").hide();
        $("#whyNoDebriefingDiv").show();        
        break;
      case "1":
        $("#debriefingText").show();
        $("#whyNoDebriefingDiv").hide();
        break;                  
    }         
  }

$(".debriefing").change(debriefToggle).click(debriefToggle);

  $(".koala").change(function() {                 
    switch ($(this).val()) {
      case "0":       
        $("#infConsentTextDiv").hide();
        $("#waiveInfConsentDiv").show();
        break;
      case "1":
        $("#infConsentTextDiv").show();
        $("#waiveInfConsentDiv").hide();
        break;                    
    }       
  });  

$(".deleteFile").on('click', function() {
  var filename = $(this).attr("id");
  if (window.confirm("Delete "+filename+"?")) { 
    window.open('application.php?page=2&delete='+filename);
  }
});
