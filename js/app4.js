
    $(".blood1").change(function() {
      var totalPoints = 0;
      $(".blood1:checked").each(function() {
        totalPoints += parseInt($(this).val(),10);         
      });      
      if(totalPoints > 1) {
        $(".blood2").hide();
      } else {
        $(".blood2").show();  
      }        
    });
      

  // add a warning panel to each of the 'expedited' classes.
  // $(".expedited").closest('div').after('<div class="panel panel-warning" hidden><div class="panel-heading"><h3 class="panel-title">Alert</h3> </div> <div class="panel-body"> This study is not eligible for expedited review and would need to be reviewed by the full Institutional Review Board, a process which can take 2-3 weeks. </div> </div>');

  // $(".expedited").change(function() {
  //   switch ($(this).attr("data-expedited")) {
  //     case "no":      
  //     // display alert that research does not qualify as expedited 
  //       console.log("no");
  //       $(this).closest('div').next().show();
  //       // add a new and unique selector tag (e.g., id="blah")
  //       // $(this).closest('.panel-body').attr("id","blah");
  //       // use the subsequent sibling selector to hide later expedited questions:
  //       // $("#blah ~ .panel-body").hide();
  //       break;
  //     case "null":
  //       // $("#blah ~ .panel-body").show();
  //       // $(this).closest('.panel-body').removeAttr("id");
  //       // not diagnostic; reveal next panel
  //       break;
  //     case "yes":        
  //       // $("#blah ~ .panel-body").show();
  //       // $(this).closest('.panel-body').removeAttr("id");
  //       $(this).closest('div').next().hide();
  //       console.log("yes");
  //       // display alert that research qualifies as expedited
  //       break;
  //   }     
  // });


