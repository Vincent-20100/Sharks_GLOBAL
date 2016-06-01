<!DOCTYPE html>
<html>

	<head>
	<title>Shark Tagging Game</title>
	<meta charset="UTF-8">
	 <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/menu.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<!-- Latest jQuery Library -->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
	<!-- Latest jQuery Validation Plugin -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

	<style type="text/css">
	.error {color: #FF0000;}
	</style>

</head>
	<body background="images/scores.jpg">
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

			<div class="menu_simple">
				<ul class="nav nav-pills nav-stacked list-group">
					<li><a class="col-sm-12 list-group-item btn-lg" href="menu.php">Back</a></li>
				</ul>
			</div>
		</div>
	</body>
</html>

