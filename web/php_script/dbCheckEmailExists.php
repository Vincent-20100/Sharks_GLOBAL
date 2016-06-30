<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
$return = false;
if( isset($_POST['email']) ) {
	// open connection
	require 'dbConnect.php';
	
	$email = $_POST['email'];
	
	// find potential accounts already using this email
	$query  = "SELECT id FROM Person
				WHERE email = '$email'";
	
	if ($result = $mysqli->query($query)) {
		if ($result->num_rows <= 0) {
			echo "Failed";
		}
		else {  // $result >= 1
			// this email is already used
			echo "Success";
			$return = true;
		}
		
		$result->close();
	}
	
	// close connection
	include 'dbDisconnect.php';
	
}
else {
	echo "BIG Failed";
}
return $return;
?>
