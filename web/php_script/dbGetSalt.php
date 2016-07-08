<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	include 'dbManager.php';
	
if( isset($_POST['username']) ) {
	
	// open connection
	$db = dbOpen();
	
	$username = $_POST['username'];
	
	// get the user's password salt
	$q = $db->query("	SELECT salt
						FROM Person
						WHERE username = '$username'");
	if($q) {
		if ($row = $q->fetch(PDO::FETCH_ASSOC)) {
			print $row['salt'];
		}
		else {
			echo "Failed";
		}
	}
	
	// close connection
	dbClose($db);
}
else {
	echo "Failed";
}
?>
