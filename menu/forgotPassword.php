<!DOCTYPE html>
<html lang="en">
<head>
	<title>Shark Tagging Game</title>
	<meta charset="UTF-8">
	 <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/connexion.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body background="images/back.jpg">

<div class="container">
	<!-- Vertical Menu -->
	<ul class="nav nav-pills nav-stacked" id"menu">
		<li>
			<form class="form-horizontal list-group-item" role="form" action="#" method="post" autocomplete="false">
				<div class="raw form-group">
					<label class="col-sm-6 control-label" for="usr">Username/Email:</label>
					<div class="col-sm-6">
						<input class="form-control" type="text" id="usr" required>
					</div>
				</div>
				<div class="raw form-group">
					<div class="col-sm-12">
						<input class="btn btn-default" type="submit" value="Request code">
					</div>
				</div>
			</form>
		</li>
		<li class="list-group-item"><a href="connexion.php" class="list-group-item">Back</a></li>
	</ul>
	
</div>

</body>
</html>