<?php
include 'php_script/startSession.php';
?>


<!DOCTYPE HTML>
<html lang="en">
<head>
	<title>Shark Tagging Game - activate your account</title>
	<meta charset="UTF-8">

	<?php include('php_shared/header.php'); ?>
	
	<style type="text/css">
	.error {color: #FF0000;}
	</style>

</head>
<body background="images/back.jpg">
<?php 
	  include 'php_shared/head.php';
?>


<?php 
	$activationCode = "";

	if (isset($_POST["activationCode"])) {

	  	if (empty($_POST["activationCode"])) {
	    	echo "Please, enter an activation code.";
		} else {
			//success !
		    $activationCode = test_input($_POST["activationCode"]);

		    $querySelect = "SELECT id
		    				FROM Person
		    				WHERE activationCode = '$activationCode'";
		    
		    $queryUpdate = "UPDATE Person
		    				SET activationCode = NULL
		    				WHERE activationCode = '$activationCode'";
		    
		    include 'php_script/dbConnect.php';
		    
		    if ($result = $mysqli->query($querySelect)) {
		    	if($result->num_rows == 1) {
		    		if ($result = $mysqli->query($queryUpdate)) {
		    			echo 'Success';
		    		}
		    		else echo 'Failed while using your valid code';
		    	}
		    	else {
		    		echo 'Invalid code.';
		    	}
		    }
		    else {
		    	echo "Can't execute the request.";
		    }
		    
		    include 'php_script/dbDisconnect.php';
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
/* https://bootsnipp.com/snippets/featured/login-and-register-tabbed-form 	*/
/****************************************************************************/
 -->
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-activateAccount">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12">
							<a href="#" class="activate" id="activateAccount-form-link">Activate Account</a>
						</div>
					</div>
					<hr>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<form id="activateAccount-form" action="" method="POST" enctype="multipart/form-data" role="form" style="display: block;">
								<div class="form-group">
									<input type="text" name="activationCode" id="activationCode" tabindex="1" class="form-control" placeholder="Enter your activation code here" value="<?php if(isset($_GET['code'])) { echo $_GET['code'] ; } ?>">
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-offset-3 col-sm-6">
											<input type="submit" name="activateAccount-submit" id="activateAccount-submit" tabindex="2" class="btn btn-success btn-lg btn-block" value="Activate Account">
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
	    $('#activateAccount-form-link').click(function(e) {
			$("#activateAccount-form").delay(100).fadeIn(100);
			$(this).addClass('activate');
			e.preventDefault();
		});
	});
</script>

</html>
