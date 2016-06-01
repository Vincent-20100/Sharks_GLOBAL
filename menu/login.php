<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Shark Tagging Game</title>
	<meta charset="UTF-8">
	
	<link rel="stylesheet" href="css/login.css">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
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
	$usernameErr = $emailErr = $passwordErr = $password_againErr = "";
	$username = $email = $password = $password_again = "";
	$remember = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$remember = $_POST["remember"];

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

<!--
/****************************************************************************/
/* HTML inpired from "Login and Register tabbed form"						*/
/* Bootstrap 3.3.0 Snippet by pukey22 										*/
/* http://bootsnipp.com/snippets/featured/login-and-register-tabbed-form 	*/
/****************************************************************************/
 -->
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-login">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-6">
							<a href="#" class="active" id="login-form-link">Login</a>
						</div>
						<div class="col-xs-6">
							<a href="#" id="register-form-link">Register</a>
						</div>
					</div>
					<hr>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<form id="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" role="form" style="display: block;">
								<div class="form-group">
									<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="<?php echo $usernameErr;?>">
								</div>
								<div class="form-group">
									<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="<?php echo $passwordErr;?>">
								</div>
								<div class="form-group text-center">
									<input type="checkbox" tabindex="3" class="" name="remember" id="remember" <?php if (isset($remember)) echo "checked";?>>
									<label for="remember"> Remember Me</label>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-primary btn-md" value="Log In">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-12">
											<div class="text-center">
												<a href="forgotPassword.php" tabindex="5" class="forgot-password">Forgot Password?</a>
											</div>
										</div>
									</div>
								</div>
							</form>
							<form id="register-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" role="form" style="display: none;">
								<div class="form-group">
									<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="<?php echo $usernameErr;?>">
								</div>
								<div class="form-group">
									<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="<?php echo $emailErr;?>">
								</div>
								<div class="form-group">
									<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="">
								</div>
								<div class="form-group">
									<input type="password" name="confirm-password" id="confirm-password" tabindex="3" class="form-control" placeholder="Confirm Password" value="">
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-success btn-md" value="Register Now">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	//FadIn / FadOut and active effect for login and register form
	$(function() {

	    $('#login-form-link').click(function(e) {
			$("#login-form").delay(100).fadeIn(100);
	 		$("#register-form").fadeOut(100);
			$('#register-form-link').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		});
		$('#register-form-link').click(function(e) {
			$("#register-form").delay(100).fadeIn(100);
	 		$("#login-form").fadeOut(100);
			$('#login-form-link').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		});

	});
</script>

<script type="text/javascript">
	//Quick validation of the inputs
	$(document).ready(function () {
		$('#login-form').validate({
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

<script type="text/javascript">
	//Quick validation of the inputs
	$(document).ready(function () {
		$('#register-form').validate({
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
