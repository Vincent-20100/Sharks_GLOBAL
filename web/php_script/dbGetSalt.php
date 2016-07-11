<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	
if( isset($_POST['username']) ) {
	
	// open connection
	require 'dbConnect.php';
	
	$username = test_input($_POST['username']);
	
	// get the user's password salt
	$query  = "SELECT salt FROM Person WHERE username = '$username'";
	
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
}
else {
	echo "Failed";
}

//modify any special character like <p> </p>
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
