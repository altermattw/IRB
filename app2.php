<div class="panel panel-default"> <!-- informed consent panel -->	
	<div class="panel-body form-group"> 		
		<div class="col-sm-12">
			<label>2.1. Will you be obtaining informed consent from participants before their participation begins?</label>
			<div class="radio"><!-- Yes -->
				<label>
					<input type="radio" name="infConsent" class="expand" value="1">Yes.
				</label>				
				<div class="panel panel-default infConsent" id="infConsent1" hidden>				
					<div class="panel-body">									
						<label>2.1.1. Please paste the text of your informed consent into the text area below:</label>
						<textarea name="infConsentText" class="form-control countable" rows="5"></textarea>						
						<label>2.1.2. Will you be obtaining participants&rsquo; written signatures on an informed consent form?</label>
						<div><!-- Yes -->
							<label class="radio-inline">
								<input type="radio" class="expand" name="infConsSig" value="1">Yes.
							</label>
							<div class="panel panel-default infConsSig" id="infConsSig1" hidden>
								<div class="panel-body">
									<label>2.1.2.1. Could those signatures pose a risk to participants? That is, if people knew that a particular person was in your study, would that information pose any risk to that person&rsquo;s reputation, liability to prosecution, employability, financial standing, or insurability?  (For example, if all your participants were selected because they reported illegal drug use, their signature on an informed consent form could pose a risk and you should answer &ldquo;Yes&rdquo; to this question.)</label>							
									<div>
										<label class="radio-inline">
											<input type="radio" class="expand alert" name="infConsRisk" value="1">Yes.
										</label>
										<div class="panel panel-default infConsRisk" id="infConsRisk1" hidden>									
											<div class="panel-body">									
												<label>2.1.2.1.1. What steps will you take to ensure that the informed consent forms are not publicly disclosed?</label>
												<textarea id="infConsRiskText" name="infConsRiskText" class="form-control countable" rows="5"></textarea>
												<h5><small>Word Count: <span class="count"></span></small></h5>
											</div>
										</div>													
										<label class="radio-inline">
											<input type="radio" class="expand" name="infConsRisk" value="0">No.
										</label>
									</div>							
								</div>
							</div>				
							<label class="radio-inline">
								<input type="radio" class="expand" name="infConsSig" value="0">No.
							</label>
							<div class="panel-body infConsSig" id="infConsSig0" hidden>
								<label>2.1.2.2. How will you be obtaining informed consent, if not through a signed informed consent form?</label>
								<textarea name="otherInfConsent" class="form-control countable" rows="5"></textarea>					
							</div>
						</div>													
					</div>
				</div>					
			</div>
			<div class="radio"><!-- No -->
				<label>
					<input type="radio" name="infConsent" class="expand" value="0">No.
				</label>
				<div id="infConsent0" class="infConsent" hidden>
					<div class="panel-body"> 
						<label class="control-label">2.1.3. Why will you not be obtaining informed consent? (check all that apply)</label>
						<div class="col-sm-10 checkbox">
							<label>
								<input name="waiveArchival" id="waiveArchival" type="checkbox">
								Study relies on archival data (e.g., homicide records, baseball statistics, etc.)
							</label>
						</div>
						<div class="col-sm-10 checkbox">
							<label>
								<input name="waiveFieldStudy" id="waiveFieldStudy" type="checkbox">
								Informed consent cannot be obtained without jeopardizing the study (e.g., field study, naturalistic observation). Please explain:
							</label>
							<input type="text" class="form-control" name="waiveJeopardize" id="waiveJeopardize">
						</div>
						<div class="col-sm-10 checkbox">
							<label>
								<input name="waiveOther" id="waiveOther" type="checkbox">
								Other:
							</label><input type="text" class="form-control" name="waiveOtherText" id="waiveOtherText">
						</div>
					</div>
				</div> <!-- end waiveInfConsentDiv -->
			</div> <!-- end No -->
		</div> <!-- end col-sm-12 -->
	</div> <!-- end panel-body -->
</div> <!-- end informed consent panel -->
<div class="panel panel-default"> <!-- debriefing panel -->
	<div class="panel-body form-group">
		<div class="col-sm-12">
			<label>2.2. Will you be debriefing your participants at the end of your study?</label>
			<div class="radio"><!-- Yes -->
				<label>
					<input type="radio" class="expand" name="debriefing" value="1">Yes.
				</label>
				<div class="panel panel-default" class="debriefing" id="debriefing1" hidden>				
					<div class="panel-body">									
						<label>2.2.1. Please paste the text of your debriefing into the text area below:</label>
						<textarea name="debriefText" class="form-control countable" rows="5"></textarea>						
					</div>
				</div>		
			</div>
			<div class="radio"><!-- No -->
				<label>
					<input type="radio" class="expand" name="debriefing" value="0">No.
				</label>
				<div id="debriefing0" class="debriefing" hidden>
					<div class="panel-body"> 
						<label class="control-label">2.2.2. Why will you not debrief participants?</label>
						<input type="text" class="form-control" name="whyNoDebriefText" id="whyNoDebriefText">
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- end debriefing panel -->
<div class="col-sm-12"> <!-- links -->
	<div class="panel panel-default form-group">
		<div class="panel-heading">
			<h3 class="panel-title">2.3. Links to webpages (optional)</h3>
		</div>
		<div class="panel-body">									
			If any of your materials (e.g., survey, images) are online, you may paste the URLs (web address, beginning "http://...") to those materials below. Please introduce each link with a sentence.
			<textarea id="links" name="links" class="form-control" rows="3"></textarea>				
		</div>
	</div>
</div> <!-- end links -->
<div class="col-sm-12"> <!-- links -->
	<div class="panel panel-default form-group">
		<div class="panel-heading">
			<h3 class="panel-title">Supporting files</h3>
		</div>		
		<div class="panel-body">
			<?php
				$uploaddir = 'upload/'.$_SESSION["studyNumber"];
				if(!file_exists($uploaddir)) {					
					mkdir($uploaddir);
				}
				if(isset($_GET["delete"])) {
					$fileToDelete = $_GET["delete"];
					if(file_exists($uploaddir.'/'.$fileToDelete)) {
						if(unlink($uploaddir.'/'.$fileToDelete)) {
							echo '<p>'.$fileToDelete.' deleted.</p>';
						} else {
							echo '<p>Error deleting '.$fileToDelete.'. File not deleted.</p>';
						}
					}
				}
			// process newly uploaded files
				if(!empty($_FILES)) {
					if(file_exists($_FILES['userfile']['tmp_name']) || is_uploaded_file($_FILES['userfile']['tmp_name'])) {												
						$uploadfile = $uploaddir . '/'. basename($_FILES['userfile']['name']);
						if(move_uploaded_file($_FILES["userfile"]["tmp_name"],$uploadfile)) {		        
			        echo '<p>File upload successful for '.basename($_FILES['userfile']['name']).'</p>';
			      } else {
			        echo '<p>File upload error: <a href="http://php.net/manual/en/features.file-upload.errors.php">'.$_FILES["userfile"]["error"].'</a></p>';
			      }   
					}
				}
			?>
			<h4>Currently uploaded files</h4>			
			<?php
				// display currently uploaded files					
					if(file_exists($uploaddir)) {
						$iterator = new \FilesystemIterator($uploaddir);
						if(!$iterator->valid()) {
							echo '<p>No files uploaded</p>';
						} else {
							echo '<ol>';
							foreach(glob('upload/'.$_SESSION["studyNumber"].'/*.*') as $file) {
						    echo '<li><a href="'.$file.'">'.basename($file).'</a> <button type="button" id="'.basename($file).'" class="deleteFile btn btn-danger btn-sm">delete</button>';
						    echo '<br>Filesize: '.filesize($file);
						    echo '<br>Last modified: '.date("F d, Y H:i:s", filemtime($file)).'</li>';
						    // add a button to delete the file
						    
							}	
							echo '</ol>';				
						}	
					} else {
						echo '<p>No files uploaded</p>';
					}					
			?>			
		</div>
		<div class="panel-body">
			<h4>Upload new file</h4>
			<p>To upload a file, select the filename using the button below and then click the Save button at the bottom of the page. You should see the uploaded file added to the list above. If the uploaded file has the same name as a previously uploaded file, the previously uploaded file will be replaced.</p>
			<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
			<input id="fileupload" type="file" name="userfile">
		</div>
	</div>
</div>