	<div class="Author"> <!-- author -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Author 1</h3>
      </div>
      <div class="panel-body">
        <div class="form-group authorName">                            
          <label for="5Author1A" class="col-sm-2 control-label">Name: </label>
          <div class="col-sm-10">
            <input type="text" id="5Author1A" name="5Author1A" Placeholder="Name" class="form-control">
          </div>
        </div>		                    	                    
        <div class="form-group authorEmail">                            
          <label for="5Author1D" class="col-sm-2 control-label">Email: </label>
          <div class="col-sm-10">
            <input type="text" id="5Author1D" name="5Author1D" Placeholder="Email" class="form-control">
          </div>
        </div>
        <div id="moreAuthors" class="col-sm-10 col-sm-offset-2">
          <button type="button" id="addAuthor" class="btn btn-primary btn-default">
            Add Author
          </button>              
          <button type="button" id="remAuthor" class="btn btn-primary btn-warning" style="display: none;">
            Remove Author
          </button>
        </div>              
      </div>                       
    </div>
  </div>		               
  <div class="panel panel-default"> <!-- supervisor -->
		<div class="panel-heading">
        <h3 class="panel-title">Faculty Supervisor</h3>
      </div>		                  
      <div class="panel-body">
        <div class="form-group">
        	<label for="sponsorName" class="col-sm-2 control-label">Name: </label>
          <div class="col-sm-10">
            <input type="text" id="sponsorName" name="sponsorName" Placeholder="Name of Faculty Supervisor" class="form-control" >
          </div>		                      
        </div>
        <div class="form-group">
        	<label for="sponsorEmail" class="col-sm-2 control-label">Email: </label>
          <div class="col-sm-10">
            <input type="text" id="sponsorEmail" name="sponsorEmail" Placeholder="Email of Faculty Supervisor" class="form-control" >
          </div>		                      
        </div>							
			<div class="col-sm-10 col-sm-offset-2 checkbox">
				<label>
					<input id="facultyProject" name="facultyProject" type="checkbox">Faculty project; no supervisor
				</label>
			</div>
		</div>								
	</div>	
	<div class="form-group"> <!-- title -->
		<label for="title" class="col-sm-2 control-label">Title of Study</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="title" id="title" placeholder="Title">
			<!-- TODO:  max length:  150 characters -->
			<!-- TODO:  auto populate first author info with user info -->
		</div>								
	</div>		
	<div class="panel panel-default"> <!-- for a class? -->	
		<div class="panel-body form-group"> 		
			<div class="col-sm-12">
				<label>Is this project for a class?</label>
				<div class="radio">
					<label>
						<input type="radio" class="forClass" name="forClass" value="0">No, it is not for a class.
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" class="forClass" name="forClass" value="1">Yes, it is for a class.
					</label>
				</div>								
			</div>
			<div id="forClassDiv" class="col-sm-12" hidden> 
				<label for="courseDept" class="col-sm-2 control-label">What class is this for?
				</label>
				<div class="col-sm-3">
					<select class="form-control" name="courseDept">
						<?php 
						$courses = array("prefix","PSY","SOC","KIP","COM","---","ANTH","ART","ARTH","AST","BIO","BSP","CHE","CLA","COM","CS","ECO","EDU","ENG","ENV","FRE","GEO","GER","GW","GRE","HC","HF","HFA","HMS","HIS","ID","INS","KIP","LAT","MAT","ML","MS","MUS","PHI","PHY","PLS","PSY","SOC","SPA","THR","THS"); 
						foreach($courses as $course) {
							echo '<option>'.$course.'</option>'.PHP_EOL;
						}
						?>							  
					</select>
				</div>
				<div class="col-sm-3">
					<input type="text" class="form-control" name="courseNum" id="courseNum" placeholder="course num">
				</div>
			</div>
		</div>			
	</div>
	<div class="form-group"> <!-- maxMinutes & sampleSize -->
		<label for="maxMinutes" class="col-sm-3 control-label">Maximum number of minutes required per subject</label>
		<div class="col-sm-2">
			<input type="text" class="form-control" name="maxMinutes" id="maxMinutes" placeholder="Minutes">
			<!-- TODO:  validate:  integer, min 1, max 600 (10 hours) -->									
		</div>								
	 <!-- sampleSize --> 
		<label for="sampleSize" class="col-sm-3 control-label">What is the expected size of your sample?</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" name="sampleSize" id="sampleSize" placeholder="Sample size">
			<!-- TODO:  validate:  integer, min 1, max 5000 -->	
		</div>								
	</div>
	<div class="panel panel-default"><!-- recruitment -->
		<div class="panel-body"> 
			<label>How will you be recruiting participants? Check all that apply:</label>
			<div class="col-sm-10 col-sm-offset-1 checkbox">
				<label>
					<input name="recruitPersonal" id="recruitPersonal" type="checkbox">
					Personal friends and acquaintances of researcher
				</label>
			</div>
			<div class="col-sm-10 col-sm-offset-1 checkbox">
				<label>
					<input name="recruitExtra" id="recruitExtra" type="checkbox">
					Students receiving extra credit in a class for participating in studies
				</label>
			</div>
			<div class="col-sm-10 col-sm-offset-1 checkbox">
				<label>
					<input name="recruitSocialMedia" id="recruitSocialMedia" type="checkbox">
					Invitation posted on personal social media account
				</label>
			</div>
			<div class="col-sm-10 col-sm-offset-1 checkbox">
				<label>
					<input name="recruitRandom" id="recruitRandom" type="checkbox">
					Email invitation sent to random students at Hanover
				</label>
			</div>
			<div class="col-sm-10 col-sm-offset-1 checkbox">
				<label>
					<input name="recruitGroup" id="recruitGroup" type="checkbox">
					Invitation sent to particular group
				</label>
				<div id="recruitGroupDiv" class="form-group" hidden>		
					<label for="recruitGroupText" class="col-sm-3 control-label">Describe the group(s):</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="recruitGroupText" id="recruitGroupText" placeholder="Groups">
					</div>
				</div>														
			</div>
			<div class="col-sm-10 col-sm-offset-1 checkbox">
				<label>
					<input name="recruitNot" id="recruitNot" type="checkbox">
					Naturalistic observation or field study
				</label>
			</div>	
			<div class="col-sm-10 col-sm-offset-1 checkbox form-inline">
				<label>
					<input name="recruitOther" id="recruitOther" type="checkbox">
					Other: <input type="text" class="form-control" name="recruitOtherText" id="recruitOtherText">
				</label>																			
			</div>	
		</div>								
	</div>
	<div class="panel panel-default"> <!-- multiSession -->
		<div class="panel-body form-group"> 
			<div class="col-sm-10">
				<label>Multiple sessions?</label>
				<div class="radio">
					<label>
						<input type="radio" class="multiSession" name="multiSession" value="0">Participants will complete the study in a single session.
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" class="multiSession" name="multiSession" value="1">Participants will complete the study in more than one session.
					</label>
				</div>								
			</div>
			<div id="multiSessionDiv" class="col-sm-12" hidden> 
				<div class="panel panel-body">
					<label for="multiSessionExp" class="control-label">Describe the multiple sessions</label>										
					<textarea id="multiSessionExp" name="multiSessionExp" class="form-control" rows="3"></textarea>
				</div>
			</div>
		</div>
	</div>								
	<div class="col-sm-12">
		<div class="panel panel-default form-group">
			<div class="panel-heading">
				<h3 class="panel-title">Brief Description of Study</h3>
			</div>
			<div class="panel-body">									
				Describe the purpose of your research and your procedures and measures in lay terms. What will the typical participant in your project experience or, if your study involves naturalistic observation or archival research, how and where will you collect data? Be as brief as possible, but provide enough information for a non-specialist to understand your research.
				<textarea id="briefDescrip" name="briefDescrip" class="form-control countable" rows="5"></textarea>				
			</div>
		</div>
	</div>
	
				      

						