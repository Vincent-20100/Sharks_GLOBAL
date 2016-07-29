<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
header('Access-Control-Allow-Origin: *');
function dbOpen() {
	try{
		return new PDO('mysql:host=172.16.3.120;dbname=db1200189_sharksTaggingGame', 'u1200189_game', 'divelikeAstone2016');
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
	return null;
}

function dbClose($db) {
	$db = null;
}

?>
