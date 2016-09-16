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
		<title>HC IRB Account Info</title>			
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
								HC IRB User Account Information					
							</h2>							
						</div>
					</div>						
				</div>
			</div>
			
									
			<div class="row">			
				<div id="accountInfo" class="col-md-5">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Account Info 
						<button class="btn btn-sm" id="editAccount">Edit</button>
						<button class="btn btn-sm btn-success" type="submit" id="saveEdit">Save</button>
						<button class="btn btn-sm btn-warning" id="cancelEdit">Cancel</button>
							</h4>
						</div>
						<div class="panel-body">					
							<table class="table" id="Account">
							</table>
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
		// Account Information Table
			var accountFields={lastName: "Last Name", firstName: "First Name", status: "Status" };
			var tText="";
			$.each(accountFields, function (key,value) {
				tText+='<tr><th>'+value+'</th><td id="'+key+'"></td></tr>';
			});		
			$("#Account").html(tText);
			// populate table with values from user account
				getAccount(email);		
		$("#saveEdit").hide();
		$("#cancelEdit").hide();
		// function changeListen(key) {
		// 	$("#edit"+key).keydown(function() {
		// 		$("#submitEdit"+key).prop('disabled', false);
		// 	});
		// }

		function editAccount() {
			$.each(accountFields, function (key,value) {
				var oldValue = $("#"+key).html();				
				$("#"+key).html('<input type="text" name="'+key+'" id="edit'+key+'" value="'+oldValue+'">');			
				});			
			$("#editAccount").hide();
			$("#saveEdit").show();
			$("#cancelEdit").show();	
		}
		function saveEdit() {
			var new_object = {};
			$.each(accountFields, function (key,value) {
				new_object[key]=$("#edit"+key).val();
			});	
			console.log(email,new_object);		
			updateAccountInfo(email,new_object);	
			// grab the new values and put them into the table
			var data = {};
			$.each(accountFields, function (key,value) {
				data[key] = $("#edit"+key).val();
			});			
			fillHTML(data);		
			$("#editAccount").show();
			$("#saveEdit").hide();
			$("#cancelEdit").hide();			
		}
		$("#editAccount").on("click", function() {
			editAccount();		
			return false;
		});
		$("#saveEdit").on("click", function() {
			saveEdit();		
			return false;
		});
		$("#cancelEdit").on("click", function() {
			getAccount(email);
			$("#editAccount").show();
			$("#saveEdit").hide();
			$("#cancelEdit").hide();
			return false;
		});	
	});	
	</script>
</html>
