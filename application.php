<?php
  include('php/SQLutils.php');
  if(!isLoggedIn()) {
    echo '<p>Please <a href="login.php">login</a> to access this page.</p>';
    die();
  }
	$pageTitle = "IRB Application";
  $user = $_SESSION['userid'];
	$mysql = myConnect();
  // page number
    $page = 1;
  if(isset($_GET["new"]) && $_GET["new"]=="true") {
    unset($_SESSION["studyNumber"]);
  }
  if(isset($_GET["studyNumber"])) {
    if(hasAccess($mysql,$_SESSION['userid'],$_GET["studyNumber"]) || isAdmin()) {
      $_SESSION["studyNumber"] = $_GET["studyNumber"];
    }
    else {
      echo '<p>You do not have access to that study.</p>';
      die();
    }
  }
  if(isset($_POST["submit"])) { // incoming form data
    // catch incoming data
    require('php/appProcessor.php');

    $incoming = postToResults(getAccepted()); // a key->value array of accepted incoming form values

    if(isset($_SESSION["studyNumber"])) {
      $incoming["studyNumber"] = $_SESSION["studyNumber"]; // adds studyNumber if available
      $table = 'year'.substr($_SESSION["studyNumber"],0,4); // table is first 4 digits of study number
      updateApp($mysql,$user,$table,$incoming); // update year20xx table with incoming data
    } else { // studyNumber is not yet set
      $table = 'year'.date("Y"); // table is the word 'year' plus the current 4-digit year

      // add new data to database
        $_SESSION["studyNumber"] = updateApp($mysql,$user,$table,$incoming); // updateApp should return studyNumber if successful
    }

    $submit = $_POST["submit"]; // catches the value attached to the "submit" button, which can be a number from 1-5, "submit", "CoauthorRevision", "FacultyRevision", or "IRBRevision".  "Submit" advances the app to the next stage. The other words return it to revision.
    if(intval($submit,10) == 0) $submit = 5; // If "submit" is a word, go to page 5.
    if($submit > 5) {
      header("userDashboard.php");
    } else {
      $page = $submit;
    }
  } else { // No data is coming in
    if(isset($_GET["page"])) {
      $page = $_GET["page"];
    }
  }

	include('php/navbar.php');
  ?>

<h2>Hanover College Institutional Review Board (IRB)<br>
  <?php
    if(isset($_SESSION["studyNumber"])) {
      $status = computeCurrentStatus($mysql,$_SESSION["studyNumber"]);
      echo '<div class="row"><div class="col-sm-9 col-xs-12"><small>Study Number: '.$_SESSION["studyNumber"].' <span id="currentStatus" class="label label-default"></span></small></div><div class="col-sm-3 col-xs-12"><a class="btn btn-xs btn-warning" role="button" href="userDashboard.php">Go to Dashboard</a></div></div>';
    } else {
      echo '<small>Application Form</small>';
    }
    echo '<script>var userid = "'.$user.'";</script>';
  ?>
</h2>
</div> <!-- closes page header -->
</div> <!-- closes page header row -->

  <?php
  $ending = '</div></div></body></html>';
	if(!isLoggedIn()) {
			echo '<p>Please <a href="login.php">login</a> to access this page.</p>'.$ending;
			die();
		}

    echo '<script>var page = '.$page.'</script>'.PHP_EOL; // page number now available to js
    if(isset($_SESSION["studyNumber"])) {
      echo '<script>var studyNumber = '.$_SESSION["studyNumber"].'</script>'.PHP_EOL; // studyNumber now available to js
    }
    $pages = array("Overview","Documents","Protections","Classification","Submit");
    $pageFile = 'app'.$page.'.php';
    $jsFile = '"js/app'.$page.'.js"';
    $pageButton = '"#app'.$page.'Button"';
?>

			<form id="appForm" method="POST" enctype="multipart/form-data" class="form-horizontal" action="application.php">
			<div class="row">
				<ul id="navPills" class="nav nav-pills">
				  <button class="btn btn-default" type="submit" value="1" name="submit">Overview &rarr;</button>
				  <button class="btn btn-default" type="submit" value="2" name="submit">Documents &rarr;</button>
				  <button class="btn btn-default" type="submit" value="3" name="submit">Protections &rarr;</button>
				  <button class="btn btn-default" type="submit" value="4" name="submit">Classification &rarr;</button>
				  <button class="btn btn-default" type="submit" value="5" name="submit">Submit</button>
				</ul>
			</div>
      <input type="hidden" id="pageValue" name="page">
      <input type="hidden" id="lockStatus" name="lockStatus" value="locked">
			<div class="row">

            <p>&nbsp;</p>
            <?php include($pageFile); ?> <!-- includes /body tag -->


      </div> <!-- closes row -->
      <div class="row">
        <ul class="pager">
          <li id="previous" class="hidden"><button type="submit" id="prevButton" class="btn btn-default" name="submit" value="previous" >&larr; Previous</button></li>
          <?php echo '<li id="save"><button type="submit" id="saveButton" class="btn btn-success" name="submit" value="'.$page.'" >Save</button></li>'; ?>
          <li id="next"><button type="submit" id="nextButton" class="btn btn-default" name="submit" value="next">Next &rarr;</button></li>
        </ul>
      </div> <!-- closes row -->
    </form>
  </div> <!-- closes container -->
</body>
<?php
    mysqli_close($mysql); // closes connection
?>
	<script>
     $(document).ready(function() {

      $.ajaxSetup({
          cache: true
      });

      if(page>1) {
        $.getScript('js/app1.js?version=2'); // get anotherAuthor() function to avoid error
      }

      $.getScript('js/app'+page+'.js?version=new'); // runs the js specific to each page
                                                    // ?version=new makes the browser reload the js (not use an old cached version)

      // Add hidden input for each checkbox that is set to 'off' (over-ridden if checked)
      $('[type="checkbox"]').each(function() {
        // before each checkbox, add an <input type="hidden" name="[same as checkbox name]" value="off">
        var chkname = $(this).attr("name");
        $(this).before('<input type="hidden" value="off" name="'+chkname+'">');
      });

      function checkClassification() {
        // is at least one classification set for the proposal?
        var oneChecked = false;
        $('input[name="Classification"]').each(function() {
          // var value = $(this).val();
          // if (value == "Exempt" || value == "Expedited" || value == "Full Review") {
          //   oneChecked = true;
          //  }
          if($(this).is(':checked')) {
            oneChecked = true;
          }
        });
        if(oneChecked) {
          $('#IRBapproval').prop("disabled",false);
        } else {
          $('#IRBapproval').prop("disabled",true);
        }
      }

      $('input[name="Classification"]').change(function() {
        checkClassification();
      });

      $('#updateIRB').on('click', function() {
        var IRBname = $('input[name="IRBname').val();
        var IRBemail = $('input[name="IRBemail').val();
        $.post("php/ajax.php",
          { "updateIRB":true, "studyNumber":studyNumber, "IRBname":IRBname, "IRBemail":IRBemail },
          function(data) {
            if(data==1) { // it worked
              $("#updateIRB").after('<span class="label label-default">Reviewer information updated</span>');
            } else { // it didn't work
              $("#updateIRB").after('<span class="label label-danger">Error: Info not updated</span>');
            }
          },
          "text"
        );
      });

        if(typeof studyNumber !== 'undefined') { // if the studyNumber variable is set, fill the form with its data
          $("#lockStatus").val("locked"); // temporarily lock form, so that any partially-filled entries are not processed by updateApp if the user clicks one of the Submit buttons.
          $.post("php/ajax.php",
            { "getAppRecord" : "true", "studyNumber":studyNumber},
            function(data) {
              //  checkExempt(data); // in app4.js, used to see if study is exempt
              var exempt = true;
              var exemptQuestions = ["exceedsMinRisk","privacyProblem","deception","objectionable","sensitive","pregnantRisk","children","incarcerated","pregnant","mentallyDisabled","disadvantaged","otherParticipants"];
              $.each(data, function(key, val) {
                if(key.substring(0,7)=="5Author") {
                  var regExp = /(?:^5Author)(\d{1,2})/;
                  var thisAuthor = parseInt(regExp.exec(key)[1],10); // get the current author number
                  var authorDivs = $("div.Author").length; // Count the number of author fields currently in the form.
                  if(thisAuthor > authorDivs) { anotherAuthor(); } // If authorDivs is less than thisAuthor, trigger anotherAuthor() function
                }
                var el = $('[name="'+key+'"]:not([type="hidden"])');  // excludes hidden fields
                type = el.attr('type');
                if(el.length > 0) { // if the DOM element exists on this page
                  switch(type){
                    case 'checkbox':
                        if(val=="on") {
                          el.attr('checked', 'checked');
                        }
                        break;
                    case 'radio':
                        el.filter('[value="'+val+'"]').attr('checked', 'checked').change();
                        break;
                    default:
                        el.val(val);
                  }
                }
              });
            },
            "json"
          );

          $.post("php/ajax.php",
            { "getStatus": "true", "studyNumber":studyNumber},
            function(data) {
              $("#currentStatus").text(data);
              if($.inArray(data,["Submitted to Co-authors","Co-author Approval","Submitted to Faculty Sponsor","Faculty Sponsor Approval","Submitted to IRB","IRB Approval","Withdrawn"]) !== -1) {
                $(':input[type="text"],textarea:not([name="comments"]):not([name="Classification"]):not([name="category"]):not(".IRB")').prop("readOnly",true); // disable inputs when form is under review
                $('.IRB').prop("readOnly",false);
                $(':input:not([type="submit"],[type="text"]):not(textarea):not([name="comments"]):not([name="Classification"]):not([name="category"]):not(".IRB")').prop("disabled",true); // disable inputs when form is under review
                $('#currentStatus').after(' <span id="editingDisabled" class="label label-danger">Editing disabled</span>');
              }
              if(data==="Submitted to IRB" && page===5) {
                checkClassification(); // this is in app5.js and checks whether at least one of the Classification radio buttons has been selected. If not, approve button disabled.
              }
            },
            "json"
          );
          $("#lockStatus").val("unlocked"); // AFTER all the data have been loaded via ajax, the form is set to unlocked, which means that pressing a Submit button WILL cause the data to be updated via updateApp.
        } else { // studyNumber not set
          $("#lockStatus").val("unlocked"); // no need to lock the form for the first draft.
        }


            // from userapps (only if on page 1)
              // process userapps to get it into the input field format
                // trigger the anotherAuthor function in js/app1.js to get the appropriate number of author fields ready
          // Get a list of the names of all the input fields on the current page.
          // For each input field, set the value of that field to what was in the record.
          // For convenience, make sure the input name and the db variable name are identical.
            // This will not be true for author and sponsor info. Need to get that from table 'userapps'





      function countText() {
      	var charLength = $(this).val().length;
      	$(this).next().find(".count").html(charLength);
      	$(this).next().find(".count").css("color","black");
        if(charLength > 65000) {
	      	// turn text red
	      	$(this).next().find(".count").css("color","red").append(' Alert! The database cannot store a text entry with more than 65,000 characters. Please reduce your text.');
          // alert
     		} else {
          if(charLength > 50000) {
            // turn text orange
            $(this).next().find(".count").css("color","orange").append(' Alert! The database cannot store a text entry with more than 65,000 characters. Please reduce your text.');;
            }
        }
     	}

     	$('.countable')
        .change(countText)
     		.keypress(countText)
      	.keyup(countText)
      	.blur(countText)
      	.focus(countText)
        .after('<h5><small>Characters: <span class="count"></span></small></h5>');

      $("#navPills button:nth-child("+page+")").addClass("btn-primary");  // showing current page

      $("#pageValue").val(page); // adding page number to hidden form field
      if(page>1) {
        $("#previous").removeClass("hidden"); // reveal 'previous' button
      }
      if(page==5) {
        $("#nextButton").addClass("hidden"); // hide 'next' button on last page
      }
      $("#nextButton").val(page+1); // here's where the page values for the next and prev buttons are set
      $("#prevButton").val(page-1);

      function expandHide() {
        var nm = $(this).attr("name");   // e.g., "debriefing"
        var div = nm+$(this).val();  // e.g., "debriefing0"
        $("."+nm).hide(); // hides all divs with that class name
        $("#"+div).show(); // reveals the correct div
        // if($(this).hasClass("alert")) {
        //   console.log("alert!");
        //   $("#"+div).removeClass("panel-default").addClass("panel-danger");
        // } else {
        //   $("#"+div).removeClass("panel-danger").addClass("panel-default");
        // }
      }

      $(".expand").change(expandHide);
      $(".fullReview").each(function() {
        var name = $(this).attr("name");
        var nm = name+"warn";   // e.g., "debriefing"
        var extraText = "";
        if($(this).attr("data-text")) {
          extraText+=$(this).attr("data-text");
        }
        $(this).closest('div').after('<div class="panel panel-warning" id="'+nm+'" hidden><div class="panel-heading"><h3 class="panel-title">Alert</h3> </div> <div class="panel-body"> '+extraText+'This study is not eligible for expedited review and would need to be reviewed by the full Institutional Review Board, a process which can take 2-3 weeks. To avoid this delay, you may consider revising your procedure. </div> </div>');
        $('[name="'+name+'"]:not([type="hidden"]').change(function() {
          if ($(this).hasClass("fullReview")) {
             $("#"+nm).show();
          } else {
            $("#"+nm).hide();
          }
        });
      });
    });
	</script>
</html>
