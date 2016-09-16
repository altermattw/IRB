<?php  
  include('php/SQLutils.php');
if(!isLoggedIn() || !isAdmin()) {		
	header('Location: logout.php');
} else {
	$pageTitle = 'HC IRB Administrator Dashboard';
	include('php/navbar.php');
}  
$year = date("Y"); // 4-digit year (e.g., "2015")
if(isset($_GET["year"])) {
	$year = $_GET["year"];
}
$mysqli = myConnect();
?>

			<h2>
				HC IRB Administrator Dashboard					
			</h2>							
		</div> <!-- end page header -->
	</div> <!-- close row -->									

	<div class="row">		
		<?php
			// compute the current status for each application in a particular year
			// or rely on the 'current' database table

			$statusList = array("Submitted to IRB","IRB Revision","Faculty Sponsor Revision","Submitted to Faculty Sponsor","Co-author Approval","Co-author Revision","Submitted to Co-authors","First Draft","IRB Approval","Withdrawn");
			foreach($statusList as $status) {
				listApps($mysqli,getStatusApps($mysqli,$status),$status);				
			}			
		?>			
	</div>		
</div> <!-- close container -->
	</body>
	<script src="js/ajax.js"></script>
	<script>
	$(document).ready(function(){	
		<?php echo 'var email="'.$_SESSION['userid'].'";'; ?>	
		$("#user").append(email);		
		$(".SubmittedtoIRB").removeClass("btn-primary").addClass("btn-danger");	
	});	
	</script>
</html>
