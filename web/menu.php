<?php
// Start the session
include 'php_script/startSession.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Shark Tagging Game</title>
		<meta charset="UTF-8">
		
		<?php include('php_shared/header.php'); ?>
		
		<link rel="stylesheet" href="css/menu.css">

		<style type="text/css">
		.error {color: #FF0000;}
		</style>

	</head>
	<body background="images/back.jpg">
		<?php 
			  include 'php_shared/head.php';
		?>
		
		<div class="raw">
			<h1> <font color = red>
				Shark Tagging Game
			</h1>
			<div class="menu_simple text-center">
			<div class="btn-vertical">
				<a href="game.php" class="btn btn-primary btn-lg btn-block" role="button">Play</a>
				<a href="tutorial.php" class="btn btn-primary btn-lg btn-block" role="button">Tutorial</a>
				<a href="scores.php" class="btn btn-primary btn-lg btn-block" role="button">Highscores</a>
				<a href="credits.php" class="btn btn-primary btn-lg btn-block" role="button">Credits</a>
				<a href="logout.php" class="btn btn-primary btn-lg btn-block" role="button">Log out</a>
			</div>
			</div>
		</div>
	</body>
</html>
