<?php
session_start();
if(!isset($_SESSION['page']) || $_SESSION['page'] < 2) $_SESSION['page'] = 2;
include('utils.php');
if(!isLoggedIn()) { // not logged in
		echo 'Before you can begin an application, you first need to <a href="../index.php">log in</a>. Please contact the IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].' if you have questions.</p>';
		die();									
}
if(!isset($_SESSION['app'])) { // this is a new application
	$_id = new MongoId();
	echo $_id;
}
// initialize new application in database
	// catch incoming $_POST data	
	// collection will be the 4-digit year
		$collYear = date('Y',time());
	// add reference to application in primary author's IRBacc
		// use MongoID?




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
		<title>IRB App Page 2</title>
	</head>
	<body>
		<div class="container">
			<div class="col-md-10 col-md-offset-1">
				<div class="row">
					<?php include('../userNavbar.html'); ?>
					<div class="page-header">
						<h2>Hanover College Institutional Review Board (IRB)<br>
							<small>New Application - Page 2</small>
						</h2>
						<p>
							<?php
								if(!isLoggedIn()) { // not logged in
									echo 'Before you can begin an application, you first need to <a href="../index.php">log in</a>. Please contact the IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].' if you have questions.</p>';
									echo '</div></div></div></div></body></html>';
									die();									
								}
							?>							
							At any time, you should feel free to contact the chair of the IRB, <?php echo $IRBchair["name"]; ?>, at <?php echo $IRBchair["email"]; ?> if you have questions.
						</p>
					</div>
					<div id="newApp">
						<form name="IRBapp" id="IRBapp" role="form" autocomplete="off" action="php/newApp3.php" method="post">
							<div class="row">
								<div id="formItems" class="col-md-6">
								</div>	
							</div>								
							<div class="row">					
								<div class="text-center">					
									<button type="submit" id="submit" class="btn btn-primary">Save</button>
								</div>					
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>	
	<script src="../js/utils.js"></script>
	<script>
	$(document).ready(function(){	
		// adding user id to nav bar
		<?php echo 'var email="'.$_SESSION['userid'].'";'; ?>	
		$("#user").append(email);	
		// setting up form elements to insert	
	});
	</script>
</html>