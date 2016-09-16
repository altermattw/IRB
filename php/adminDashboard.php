<?php
session_start();
include('php/utils.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width">				 
  	<link href="/~altermattw/css/bootstrap.css" rel="stylesheet" media="screen">
  	<link href="/~altermattw/css/bootstrap-theme.css" rel="stylesheet" media="screen">
  	<link href="/~altermattw/css/styles.css" rel="stylesheet" media="screen">
		<script src="/~altermattw/js/jquery-1.10.2.min.js"></script>
		<script src="/~altermattw/js/bootstrap.min.js"></script>		
		<title>HC IRB Administrator Dashboard</title>			
	</head>
	<body>
		<div class="container">
			<div class="row"> <!-- todo: put these inside a nav bar at the top? -->
				<div class="col-md-2">
					<p>Username: <span id="userid"></span></p>
				</div>
				<div class="col-md-2">
					<p>Last login: <span id="lastLogin"></p>
				</div>
				<div class="col-md-2 pull-right">
					<button type="button" id="logoutButton" class="btn btn-primary btn-sm">Logout</button>
				</div>
			</div>
			<div class="row">
				<div class="page-header col-md-10 col-md-offset-1">									
					<h2 class="text-center">HC IRB Administrator Dashboard<br>							
					</h2>						
				</div>	
			</div>
			<div class="row">			
						<?php
						// if(!isLoggedIn()) {
						// 	echo '<p>Please <a href="login.html">login</a> to continue</p>';
						// 	echo '</div></div></body></html>';
						// 	logout();
						// 	die();
						// }
						?>
				<div id="Applications">
					<h3>Applications</h3>
				</div>
			</div>
		</div>
	</body>
	<script>
	$(document).ready(function(){
		// ajax request to get last login
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
