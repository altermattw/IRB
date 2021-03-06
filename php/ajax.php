<?php
	include('SQLutils.php');
	if(!isLoggedIn()) {		// have to be logged in for request to be processed.
		echo '<p>Error: You are not logged in</p>';
		die();
	} else {

		// getAppRecord
		if(isset($_POST['getAppRecord']) && isset($_POST['studyNumber'])) {
			$mysqli = myConnect();
			$results = getAppRecord($mysqli,$_POST['studyNumber']);
			if($results) {
				echo json_encode($results);
			}
			mysqli_close($mysqli);
			die();
		}

		// getStatus
		// returns current status for a particular study
		if(isset($_POST['getStatus']) && isset($_POST['studyNumber'])) {
			$mysqli = myConnect();
			$studyNumber = mysqli_escape_string($mysqli,$_POST['studyNumber']);
			$results = computeCurrentStatus($mysqli,$studyNumber);
			if($results) {
				echo json_encode($results);
			}
			mysqli_close($mysqli);
			die();
		}

		// getIRBreviewer
		if(isset($_POST['getReviewer']) && isset($_POST['studyNumber'])) {
			$mysqli = myConnect();
			$studyNumber = mysqli_escape_string($mysqli,$_POST['studyNumber']);
			$people = getAuthors($mysqli,array($studyNumber));
			$reviewer = array();
			foreach($people as $person) {
				if($person["role"]=="IRB") {
					$reviewer = $person; // array with keys email, name, role, studyNumber
				}
			}
			echo $reviewer;
		}

		if(isset($_POST['updateIRB']) && isset($_POST['studyNumber']) && isset($_POST['IRBname']) && isset($_POST['IRBemail'])) {
			$mysql = myConnect();
			$email = mysqli_escape_string($mysql,$_POST["IRBemail"]);
			$name = mysqli_escape_string($mysql,$_POST["IRBname"]);
			$studyNumber = mysqli_escape_string($mysql,$_POST["studyNumber"]);
			$query = 'UPDATE userapps SET email="'.$email.'", name="'.$name.'" WHERE studyNumber="'.$studyNumber.'" AND role="IRB";';
			$WM = getWM();
			if(!$mysql->query($query)) {
				$reply = '<p>There was a problem deleting the old IRB name and emails for this study from the userapps database. Please email the IRB webmaster, '.$WM["name"].', at '.$WM["email"].' with this message.</p>';
				$reply.= '<p>Query: '.$query.'</p>';
				$reply.= '<p>Error: '.$mysql->error.'</p>';
				echo $reply;
			} else {
				$subj = "Assigned as IRB reviewer to study ".$studyNumber;
				$IRBwebmaster = getWM();
				$msg = '<p>You have been assigned as the IRB reviewer for study number '.$studyNumber.'. To check the status of this application, log in to <a href="http://irb.hanover.edu">irb.hanover.edu</a> and click on the &ldquo;Go to Administrator Page&rdquo; button or click on your name in the menu bar and select &ldquo;Administrator Dashboard.&rdquo; After the study has been submitted for IRB review, you will be able to suggest revisions or approve the study. If you have questions, please contact '.$IRBwebmaster["name"].' at '.$IRBwebmaster["email"].'.';
				mailMessage($email,$subj,$msg);
				echo 1;
			}
		}
	}

?>
