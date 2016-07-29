<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	header('Access-Control-Allow-Origin: *');
	include 'dbManager.php';
	
if( isset($_POST['recoveryCode']) ) {
	
	// open connection
	$db = dbOpen();
	
	$recoveryCode = test_input($_POST['recoveryCode']);
	
	// get the user's password salt
	$q = $db->query("	SELECT salt
						FROM Person
						WHERE recoveryCode = '$recoveryCode'");
	
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

//modify any special character like <p> </p>
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
