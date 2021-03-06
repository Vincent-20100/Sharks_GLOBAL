<?php
	// Start the session
	include_once 'php_script/startSession.php';
	include_once 'php_script/dbSendRequestRecoveryCode.php';

	$usernameOrEmailErr = "";
	$usernameOrEmail = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

	  	if (empty($_POST["usernameOrEmail"])) {

	    	$usernameOrEmailErr = "Enter a username or an email";
		} else {
			
		    $usernameOrEmail = test_input($_POST["usernameOrEmail"]);

		    // check if username/e-mail address is well-formed
		    if (!preg_match("/^[a-zA-Z ]*$/",$usernameOrEmail) && !filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
		      	$usernameOrEmailErr = "This username/email adress is invalid";
		    } 
		    else {
		    	//success !

		    	sendRecoveryCode($usernameOrEmail);

		    	header("Location: recoverActivation.php");
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


<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Shark Tagging Game</title>
	<meta charset="UTF-8">
	
	<?php include('php_shared/shared_Links&Scripts.php'); ?>
	
	<link rel="stylesheet" href="css/recover.css">

	<style type="text/css">
	.error {color: #FF0000;}
	</style>

</head>
<body background="images/back.jpg" class="stop-scrolling">

<?	include_once 'php_shared/head.php'; ?>


<!--
/****************************************************************************/
/* HTML inpired from "Login and Register tabbed form"						*/
/* Bootstrap 3.3.0 Snippet by pukey22 										*/
/* https://bootsnipp.com/snippets/featured/login-and-register-tabbed-form 	*/
/****************************************************************************/
 -->
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-recover">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12">
							<a href="#" class="active" id="recover-form-link">Recover Account</a>
						</div>
					</div>
					<hr>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<form id="recover-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data" role="form" style="display: block;">
								<div class="form-group">
									<input type="text" name="usernameOrEmail" id="usernameOrEmail" tabindex="1" class="form-control" placeholder="Username or Email Address" value="<?php echo $usernameOrEmail?>">
									<span class="error"><?php echo $usernameOrEmailErr;?></span>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-3 col-sm-6">
											<input type="submit" name="recover-submit" id="recover-submit" tabindex="2" class="btn btn-success btn-lg btn-block" value="Recover Account">
										</div>
										<div class="col-sm-3">
											<a href="login.php" role="button" name="cancel" id="cancel" tabindex="3" class="btn btn-danger btn-lg btn-block">Cancel</a>
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
	    $('#recover-form-link').click(function(e) {
			$("#recover-form").delay(100).fadeIn(100);
			$(this).addClass('active');
			e.preventDefault();
		});
	});
</script>

</html>
