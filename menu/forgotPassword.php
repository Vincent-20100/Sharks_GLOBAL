<!DOCTYPE HTML>
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
	<!-- Latest jQuery Library -->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
	<!-- Latest jQuery Validation Plugin -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

	<style type="text/css">
	.error {color: #FF0000;}
	</style>

</head>
<body background="images/back.jpg">

<?php 
	$usernameOrEmailErr = "";
	$usernameOrEmail = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

	  	if (empty($_POST["usernameOrEmail"])) {

	    	$usernameOrEmailErr = "Enter a username or an email";
		} else {
			//success !
		    $usernameOrEmail = test_input($_POST["usernameOrEmail"]);

		    // check if username/e-mail address is well-formed
		    if (!preg_match("/^[a-zA-Z ]*$/",$usernameOrEmail) && !filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
		      	$usernameOrEmailErr = "This username/email adress is invalid";
		    } 
		    else {
		    	//success !
		    }
		}
	}

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
?>

<div class="container">
	<!-- Vertical Menu -->
	<ul class="nav nav-pills nav-stacked" id="menu">
		<li>
			<form class="form-horizontal list-group-item" id="forgotPasswordForm" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="false">
				<div class="form-group">
					<label class="col-sm-6 control-label" for="usernameOrEmail">Username/Email:</label>
					<div class="col-sm-6">
						<input class="form-control" type="text" id="usernameOrEmail" name="usernameOrEmail" value="<?php echo $usernameOrEmail?>" required>
						<span class="error">* <?php echo $usernameOrEmailErr;?></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<!-- <button type="submit" class="btn btn-default">Request code</button> -->
						<input type="submit" name="submit" value="Request code">
					</div>
				</div>
			</form>
		</li>
		<li class="list-group-item"><a href="connexion.php" class="list-group-item">Back</a></li>
	</ul>
	
</div>

</body>
</html>