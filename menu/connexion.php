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
	$usernameErr = $passwordErr = "";
	$username = $password = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  	if (empty($_POST["username"])) {
	    	$usernameErr = "You need an account to log in";
		} else {
			//success !
		    $username = test_input($_POST["username"]);

		    // check if username only contains letters and whitespace
		    if (!preg_match("/^[a-zA-Z ]*$/",$username)) {
		      $usernameErr = "This username doesn't exist";
		    }
		}

		if (empty($_POST["password"])) {
	    	$passwordErr = "You have to enter a valid password";
		} else {
		    //success !
		}
	}

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
?>


<div class="container" >
	<!-- Vertical Menu -->
	<ul class="nav nav-pills nav-stacked">
		<li>
			<form class="form-horizontal list-group-item" id="connexionForm" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<div class="form-group">
					<label class="col-sm-4 control-label" for="username">Username:</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="username" value="<?php echo $username?>" required>
						<span class="error"><?php echo $usernameErr;?></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="password">Password:</label>
					<div class="col-sm-8">
						<input class="form-control" type="password" name="password" value="<?php echo $password?>" required>
						<span class="error"><?php echo $passwordErr;?></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-2">
						<input class="form-control" type="checkbox" name="remember">
					</div>
					<label class="col-sm-6 control-label" style="text-align: left;" for="remember">Keep me logged in</label>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-default">Login</button>
					</div>
				</div>
			</form>
		</li>
		<li><a href="register.html" class="list-group-item">Register</a></li>
		<li><a href="forgotPassword.html" class="list-group-item">Forgot Password</a></li> 
	</ul>
	
</div>

<script type="text/javascript">
	//quick validation of the inputs
	$(document).ready(function () {
		$('#connexionForm').validate({
			rules: {
				username: {
					required: true,
					lettersonly: true
				},
				password: {
					required: true,
					minlength: 8
				}
			},
			messages: {
				username: {
					required: "Enter a username",
					lettersonly: "Username must contain only letters"
				},
				password: {
					required: "Enter a password",
					minlength: "Password must be 8 character long at least"
				}
			},
			submitHandler: function(form) {
	        	form.submit();
	   		}
		});
	});
</script>


</body>
</html>