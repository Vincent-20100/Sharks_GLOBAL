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
	<!-- Latest jQuery Library -->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
	<!-- Latest jQuery Validation Plugin -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<?php// echo realpath(dirname(__FILE__) . '/..').'/php_script/registerFormCheck.php'?>
	<?php// require_once(realpath(dirname(__FILE__) . '/..').'/php_script/registerFormCheck.php') ?>
	<?php// require_once(realpath(dirname(__FILE__) . '/..').'/php_script/supports_input_placeholder.php') ?>

	
</head>
<body background="images/back.jpg">

<?php 
	$usrInputErr = $emailInputErr = $passwordInputErr = $password_againInputErr = "";
	$usrInput = $emailInput = $passwordInput = $password_againInput = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  	if (empty($_POST["usrInput"])) {
	    	$nameErr = "Username is required";
		} else {
		    $usrInput = test_input($_POST["usrInput"]);
		    // check if usrInput only contains letters and whitespace
		    if (!preg_match("/^[a-zA-Z ]*$/",$usrInput)) {
		      $nameErr = "Only letters and white space allowed";
		    }
		}
		  
		if (empty($_POST["emailInput"])) {
		   	$emailInputErr = "EmailInput is required";
	  	} else {
		    $emailInput = test_input($_POST["emailInput"]);
		    // check if e-mail address is well-formed
		    if (!filter_var($emailInput, FILTER_VALIDATE_EMAIL)) {
		      $emailInputErr = "Invalid emailInput format";
		    }
		}

		if (empty($_POST["passwordInput"])) {
		   	$passwordInputErr = "Password is required";
	  	} else {
	  		//success !
		    $passwordInput = test_input($_POST["passwordInput"]);
		    
			if (empty($_POST["password_againInput"])) {
			   	$password_againInputErr = "Password repeat is required";
		  	} else {
		  		//success !
			    $password_againInput = test_input($_POST["password_againInput"]);

			    //Testing password conditions
			    if ($_POST["passwordInput"] != $_POST["password_againInput"]) {
				   	$passwordInputErr = "Passwords are not the same";
				   	$password_againInputErr = "Passwords are not the same";
				}
				else {
				   	// success!

					//The password must be at least 8 character long
			    	if(strlen($_POST["passwordInput"])<8) {
			    		$passwordInputErr = "Password must be at least 8 character long";
			    	} 
			    	else {

			    		//success !

						//The password must not contain the username
						if(strpos($_POST["passwordInput"], $_POST["usrInput"])) {
							$passwordInputErr = "Passwords must not contain the username";
						}
						else {
							//success !

							//The password must contain one number
							if(strspn($_POST["passwordInput"], "0123456789")) {
								$passwordInputErr = "Passwords must not contain at least one numerical value";
							}
							else {
								//success !

								//The password must contain one lower case character
								if(strspn($_POST["passwordInput"], "abcdefghijklmnopqrstuvwxyz")>0) {
									$passwordInputErr = "Passwords must not contain at least one lower case character";
								}
								else {
									//success !

									//The password must contain one upper case character
									if(strspn($_POST["passwordInput"], "ABCDEFGHIJKLMNOPQRSTUVWXYZ")>0) {
										$passwordInputErr = "Passwords must not contain at least one upper case character";
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
	<ul class="nav nav-pills nav-stacked" id"menu">
		<li>
			<form class="form-horizontal list-group-item" id="registerForm" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off" onsubmit="return validateForm()">
				<div class="raw form-group">
					<label class="col-sm-4 control-label" for="usrInput">Username:</label>
					<div class="col-sm-8">
						<input class="form-control" type="text" id="usrInput" value="<?php echo $usr?>" autofocus required>
					</div>
				</div>
				<div class="raw form-group">
					<label class="col-sm-4 control-label" for="emailInput">EmailInput:</label>
					<div class="col-sm-8">
						<input class="form-control" type="email" id="emailInputInput" placeholder="Enter a valid email adress" value="<?php echo $emailInput?>" required>
					</div>
				</div>
				<div class="raw form-group">
					<label class="col-sm-4 control-label" for="passwordInput">Password:</label>
					<div class="col-sm-8">
						<input class="form-control" type="password" id="passwordInput" value="<?php echo $passwordInput?>" required>
					</div>
				</div>
				<div class="raw form-group">
					<label class="col-sm-4 control-label" for="password_againInput">Repeat password:</label>
					<div class="col-sm-8">
						<input class="form-control" type="password" id="password_againInput" value="<?php echo $password_againInput?>" required>
					</div>
				</div>
				<div class="raw form-group">
					<div class="col-sm-12">
						<input class="btn btn-default" type="submit" value="Register">
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
	    var usrInput = document.forms["registerForm"]["usrInput"].value;
		var emailInput = document.forms["registerForm"]["emailInput"].value;
	    var passwordInput = document.forms["registerForm"]["passwordInput"].value;
	    var password_againInput = document.forms["registerForm"]["password_againInput"].value;
	    if (usrInput == null || usrInput == "" ) {
	        alert("Name must be filled out");
	        return false;
	    }
	    else if (email == null || email == "") {
	    	alert("Email must be filled out");
	        return false;
	    }
	    else if (passwordInput == null || passwordInput == "") {
	    	alert("Password must be filled out");
	        return false;
	    }
	    else if (passwordInput != password_againInput){
	    	alert("Passwords are not the same");
	        return false;
	    }

	}
*/


	$(document).ready(function () {
		$('#registerForm').validate({
			rules: {
				usrInput: {
					required: true,
					lettersonly: true
				},
				emailInput: {
					required: true,
					email: true
				},
				passwordInput: {
					required: true,
					minlength: 8
				},
				password_againInput: {
					required: true,
					minlength: 8
				}

			},
			messages: {
				usrInput: {
					required: "Enter a username",
					lettersonly: "Username must contain only letters"
				},
				emailInput: {
					required: "Enter an email adress",
					email: "Email must be valid"
				},
				passwordInput: {
					required: "Enter a password",
					minlength: "Password must be 8 character long at least"
				},
				password_againInput: {
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