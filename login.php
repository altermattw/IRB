<?php
	// This page is both the form for logging in and the script for processing that login.	
	include('php/SQLutils.php');	
	$WM = getWM();
	$begin = '<h2>Hanover College Institutional Review Board (IRB) Email Verification</h2></div>';
	$end = '</div></div></body></html>';
	$fail = '<p>The user name or password was incorrect. Please <a href="login.php">try again</a>.</p>';	
	
	if(isset($_GET["requestVerification"])) {
		$email = $_GET["requestVerification"];
		echo $begin.mailVerification($email).$end; // prints feedback on whether a request to resend the email verification link has worked.
		die();
	}

	if(isset($_POST["email"]) && isset($_POST["password"])) { // Login info incoming!
		$password = (string) $_POST["password"];
		$email = (string) $_POST["email"];
		$unregistered = '<p>That email ('.$email.') is not in the IRB database. If you have not yet registered, you must do that before you can log in: <a href="register.php">Click here to register</a>. If you have already registered, please check the spelling of your email address and <a href="login.php">try again</a>. If you continue to have problems, please contact the HC IRB webmaster, '.$WM["name"].', at '.$WM["email"].'.</p>';
		$unverified = '<p>Your account has not yet been verified through email. Check your email for a message from do-not-reply@hanover.edu with the subject line &ldquo;HC IRB email verification&rdquo;. That message should contain a link that you can click to verify your account by email. If you would like to receive a new email verification message, <a href="login.php?requestVerification='.$email.'">click here.</a> If you continue to have problems, please contact the HC IRB webmaster, '.$WM["name"].', at '.$WM["email"].'.</p>';	
		// check to see if someone with that email address is already registered
		$mysqli = myConnect(); // from SQLutils
		if(userExists($email,$mysqli)) { // from SQLutils			
			$row = getUserRecord($email,$mysqli); // $row is an associative array			
			if(array_key_exists('validated', $row)) {				
				if($row["validated"] == 1) { // email account has been verified					
					if(checkPassword($password,$row["password"])) { // passwords match!
						updateLastLogin($email,$mysqli);
						validateUser($email);
						header('Location: userDashboard.php');
					} else { // password does not match
						$pageTitle = 'Hanover College IRB Login';
						include('php/navbar.php');						
						echo $begin.$fail.$end;
						mysqli_close($mysqli);
						die();
					}
				} else { // not verified
					$pageTitle = 'Hanover College IRB Login';
					include('php/navbar.php');
					echo $begin.$unverified.$end;
					mysqli_close($mysqli);
					die();
				}
			} else { // verified field not in record
				$pageTitle = 'Hanover College IRB Login';
				include('php/navbar.php');
				echo $begin.$unverified.$end;
				mysqli_close($mysqli);
				die();
			}
		} else {
			// nobody in database with that email address
				$pageTitle = 'Hanover College IRB Login';
				include('php/navbar.php');				
				echo $begin.$unregistered.$end;
				mysqli_close($mysqli);
				die();
		}
	} else { // login information not coming; display login form
		$pageTitle = 'Hanover College IRB Login';
		include('php/navbar.php');
	}

?>
		<h2>Hanover College Institutional Review Board (IRB) Login<br>							
					</h2>						
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">				
					<div id="loginForm">
							<div class="panel panel-default col-sm-12">
								
									<h3>Login</h3>									
									<p><small>If you have not yet registered with the IRB, you can do so <a href="register.php">here</a></small></p>
							
								<div class="panel-body">							
									<form name="logForm" id="logForm" role="form" action="login.php" method="post">
										<div class="form-group">
									    <label for="email">Email address</label>
									    <input type="email" class="form-control login" id="email" name="email" placeholder="Enter email">
									  </div>
									  <div id="emailError" hidden><p><small>Only email addresses ending in @hanover.edu are accepted</small></p></div>
								    <div class="form-group">
									    <label for="password">Password</label>
									    <input type="password" class="form-control login" id="password" name="password" placeholder="Password">
									  </div>
									  <div id="passWarn" hidden><small>Password is fewer than 7 characters.</small></div>
									  <div><p><small>If you&rsquo;ve forgotten your password, <a id="reset" href="resetPassword.html">click here</a></small></p></div>
									  <div class="row">					
											<div class="text-center">					
												<button type="submit" id="submit" class="btn btn-primary">Continue</button>
											</div>					
										</div>
									</form>
								</div>
							</div>
						</div>
					</body>
					<script>
	$(document).ready(function(){

		// var checkform = function() {
		// 	if ($("#password").val().length < 7)  {							
		// 		$(":password").parent().addClass('has-error').removeClass('has-success');				
		// 		$("#passWarn").show();
		// 		return false;
		// 	} else {
		// 	// 	var email = $("#email").val();
		// 	// 	var syntax = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@hanover.edu$/;						
		// 	// 	var passed = syntax.test(email);			
		// 	// 	if(!passed) return false;
		// 	// } else {
		// 		return true;
		// 	}
		// }

		// }

		// var passT, emailT;
		// passT = emailT = false;	
		
		// var checkEmail = function()	{
			
		// }

		// var checkPass = function() {			
			
		// 		passT = false;
		// 	} else {								
		// 		$(":password").parent().addClass('has-success').removeClass('has-error');				
		// 		$("#passWarn").hide();
		// 		passT = true;
		// 	}
		// 	checkForm();
		// }
		// var checkForm = function() {
		// 	if ([passT, emailT].every(function(i) {return i === true; })) {
		// 		$("#submit").prop('disabled', false);
		// 	} else 
		// 		{
		// 			$("#submit").prop('disabled', true);
		// 		}
		// }
		
		// // $("#reset").on("click", function() {
		// // 	// check to see if email field is filled		
		// // 	if(!checkEmail()) {
		// // 		$("#emailError").show();
		// // 	} else {				
		// // 		var email = $("#email").val();
		// // 		window.open('http://vault.hanover.edu/~altermattw/dev/IRB/reset.php?reset=true&email='+email, '_self');
		// // 	}
		// // });
		// $("#email").blur(function() {
		// 	if (!checkEmail()) {
		// 		$("#emailError").show();
		// 		$("#email").parent().addClass('has-error').removeClass('has-success');
		// 		emailT = false;
		// 		checkForm();
		// 	} else {
		// 		$("#emailError").hide();
		// 		$("#email").parent().addClass('has-success').removeClass('has-error');
		// 		emailT = true;
		// 		checkForm();
		// 	}
		// });
		// checkForm();		
		// $("#password").blur(checkPass);
		// $("#password").keypress(checkPass);
		// $("#password").keyup(checkPass);

	});
	</script>
</html>
	

