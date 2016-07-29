<?php
// Start the session
include_once 'php_script/startSession.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Shark Tagging Game</title>
		<meta charset="UTF-8">
		
		<?php include('php_shared/shared_Links&Scripts.php'); ?>
		
		<link rel="stylesheet" href="css/menu.css">

		<style type="text/css">
		.error {color: #FF0000;}
		</style>

	</head>
	<body background="images/back.jpg" class="stop-scrolling">
		<?php 
			  include 'php_shared/head.php';
		?>
		
		<div class="raw">
			<h1 style="color: red;">
				Shark Tagging Game
			</h1>
			<div class="menu_simple text-center">
				<div class="btn-vertical">
					<?php
					// admins don't play because they don't have a score attribute
					if (!$_DEBUG) {
						if (! $_SESSION['user']->isAdmin()) {
							echo "
							<a href='game.php' class='btn btn-primary btn-lg btn-block' role='button'>Play</a>
							<a href='tutorial.php' class='btn btn-primary btn-lg btn-block' role='button'>Tutorial</a>
							";
						}
					}
					?>
					<a href="scores.php" class="btn btn-primary btn-lg btn-block" role="button">Highscores</a>
					<a href="account.php" class="btn btn-primary btn-lg btn-block" role="button">Your account</a>
					<a href="credits.php" class="btn btn-primary btn-lg btn-block" role="button">Credits</a>
					<a href="logout.php" class="btn btn-primary btn-lg btn-block" role="button">Log out</a>
				</div>
			</div>
		</div>
	</body>
</html>