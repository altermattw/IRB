<?php
	include('php/SQLutils.php');
	$pageTitle = 'Hanover College IRB';
	include('php/navbar.php');
	$WM = getWM();
	$chair = getChair();
?>
		<h2>Hanover College Institutional Review Board (IRB)<br>
			<small>IORG #0006298, FWA #00015470</small>
		</h2>
	</div> <!-- close page header-->
</div> <!-- close row -->
<div class="row">
	<div class="col-md-8">
		<p>The Hanover College IRB is responsible for approving, requiring modifications in (to secure approval), or disapproving all research activities involving human subjects conducted by representatives of Hanover College. For more information, see the <a href="overview.php">Overview</a>. For a full description of the IRB&rsquo;s procedures, see the <a href="pdf/WrittenProceduresForIRB.pdf" target="_blank">Written Procedures</a>. Questions? Contact the current chair of the IRB, <?php echo $chair["name"]; ?>, at <?php $chair["email"]; ?>.</p>
	</div>
</div>
<div class="row">
	<div class="col-md-8" id="procedure">
		<h3>
			Application Procedure
		</h3>
		<p>
			All research involving human participants that is conducted by students, employees, or faculty of Hanover College must first be approved by the Institutional Review Board. To submit an application to the Board, please <a href="register">register</a> with the IRB to set up an account, and then <a href="login.php">login</a> to begin working on your application. For questions or problems with this website, please contact Bill Altermatt at altermattw@hanover.edu. For questions about the application or review process, please contact Dean Jacks at jacks@hanover.edu.
		</p>
		<p>
			You <strong>may not begin data collection</strong> until you have received notification from the IRB that your study has been approved.
 		</p>
	</div>
</div> <!-- close row -->
</div> <!-- close container -->
</body>
</html>
