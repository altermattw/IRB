<?php 
	include('php/SQLutils.php');
	$pageTitle = 'HC IRB Email Verification';
	include('php/navbar.php');
?>

	
						<h2>Hanover College Institutional Review Board (IRB)<br>
							<small>Contact Information</small>
						</h2>
						<p>
							For questions about IRB policies and procedures, please contact the chair of the IRB, <?php echo $IRBchair["name"]; ?>, at <?php echo $IRBchair["email"]; ?>.  For questions about this website, please contact <?php echo $IRBwebmaster["name"]; ?> at <?php echo $IRBwebmaster["email"]; ?>.
						</p>
					</div>
				</div>				
			</div>
		</div>
	</body>	
</html>