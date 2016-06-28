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
	<div class="container">
		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading text-center"> 
				<font size = 10px> Highscores </font>
			</div>
			
			<!-- Table -->
			<table class="table table-bordered table-condensed" id="HighscoresTable">
				<thead>
   					<tr>
						<th name="col1" class="text-center">Player</th>
						<th name="col2" class="text-center">Score</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td name="col1">play1</td>
						<td name="col2">55</td>
					</tr>
					<tr>
						<td name="col1">play2</td>
						<td name="col2">45</td>
					</tr>
				</tbody>
				
			</table>
		</div>
		<br><br>
		<div class="raw">
			<div class="col-offset-6 col-lg-12 col-sm-12 col-md-24 col-xl-36 col-xs-12 text-center">
				<a href="menu.php" class="btn btn-primary btn-lg" role="button">Back</a>
			</div>			
		</div>
	</div>
</body>
</html>

