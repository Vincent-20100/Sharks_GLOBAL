<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	
if( isset($_POST['email']) && isset($_POST['username']) &&
	isset($_POST['password']) && isset($_POST['salt']) ) {
	
	// find potential accounts already using this username or email
	// check if this email is already used
	// check if this username is already used
	
	$r1 = require 'checkEmailExists.php';
	$r2 = require 'checkUsernameExists.php';
	if ($r1 || $r2) {
		echo "Failed";
	}
	else {
		
		// open connection
		require 'dbConnect.php';
		
		$email = $_POST['email'];
		$username = $_POST['username'];
		$passwd_hash = $_POST['password'];
		$salt = $_POST['salt'];
		$activationCode = bin2hex(random_bytes(5));
		
		$query  = "INSERT INTO Player(`username`, `email`, `password`, `salt`, `session`, `activationCode`/*, `ip`*/)
					VALUES('$username', '$email', '$passwd_hash', '$salt', '{$_SESSION['id']}', '$activationCode'/*, '{$_SERVER['REMOTE_ADDR']}'*/)";
		if ($mysqli->query($query)) {
			echo "Success";
		}
		else {
			echo "Failed";
		}
		
		// close connection
		include 'dbDisconnect.php';
		
	}
}
else {
	echo "Failed";
}
?>
