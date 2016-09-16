<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width">				 
	  	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">  	
	  	<link href="css/styles.css" rel="stylesheet" media="screen">
      <!-- <base href="http://vault.hanover.edu/~altermattw/IRB/">       -->
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>						
		<title><?php echo $pageTitle; ?></title>
	</head>
	<body>
		<div class="container">			
			<div class="row">					
				
<div class="navbar navbar-inverse" role="navigation">  
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".irb-navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.php">HC IRB</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse irb-navbar-collapse">
    <ul class="nav navbar-nav">            
      <!-- <li><a href="/~altermattw/IRB/index.php?login=true">Login</a></li> -->
      <!-- <li><a href="/~altermattw/IRB/register.html">Register</a></li> -->
      <li><a href="contact.php">Contact</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Resources <b class="caret"></b></a>
        <ul class="dropdown-menu">          
          <li><a href="overview.php">Overview</a></li>
          <li><a href="pdf/WrittenProceduresForIRB.pdf">Written Procedures</a></li>
          <li><a href="pdf/informed_consent_debriefing.pdf">Sample Informed Consent</a></li>
          <li><a href="members.php">IRB Members</a></li>          
        </ul>
      </li>
<?php
		if(isLoggedIn()) {
			$userArray = explode('@', $_SESSION["userid"]);
			$user = $userArray[0]; // chops off the @hanover.edu
			echo '<li class="dropdown">';
      echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$user.' <b class="caret"></b></a>';
      echo '<ul class="dropdown-menu">';      
      echo '<li><a href="userDashboard.php">My Applications</a></li>';
      if(isset($_SESSION["admin"]) && $_SESSION["admin"]==1) {
        echo '<li><a href="adminDashboard.php">Administrator Dashboard</a></li>';
      }
      //echo '<li><a href="account.php">Account info</a></li>';
      echo '<li><a href="logout.php">Log out</a></li>';
      echo '</ul>';
      echo '</li>';
		} else {
      echo '<li><a href="login.php">Login</a></li>';
    }
?>      
    </ul>
  </div><!-- /.navbar-collapse -->
</div>

</div> <!-- close row -->
<div class="row">
	<div class="page-header">
