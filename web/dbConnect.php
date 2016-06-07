<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	if (!session_id()){
		print "session start<br />";
		session_start();
		$_SESSION['id'] = session_id();
	}
	else {
		print "session already started<br />";
	}
	print $_SESSION['id'] = session_id();
	
	
	
	$mysqli = new mysqli("localhost", "root", "", "sharksTaggingGame");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	
/* **************************************************************************
   ************************************************************************** */
	
	function print_connected() {
		print "<div>Connected.</div>";
	}
	
	function print_notConnected() {
		print "<div>Not connected. Please, check your login and password.</div>";
	}
?>
