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
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<div class="panel panel-default text-center">
					<div class="panel-body" style="color: #483D8B;">
						<h2 style="color: Crimson;">
							Credits
						</h2>
						<br>
						<p>This project was initiated by Brian Stone, researcher in Dublin City University and Scuba Diver. It was written under the supervision of Brian Stone and thanks to the previous version of Povilas Auskalnis and Jerzy Baran by Vincent Bessouet, Cassien Ippolito, Tristan Le Nair and Florian Talour.</p><br>
						<p>This is a game with purpose : your actions in the game will help a neural network to learn how to recognize sharks and participate in making statistics. We hope you will have as much fun playing this game as we had making it.</p>		
					</div>
				</div>
			</div>
			<div class="col-lg-12 text-center">
				<a href="menu.php" class="btn btn-primary btn-lg" role="button">Back</a>
			</div>
		</div>
	</div>
	</body>
</html>
