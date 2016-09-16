<?php

// constants
	$IRBchair = array("name" => "Dean Jacks", "email" => "jacks@hanover.edu");
	$IRBwebmaster = array("name" => "Bill Altermatt", "email" => "altermattw@hanover.edu");
	$database = "research";
	$username = "altermattw";
	$passwd = "calliope77";
	$uri = "mongodb://".$username.":".$passwd."@ds061228.mongolab.com:61228/".$database;
	$options = array("connectTimeoutMS" => 30000);
	$client = new MongoClient($uri, $options );
	$db = $client->selectDB($database);
	$IRBacc = $db->IRBacc;
		
function encryptPassword($password) {
		$random = openssl_random_pseudo_bytes(18);
		$salt = sprintf('$2y$%02d$%s',
		    13, // 2^n cost factor
		    substr(strtr(base64_encode($random), '+', '.'), 0, 22)
		);
		return crypt($password, $salt); // encrypting password	
}

// MONGO UTILITIES

function docExists($key,$value,$collection) {	
	// note: $collection is the STRING name of a collection, not the actual collection	
	global $client;
	global $db; // using the $db variable from outside the function
	$coll = $client->selectCollection($db,$collection);
	$query = array( $key => $value );
	$result = $coll->findOne($query);
	if(empty($result)) {
		return false;
	} else {
		return true;
	}
}
function getDoc($key,$value,$collection) {
	// collection is a string, like 'IRBacc' or 'IRBapps' or '2014'
	// This will return one record as an array
	// Access particular values using bracket notation:
	//   $results["username"]
	global $client;
	global $db; // using the $db variable from outside the function
	$coll = $client->selectCollection($db,$collection);
	if($key == "_id") {
		$value = new MongoID($value);
	}
	$query = array( $key => $value );
	$result = $coll->findOne($query);
	if(empty($result)) {
		return false;
	} else {
		return $result;
	}	
}

function getDocs($query,$collection,$fields=array()) {
	// $query is an array in array(key => value, key => value) format
	// $query will return all the records that match the specifications
		// range: $query = array('x' => array('$gt' => 5, '$lt' => 20);
		// using javascript: 
			// $js = "function() {
		    // return this.name == 'Joe' || this.age == 50;
				// }";
			// then, $query = array('$where' => $js)
		// dot notation: $query = array('awards.gold' => 'USA')
		// OR:  array('awards' => array($'in' => array('gold','copper'))) would return any documents that had either gold OR copper awards		
	// $fields is optional and specifies which fields should be returned and is in the format array('fieldname1' => true, 'fieldname2' => true).
	// $collection is the STRING name of the collection, NOT the collection itself
	global $client;
	global $db;
	$coll = $client->selectCollection($db,$collection);
	$docs = iterator_to_array($coll->find($query,$fields));
	return $docs;
	// returns an ARRAY of objects
}

function removeDoc($key,$value,$collection) {
	global $client;
	global $db; // using the $db variable from outside the function
	$coll = $client->selectCollection($db,$collection);
	$criteria = array($key => $value);
	$options = array ("justOne" => true, "j" => true);
	return $coll->remove($criteria, $options);							
}
// testing removeDoc
		// $key = 'login';
		// $value = 1408378562;

		// if(removeDoc($key,$value,$IRB)) {
		// 	echo '<p>'.$key.' = '.$value.' removed.</p>';
		// }

function updateDoc($criteria,$new_object,$collection,$operator='$set',$options=array ("j" => true, "w" => 1, "upsert" => true)) {
	// note: collection is the STRING name of a collection, not an actual collection
	global $client;
	global $db; // using the $db variable from outside the function	
	$coll = $client->selectCollection($db,$collection);
	$op = '$set';
	if($operator == "set") $op = '$set' ;
	if($operator == "inc")  $op = '$inc' ;
	if($operator == "setOnInsert") $op = '$setOnInsert';
	$new_obj = array($op => $new_object);
	// print_r($new_obj);
	$coll->update($criteria,$new_obj,$options);
	return $coll;
}
		// Note: put operators in single quotes: '$set'
		// Operators:
			// $set
			// $setOnInsert:  only sets fields if this is the initial write to that record
			// 
		// testing updateDoc
			// $criteria = array( 'user' => 'Tartouffe');
			//  $new_object = array( 
			// 	'user' => 'Tartouffe',
			// 	'movie' => 'Matrix',
			// 	'login' => time()
			// 	);
			// $operator='$setOnInsert';
			// if(updateDoc($criteria,$new_object,$IRB,$operator)) {
			// 	echo 'yahoo!';
			// }

function getStudyNumber() { 	
	$coll = 'IRBnextStudyNumber';
	$_id = '53f799149ed71ec93ce62adb';
	$criteria = array('_id' => new MongoId($_id));	
	$doc = getDoc('_id',$_id,$coll);
	$studyNumber = $doc["study"]+1;
	$year = date('Y',time());
	if($doc["year"] != $year) {
		// update year to current year and set study to 1
		$criteria = array('_id' => new MongoId($_id));
		$new_object = array( 'study' => 1, 'year' => $year );
		$operator = '$set';
		updateDoc($criteria,$new_object,$coll,$operator);
		return $year.'-001';
	} else {		
		$operator = '$inc';
		$new_object = array('study' => 1);
		updateDoc($criteria,$new_object,$coll,$operator);	
		return $year.'-'.str_pad($studyNumber,3,"0",STR_PAD_LEFT);
	}	
}

function registerApp($_id,$year,$title,$emails) {	
	// note: $emails is an ARRAY of emails
	$collection = 'IRBapps';
	$studyNumber = getStudyNumber();
	$operator='setOnInsert';
	// $criteria = array('_id' => new MongoId($_id));
	$criteria = array('_id' => new MongoId($_id));
	$new_object = array('_id' => new MongoId($_id), 'year' => $year,'studyNumber' => $studyNumber, 'title' => $title, 'status' => 'editing', 'emails' => $emails);	
	updateDoc($criteria,$new_object,$collection,$operator);
	// return $new_object;
}

// end Mongo utilities
function isEqual($str1, $str2) // used for constant-time string compare (to prevent timing attacks)
			{
			    $n1 = strlen($str1);
			    if (strlen($str2) != $n1) {
			        return false;
			    }
			    for ($i = 0, $diff = 0; $i != $n1; ++$i) {
			        $diff |= ord($str1[$i]) ^ ord($str2[$i]);
			    }
			    return !$diff;
			}

function checkPassword($given_password,$db_hash) {
	// givenPassword is what you get from the user
	// db_hash is the encrypted version of the password, stored in the db	
	$given_hash = crypt($given_password, $db_hash);	
	if (isEqual($given_hash, $db_hash)) {
		return true;
	} else {
		return false;
	}
}

function validateUser($userid) // called if the login is successful
{
    session_regenerate_id (); //this is a security measure
    $_SESSION['valid'] = 1;
    $_SESSION['userid'] = $userid;
    $administrators = array(
			"jacks@hanover.edu",
			"bruyninx@hanover.edu",
			"vosm@hanover.edu",
			"altermattw@hanover.edu"
			);
		if(in_array($userid,$administrators)) { // does user have admin privileges?
			$_SESSION['admin'] = 1;			
		}
}

function isLoggedIn()
{
    if(isset($_SESSION['valid']) && $_SESSION['valid'])
        return true;
    return false;
}

function isAdmin()
{
    if(isset($_SESSION['admin']) && $_SESSION['admin'])
        return true;
    return false;
}

function logout()
{
    session_destroy(); 
    $_SESSION = array(); //destroy all of the session variables
       
}

// file upload utilities
	$ext = pathinfo($uploadedFilename)['extension'];
	while (true) { // generate unique filename for uploads
 		$prefix = date('Y',time()) . '.'; // prepends the filename with the 4-digit year and a period
 		$filename = uniqid($prefix, true) . '.' . $ext;
 		if (!file_exists('../upload/' . $filename)) break;
	}

?>