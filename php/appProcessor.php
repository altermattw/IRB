<?php
	// receives application data and processes it

	function getAccepted() {
		$varText = file('php/runOnce/createTable2015.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		// first, define accepted values using the createTable2015.txt file
		$varList = array();
		foreach($varText as $line) {
			if(!ctype_alpha(substr($line,0,1))) {
				$varName = substr($line, (strpos($line,'`')+1), (strrpos($line,'`')-strpos($line,'`')-1)); // extract variable name between backticks
				$varList[] = $varName;
			}
		}
		// Need to add variables for author names and author emails, which are separate on the form but will be combined in the database
			for($i=1; $i < 25; $i++) {
             $varList[] = '5Author'.$i.'A'; // name
             $varList[] = '5Author'.$i.'D'; // email
         }

		return array_unique($varList);
	}

?>
