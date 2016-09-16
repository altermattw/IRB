<?php
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
		<title>New IRB Application</title>
	</head>
	<body>
		<div class="container">
			<div class="col-md-10 col-md-offset-1">
				<div class="row">
					<div class="page-header">
						<h2>Hanover College Institutional Review Board (IRB)<br>
							<small>New Application Form</small>
						</h2>						
							<?php
								if(!isLoggedIn()) {
									echo '<p>Please <a href="../index.php">login</a> to continue</p>';
									echo '</div></body></html>';
									logout();
									die();
								}
							?>
						<p>
						</p>
					</div>
					<div>
						<form name="appForm" id="appForm" role="form" autocomplete="off" action="processNewApp.php" method="post">
							<div class="row">
								<div id="formItems" class="col-md-6 col-md-offset-3">
								</div>					
							</div>
							<div class="row">					
								<div class="text-center">					
									<button type="submit" id="submit" class="btn btn-primary" disabled>Continue</button>
								</div>					
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script>
	$(document).ready(function(){		

		});
	</script>
</html>