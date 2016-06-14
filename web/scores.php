<!DOCTYPE html>
<html>

	<head>
	<title>Shark Tagging Game</title>
	<meta charset="UTF-8">
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

	<link rel="stylesheet" href="css/menu.css">
	<style type="text/css">
	.error {color: #FF0000;}
	</style>

</head>
	<body background="images/back.jpg">
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

