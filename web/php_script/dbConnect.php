<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	if (!session_id()){
		session_start();
		$_SESSION['id'] = session_id();
	}
	else {
		// session already started
	}
	//print $_SESSION['id'] = session_id();
	
	
	
	$mysqli = new mysqli("http://136.206.48.174", "root", "", "sharksTaggingGame");
	if ($mysqli->connect_errno) {
		//echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
?>
