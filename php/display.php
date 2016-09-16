<?php

	function arrangeApps($mysqli,$studyArray) {
		// $statusArray is what you get back from getStudies():  Array([0] => Array( [studyNumber] => 2016010 [status] => First Draft [time] => 1453822218 [author] => Array ( [marklandc17@hanover.edu] => Markland ) [sponsor] => Array ( [altermattw@hanover.edu] => Altermatt ) [IRB] => Array ( [jacks@hanover.edu] => Jacks ) ) ))		
		$appArray = array();				
		if(!empty($studyArray)) {										
			// action: 0 = IRB review; 1 = faculty sponsor review; 2 = co-author approval needed; 3 = first draft or revision			
			$identified = false;
			foreach($studyArray as $study) {				
				if(in_array($_SESSION["userid"], array_keys($study["author"]))) { // user is an author of this study
					$identified = true;					
					if($study["status"] == "First Draft" || strpos($study["status"],"Revision") !== FALSE) { // user is an author of this study AND study is first draft or in revision
						$appArray["author"][] = $study;
						$appArray["action"][3][] = $study;						
					} else { // user is author, but study status is NOT in first draft or revision
						if($study["status"] == "Submitted to Co-authors") { // user is author and status of app is "Submitted to Co-authors"
							$appArray["author"][] = $study;
							$approved = getApprovalStatus($mysqli,$study["studyNumber"]);		
							if($approved["authors"][$_SESSION["userid"]]==0) { // user has not yet approved this application
								$appArray["action"][2][] = $study;
							}
						} else {
							if($study["status"] == "IRB Approval") {
								$appArray["approved"][] = $study;
							} else {
								if($study["status"] == "Withdrawn") {
									$appArray["withdrawn"][] = $study;
								} else {
									$appArray["author"][] = $study;
								}								
							}
						}							
					}						
				}
				if(isset($study["sponsor"]) && in_array($_SESSION["userid"], array_keys($study["sponsor"]))) { // user is a sponsor of this study
					$identified = true;					
					if($study["status"] == "Submitted to Faculty Sponsor") { // user is a sponsor of this study AND study has been submitted to faculty sponsor	
						$appArray["action"][1][] = $study;
						$appArray["sponsor"][] = $study;
					} else {
						if($study["status"] == "IRB Approval") {
							$appArray["approved"][] = $study;
						} else {
							if($study["status"] == "Withdrawn") {
								$appArray["withdrawn"][] = $study;
							} else {
								$appArray["sponsor"][] = $study;
							}								
						}
					}
				}							
				if(in_array($_SESSION["userid"], array_keys($study["IRB"]))) { // user is an IRB reviewer for this study
					$identified = true;					
					if($study["status"] == "Submitted to IRB") { // user is an IRB reviewer for this study AND it is in IRB review
						$appArray["action"][0][] = $study;
						$appArray["reviewer"][] = $study;
					} else {
						if($study["status"] == "IRB Approval") {
							$appArray["approved"][] = $study;
						} else {
							if($study["status"] == "Withdrawn") {
								$appArray["withdrawn"][] = $study;
							} else {
								$appArray["reviewer"][] = $study;
							}								
						}
					}
				}
				if(!$identified) { // study doesn't fall under any of the previous rules
					$appArray["other"][] = $study;
				}				
			}			
		}
		return($appArray);
	}

	function listApps2($statusArray,$heading=NULL,$formatting="primary") {
		// $statusArray is what you get back from getStudies():  Array([0] => Array( [studyNumber] => 2016010 [status] => First Draft [time] => 1453822218 [author] => Array ( [marklandc17@hanover.edu] => Markland ) [sponsor] => Array ( [altermattw@hanover.edu] => Altermatt ) [IRB] => Array ( [jacks@hanover.edu] => Jacks ) ) ))
		if(count($statusArray) > 0) { 
			//$titles = getTitles($mysqli,array_map(function($arr) { return $arr['studyNumber']; }, $statusArray));			
			$output = "";
			$class = preg_replace('/\s+/', '', $heading); // removes spaces in status labels; used for creating a class variable that could be manipulated by js			
			if(isset($heading)) $output.= '<div class="row"><div class="col-sm-12"><h4>'.$heading.'</h4></div>';	
			foreach($statusArray as $study) {
				$authors = implode(", ",$study["author"]);
				if(strlen($authors)>30) {
					$authors = substr($authors,0,27).'...';
				}				
				// $output.= '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"><a class="btn btn-'.$formatting.' btn-block '.$class.'" role="button" href="application.php?studyNumber='.$study["studyNumber"].'" style="white-space: normal; margin-bottom:4px;">'.$authors.'<br>'.$study["studyNumber"].', '.date("m/d/y H:i",$study["time"]).'<br>'.$study["status"].'</a></div>';
				$output.= '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"><a class="btn btn-'.$formatting.' btn-block '.$class.'" role="button" href="application.php?studyNumber='.$study["studyNumber"].'" style="white-space: normal; margin-bottom:4px;">'.$authors.'<br>Study '.$study["studyNumber"].', '.intval((time()-$study["time"])/60/60/24).' days'.'<br>'.$study["status"].'</a></div>';
			}
			if(isset($heading)) $output.='</div><hr>';	
			echo $output;
		} 
	}

?>