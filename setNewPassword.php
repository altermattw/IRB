<?php
	// Note: This is a form where the user enters their new password.
	// They should arrive here after clicking a link in their email.
	// The form passes the information along to changePassword.php
	include('php/SQLutils.php');
	$pageTitle = 'Hanover College IRB Set New Password';
	include('php/navbar.php');
?>

						<p>
							<?php
								if(!isset($_GET["email"]) || !isset($_GET["hash"])) {
									echo 'There was a problem retrieving your email address. Please check your email for the link to reset your password and try clicking it or  pasting the link into your browser again. If you continue to have trouble, please contact the IRB webmaster, '.$IRBwebmaster["name"].', at '.$IRBwebmaster["email"].'.';
									echo '</p></div></div></div></div></body></html>';
									die();
								} else {
									$email = $_GET["email"];
									$hash = $_GET["hash"];
								}
							?>
							To change your password, enter a new password in the boxes below and click the Continue button.
						</p>
					</div>			
					<div id="registerForm">
						<form name="regForm" id="regForm" role="form" autocomplete="off" action="changePassword.php" method="post">
							<input type="hidden" name="email" value="<?php echo $email; ?>">
							<input type="hidden" name="hash" value="<?php echo $hash; ?>">
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
		// building the form:
			var regQuestions = {					
						password: ["password", "New Password"],
						passReg2: ["password", "Re-enter Password"]
					}		
			var formIns = [];
			$.each(regQuestions, function(key, val) {
				formIns.push('<div class="form-group"><label for="'+key+'">'+val[1]+'</label><input type="'+val[0]+'" class="form-control login" id="'+key+'" name="'+key+'" placeholder="'+val[1]+'" required></div>');
			});
			$("#formItems").append(formIns.join("")); // actually inserting the form elements
			$("#passReg2").parent().append('<div id="passWarn" hidden><small>Passwords do not match or password is fewer than 7 characters.</small></div>');

		// checking if passwords match
		var checkPass = function() {						
			if (($("#password").val() !== $("#passReg2").val()) || $("#passReg2").val().length < 7)  {
				// passwords don't match				
				$(":password").parent().addClass('has-error').removeClass('has-success');				
				$("#passWarn").show();
				$("#submit").prop('disabled', true);
			} else {
				// passwords match				
				$(":password").parent().addClass('has-success').removeClass('has-error');				
				$("#passWarn").hide();
				$("#submit").prop('disabled', false);
			}			
		}
				
		// set listener for changes to password
		$(":password").blur(checkPass).focus(checkPass).keyup(checkPass);
	</script>
</html>