<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
$return = false;
if( isset($_POST['username']) ) {
	
	// open connection
	require 'dbConnect.php';
	
	$username = $_POST['username'];
	
	// find potential accounts already using this username
	$query  = "SELECT id FROM Player
				WHERE username = '$username'";
	
	if ($result = $mysqli->query($query)) {
		if ($result->num_rows <= 0) {
			echo "Failed";
		}
		else { // $result >= 1
			// this username is already used
			echo "Success";
			$return = true;
		}
		
		$result->close();
	}
	
	// close connection
	include 'dbDisconnect.php';
	
}
else {
	echo "Failed";
}
return $return;
?>
