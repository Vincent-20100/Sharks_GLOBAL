<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
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
			echo "Success";
			$return = true;
		}
		else {
			echo "Failed";
		}
	}
	
	// close connection
	dbClose($db);
	
}
else {
	echo "BIG Failed";
}
return $return;
?>
