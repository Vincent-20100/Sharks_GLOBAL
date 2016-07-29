<?php
// Start the session
include_once 'php_script/startSession.php';
$_COOKIE["remember"] = false;
$nextPage = "/Sharks/menu.php";
if (isset($_GET['n'])) {
	$nextPage = test_input($_GET['n']);
}

//modify any special character like <p> </p>
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$_COOKIE["username"] = "";
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Shark Tagging Game</title>

	
	<?php include('php_shared/shared_Links&Scripts.php'); ?>

	
	<!-- Custom CSS for login.php -->
	<link rel="stylesheet" href="css/login.css"/>
	<script type="text/javascript" src="javascript/login.js"></script>

	<script type="text/javascript" src="javascript/registerValidation.js"></script>

	<!-- Check the user inputs to log in -->
	<script src="javascript/loginInputCheck.js"></script>
	<!-- Check the user inputs to register -->
	<script src="javascript/registerInputCheck.js"></script>
	<!-- Effects to change view between log in and registry -->
	<script src="javascript/loginPageEffects.js"></script>

	<style type="text/css">
	.error {color: #FF0000;}
	</style>

</head>
<body background="images/back.jpg" class="stop-scrolling">

<?php include 'php_shared/head.php'; ?>
<!--
/****************************************************************************/
/* HTML inpired from "Login and Register tabbed form"						*/
/* Bootstrap 3.3.0 Snippet by pukey22 										*/
/* https://bootsnipp.com/snippets/featured/login-and-register-tabbed-form 	*/
/****************************************************************************/
 -->
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="panel panel-login panel-default">
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
							<form id="login-form" next-page="<?php echo $nextPage; ?>" method="POST" enctype="multipart/form-data" role="form" style="display: block;">
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="text" name="username" id="username-login" tabindex="1" class="form-control" placeholder="Username or e-mail" maxlength="30" pattern="[A-Za-z0-9=!?\-@._*$]*" required/>
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
									<input type="checkbox" tabindex="3" class="" name="remember" id="remember" />
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
							<form id="register-form" next-page="activateAccount.php" method="POST" enctype="multipart/form-data" role="form" style="display: none;">
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="text" name="username" id="username-register" tabindex="1" class="form-control" placeholder="Username" value="" maxlength="64" pattern="[A-Za-z0-9=!?\-@._*$]*" required/>
										</div>
										<div name="validation" id="username-validation" class="hidden-xs col-sm-1"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="email" name="email" id="email-register" html=true tabindex="2" class="form-control" placeholder="Email Address" maxlength="128" required/>
										</div>
										<div name="validation" id="email-validation" class="hidden-xs col-sm-1"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="password" name="password" id="password-register" tabindex="3" class="form-control" placeholder="Password"  maxlength="64" pattern="[A-Za-z0-9=!?\-@._*$]*" required/>
										</div>
										<div name="validation" class="hidden-xs col-sm-1">
											<div class="content show-tooltip icon-info" data-toggle="popover" data-placement="right" 
												data-title="How choose a strong password?"
												data-content="It must contain at least 6 character long with one digit, one uppercase and one lowercase character.">
												<span class="glyphicon glyphicon-info-sign color-info"></span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="password" name="confirm-password" id="confirm-password-register" tabindex="4" class="form-control" placeholder="Confirm Password" value="" maxlength="64" pattern="[A-Za-z0-9=!?\-@._*$]*" required/>
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