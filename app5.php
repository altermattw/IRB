<?php 
	$sponsor = "";
	$chair = getChair();
	$WM = getWM();
	if(isset($_SESSION["studyNumber"])) {
		$approved = getApprovalStatus($mysql,$_SESSION["studyNumber"]); // collects array of roles and names of people who need to approve study		
			// getApprovalStatus runs getAuthors(), which goes to the 'userapps' database and gets all the people associated with a particular study number
				// These are the people who could approve the study
			// getApprovalStatus then gets all the status updates for a particular study number using getStatus(), which goes to the 'status' DB.			
				// It searches through the status updates for the most recent "First Draft" or "Revision" and notes the time in a variable called $latest
				// It then looks at all the status updates SINCE $latest
		$authorArray = array_keys($approved["authors"]); // email addresses of authors
		if(isset($approved["sponsor"])) {
			$sponsor = current(array_keys($approved["sponsor"])); // email address of faculty sponsor		
		}
		$titleArray = current(getTitles($mysql,array($_SESSION["studyNumber"])));
		$title = $titleArray["title"];
		$allStatus = getStatus($mysql,array($_SESSION["studyNumber"]));
	}
	$message = "";	
	if(isset($_POST["submit"]) && $_POST["submit"] == "submit") { // If the user pressed the "submit" button on page 5
		if($status == "First Draft" || strpos($status,"Revision") !== FALSE) { // status is first draft or revision		
			// are there co-authors?  			
			if(count($authorArray) > 1) { // if there is more than one author							
				// change status to "Submitted to Co-authors"
				if(setStatus($mysql,$_SESSION["studyNumber"],"Co-author Approval",$_SESSION["userid"])) {					
					setStatus($mysql,$_SESSION["studyNumber"],"Submitted to Co-authors",$_SESSION["userid"]);
					$message.='<p>Status changed to &ldquo;Submitted to Co-authors&rdquo;</p>';				
					// email co-authors
					foreach($authorArray as $coauthor) {
						if($coauthor != $_SESSION['userid']) { // email sent to co-authors other than the user
							$newStatus = 'submitted for co-author review';
							$nextStep = 'The next step is for you to log in to the <a href="http://irb.hanover.edu" target="_blank">Hanover College IRB website</a> (registering first if you have not already done that), review the application, and on the <strong>Submit</strong> page, to indicate whether you approve the application or whether some revisions are needed before you can approve the application. ';						
							if(confirmationEmail($coauthor,$_SESSION["studyNumber"],$title,"co-author",$newStatus,$nextStep)) {
								$message.='<p>Confirmation email sent to '.$coauthor.'.</p>';
							} else {
								$message.='<p>Error sending email to '.$coauthor.'. Email not sent.</p>';
							}
						} else { // confirmation email sent to the user
							$newStatus = 'submitted for co-author review';
							$nextStep = 'Your co-authors have been sent an email asking them to log in to the <a href="http://irb.hanover.edu" target="_blank">Hanover College IRB website</a> (registering first if they have not already done that), review the application, and to indicate whether they approve the application or whether some revisions are needed. As each co-author approves or flags the application for revision, you will receive additional emails. ';							
							if(confirmationEmail($coauthor,$_SESSION["studyNumber"],$title,"co-author",$newStatus,$nextStep)) {
								$message.='<p>'.$nextStep.'</p><p>Confirmation email sent to '.$coauthor.'.</p>';
							} else {
								$message.='<p>Error sending email to '.$coauthor.'. Email not sent.</p>';
							}
						}								
					}		
				}											
			} else { 							// if there are no co-authors
				if($sponsor == "") { 		// no co-authors and no faculty sponsor
					// change status to "Submitted to IRB"
					if(setStatus($mysql,$_SESSION["studyNumber"],"Co-author Approval",$_SESSION["userid"])) {
						setStatus($mysql,$_SESSION["studyNumber"],"Submitted to IRB",$_SESSION["userid"]);
						$message.='<p>Application submitted to IRB for review.</p>';
						// email to author
						$newStatus = 'submitted to the IRB';
						$nextStep = 'When the IRB has completed its review of your application, you will be notified by email. ';
						$to = $_SESSION["userid"];
						if(confirmationEmail($to,$_SESSION["studyNumber"],$title,"author",$newStatus,$nextStep)) {
							$message.='<p>Confirmation email sent to '.$to.'.</p>';
						} else {
							$message.='<p>Error sending email to '.$to.'. Email not sent.</p>';
						}
						// email to IRB reviewer
						$to = current(array_keys($approved["IRB"])) or $to = $chair["email"];
						$role = 'IRB reviewer';
						$nextStep = 'The next step is for you to log in to <a href="http://irb.hanover.edu" target="_blank">irb.hanover.edu</a> and review the application, then either approve it or indicate what revisions are necessary.';
						if(confirmationEmail($to,$_SESSION["studyNumber"],$title,$role,$newStatus,$nextStep)) {
							$message.='<p>Confirmation email sent to '.$to.'.</p>';
						} else {
							$message.='<p>Error sending email to '.$to.'. Email not sent.</p>';
						}
					} else {
						$message.='<p>Error changing the status to &ldquo;Submitted to IRB&rdquo;. Contact the IRB webmaster, '.$WM["name"].', at '.$WM["email"].' for assistance.</p>';
					}						
				} else {							// no co-authors, but there is a faculty sponsor
					// change status to "Submitted to Faculty Sponsor"
					if(setStatus($mysql,$_SESSION["studyNumber"],"Co-author Approval",$_SESSION["userid"])) {
						setStatus($mysql,$_SESSION["studyNumber"],"Submitted to Faculty Sponsor",$_SESSION["userid"]);
						// email to author
						$message.='<p>Application submitted to faculty sponsor.</p>';
						$to = $_SESSION["userid"];
						$newStatus = 'submitted to faculty sponsor';
						$nextStep = 'The faculty sponsor listed on your application was '.$sponsor.'. When your sponsor has completed his or her review of your application, you will be notified by email. ';
						$role = 'author';
						if(confirmationEmail($to,$_SESSION["studyNumber"],$title,$role,$newStatus,$nextStep)) {
							$message.='<p>Confirmation email sent to '.$to.'.</p>';
						} else {
							$message.='<p>Error sending email to '.$to.'. Email not sent.</p>';
						}
						// email to faculty sponsor
						$nextStep = 'The next step is for you to log in to <a href="http://irb.hanover.edu" target="_blank">irb.hanover.edu</a> and review the application, then either approve it or indicate what revisions are necessary.';
						$to = $sponsor;
						if(confirmationEmail($to,$_SESSION["studyNumber"],$title,'faculty sponsor',$newStatus,$nextStep,FALSE)) {
							$message.='<p>Confirmation email sent to '.$to.'.</p>';
						} else {
							$message.='<p>Error sending email to '.$to.'. Email not sent.</p>';
						}
					}						
				}
			}	
		} else { // status is not first draft or revision
			if($status=="IRB Approval") { // study has been approved by the IRB				
				// This shouldn't happen. There shouldn't be a "submit" option after the study is IRB approved
			} 
			if($status=="Submitted to IRB" && $_SESSION["userid"]==current(array_keys($approved["IRB"])) && isset($_POST["Classification"])) {
				// gather category for acceptance
					$comments="";
					if(isset($_POST["Classification"])) {
						$Classification=$_POST["Classification"];
						$comments.=$Classification;
					} 
					if(isset($_POST["category"])) {
						$category=$_POST["category"];
						$comments.=': '.$category;
					}					
				// Approve application					
					if(setStatus($mysql,$_SESSION["studyNumber"],"IRB Approval",$_SESSION["userid"],$comments)) {			
						include('php/classify.php');						
						// Confirmation message to display
							$message.='<p>Study number '.$_SESSION["studyNumber"].' has been approved by the IRB.</p>';
						// Email co-authors, faculty sponsor, IRB admin, IRB webmaster
							$destination = $authorArray;
							if($sponsor!="") $destination[] = $sponsor;
							$destination[] = $chair["email"];
							$destination[] = $WM["email"];
							$subject = 'Study '.$_SESSION["studyNumber"]. ' approved by IRB';
							$futureDate=date('M j, Y', strtotime('+1 year'));
							$msg = '<p>Study number '.$_SESSION["studyNumber"].', titled <strong>'.$title.'</strong> has been approved by the Hanover College Institutional Review Board. The study was classified as &ldquo;'.$Classification.'.&rdquo;</p>';
							if(isset($category) && $Classification=="Expedited") {
								$msg.='<p>Specifically, the IRB found that the study qualified as '.$category.': &ldquo;'.$Classify[$Classification][$category]. '&rdquo; <a href="http://www.hhs.gov/ohrp/policy/expedited98.html">[reference]</a>.</p>';
							}
							if(isset($category) && $Classification=="Exempt") {
								$link='http://www.hhs.gov/ohrp/humansubjects/guidance/45cfr46.html#'.$category;
								$msg.='<p>Specifically, the IRB found that the study qualified under <a href="'.$link.'" target="_blank">the Code of Federal Regulations (CFR) Title 45, Part '.$category.'</a>: '.$Classify[$Classification][$category].'</p>';
							}
							$msg.='<p><strong>This approval authorizes the authors of this application to begin data collection.</strong>  This approval will expire on '.$futureDate.'.</p><p>Any changes to the procedure must be approved by the IRB prior to making those changes. Authors may request a modification to their procedure by logging in to irb.hanover.edu, navigating to the approved application, going to the <strong>Submit</strong> section, and clicking the <em>Request Modification</em> button. This will create a clone of the original application with a new study number, to which modifications can be made. If you have any questions, please contact either the IRB webmaster, '.$WM["name"].', at '.$WM["email"].', or the chair of the Hanover College Institutional Review Board, '.$chair["name"].', at '.$chair["email"].'</p>';						
							foreach($destination as $recipient) {
								if(mailMessage($recipient,$subject,$msg)) {
									$message.='<p>Confirmation email sent to '.$recipient.'.</p>';
								} else {
									$message.='<p>Error: Problem sending email to '.$recipient.'. Email not sent.</p>';
								}
							}
					} else {
						$message.='<p>There was a problem changing the status to &ldquo;IRB Approval&rdquo;. Status not changed.</p>';
					}
				}
				if($status=="Submitted to Faculty Sponsor" && $_SESSION["userid"]==current(array_keys($approved["sponsor"]))) {
					// Approve application					
					if(setStatus($mysql,$_SESSION["studyNumber"],"Faculty Sponsor Approval",$_SESSION["userid"])) {
						setStatus($mysql,$_SESSION["studyNumber"],"Submitted to IRB",$_SESSION["userid"]); // upgrading to submitted to IRB
						// Confirmation message to display
						$message.='<p>Faculty sponsor has approved the application and it has now been submitted to the IRB for review.</p>';
						// Email co-authors, confirmation email to sponsor
						// email to author
						$newStatus = 'approved by faculty sponsor';
						$nextStep = 'The application has been submitted to the IRB. When the IRB review is complete, you will be notified by email. ';
						$role = 'author';
						foreach($authorArray as $author) {
							if(confirmationEmail($author,$_SESSION["studyNumber"],$title,$role,$newStatus,$nextStep)) {
								$message.='<p>Confirmation email sent to '.$author.'.</p>';
							} else {
								$message.='<p>Error sending email to '.$author.'. Email not sent.</p>';
							}	
						}									
						// email to faculty sponsor
						$nextStep = 'The application has been submitted to the IRB. When the IRB review is complete, you will be notified by email. ';
						$to = $sponsor;
						if(confirmationEmail($to,$_SESSION["studyNumber"],$title,'faculty sponsor',$newStatus,$nextStep)) {
							$message.='<p>Confirmation email sent to '.$to.'.</p>';
						} else {
							$message.='<p>Error sending email to '.$to.'. Email not sent.</p>';
						}
					} else {
						$message.='<p>Sorry, but there was a problem updating the status of this application to &ldquo;Faculty Sponsor Approval&rdquo;. Please contact the webmaster for the IRB, '.$WM["name"].', at '.$WM["email"].'</p>';
					}
				}
				if($status=="Submitted to Co-authors" && in_array($_SESSION["userid"],$authorArray) && $approved["authors"][$_SESSION["userid"]]==0) {
					// if user is an author who has not yet approved (timestamp is 0)
					if(setStatus($mysql,$_SESSION["studyNumber"],"Co-author Approval",$_SESSION["userid"])) { // approved by current user		
						$subject = 'Study '.$_SESSION["studyNumber"].' approved by '.$_SESSION["userid"];
						// is the user the LAST one to approve?
						$otherAuthors = $approved["authors"];
						unset($otherAuthors[$_SESSION["userid"]]); // take out the user
						if(empty($otherAuthors) || array_product($otherAuthors) > 0) { // last co-author b/c only 1 author or everyone else has approved
							if($sponsor=="") { // no sponsor
								// send directly to IRB
								if(setStatus($mysql,$_SESSION["studyNumber"],"Submitted to IRB",$_SESSION["userid"])) {
									$message.='<p>Status updated to &ldquo;Submitted to IRB&rdquo;.</p>';
									$newStatus='submitted to the IRB';
									$nextStep='You will receive an email after the IRB has completed its review of the application. ';
									foreach($authorArray as $author) {
										if(confirmationEmail($author,$_SESSION["studyNumber"],$title,"author",$newStatus,$nextStep)) {
											$message.='<p>Confirmation email sent to '.$to.'.</p>';
										} else {
											$message.='<p>Error sending email to '.$to.'. Email not sent.</p>';
										}	
									}
									$nextStep='Please log in to <a href="http://irb.hanover.edu" target="_blank">irb.hanover.edu</a> and review the application, then either approve it or indicate what revisions are necessary. ';
									if(confirmationEmail(current(array_keys($approved["IRB"])),$_SESSION["studyNumber"],$title,"IRB",$newStatus,$nextStep)) {
											$message.='<p>Confirmation email sent to '.$to.'.</p>';
										} else {
											$message.='<p>Error sending email to '.$to.'. Email not sent.</p>';
										}	
								} else {
									$message.='<p>Error updating status to &ldquo;Submitted to IRB.&rdquo;</p>';
								}	
							} else { // sponsor											
								// send to sponsor for their review
								if(setStatus($mysql,$_SESSION["studyNumber"],"Submitted to Faculty Sponsor",$_SESSION["userid"])) {
									$message.='<p>Status updated to &ldquo;Submitted to Faculty Sponsor&rdquo;.</p>';
									$newStatus='submitted to the faculty sponsor';
									$nextStep='You will receive an email after the faculty sponsor has completed his or her review of the application. The faculty sponsor may ask that additional revisions be made or may approve the study, in which case it would be submitted to the IRB for final review.';
									foreach($authorArray as $author) {
										$to=$author;
										if(confirmationEmail($author,$_SESSION["studyNumber"],$title,"author",$newStatus,$nextStep)) {
											$message.='<p>Confirmation email sent to '.$to.'.</p>';
										} else {
											$message.='<p>Error sending email to '.$to.'. Email not sent.</p>';
										}	
									}
									$nextStep='The next step is for you to log in to <a href="http://irb.hanover.edu" target="_blank">irb.hanover.edu</a> and review the application, then either approve it or indicate what revisions are necessary. ';
									$to=$sponsor;
									if(confirmationEmail($sponsor,$_SESSION["studyNumber"],$title,"faculty sponsor",$newStatus,$nextStep)) {
										$message.='<p>Confirmation email sent to '.$to.'.</p>';
									} else {
										$message.='<p>Error sending email to '.$to.'. Email not sent.</p>';
									}		
								}	
							}
						}
					}
				}
			}				
		} // end $_POST["submit"] == "submit"

		if(isset($_POST["submit"]) && $_POST["submit"]=="Revise") { // "Revisions needed" button pressed
			$comments="";
			if(isset($_POST["comments"])) $comments = mysqli_escape_string($mysql,$_POST["comments"]);			
			// Which status will it be changed TO?
				// Depends on who the user is.
			$approved = getApprovalStatus($mysql,$_SESSION["studyNumber"]);
			// user is a co-author
				if(in_array($_SESSION["userid"],array_keys($approved["authors"]))) {
					$message.=revisionRequest($mysql,$_SESSION["studyNumber"],$title,"Co-author Revision",$approved,$comments,$message);							
				} else {
				// user is faculty sponsor
				if(in_array($_SESSION["userid"],array_keys($approved["sponsor"]))) {
					$message.=revisionRequest($mysql,$_SESSION["studyNumber"],$title,"Faculty Sponsor Revision",$approved,$comments,$message);					
				} else {
				// user is IRB or has admin privileges
					if(in_array($_SESSION["userid"],array_keys($approved["IRB"])) || isAdmin()) {								
						$message.=revisionRequest($mysql,$_SESSION["studyNumber"],$title,"IRB Revision",$approved,$comments,$message);				
					} else {
						$message.='<p>Error: User does not have correct author, faculty sponsor, or IRB privileges to request revision. Please contact the IRB webmaster, '.$WM["name"].', at '.$WM["email"].' for assistance.</p>';
					}
				}
			}			
		}

		if(isset($_POST["submit"]) && $_POST["submit"]=="Modification") { // "Request Modification" button pressed on study already approved by IRB
			if(in_array($_SESSION["userid"],array_keys($approved["authors"]))) { // make sure submitter is an author
				$newStudyNumber = duplicateApp($mysql,$_SESSION["studyNumber"],$_SESSION["userid"]); // duplicates application
				if($newStudyNumber > 0) {
					$message.='<p>A clone of study '.$_SESSION["studyNumber"].' has been created and assigned study number '.$newStudyNumber.'. Its status has been set to &ldquo;First Draft.&rdquo; <a href="application.php?studyNumber='.$newStudyNumber.'">Click here</a> to go to that application and begin making your revisions.</p>';
				}
			} else {
				$message.='<p>Error: Only authors may initiate a request to modify an accepted IRB proposal.</p>';
			}			
		}
				
	// Whether to display Submit/Approve button, Revisions Needed button, Request Modification button, or Withdraw button
		// need to retrieve the new status of the app, because it might have changed
		if(isset($_SESSION["studyNumber"])) {
			$revisionsNeeded ='<hr><div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true"><div class="panel panel-default"><div class="panel-heading" role="tab" id="headingOne"><h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Revisions Needed?</a></h4></div> <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne"><div class="panel-body">This application is currently under review. If you believe the application requires revisions before it can be approved, type your suggested revisions into the text box below and click the &ldquo;Revisions Needed&rdquo; button. Note that this will reset the review process, and all co-authors and the faculty sponsor (if applicable) will need to approve those revisions before the application will be reviewed by the IRB.  If you have any questions about this process, please contact the chair of the IRB, '.$chair["name"].', at '.$chair["email"].'.<div class="panel-body"><label>Please type your comments for revision below.</label><textarea name="comments" class="form-control countable" rows="5"></textarea></div><button type="submit" class="btn btn-danger" name="submit" value="Revise">Revisions Needed</button></div> </div> </div> </div>';							
			$status = computeCurrentStatus($mysql,$_SESSION["studyNumber"]); // this returns a single text string, e.g., "Submitted to Co-authors"
			function isAuthor($authorName,$approved) {
				if(in_array($authorName,array_keys($approved["authors"]))) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
			$tempStatus = $status;
			if(strpos($status,"Revision") !== FALSE) { // status is one of the revision states (Co-Author, Faculty Sponsor, or IRB)
				$tempStatus = "Revision";
			}
			$approved = getApprovalStatus($mysql,$_SESSION["studyNumber"]);			
			switch($tempStatus) {
				case "First Draft":
					if(isAuthor($_SESSION["userid"],$approved)) {
						$message.='<p>This application is in its first draft. Once you are satisfied that the application is complete, you may press the button below to Submit the application. If you have any co-authors, they will be notified by email and invited to review the application. After all co-authors have approved the application, it will then be submitted either to the faculty sponsor listed on your application or to the IRB for its review. If you have any questions about this process, please contact the chair of the IRB, '.$chair["name"].', at '.$chair["email"].'.</p>';
						$message.='<button type="submit" class="btn btn-success" name="submit" value="submit">Submit</button>';
					} else { // user is not an author
						$message.='<p>This application is in its first draft. Once the authors are satisfied that the application is complete, they may submit the application. If there are any co-authors, they will be notified by email and invited to review the application. After all co-authors have approved the application, it will then be submitted either to the faculty sponsor listed on the application or to the IRB for its review. If you have any questions about this process, please contact the chair of the IRB, '.$chair["name"].', at '.$chair["email"].'.</p>';
					}
					break;
				case "Revision":
					if(isAuthor($_SESSION["userid"],$approved)) {
						$message.='<p>This application is in revision. Once the revisions are complete, you may press the button below to Approve the application. If you have any co-authors, they will be notified by email and invited to review the application. After all co-authors have approved the application, it will then be submitted either to the faculty sponsor listed on your application or to the IRB for its review. If you have any questions about this process, please contact the chair of the IRB, '.$chair["name"].', at '.$chair["email"].'.</p>';
						$message.='<button type="submit" class="btn btn-success" name="submit" value="submit">Approve</button>';
					} else { // not an author
						$message.='<p>This application is in revision. Once one of the authors approves the application, any co-authors will be contacted for their approval. Once all co-authors have approved the application, it will be forwarded to the faculty sponsor (if applicable). After any faculty sponsors have approved the application, it will be forwarded to the IRB. If you have any questions about this process, please contact the chair of the IRB, '.$chair["name"].', at '.$chair["email"].'.</p>';
					}										
					break;
				case "Submitted to Co-authors":
					if(isAuthor($_SESSION["userid"],$approved)) {
						if($approved["authors"][$_SESSION["userid"]]==0) { // user is author *who has not approved*							
								$message.='<p>This application lists you as a co-author and you have not yet approved it. Review the application information carefully. If you find the application satisfactory, press the Approve button below to advance the application to the next stage in its review. After all co-authors have approved the application, it will then be submitted either to the faculty sponsor listed on your application or to the IRB for its review. If you have a concern about the application and believe that changes need to be made, press the &ldquo;Revisions Needed&rdquo; button and describe the necessary changes. This will clear all approvals and make the application editable again. If you have any questions about this process, please contact the chair of the IRB, '.$chair["name"].', at '.$chair["email"].'.</p>';
								$message.='<button type="submit" class="btn btn-success" name="submit" value="submit">Approve</button>';
						} else { // user is author *who has approved*
							$message.='<p>This application lists you as a co-author and you have already approved it. After all co-authors have approved the application, it will then be submitted either to the faculty sponsor listed on your application or to the IRB for its review. If you have a concern about the application and believe that changes need to be made, press the &ldquo;Revisions Needed&rdquo; button and describe the necessary changes. This will clear all approvals and make the application editable again. If you have any questions about this process, please contact the chair of the IRB, '.$chair["name"].', at '.$chair["email"].'.</p>';
						}
					$message.=$revisionsNeeded;
					} else { // user is not a co-author
						$message.='<p>This application has been submitted to co-authors for their approval. After all co-authors have approved the application, it will then be submitted either to the faculty sponsor listed on the application or to the IRB for its review. If you have any questions about this process, please contact the chair of the IRB, '.$chair["name"].', at '.$chair["email"].'.</p>';
					}
					break;
				case "Submitted to Faculty Sponsor":
					if($_SESSION["userid"] == current(array_keys($approved["sponsor"]))) { // user is faculty sponsor
						$message.='<p>This application has been approved by the author(s). To approve the application and send it on to the IRB for review, click the &ldquo;Approve&rdquo; button below. If you have a concern about the application and believe that changes need to be made, press the &ldquo;Revisions Needed&rdquo; button and describe the necessary changes. This will clear all approvals and make the application editable again.</p>';
						$message.='<button type="submit" class="btn btn-success" name="submit" value="submit">Approve</button>';
						$message.=$revisionsNeeded;
					} else { // not the faculty sponsor
						if(isAuthor($_SESSION["userid"],$approved)) { // user is an author
							$message.='<p>The application is currently under review by the faculty sponsor. However, if you believe that changes need to be made to the application before the faculty sponsor approves it, you should press the &ldquo;Revisions Needed&rdquo; button below and explain your concern. That will clear all the approvals and make the application editable again.</p>';
							$message.=$revisionsNeeded;
						} else { // user is neither faculty sponsor nor author
							$message.='<p>The application is currently under review by the faculty sponsor. Once the faculty sponsor has approved the application, it will be forwarded to the IRB for final review. If the faculty sponsor believes that revisions need to be made, then the authors of the application will be contacted and invited to make changes before resubmitting it to their faculty supervisor.</p>';
						}						
					}
					break;
				case "Submitted to IRB":
					if(isAdmin() || $_SESSION["userid"]==current(array_keys($approved["IRB"]))) {
						$IRBmessage=file_get_contents("appClassify.php");	
						$message.='<p>This application is under IRB review. As someone authorized to provide IRB approval, you can either approve the application using one of the classifications above or you can indicate that revisions are needed by clicking on that link below.</p>';
						$message.=$revisionsNeeded;			
					}		
					
					break;
				case "IRB Approval":
					// Offer option to Request Modification to Procedure					
					// This will create a new study number but duplicate all the form values from the original study as a starting point.											
					$message.='<p>This application has been approved by the IRB. Any changes to the procedures must first be approved by the IRB before they are implemented.</p>';					
					if(isAuthor($_SESSION["userid"],$approved)) {
						$message.='<p>If you would like to request a modification to your procedure, click the &ldquo;Request Modification&rdquo; button below. A new application will be created that is a copy of this application, but it will be assigned a new study number and must go through the same sequence of approvals as your original proposal (all co-authors, faculty sponsor if applicable, then IRB). If you have any questions, please contact the chair of the IRB, '.$chair["name"].', at '.$chair["email"].'.</p>';
						$message.='<button type="submit" class="btn btn-success" name="submit" value="Modification">Request Modification</button>';
					}
					break;
				case "Withdrawn":
					break;
			}				
						
		} else { // study has not yet been registered or has no study number

		}
				
?>
<div id="Submit">
	<?php
		if(isset($IRBmessage)) {
			echo '<div class="row"><div class="col-md-12">';
			echo $IRBmessage;
			echo '</div></div>';
		}
		if(isAdmin()) {
			echo '<div class="row"><div class="col-md-12">';
			echo '<div class="panel panel-danger" > <!-- IRB reviewer --> <div class="panel-heading"> <h3 class="panel-title">IRB Reviewer</h3> </div> <div class="panel-body"> <div class="form-group"> <label for="IRBname" class="col-sm-2 control-label">Name: </label> <div class="col-sm-10"> <input type="text" id="IRBname" name="IRBname" Placeholder="Name of IRB Reviewer" class="form-control IRB"> </div> </div> <div class="form-group"> <label for="IRBemail" class="col-sm-2 control-label">Email: </label> <div class="col-sm-10"> <input type="text" id="IRBemail" name="IRBemail" Placeholder="Email of IRB Reviewer" class="form-control IRB"> </div> </div> <div class="form-group"> <div class="col-sm-offset-2 col-sm-10"> <a href="#" id="updateIRB" class="btn btn-default">Update</a> </div> </div> </div> </div>';
			echo '</div></div>';	
		}
	?>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">
						Messages and Action Options
					</h4>
				</div>
				<div class="panel-body">
					<?php 
						echo $message; 						
					?>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">
						Application Approvals
					</h4>
				</div>
				<div class="panel-body">					
					<?php
					if(isset($_SESSION["studyNumber"])) {
						echo '<p> The table below shows the emails of all the individuals who need to approve the study before you can begin data collection:  any co-authors, a faculty sponsor (if this is a student project), and finally the IRB member assigned to your application. The co-authors and faculty sponsor information is based on the answers provided on page 1 of this application. </p>';
						echo '<table class="table table-striped"><thead><th>Email</th><th>Role</th><th>Approval</th></thead><tbody>';						
						$approved = getApprovalStatus($mysql,$_SESSION["studyNumber"]);
						foreach($approved as $key => $val) {						
							foreach($val as $key2 => $val2) {
								if($val2 > 0) {
									$value = date("n/d/y, H:i",$val2);
								} else {
									$value = "Not Yet Approved";
								}
								echo '<tr><td>'.$key2.'</td><td>'.$key.'</td><td>'.$value.'</td></tr>';							
							}
						}
						echo '</tbody></table>';
					} else {
						echo 'getWM()This study has not yet been assigned a study number by the IRB. To receive a study number, complete some portion of this form and press either <em>Save</em> or go to another page of the application. If you continue to receive this message, please contact the IRB webmaster, '.$WM["name"].', at '.$WM["email"].'.</p>';
					}				
					?>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">
						Status History
					</h4>
				</div>
				<div class="panel-body">
					<?php
						echo '<ul class="list-group">';
						$allStatus = getStatus($mysql,array($_SESSION["studyNumber"]));
						foreach($allStatus as $status) {
							echo '<li class="list-group-item">';
							echo date("n/d/y, H:i",$status["time"]);
							echo ' <strong>'.$status["status"].'</strong>';
							echo ' ('.$status["email"].')';
							if(strlen($status["comments"]) > 0) {
								echo ': '.$status["comments"];
							}
							echo '</li>';
						}
						echo '</ul>';
					?>
				</div>
			</div>
		</div>
	</div>	
</div>