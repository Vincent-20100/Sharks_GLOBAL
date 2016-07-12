<?php
// Start the session
include 'php_script/startSession.php';
?>

<!DOCTYPE html>
<html>

<head>
	<title>Shark Tagging Game</title>
	<meta charset="UTF-8"/>
	
	<?php include('php_shared/header.php'); ?>
	
	<script type="text/javascript" src="javascript/account.js"></script>
	<script src="javascript/accountInputCheck.js"></script>

	<link rel="stylesheet" href="css/menu.css"/>
</head>
<body background="images/back.jpg">
	<?php 
		include 'php_shared/head.php';
	?>
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">	
			<div class="panel panel-default text-center">
				<div class="panel-heading">
					<div class="row">
						
						<?php echo "<h2>Welcome " . $_SESSION['user']->username() . "</h2>"; ?>

						
					</div>
				</div>
				<div class="panel-body">
					<div class="panel-heading">
						<div class="row">
						
								<h3>Change Password</h3>
						
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="form-group">
								<div class="row">
									<div class="col-sm-offset-1 col-sm-10">
										<input type="password" name="password" id="oldpassword" tabindex="2" class="form-control" placeholder="Old Password" value="" maxlength="30" required/>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-offset-1 col-sm-10">
										<input type="password" name="password" id="newpassword" tabindex="3" class="form-control" placeholder="New Password"  maxlength="64" pattern="[A-Za-z0-9=!\-@._*$]*" required/>
									</div>
										<div name="validation" class="hidden-xs col-sm-1">
											<div class="content show-tooltip icon-info" data-toggle="popover" data-placement="right" 
												data-title="How to choose a strong password?"
												data-content="It must contain at least 6 character long with one digit, one uppercase and one lowercase character.">
												<span class="glyphicon glyphicon-info-sign"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-offset-1 col-sm-10">
										<input type="password" name="confirm-password" id="confirm-newpassword" tabindex="4" class="form-control" placeholder="Confirm New Password" value="" maxlength="64" pattern="[A-Za-z0-9=!\-@._*$]*" required/>
									</div>
									<div name="validation" id="confirm-password-validation" class="hidden-xs col-sm-1"></div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3">
										<input type="submit" name="submit" id="changepassword-submit" tabindex="5" class="btn btn-success btn-lg btn-block" value="Apply Change"/>
									</div>
								</div>
							</div>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
