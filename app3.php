<div id="Protections">
	<div class="panel panel-default"> <!-- uniquely identifiable -->	
		<div class="panel-body form-group"> 		
			<div class="col-sm-12">
				<label>3.1. Will you be recording participants&rsquo; names, email addresses, phone numbers, voices, faces, or any other uniquely identifying information?</label>
				<div><!-- Yes -->
					<label class="radio-inline">
						<input type="radio" class="expand" name="uniqueID" value="1">Yes.
					</label>
					<div class="panel panel-default uniqueID" id="uniqueID1" hidden>
						<div class="panel-body"> <!-- describe unique info -->
							<label>
								3.1.1. Please provide, in language that could be pasted into your informed consent form:
								<ol>
									<li>What personally identifiable information you will be collecting</li>
									<li>Who will have access to it (e.g., just you, faculty supervisor, whole class, etc.)</li>
									<li>By what date that personally identifiable information will be destroyed.</li>
								</ol>
							</label>	
							<div class="panel-body">
								<textarea id="uniqueIDtext" name="uniqueIDtext" class="form-control countable" rows="5"></textarea>			
								<div class="radio">							
									<label>
										<input type="radio" class="expand" data-expand="no" name="collectedInfo" value="1">I will be including the above language in my informed consent form.
									</label>			
								</div>	
								<div class="radio">									
									<label>
										<input type="radio" class="expand" name="collectedInfo" value="0">I will NOT be including the above language in my informed consent form.
									</label>
									<div class="panel panel-default collectedInfo" id="collectedInfo0" hidden>
										<div class="panel-body">
											<label>
												3.1.1.1. Explain why you will not be disclosing the above information in your informed consent form.
											</label>	
											<textarea name="uniqueIDhandling" class="form-control countable" rows="5"></textarea>
										</div>
									</div>	
								</div>								
							</div>					
						</div>
						<div class="panel-body"> <!-- unique info linked to participants' responses? -->
							<label>
								3.1.2. Will the uniquely identifiable information be linked to any other information about the participant (e.g., answers to interview or survey questions)?
							</label>						
							<div>
								<label class="radio-inline">
									<input type="radio" class="expand" name="uniqueLinked" value="1">Yes.
								</label>
								<div class="panel panel-default uniqueLinked" id="uniqueLinked1" hidden>
									<div class="panel-body"> 								
										<label>3.1.2.1. Would public disclosure of a participant&rsquo;s responses pose a risk to the participant&rsquo;s reputation, liability to prosecution, employability, financial standing, or insurability?</label>				
										<label class="radio-inline">
											<input type="radio" class="expand" name="responseRisk" value="1">Yes.
										</label>
										<div class="panel panel-default responseRisk" id="responseRisk1" hidden>
											<div class="panel-body">
												<label>
													3.1.2.1.1. Describe what precautions you will take to minimize the risk of public disclosure. For example, will your data be stored in a location only accessible by you? Will you be securely destroying the data at some specified future date?
												</label>
												<textarea name="publicDisclose" class="form-control countable" rows="5"></textarea>
											</div>
										</div>
										<label class="radio-inline">
											<input type="radio" class="expand" name="responseRisk" value="0">No.
										</label>
									</div>									
								</div>													
								<label class="radio-inline">
									<input type="radio" class="expand" data-expand="no" name="uniqueLinked" value="0">No.
								</label>								
							</div>
						</div>						
					</div>					
					<label class="radio-inline">
						<input type="radio" class="expand" name="uniqueID" value="0">No.
					</label>
				</div>
																	
			</div>
		</div>
	</div> <!-- end uniquely identifiable -->
	<div class="panel panel-default"> <!-- minimal risk -->
		<div class="panel-body">
			<label>
				3.2. Does the study involve a risk of harm or discomfort that is beyond what is encountered in daily life or during the performance of routine physical or psychological tests?
			</label>			
			<label class="radio-inline">
				<input type="radio" class="expand" name="exceedsMinRisk" value="1">Yes.
			</label>
			<div class="panel panel-default exceedsMinRisk" id="exceedsMinRisk1" hidden>
				<div class="panel-body">
					<label>
						Warning:  Studies that exceed minimal risk must be reviewed by the full Institutional Review Board, a process that may take 2-3 weeks. Consider modifying your procedures so that they do not exceed minimal risk. If you wish to proceed with an application for a study that exceeds minimal risk, please describe the risk in your study.
					</label>
						<textarea name="exceedsMinRiskText" class="form-control" rows="5"></textarea>											
				</div>
			</div>											
			<label class="radio-inline">
				<input type="radio" class="expand" name="exceedsMinRisk" value="0">No.
			</label>			
			
		</div>
	</div>
	<div class="panel panel-default"> <!-- privacy -->
		<div class="panel-body">
			<label>
				3.3. Will your data be obtained in a private setting (e.g., restroom, bedroom, etc.), where participants could reasonably expect that they are NOT being observed?  Answer &ldquo;No&rdquo; if your only data collection method is a questionnaire.
			</label>		
			<label class="radio-inline">
				<input type="radio" class="expand" name="privacyProblem" value="1">Yes.
			</label>
			<div class="panel panel-default privacyProblem" id="privacyProblem1" hidden>
				<div class="panel-body">
					<label>
						3.3.1. Explain why this is necessary and how you will address participants&rsquo; concerns about privacy.						
					</label>
					<textarea name="privacyExplain" class="form-control" rows="5"></textarea>						
				</div>
			</div>													
			<label class="radio-inline">
				<input type="radio" class="expand" name="privacyProblem" value="0">No.
			</label>						
		</div>	
	</div>
	<div class="panel panel-default"> <!-- deception -->
		<div class="panel-body">
			<label>
				3.4. Will you be deliberately misleading participants about the topic of your study or about the procedures they will be performing? This includes the use of actors posing as participants.
			</label>		
			<label class="radio-inline">
				<input type="radio" class="expand" name="deception" value="1">Yes.
			</label>
			<div class="panel panel-default deception" id="deception1" hidden>
				<div class="panel-body">
					<label>
						3.4.1. Describe the deception, explain why it is necessary, and describe how you will address participants&rsquo; concerns about the deception.						
					</label>
					<textarea name="deceptionExplain" class="form-control countable" rows="5"></textarea>						
				</div>
			</div>													
			<label class="radio-inline">
				<input type="radio" class="expand" name="deception" value="0">No.
			</label>						
		</div>
	</div>
	<div class="panel panel-default"> <!-- objectionable -->
		<div class="panel-body">
			<label>
				3.5. Will participants be exposed to material that they might find offensive, threatening, or degrading, such as pornography, intense scenes of violence or horror, or racist statements?
			</label>		
			<label class="radio-inline">
				<input type="radio" class="expand" name="objectionable" value="1">Yes.
			</label>
			<div class="panel panel-default objectionable" id="objectionable1" hidden>
				<div class="panel-body">
					<label>
						3.5.1. Describe the objectionable material and what steps you will take to minimize harm to participants.		
					</label>
					<textarea name="objectionableExplain" class="form-control" rows="5"></textarea>						
				</div>
			</div>														
			<label class="radio-inline">
				<input type="radio" class="expand" name="objectionable" value="0">No.
			</label>					
		</div>	
	</div>
	<div class="panel panel-default"> <!-- sensitive -->
		<div class="panel-body">
			<label>
				3.6. Questions are considered &ldquo;sensitive&rdquo; if participants are likely to feel some discomfort in disclosing the information in a face-to-face setting. Example topics include the participants&rsquo; own (1) criminal actions, (2) diseases or disorders, or (3) sexual behavior. Will you be asking questions that meet this definition?
			</label>		
			<label class="radio-inline">
				<input type="radio" class="expand" name="sensitiveQ" value="1">Yes.
			</label>
			<div class="panel panel-default sensitiveQ" id="sensitiveQ1" hidden>
				<div class="panel-body">
					<label>
						3.6.1. Describe the nature of the sensitive questions and how you will minimize participants&rsquo; discomfort.
					</label>
					<textarea name="sensitiveText" class="form-control" rows="5"></textarea>
				</div>
			</div>												
			<label class="radio-inline">
				<input type="radio" class="expand" name="sensitiveQ" value="0">No.
			</label>					
		</div>
	</div>
	<div class="panel panel-default"> <!-- women of childbearing potential -->
		<div class="panel-body">
			<label>
				3.7. Is your sample likely to include women?
			</label>		
			<div>
				<label class="radio-inline">
					<input type="radio" class="expand" data-expand="yes" name="women" value="1">Yes.
				</label>	
				<div class="panel panel-default women" id="women1" hidden>
					<div class="panel-body">
						<label>
							3.7.1. Would any of your procedures pose more than minimal risk to either a pregnant woman or fetus? (e.g., consumption of alcohol or tobacco)
						</label>
						<div>
							<label class="radio-inline">
								<input type="radio" class="expand" name="pregnantRisk" value="1">Yes.
							</label>
							<div class="panel panel-default pregnantRisk" id="pregnantRisk1" hidden>
								<div class="panel-body">
									<label>
										3.7.1.1. Describe these risks and how you will minimize them.
									</label>
									<textarea name="pregnantExplain" class="form-control" rows="5"></textarea>
								</div>
							</div>													
							<label class="radio-inline">
								<input type="radio" class="expand" name="pregnantRisk" value="0">No.
							</label>							
						</div>
					</div>
				</div>													
				<label class="radio-inline">
					<input type="radio" class="expand" name="women" value="0">No.
				</label>
			</div>					
		</div>
	</div>
	<div class="panel panel-default"> <!-- special populations -->
		<div class="panel-body">
			<label>
				3.8. Are any of your participants:
			</label>		
			<div class="checkbox">
				<label>
					<input class="specialPop" name="children" type="checkbox">
					under the age of 18
				</label>
			</div>					
			<div class="checkbox">
				<label>
					<input class="specialPop" name="incarcerated" type="checkbox">
					incarcerated persons
				</label>
			</div>									
			<div class="checkbox">
				<label>
					<input class="specialPop" name="mentallyDisabled" type="checkbox">
					mentally disabled persons
				</label>
			</div>					
			<div class="checkbox">
				<label>
					<input class="specialPop" name="disadvantaged" type="checkbox">
					economically or educationally disadvantaged persons
				</label>
			</div>					
			<div class="checkbox">
				<label>
					<input class="specialPop" name="otherParticipants" type="checkbox">
					Any other groups for whom informed consent is unclear or for whom special protection is required:					
				</label>
				<div>
					<input type="text" class="form-control" name="otherParticipantsText">
				</div>
			</div>				
		</div>
	</div>
</div>