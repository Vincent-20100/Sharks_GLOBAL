<?php
// Start the session
include 'php_script/startSession.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/menu.css">

		 <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<!-- Latest jQuery Library -->
		<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
		<!-- Latest jQuery Validation Plugin -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

		<style type="text/css">
		.error {color: #FF0000;}
		</style>

		<title>Shark Tagging Game</title>

	</head>
	<body background="images/back.jpg">
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
