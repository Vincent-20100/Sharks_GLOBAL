<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	// open connection
	require 'dbConnect.php';
	
	$username = $_POST['username'];
	
	// get the user's password salt
	$query  = "SELECT salt FROM Player WHERE username = '$username'";
	
	if ($result = $mysqli->query($query)) {
		if ($result->num_rows === 1) {
			$row = $result->fetch_row();
			print $row[0];
		}
		else {
			echo "Failed";
		}
		$result->close();
	}
	
	// close connection
	include 'dbDisconnect.php';
?>
