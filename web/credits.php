<?php
// Start the session
include 'php_script/startSession.php';
?>

<!DOCTYPE html>
<html>

	<head>
	<title>Shark Tagging Game</title>
	<meta charset="UTF-8">
	
	<?php include('php_shared/header.php'); ?>
	
	<link rel="stylesheet" href="css/menu.css">
	
	<style type="text/css">
	.error {color: #FF0000;}
	</style>

</head>
	<body background="images/back.jpg">
<?php 
	  include 'php_shared/head.php';
?>
		<div class="raw">
			<h2> <font color = blue>
				Credits
			</h2>
			<br><br><font color = #483D8B>
			<p>Tristan Le Nair</p>			
			<p>Florian Talour</p>
			<p>Vincent Bessouet</p>
			<p>Cassien Ippolito</p>
			<br><br>
			<div class="raw">
				<div class="col-offset-6 col-lg-12 col-sm-12 col-md-24 col-xl-36 col-xs-12 text-center">
					<a href="menu.php" class="btn btn-primary btn-lg" role="button">Back</a>
				</div>			
			</div>
		</div>
	</body>
</html>
