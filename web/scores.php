<?php
// Start the session
include 'php_script/startSession.php';
?>

<!DOCTYPE html>
<html>

<head>
	<title>Shark Tagging Game</title>
	<meta charset="UTF-8"/>
	
	<?php include('php_shared/header.php'); ?>
	
	<link rel="stylesheet" href="css/menu.css"/>
</head>
<body background="images/back.jpg">
	<?php 
		include 'php_shared/head.php';
	?>
	<div id="table-highscores" class="container">
		
		<div class="panel panel-default">
			<!-- Table -->
			<div class="table-responsive">
				<table class="table table-hover table-bordered table-condensed" border="1">
					<thead>
						<tr>
							<th colspan="3" id="table-title">Highscores</th>
						</tr>
	   					<tr>
							<th name="col1" class="text-center">Player</th>
							<th name="col2" class="text-center">Tagged sharks</th>
							<th name="col3" class="text-center">Score</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td name="col1">play1</td>
							<td name="col2">55</td>
							<td name="col3">55</td>
						</tr>
						<tr>
							<td name="col1">play1</td>
							<td name="col2">55</td>
							<td name="col3">55</td>
						</tr>
						<tr>
							<td name="col1">play2</td>
							<td name="col2">45</td>
							<td name="col3">45</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<br/><br/>
		<div class="raw">
			<div class="col-lg-12 text-center">
				<a href="menu.php" class="btn btn-primary btn-lg" role="button">Back</a>
			</div>			
		</div>
	</div>
</body>
</html>

