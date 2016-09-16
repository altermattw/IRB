<?php	
	include('php/SQLutils.php');
	$pageTitle = 'Hanover College IRB';
	include('php/navbar.php');
?>
		<h2>Hanover College Institutional Review Board (IRB)<br>
			<small>IORG #0006298, FWA #00015470</small>
		</h2>
	</div> <!-- close page header-->
</div> <!-- close row -->
<div class="row">
	<div class="col-md-8">
		<p>The Hanover College IRB is responsible for approving, requiring modifications in (to secure approval), or disapproving all research activities involving human subjects conducted by representatives of Hanover College. For more information, see the <a href="overview.php">Overview</a>. For a full description of the IRB&rsquo;s procedures, see the <a href="pdf/WrittenProceduresForIRB.pdf" target="_blank">Written Procedures</a>. Questions? Contact the current chair of the IRB, <?php echo $IRBchair["name"]; ?>, at <?php echo $IRBchair["email"]; ?>.</p>
	</div>				
</div>
<div class="row">						
	<div class="col-md-8" id="procedure">
		<h3>
			Application Procedure
		</h3>
		<p>
			All research involving human participants that is conducted by students, employees, or faculty of Hanover College must first be approved by the Institutional Review Board. To submit an application to the Board, please follow the steps below. For questions about the application or review process, please contact Dean Jacks at jacks@hanover.edu. For questions or problems with this website, please contact Bill Altermatt at altermattw@hanover.edu.
		</p>
		<ol>
			<li>
				<a href="pdf/HumanSubjectsApprovalForm.pdf" target="_blank">Download the PDF application form.</a>
			</li>
			<li>
				Part I of that form (&quot;Description of the Research&quot;) requires you to answer several questions on separate pages, including the title of your project, a brief description, etc. Be sure to attach those pages to your application. <a href="pdf/informed_consent_debriefing.pdf" target="_blank">Click here for a sample informed consent and debriefing page.</a>
			</li>
			<li>
				Complete the checklist in Part II (&quot;Determination of Exempt from Review&quot;) by circling &quot;Y&quot; or &quot;N&quot; to each question. If you answer &quot;Y&quot;, you will need to attach an explanation of why your study meets that criterion and what steps you will take to protect participants. If your study qualifies for Exempt status, proceed to Part IV.
			</li>
			<li>
				If your study does not qualify for Exempt status, complete the checklist in Part III. If your study involves <a href="pdf/ResearchInvolvingDrugsorMedicalDevices.pdf" target="_blank">Drugs or Medical Devices, complete and attach that supplemental form</a>.
			</li>
			<li>
				Read Part IV and have <strong>each researcher</strong> sign and date the form. If the study is a student project, the faculty supervisor must also sign and date the form at the bottom.
			</li>
			<li>
				Send the completed form and all attachments to Dean Jacks, chair of the IRB, through campus mail or at his office in 218 Science Center.
			</li>
			<li>
				You <strong>may not begin data collection</strong> until you have received notification from the IRB that your study has been approved.
			</li>
		</ol>
	</div>						
</div> <!-- close row -->				
</div> <!-- close container -->
</body>	
</html>