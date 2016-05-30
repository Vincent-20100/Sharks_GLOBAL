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
	
<div class="container" >
	<!-- Vertical Menu -->
	<ul class="nav nav-pills nav-stacked">
		<li>
			<form class="form-horizontal list-group-item" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<div class="raw form-group">
					<label class="col-sm-4 control-label" for="usr">Username:</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="usr" required>
					</div>
					
				</div>
				<div class="raw form-group">
					<label class="col-sm-4 control-label" for="psw">Password:</label>
					<div class="col-sm-8">
						<input class="form-control" type="password" name="psw" required>
					</div>
				</div>
				<div class="raw form-group">
					<div class="col-sm-6 pull-left">
						<input class="form-control" type="checkbox" name="remember" disabled>
					</div>
					<label class="col-sm-6 control-label" style="text-align: left;" for="remember"> Keep me logged in</label>
				</div>
				<div class="raw form-group">
					<div class="col-sm-12">
						<input class="btn btn-default" type="submit" value="Login">
					</div>
				</div>
			</form>
		</li>
		<li><a href="register.php" class="list-group-item">Register</a></li>
		<li><a href="forgotPassword.php" class="list-group-item">Forgot Password</a></li> 
	</ul>
	
</div>

</body>
</html>