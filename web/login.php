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
	<!-- Latest compiled bootstap JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<!-- Latest jQuery Validation Plugin -->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

	<script type="text/javascript" src="javascript/log.js"></script>
	<script  src="javascript/loginEffects.js"></script>

	<style type="text/css">
	.error {color: #FF0000;}
	</style>

</head>
<body background="images/back.jpg">

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
						<div class="col-lg-12"> <!-- action="http://povilas.ovh:8080/login<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" -->
							<form id="login-form" action="" method="POST" enctype="application/json" role="form" style="display: block;">
								<div id="form-error" class="raw">
									<div id="login-error" class="col-lg-12 text-center alert alert-danger hide" >
									</div>
									<div id="login-error" class="col-lg-12 text-center alert alert-warning hide" >
									</div>
									<div id="login-error" class="col-lg-12 text-center alert alert-info hide" >
									</div>
									<div id="login-error" class="col-lg-12 text-center alert alert-success hide" >
									</div>
								</div>
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
											<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="btn btn-primary btn-lg btn-block" value="Log In">
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
							</form><!-- action="http://povilas.ovh:8080/register<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" -->
							<form id="register-form" action="" method="POST" enctype="application/json" role="form" style="display: none;">
								<div class="form-group">
									<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
								</div>
								<div class="form-group">
									<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
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
											<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="btn btn-success btn-lg btn-block" value="Register Now">
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

	//Quick validation of the inputs to login
	$(document).ready(function () {
		$('#login-form').validate({
			rules: {
				username: {
					required: true,
					usrcheck: true
				},
				password: {
					required: true,
					minlength: 8,
					number: true,
					pwcheck: true
				}
			},
			messages: {
				username: {
					required: "Enter a username",
					usrcheck: "Username must contain only letters and digits"
				},
				password: {
					required: "Enter a password",
					minlength: "Password must be at least {0} character long",
					number: "Password must contain at least one number",
					pwcheck: "Your password must contain at least one uppercase letter, one lower case letter and one digit"
				}
			},
			submitHandler: function(form) {
	        	form.submit();
	   		}
		});

		$.vadator.addMethod("pwcheck", function(value, element) {
				return /^[A-Za-z0-9=!\-@._*$]*$/.test(value) // consist of only these
					&& /[A-Z]/.test(value) // has a upper case letter
					&& /[a-z]/.test(value) // has a lower case letter
					&& /\d/.test(value); // has a digit
		});

		$.vadator.addMethod("usrcheck", function(value, element) {
			return /^[A-Za-z0-9]*$/.test(value); // consist of only these
		});

	});

	//Quick validation of the inputs to register
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
					minlength: 6,
					number: true
				},
				password_again: {
					required: true,
					minlength: 6,
					number: true
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
					minlength: "Password must be at least {0} character long",
					number: "Password must contain at least one number"
				},
				password_again: {
					required: "Enter the password again",
					minlength: "Password must be at least {0} character long",
					number: "Password must contain at least one number"
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
