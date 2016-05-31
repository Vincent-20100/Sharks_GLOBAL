<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Shark Tagging Game</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" href="css/recover.css">

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
	$usernameOrEmailErr = "";
	$usernameOrEmail = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

	  	if (empty($_POST["usernameOrEmail"])) {

	    	$usernameOrEmailErr = "Enter a username or an email";
		} else {
			//success !
		    $usernameOrEmail = test_input($_POST["usernameOrEmail"]);

		    // check if username/e-mail address is well-formed
		    if (!preg_match("/^[a-zA-Z ]*$/",$usernameOrEmail) && !filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
		      	$usernameOrEmailErr = "This username/email adress is invalid";
		    } 
		    else {
		    	//success !
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
							<form id="recover-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" role="form" style="display: block;">
								<div class="form-group">
									<input type="text" name="usernameOrEmailErr" id="usernameOrEmailErr" tabindex="1" class="form-control" placeholder="Email Address" value="<?php echo $usernameOrEmail?>">
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="recover-submit" id="remember-submit" tabindex="2" class="form-control btn btn-remember" value="Recover Account">
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