<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	$mysqli = new mysqli("localhost", "root", "", "sharksTaggingGame");
	if ($mysqli->connect_errno) {
		//echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
?>
