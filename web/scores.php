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
	
	<script type="text/javascript" src="javascript/scores.js"></script>

	<link rel="stylesheet" href="css/scores.css"/>
</head>
<body background="images/back.jpg">
	<?php 
		include 'php_shared/head.php';
	?>
	<div id="table-highscores" class="container">
		
		<div class="panel panel-default">
			<!-- Table -->
			<div class="table-responsive" >
				<table id="headTable" class="table table-hover table-condensed">
					<tr>
						<th colspan="4" id="table-title">Highscores</th>
					</tr>
   					<tr>
						<th class="text-center">#</th>
						<th name="col1" class="text-center">Player</th>
						<th name="col2" class="text-center">Tagged sharks</th>
						<th name="col3" class="text-center">Score</th>
					</tr>
				</table>
			</div>
			<div id="bodyTable" class="table-responsive">
				<table class="table table-hover table-condensed" ng-app='scoresApp' ng-controller='scoresCtrl'>
					<tr ng-repeat="x in scoresTable">
						<td>{{ x['rank'] }}</td>
						<td name="col1">{{ x['username'] }}</td>
						<td name="col2">{{ x['NB_TAG'] }}</td>
						<td name="col3">{{ x['score'] }}</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="raw">
			<div class="col-lg-12 text-center">
				<a href="menu.php" class="btn btn-primary btn-lg" role="button">Back</a>
			</div>			
		</div>
	</div>
</body>
</html>

