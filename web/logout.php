<?php
// Start the session
include 'php_script/startSession.php';
include 'php_script/dbManager.php';

// disconnect the user in the database
$db = dbOpen();
$result = $db->query("	UPDATE Person
						SET id_sessionCurrent = NULL
						WHERE id_sessionCurrent = '{$_COOKIE['PHPSESSID']}'");

dbClose($db);

if( ! $result) {
	echo "An error occured while loging out.";
}
else {
	// generate a new session id leads to fail connection with the previous session id
	// it keeps the session vars and global vars
	session_regenerate_id();
	
	// remove the session vars
	$_SESSION = array();
	
	session_destroy();
	unset($_SESSION);
	unset($_COOKIE);
	
	// redirection to the login page
	header("Location: login.php");
	exit();

}


?>
