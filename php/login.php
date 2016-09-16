<?php
	session_start();	
	include('utils.php');
	$begin = <<<EOT
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
			<title>Hanover College IRB Login</title>			
		</head>
		<body>
			<div class="container">
				<div class="col-md-10 col-md-offset-1">
					<div class="row">
						<div class="page-header">
							<h2>Hanover College Institutional Review Board (IRB)<br>							
							</h2>						
						</div>
						<div class="col-md-6 col-md-offset-3">
EOT;
	$end = '</div></div></div></div></body></html>';
	$fail = '<p>The user name or password was incorrect. Please <a href="../index.php">try again</a>.</p>';	
	$unverified = '<p>Your account has not yet been verified through email. Check your email for a message from do-not-reply@hanover.edu with the subject line &ldquo;HC IRB email verification&rdquo;. That message should contain a link that you can click to verify your account by email. If you continue to have problems, please contact the HC IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].'.</p>';
	if(isset($_POST["email"]) && isset($_POST["password"])) {
		$password = (string) $_POST["password"];
		$email = (string) $_POST["email"];
		// check to see if someone with that email address is already registered
		if(docExists('email',$email,'IRBacc')) {
			$doc = getDoc('email',$email,'IRBacc');
			if(array_key_exists('verified', $doc)) {
				if($doc["verified"]) { // email account has been verified
					if(checkPassword($password,$doc["password"])) { // passwords match!
						$criteria = array('email' => $email);
						$new_object = array('lastLogin' => time());
						updateDoc($criteria,$new_object,'IRBacc');
						validateUser($email);
						header('Location: http://vault.hanover.edu/~altermattw/IRB/php/userDashboard.php');
					} else { // password does not match
						echo $begin.$fail.$end;
						$client->close();
						die();
					}
				} else { // not verified
					echo $begin.$unverified.$end;
					$client->close();
					die();
				}
			} else { // verified field not in record
				echo $begin.$unverified.$end;
				$client->close();
				die();
			}
		} else {
			// nobody in database with that email address
				echo $begin.$fail.$end;
				$client->close();
				die();
		}
	} else {
		echo $begin.'<p>Either the username or password were not transmitted.</p>'.$end;
		$client->close();
		die();
	}

?>


