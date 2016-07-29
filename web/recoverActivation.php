<?php
	include_once 'php_script/startSession.php';
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Shark Tagging Game - recover your account</title>
	<meta charset="UTF-8">

	<?php include('php_shared/shared_Links&Scripts.php'); ?>

	<script type="text/javascript" src="javascript/recoverActivation.js"></script>
	<script type="text/javascript" src="javascript/recoverInputCheck.js"></script>

	<link rel="stylesheet" href="css/recover.css"/>

	<style type="text/css">

		body > .container {
			margin-top: 10%;
		}
		
		.error {color: #FF0000;}
	</style>

</head>
<body background="images/back.jpg" class="stop-scrolling">
<?php 
	  include 'php_shared/head.php';
?>

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
			<div class="panel panel-default text-center">
				<div class="panel-heading">
					<div class="row">
						<h2>Recover Password</h2>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<form id="recoverpassword-form" action="" method="POST" enctype="multipart/form-data" role="form" style="display: block;">
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="text" name="recoveryCode" id="recoveryCode" tabindex="1" class="form-control" placeholder="Enter your recovery code here" value="<?php if(isset($_GET['code'])) { echo $_GET['code'] ; } ?>">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-1 col-sm-10">
											<input type="password" name="password" id="newpassword" tabindex="2" class="form-control" placeholder="New Password"  maxlength="64" pattern="[A-Za-z0-9=!?\-@._*$]*" required/>
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
											<input type="password" name="confirm-password" id="confirm-newpassword" tabindex="3" class="form-control" placeholder="Confirm New Password" value="" maxlength="64" pattern="[A-Za-z0-9=!?\-@._*$]*" required/>
										</div>
										<div name="validation" id="confirm-newpassword-validation" class="hidden-xs col-sm-1"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-8">
											<input type="submit" name="recoverPassword-submit" id="recoverPassword-submit" tabindex="4" class="btn btn-success btn-lg btn-block" value="Recover Password">
										</div>
										<div class="col-sm-4">
											<a href="login.php" role="button" name="cancel" id="cancel" tabindex="5" class="btn btn-danger btn-lg btn-block">Cancel</a>
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
	$(function() {
	    $('#activateAccount-form-link').click(function(e) {
			$("#activateAccount-form").delay(100).fadeIn(100);
			$(this).addClass('activate');
			e.preventDefault();
		});
	});
</script>

</html>
