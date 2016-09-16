<?php 
	session_start();
	$pageTitle = "IRB Dashboard";
	include('php/SQLutils.php');
	include('php/navbar.php');
	if(!isLoggedIn()) {
			echo '<p>Please <a href="login.php">login</a> to access this page.</p>';
			die();
		}
?>
						<h2>Hanover College Institutional Review Board (IRB)<br>
							<small>Dashboard</small>
						</h2>						
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<!-- big button to begin new application -->
					</div>
				</div>
				<div class="row">
					<div class="col-md-10 col-md-offset-1" id="recentActivity"> <!-- Recent Activity -->
						<!-- Put this in a scrollable window -->
					</div> <!-- End recent activity -->
				</div>
<?php
	if(isAdmin()) {		
		echo '<div class="row"><div class="col-sm-12" id="adminTable">';
			// Which year [$displayYear] to display?
				// Scan tables in database, looking for ones that begin "year". Get array of unique years ($years).
				// Scan for $_GET["year"] field.
					if(isset($_GET["year"]) && ($_GET["year"] %in% $years)) { // request coming through for most recent year, and that year is in the DB
						$displayYear = $_GET["year"];
					} else {
						$displayYear = max($years); // display the most recent year's data
					}
			// Scan for $_GET["closed"] field. Does admin want to see closed apps, too?
				if(isset($_GET["closed"]) && $_GET["closed"]) { // request to see closed apps
					$retrieve="";
				} else {
					$retrieve=" WHERE status <=4"; // 1-4 are active. 5 is approved and 6 is withdrawn
				}

			// Build query
				$query = 'SELECT studyNumber, title, versionNumber, status, statusChangeDate, authorNames, authorEmails, dateCreated, dateLastSaved, sponsorName, sponsorEmail   FROM year'.$displayYear.$retrieve.' ORDER BY status DESC, statusChangeDate';			
				// sorted so highest status (IRB review stage) first, with oldest apps at the top

		echo '</div>';
	}
?>	
				<div class="row">
					<div class="col-sm-12" id="myApplications"> <!-- User's applications -->
					</div> <!-- end user's applications -->
				</div>
			</div>
		</div>
	</body>
	<script>
	$(document).ready(function(){	

		// filtering / sorting the applications table

	});
	</script>
</html>