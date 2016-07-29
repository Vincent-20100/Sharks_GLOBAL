<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	header('Access-Control-Allow-Origin: *');
	include 'dbManager.php';

$return = false;
if( isset($_POST['email']) ) {
	// open connection
	$db = dbOpen();
	
	$email = $_POST['email'];
	
	// find potential accounts already using this email
	$q = $db->query("	SELECT id FROM Person
						WHERE email = '$email'");
	
	if ($q) {
		if ($q->fetch(PDO::FETCH_ASSOC)) {  // $result >= 1
			// this email is already used
			echo "Email already exist : Success";
			$return = true;
		}
		else {
			echo "Email doesn't already exist";
		}
	}
	
	// close connection
	dbClose($db);
	
}
else {
	echo "No email post data : Failed";
}
return $return;
?>
