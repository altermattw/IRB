<?php
	require('../SQLutils.php');
	$_SESSION['valid'] = 0;	
	if(!isset($mysqli)) $mysqli = myConnect();													
	echo '<p>Testing updateUserApps function</p>';
	$records = ['1' => 
						['email' => '"alfons@hb.edu"','name' => '"Alfie Sandretti"','role'=>'"author"'],
					'sponsor' =>
						['email' => '"carl@gh.bu"','name' => '"Carl Sacks"','role'=>'"sponsor"']
				];
	updateUserApps($mysqli,'2015004',$records);	
?>