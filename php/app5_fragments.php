switch($status["status"]) {
			case "First Draft":				
				if(count($authorArray) > 1) { // there are co-authors
					$buttonText = 'Submit for co-author approval';
					$message.='<p>The next step is for you to look carefully over your application, make sure you did not omit any important information, and then click the button below to submit your application for co-author approval. This will change the status of your application from &ldquo;First Draft&rdquo; to &ldquo;Submitted to Co-authors&rdquo; and send emails to each co-author, asking them to log in to irb.hanover.edu and review the application. Note that you cannot make any changes to the application while it is under review. If you need to make changes after you have submitted the application for review, you can come back to this page and click on &ldquo;Make Revisions&rdquo; to shift the application back into editing mode. However, your co-authors will not be able to approve the application while it is in that mode. You will need to resubmit it for co-author review after you have finished making changes.</p>';
					$message.='<button type="submit" class="btn btn-success" name="submit" value="submit" >'.$buttonText.'</button>';
				} else { // there are no co-authors
					if($sponsor == "") { // there is no faculty sponsor listed
						$buttonText = 'Submit for IRB review';
						$message.="";
					} else { // there is a faculty sponsor listed
						$buttonText = 'Submit for faculty sponsor review';
						$message.='<p>The next step is for you to submit your application for review by your faculty sponsor. By clicking the button below, you will change the status of your application from &ldquo;First Draft&rdquo; to &ldquo;Submitted to Faculty Sponsor&rdquo; and an email will be sent to your sponsor, informing them that the application is ready to be reviewed at irb.hanover.edu. Note that the application cannot be edited while it is under review, so please make all changes before you press the button below. If you need to make changes, you can come back to this page and click on &ldquo;Make Revisions&rdquo; to shift the application back into editing mode. However, your faculty sponsor will not be able to approve the application while it is in that mode. You will need to resubmit it for faculty sponsor review after you have finished making changes.</p>';
						$message.='<button type="submit" class="btn btn-success" name="submit" value="submit" >'.$buttonText.'</button>';
					}
				}
				
				break;
			case "Submitted to Co-authors":
				// who still needs to approve?
				$needsToApprove = array();
				foreach($approved["authors"] as $key => $val) {
					if($val==0) $needsToApprove[] = $key;
				}
				if(count($needsToApprove) > 0) {					
					if(in_array($_SESSION["userid"], $needsToApprove)) { // the user is one of the co-authors who needs to approve the application
						$buttonText = 'Approve as Co-Author';
						if(count($needsToApprove) == 1) { // user is LAST co-author to approve
							if($sponsor=="") { // and there is no faculty sponsor
								$message.='<p>If you click the &ldquo;Approve as Co-Author&rdquo; button, your application will be forwarded to the IRB for review. Please make sure you are satisfied with your application before submitting it to the IRB.</p>';
								$message.='<p>If the application requires revisions before being submitted to the IRB, press the &ldquo;Revisions Needed&rdquo; button below to change the status of your application to Co-Author Revision. Your co-authors will be emailed, alerting them to the change in status, and you will need to obtain approval from each co-author before the application can be forwarded to the IRB.</p>';
								$message.='<button type="submit" class="btn btn-success" name="submit" value="submit" >'.$buttonText.'</button>';
								$message.='<button type="submit" class="btn btn-warning" name="submit" value="Revise">Revisions Needed</button>';
							} else { // and there IS a faculty sponsor
								$message.='<p>If you are satisfied with the application and want to indicate your approval, please click the &ldquo;Approve as Co-Author&rdquo; button. The application will then be forwarded to your faculty sponsor for their review. Please make sure you are satisfied with your application before approving it.</p>';
								$message.='<p>If you think that the application requires revisions, you may click the &ldquo;Revisions Needed&rdquo; button to edit it. Note that this will reset the status of the application to &ldquo;Submitted to Co-Authors&rdquo; and will require each co-author to approve it before it can be forwarded to the faculty sponsor.</p>';
								$message.='<button type="submit" class="btn btn-success" name="submit" value="submit" >'.$buttonText.'</button>';
								$message.='<button type="submit" class="btn btn-warning" name="submit" value="Revise">Revisions Needed</button>';
							}							
						} else { // user is not the only co-author that needs to approve the application
							if($sponsor=="") { // no faculty sponsor
								$message.='<p>If you are satisfied with the application and want to indicate your approval, please click the &ldquo;Approve as Co-Author&rdquo; button. When the last co-author indicates his or her approval, the application will be forwarded to the IRB for their review. Please make sure you are satisfied with your application before approving it.</p>';
								$message.='<p>If you think that the application requires revisions, you may click the &ldquo;Revisions Needed&rdquo; button to edit it. Note that this will reset the status of the application to &ldquo;Submitted to Co-Authors&rdquo; and will require each co-author to approve it before it can be forwarded to the faculty sponsor.</p>';
								$message.='<button type="submit" class="btn btn-success" name="submit" value="submit" >'.$buttonText.'</button>';
								$message.='<button type="submit" class="btn btn-warning" name="submit" value="Revise">Revisions Needed</button>';
							} else { // there is a faculty sponsor
								$message.='<p>If you are satisfied with the application and want to indicate your approval, please click the &ldquo;Approve as Co-Author&rdquo; button. When the last co-author indicates his or her approval, the application will be forwarded to your faculty sponsor for their review. Please make sure you are satisfied with your application before approving it.</p>';
								$message.='<p>If you think that the application requires revisions, you may click the &ldquo;Revisions Needed&rdquo; button to edit it. Note that this will reset the status of the application to &ldquo;Submitted to Co-Authors&rdquo; and will require each co-author to approve it before it can be forwarded to the faculty sponsor.</p>';
								$message.='<button type="submit" class="btn btn-success" name="submit" value="submit" >'.$buttonText.'</button>';
								$message.='<button type="submit" class="btn btn-warning" name="submit" value="Revise">Revisions Needed</button>';
							}							
						}
					} else { // user is not one of the co-authors that needs to approve the application
						if(in_array($_SESSION["userid"],$authorArray)) { // user has already approved the application
							$message.='<p>If you think that the application requires revisions, you may click the &ldquo;Revisions Needed&rdquo; button to edit it. Note that this will reset the status of the application to &ldquo;Submitted to Co-Authors&rdquo; and will require each co-author to approve it before it can be forwarded to the faculty sponsor.</p>';								
							$message.='<button type="submit" class="btn btn-warning" name="submit" value="CoauthorRevision">Revisions Needed</button>';
						} else { // user is not one of the authors
							if($_SESSION["userid"] == $sponsor) { // user is the faculty sponsor

							}
							if(isAdmin()) { // user is administrator

							}

						}

					}
				} 			
				break;
			case "Co-author Approval":
				break;
			case "Co-author Revision":
				// message should be similar to "First Draft"
				break;
			case "Submitted to Faculty Sponsor":
				// provide option to return to editing mode
				break;
			case "Faculty Sponsor Revision":
				// provide option to return to editing mode
				break;
			case "Submitted to IRB":
				// provide option to return to editing mode
				break;
			case "IRB Revision":
				// next step is co-author approval again
				break;
			case "IRB Approval":
				// option to request minor changes to procedure
				break;
			case "Withdrawn":
				$buttonText = "Resurrect Study";
				break;

		}	