<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Shark Tagging Game</title>
	<meta charset="UTF-8">
	
	<!-- Custom CSS for login.php -->
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

	<!-- Check the user inputs to log in and register -->
	<script src="javascript/loginCheck.js"></script>
	<!-- Effects to change view between log in and registry -->
	<script src="javascript/loginEffects.js"></script>

	<style type="text/css">
	.error {color: #FF0000;}
	</style>

</head>
<body background="images/back.jpg">
<?php include 'noscript.php' ?>
<!--
/****************************************************************************/
/* HTML inpired from "Login and Register tabbed form"						*/
/* Bootstrap 3.3.0 Snippet by pukey22 										*/
/* http://bootsnipp.com/snippets/featured/login-and-register-tabbed-form 	*/
/****************************************************************************/
 -->
<div class="container">
	<div class="row">
		<div id="disp-error" class="col-sm-6 col-sm-offset-3">
			<div id="disp-error-msg" class="col-xs-12 text-center alert alert-success hide" ></div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
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
						<div class="col-xs-12">
							<form id="login-form" action="menu.php" method="POST" enctype="multipart/form-data" role="form" style="display: block;">
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="text" name="username" id="username-login" tabindex="1" class="form-control" placeholder="Username" value="" maxlength="30" pattern="[A-Za-z0-9=!\-@._*$]*" required/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="password" name="password" id="password-login" tabindex="2" class="form-control" placeholder="Password" value="" maxlength="30" required/>
										</div>
									</div>
								</div>
								<div class="form-group text-center">
									<input type="checkbox" tabindex="3" class="" name="remember" id="remember"/>
									<label for="remember"> Remember Me</label>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="submit" id="login-submit" tabindex="4" class="btn btn-primary btn-lg btn-block" value="Log In"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12">
											<div class="text-center">
												<a href="forgotPassword.php" tabindex="5" class="forgot-password">Forgot Password?</a>
											</div>
										</div>
									</div>
								</div>
							</form>
							<form id="register-form" action="/136.206.48.174/SharksTag/" method="POST" enctype="multipart/form-data" role="form" style="display: none;">
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="text" name="username" id="username-register" tabindex="1" class="form-control" placeholder="Username" value="" maxlength="30" pattern="[A-Za-z0-9=!\-@._*$]*" required/>
										</div>
										<div name="validation" id="username-validation" class="hidden-xs col-sm-1"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="email" name="email" id="email-register" tabindex="2" class="form-control" placeholder="Email Address" value="" maxlength="30" required/>
										</div>
										<div name="validation" id="email-validation" class="hidden-xs col-sm-1"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="password" name="password" id="password-register" tabindex="3" class="form-control" placeholder="Password" value="" maxlength="30" pattern="[A-Za-z0-9=!\-@._*$]*" required/>

										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="password" name="confirm-password" id="confirm-password-register" tabindex="4" class="form-control" placeholder="Confirm Password" value="" maxlength="30" pattern="[A-Za-z0-9=!\-@._*$]*" required/>
										</div>
										<div name="validation" id="confirm-password-validation" class="hidden-xs col-sm-1"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="submit" id="register-submit" tabindex="5" class="btn btn-success btn-lg btn-block" value="Register Now"/>
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

</body>
</html>
