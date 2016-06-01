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
	<?php// echo realpath(dirname(__FILE__) . '/..').'/php_script/registerFormCheck.php'?>
	<?php// require_once(realpath(dirname(__FILE__) . '/..').'/php_script/registerFormCheck.php') ?>
	<?php// require_once(realpath(dirname(__FILE__) . '/..').'/php_script/supports_input_placeholder.php') ?>

	<style type="text/css">
	.error {color: #FF0000;}
	</style>
	
</head>
<body background="images/back.jpg">

<?php 
	$usernameErr = $emailErr = $passwordErr = $password_againErr = "";
	$username = $email = $password = $password_again = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  	if (empty($_POST["username"])) {
	    	$nameErr = "Username is required";
		} else {
			//success !
		    $username = test_input($_POST["username"]);

		    // check if username only contains letters and whitespace
		    if (!preg_match("/^[a-zA-Z ]*$/",$username)) {
		      $nameErr = "Only letters and white space allowed";
		    }
		}
		  
		if (empty($_POST["email"])) {
		   	$emailErr = "email is required";
	  	} else {
		    //success !
		    $email = test_input($_POST["email"]);

		    // check if e-mail address is well-formed
		    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		      $emailErr = "Invalid email format";
		    }
		}

		if (empty($_POST["password"])) {
		   	$passwordErr = "Password is required";
	  	} else {
	  		//success !
		    $password = test_input($_POST["password"]);
		    
			if (empty($_POST["password_again"])) {
			   	$password_againErr = "Password repeat is required";
		  	} else {
		  		//success !
			    $password_again = test_input($_POST["password_again"]);

			    //Testing password conditions
			    if ($_POST["password"] != $_POST["password_again"]) {
				   	$passwordErr = "Passwords are not the same";
				   	$password_againErr = "Passwords are not the same";
				}
				else {
				   	// success!

					//The password must be at least 8 character long
			    	if(strlen($_POST["password"])<8) {
			    		$passwordErr = "Password must be at least 8 character long";
			    	} 
			    	else {

			    		//success !

						//The password must not contain the username
						if(strpos($_POST["password"], $_POST["username"])) {
							$passwordErr = "Passwords must contain the username";
						}
						else {
							//success !

							//The password must contain one number
							if(strspn($_POST["password"], "0123456789")) {
								$passwordErr = "Passwords must contain at least one numerical value";
							}
							else {
								//success !

								//The password must contain one lower case character
								if(strspn($_POST["password"], "abcdefghijklmnopqrstuvwxyz")>0) {
									$passwordErr = "Passwords must not contain at least one lower case character";
								}
								else {
									//success !

									//The password must contain one upper case character
									if(strspn($_POST["password"], "ABCDEFGHIJKLMNOPQRSTUVWXYZ")>0) {
										$passwordErr = "Passwords must contain at least one upper case character";
									}
									else {
										//success !
									}
								}
							}
						}
			    	}
				}
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
			<form class="form-horizontal list-group-item" id="registerForm" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off" onsubmit="return validateForm()">
				<div class="form-group">
					<label class="col-sm-4 control-label" for="username">Username:</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" name="username" id="username" value="<?php echo $username?>" autofocus required>
						<span class="error">* <?php echo $usernameErr;?></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="email">email:</label>
					<div class="col-sm-8">
						<input class="form-control" type="email" name="email" id="email" placeholder="Enter a valid email adress" value="<?php echo $email?>" required>
						<span class="error">* <?php echo $emailErr;?></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="password">Password:</label>
					<div class="col-sm-8">
						<input class="form-control" type="password" name="password" id="password" value="<?php echo $password?>" required>
						<span class="error">* <?php echo $passwordErr;?></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="password_again">Repeat password:</label>
					<div class="col-sm-8">
						<input class="form-control" type="password" name="password_again" id="password_again" value="<?php echo $password_again?>" required>
						<span class="error">* <?php echo $password_againErr;?></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-default">Register</button>
					</div>
				</div>
			</form>
		</li>
		<li class="list-group-item"><a href="connexion.php" class="list-group-item">Cancel</a></li>
	</ul>
	
</div>

<script type="text/javascript">
	
/*
	function validateForm() {
	    var username = document.forms["registerForm"]["username"].value;
		var email = document.forms["registerForm"]["email"].value;
	    var password = document.forms["registerForm"]["password"].value;
	    var password_again = document.forms["registerForm"]["password_again"].value;
	    if (username == null || username == "" ) {
	        alert("Name must be filled out");
	        return false;
	    }
	    else if (email == null || email == "") {
	    	alert("Email must be filled out");
	        return false;
	    }
	    else if (password == null || password == "") {
	    	alert("Password must be filled out");
	        return false;
	    }
	    else if (password != password_again){
	    	alert("Passwords are not the same");
	        return false;
	    }

	}
*/

	//Quick validation of the inputs
	$(document).ready(function () {
		$('#registerForm').validate({
			rules: {
				username: {
					required: true,
					lettersonly: true
				},
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 8
				},
				password_again: {
					required: true,
					minlength: 8
				}

			},
			messages: {
				username: {
					required: "Enter a username",
					lettersonly: "Username must contain only letters"
				},
				email: {
					required: "Enter an email adress",
					email: "Email must be valid"
				},
				password: {
					required: "Enter a password",
					minlength: "Password must be 8 character long at least"
				},
				password_again: {
					required: "Enter the password again",
					minlength: "Password must be 8 character long at least"
				}
			},
			submitHandler: function(form) {
	        	form.submit();
	   		}
		})
	});


</script>

</body>
</html>