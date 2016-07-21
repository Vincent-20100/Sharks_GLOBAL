<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	include 'dbManager.php';
	
if( isset($_POST['username']) ) {
	
	// open connection
	$db = dbOpen();
	
	$username = test_input($_POST['username']);
	
	// get the user's password salt
	$q = $db->query("	UPDATE Player Pl, Person P
						SET tutorialFinished = TRUE
						WHERE Pl.id_person = P.id
						AND (username = '$username'
						OR email = '$username')");
	if($q) {
		echo "Success";
	}
	else {
		echo "Failed";
	}
	
	// close connection
	dbClose($db);
}
else {
	echo "Missing parameter";
}

//modify any special character like <p> </p>
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
