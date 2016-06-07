<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	// open connection
	require 'dbConnect.php';
	
	$username = $_POST['username'];
	$passwd_hash = $_POST['passwd'];
	
	// connect to the account by checking the hashed passwd
	$query  = "SELECT id FROM Player
				WHERE username = '$username'
				AND password = '$passwd_hash'";
	
	if ($result = $mysqli->query($query)) {
		if ($result->num_rows === 1) {
			$row = $result->fetch_row();
			// write the current session in the database
			
			query = "UPDATE Player
					SET session = {$_SESSION['id']}
					WHERE username = $username";
			
			print_connected();
		}
		else {
			print_notConnected();
		}
		$result->close();
	}
	
	// close connection
	include 'dbDisconnect.php';
?>
