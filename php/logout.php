<?php
	session_start();
	include('utils.php');
	logout();
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
		<title>HC IRB Logout</title>		
	</head>
	<body>
		<div class="container">
			<div class="col-md-10 col-md-offset-1">
				<div class="row">
					<?php include('../navbar.html'); ?>
					<div class="page-header">
						<h2>HC IRB Logout<br>							
						</h2>						
					</div>
					<div class="col-md-6 col-md-offset-3">
						<p>
							You have been logged out of the HC IRB system. To restore your session, please <a href="../index.php">log in.</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>