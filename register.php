<?php 	
	$pageTitle = "Register with Hanover IRB";
	include('php/SQLutils.php');
	include('php/navbar.php');	
?>
						<h2>Hanover College Institutional Review Board (IRB)<br>
							<small>Registration Form</small>
						</h2>
						<p>
							Before you can submit an application for research involving human subjects, you will need to create an account with the IRB. This process requires that you have an @hanover.edu email account. If you do not, please contact the chair of the IRB, Dean Jacks, at jacks@hanover.edu.  
						</p>
					</div>
				</div>
				<div class="row">
					<div id="registerForm" class="col-md-6">
						<form name="regForm" id="regForm" role="form" autocomplete="off" action="regProcessor.php" method="post">
							<div class="row">
								<div id="formItems">
								</div>					
							</div>
							<div class="row">					
								<div class="text-center">					
									<button type="submit" id="submit" class="btn btn-primary">Continue</button>
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
		// form checking functions

		var passT, emailT, name1T, name2T;
		passT = emailT = name1T = name2T = false;
		var checkPass = function() {			
			// password
			
			if (($("#password").val() !== $("#passReg2").val()) || $("#passReg2").val().length < 7)  {
				// passwords don't match				
				$(":password").parent().addClass('has-error').removeClass('has-success');				
				$("#passWarn").show();
				passT = false;
			} else {
				// passwords match				
				$(":password").parent().addClass('has-success').removeClass('has-error');				
				$("#passWarn").hide();
				passT = true;
			}
			checkForm();
		}

			// email
		var checkEmail = function() {			
			var email = $("#email").val();	
			var syntax = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@hanover.edu$/;			
			if(!syntax.test(email)) {
				$("#emailWarn").show();
				$("#email").parent().addClass("has-error");
				emailT = false;
			} else {
				$("#emailWarn").hide();
				$("#email").parent().removeClass("has-error");
				emailT = true;
			}
			checkForm();
		}

			// names
		var checkName = function() {
			if($("#lastName").val().length > 0) {name1T = true} else {name1T = false};
			if($("#firstName").val().length > 0) {name2T = true} else {name2T = false};
			checkForm();
		}

					
			// checking overall form
		var checkForm = function() {
			if ([passT, emailT, name1T, name2T, statusT].every(function(i) {return i === true; })) {
				$("#submit").prop('disabled', false);
			} else 
				{
					$("#submit").prop('disabled', true);
				}
		}

		// setting up form elements to insert

		var regQuestions = {
					lastName: ["text", "Last Name"],
					firstName: ["text", "First Name"],
					email: ["email", "Email address"],
					password: ["password", "New Password"],
					passReg2: ["password", "Re-enter Password"]
				}				
				
		var formIns = [];
		$.each(regQuestions, function(key, val) {
			formIns.push('<div class="form-group"><label for="'+key+'">'+val[1]+'</label><input type="'+val[0]+'" class="form-control login" id="'+key+'" name="'+key+'" placeholder="'+val[1]+'" required></div>');
		});
				
		// adding elements to form

		$("#formItems").append(formIns.join(""));
		<?php 
			$chair = getChair();
			echo 'var chair="'.$chair["name"].' at '.$chair["email"].'";';
		?>
		$("#email").parent().append('<div id="emailWarn" hidden><small>Please use your @hanover.edu address. If you do not have one, contact '+chair+'</small></div>');
		$("#passReg2").parent().append('<div id="passWarn" hidden><small>Passwords do not match or password is fewer than 7 characters.</small></div>');

		// adding listeners

		$(":password").blur(checkPass).focus(checkPass);
		$("#email").blur(checkEmail);
		$("#lastName").blur(checkName).focus(checkName);
		$("#firstName").blur(checkName).focus(checkName);		
	});
	</script>
</html>