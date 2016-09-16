<?php  
  include('php/SQLutils.php');
  include('php/display.php');
if(!isLoggedIn()) {		
	header('Location: logout.php');
} else {
	$pageTitle = 'HC IRB User Dashboard';
	include('php/navbar.php');
}  
$mysqli = myConnect();

?>

			<h2>
				HC IRB User Dashboard
				<?php 
					if(isset($_SESSION["admin"]) && $_SESSION["admin"]==1) { // if validated as an administrator (see list of administrators in SQLutils.php under the validateUser function)
					echo '<a class="btn btn-xs btn-warning" role="button" href="adminDashboard.php">Go to Administrator Page</a>';
				}
				?>
			</h2>							
		</div> <!-- end page header -->
	</div> <!-- close row -->										
	<div class="row">			
		<div class="col-sm-6 col-sm-offset-3">
			<div class="panel panel-default">			
				<div class="panel-body">
					<div class="col-md-12">
						<a class="btn btn-success btn-block" role="button" href="application.php?new=true" id="newApplication" style="white-space: normal;"><br>Start New Application<br>&nbsp;</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<?php
			// faculty sponsored apps?
				// TODO:  is user a faculty member?  If so, they should not have any numbers at the end of their email address
			
			$studies = getStudies($mysqli,$_SESSION['userid']);			
			$appArray = arrangeApps($mysqli,$studies); // from display.php
			$tabOrder = array(
				"action" => "Action Items",
				"sponsor" => "Sponsored",
				"author" => "Authored",
				"approved" => "Approved",
				"withdrawn" => "Withdrawn"
				);
			$actionLabels = array(
				0 => "Awaiting IRB Review",
				1 => "Awaiting Faculty Sponsor Review",
				2 => "Awaiting Co-author Approval",
				3 => "Awaiting Author Submission"
				);
			// creating the navigation pills
			echo '<div class="panel panel-default"><div class="panel-body">';
			echo '<ul class="nav nav-pills" role="navigation">';
			foreach($tabOrder as $key=>$val) {
				if(isset($appArray[$key])) {
					echo '<li role="presentation"';
					if($key=="action") echo ' class="active"';
					echo '><a href="#'.$key.'" aria-controls="'.$key.'" role="tab" data-toggle="tab">'.$val.'</a></li>';	
				}				
			}
			echo '</ul>';
			echo '<hr>';
  			
  			// tab panes
  			echo '<div class="tab-content">';
  			foreach($tabOrder as $key=>$val) {
				if(isset($appArray[$key])) {
					// tabpanel div
					echo '<div role="tabpanel" class="tab-pane';
					if($key=="action") echo ' active';
					echo '" id="'.$key.'">';	
					// buttons
					if($key=="action") {
						foreach($appArray["action"] as $k=>$v) {
							listApps2($v,$actionLabels[$k],"danger");
						}					
					} else {
						listApps2($appArray[$key]);
					}
					// end tabpanel div
					echo '</div>';
				}				
			}
			echo '</div>';	// end tab panes

			echo '</div></div>'; // end panel
		?>	
	</div>
	
	
</div> <!-- close container -->
	</body>
	<script src="js/ajax.js"></script>
	<script>
	$(document).ready(function(){	
		<?php echo 'var email="'.$_SESSION['userid'].'";'; ?>	
		$("#user").append(email);	
		// // Account Information Table
		// 	var accountFields={lastName: "Last Name", firstName: "First Name", status: "Status" };
		// 	var tText="";
		// 	$.each(accountFields, function (key,value) {
		// 		tText+='<tr><th>'+value+'</th><td id="t'+key+'"></td></tr>';
		// 	});		
		// 	$("#Account").html(tText);
		// 	// ajax request to get last login
		// 	getAccount(email);
		// $("#saveEdit").hide();
		// $("#cancelEdit").hide();
		// function changeListen(key) {
		// 	$("#edit"+key).keydown(function() {
		// 		$("#submitEdit"+key).prop('disabled', false);
		// 	});
		// }

		// function editAccount() {
		// 	$.each(accountFields, function (key,value) {
		// 		var oldValue = $("#t"+key).html();				
		// 		$("#t"+key).html('<input type="text" name="'+key+'" id="edit'+key+'" value="'+oldValue+'">');			
		// 		});			
		// 	$("#editAccount").hide();
		// 	$("#saveEdit").show();
		// 	$("#cancelEdit").show();	
		// }
		// function saveEdit() {
		// 	var new_object = {};
		// 	$.each(accountFields, function (key,value) {
		// 		new_object[key]=$("#edit"+key).val();
		// 	});			
		// 	updateAccountInfo(email,new_object);			
		// 	$("#editAccount").show();
		// 	$("#saveEdit").hide();
		// 	$("#cancelEdit").hide();			
		// }
		// $("#editAccount").on("click", function() {
		// 	editAccount();		
		// 	return false;
		// });
		// $("#saveEdit").on("click", function() {
		// 	saveEdit();		
		// 	return false;
		// });
		// $("#cancelEdit").on("click", function() {
		// 	getAccount(email);
		// 	$("#editAccount").show();
		// 	$("#saveEdit").hide();
		// 	$("#cancelEdit").hide();
		// 	return false;
		// });

		// ajax request to see if the user has any applications.  If yes, put them in a table and append them to Applications.  If no, write "No Applications".
		// stages of processing:
			// 1. user begins new application. Can return and edit at any time.
			// 2. co-authors registered with system.
			// 3. approval from author
			// 4. approval from co-authors.  Co-authors get an email with a summary of the app.  Reply options are (a) approve, (b) suggest changes
				// (b) sends an email with suggested changes to the other co-authors.
				// any editing done after one person approves the app voids that approval.
			// 5. approval from faculty sponsor.  Fac sponsor has options to (a) approve or (b) recommend changes
		// make row clickable. If clicked, table fades out and summary of application fades in.
			// summary of application has options to:
				// 1. Make changes (will void approvals by others)
				// 2. request approval by co-authors (if any)
				// 3. if submitted but not approved by fac, send reminder email to faculty sponsor
				// 4. if not approved by IRB admin, send reminder email
	});	
	</script>
</html>
