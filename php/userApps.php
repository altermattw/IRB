<?php
session_start();
include('utils.php');
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
		<title>HC IRB Dashboard</title>			
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div id="navigationBar">
					<?php include('../userNavbar.html'); ?>
				</div>			
			</div>
			<?php
				if(!isLoggedIn()) {
					echo '<p>Please <a href="../index.php">login</a> to continue</p>';
					echo '</div></body></html>';
					logout();
					die();
				}
			?>
			
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-8">
						<div class="page-header">									
							<h2>
								HC IRB Applications					
							</h2>
							<?php
								if (isAdmin()) {
									echo '<a class="btn btn-primary btn-block" role="button" href="#" id="adminPage">Go to Administrator Page</a>';
								}
							?>
						</div>
					</div>						
				</div>
			</div>
			
									
			<div class="row">

				<div id="applications" class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Applications</h4>
						</div>
						<div class="panel-body">
							<div class="col-md-4">
								<a class="btn btn-primary btn-block" role="button" href="app1.php?new=true" id="newApplication">Start New Application</a>
							</div>
						</div>
					</div>
				</div>							
					
			</div>
		</div>
	</body>
	<script src="../js/ajax.js"></script>
	<script>
	$(document).ready(function(){	
		<?php echo 'var email="'.$_SESSION['userid'].'";'; ?>	
		$("#user").append(email);	
		
	});	
	</script>
</html>
