<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Shark Tagging Game</title>
	<meta charset="UTF-8">
	
	<link rel="stylesheet" href="css/login.css">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<!-- AngularJS library -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<!-- Latest jQuery Validation Plugin -->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
	<script type="text/javascript" src="javascript/log.js"></script>
	<script type="text/javascript" src="javascript/registerValidation.js"></script>
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
						<div class="col-lg-12">
							<form id="login-form" action="/SharksTag/" method="POST" enctype="multipart/form-data" role="form" style="display: block;">
								<div id="login-form-error" class="raw">
									<div id="login-error" class="col-lg-12 text-center alert alert-success hide" >
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-1 col-lg-10">
											<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="<?php echo $usernameErr;?>">
										</div>
										<div class="col-lg-1"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-1 col-lg-10">
											<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="<?php echo $passwordErr;?>">
										</div>
										<div class="col-lg-1"></div>
									</div>
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
							</form>
							<form id="register-form" action="menu.php" method="POST" enctype="multipart/form-data" role="form" style="display: none;">
								<div id="register-form-error" class="raw">
									<div id="register-error" class="col-lg-12 text-center alert alert-success hide"></div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-1 col-lg-10">
											<input type="text" name="username" id="username-register" tabindex="1" class="form-control" placeholder="Username" value=""/>
										</div>
										<div name="validation" id="username-validation" class="col-lg-1"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-1 col-lg-10">
											<input type="email" name="email" id="email-register" tabindex="1" class="form-control" placeholder="Email Address" value="">
										</div>
										<div name="validation" id="email-validation" class="col-lg-1"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-1 col-lg-10">
											<input type="password" name="password" id="password-register" tabindex="2" class="form-control" placeholder="Password" value="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-lg-offset-1 col-lg-10">
											<input type="password" name="confirm-password" id="confirm-password-register" tabindex="3" class="form-control" placeholder="Confirm Password" value="">
										</div><div name="validation" id="confirm-password-validation" class="col-lg-1"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="btn btn-success btn-lg btn-block" value="Register Now" onclick="return false;">
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
