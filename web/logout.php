<?php
include 'php_header.php';

print_r($_SESSION['id']);



// disconnect the user in the database
require 'php_script/dbConnect.php';
$query = "UPDATE Person
			SET id_sessionCurrent = NULL
			WHERE id = {$_SESSION['user']['id']}";

$result = $mysqli->query($query);

require 'php_script/dbDisconnect.php';

if( ! $result) {
	echo "An error occured while loging out.";
}
/*
else {
	// generate a new session id leads to fail connection with the previous session id
	// it keeps the session vars and global vars
	session_regenerate_id();
	
	// remove the session vars
	$_SESSION = array();

	// redirection to the login page
	header("Location: login.php");
	exit();
}
*/


?>
