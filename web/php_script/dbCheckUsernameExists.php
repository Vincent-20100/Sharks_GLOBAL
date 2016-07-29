<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	header('Access-Control-Allow-Origin: *');
	include 'dbManager.php';

$return = false;
if( isset($_POST['username']) ) {
	
	// open connection
	$db = dbOpen();
	
	$username = $_POST['username'];
	
	// find potential accounts already using this username
	$q = $db->query("	SELECT id FROM Person
						WHERE username = '$username'");
	if ($q) {
		if ($q->fetch(PDO::FETCH_ASSOC)) { // $result >= 1
			// this username is already used
			echo "Username already exist : Success";
			$return = true;
		}
		else {
			echo "Username doesn't already exist";
		}
	}
	
	// close connection
	dbClose($db);
	
}
else {
	echo "No username post data : Failed";
}
return $return;
?>
