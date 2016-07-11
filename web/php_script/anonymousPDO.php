<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */

function dbOpen() {
	return new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
}

function dbClose($db) {
	$db = null;
}

?>
