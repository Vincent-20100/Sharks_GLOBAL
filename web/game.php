<?php include 'php_script/startSession.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Sharks Tag game</title>
	
	<?php include('php_shared/header.php'); ?>
	
	<link rel="stylesheet" type="text/css" href="css/game.css">
	<script type="text/javascript" src="javascript/game.js"></script>
	
	<!-- in listSpecies.php -->
	<link rel="stylesheet" type="text/css" href="css/modal.css">
	<script type="text/javascript" src="javascript/comboBoxSharksSpecies.js"></script>
	<script type="text/javascript" src="javascript/modal.js"></script>
	
</head>
<body data-spy="scroll" data-target="#navGame" >
<embed src="/SharksTag/music/wave.wav" autostart="true" loop="-1" hidden="true"></embed>
<audio id='player_audio' src="/SharksTag/music/buble.wav"></audio>
	<?php
		include 'php_shared/head.php';
		include 'php_script/navbarGame.php';
	?>

	<!--Tips-->
	<div id="tipsMenu" class="container-fluid dontShow">
		<p>Tips :</p>
		<ul>
			<li>Show/hide tips by pressing T (shortcut = 'T')</li>
			<li>Delete the selected zone by pressing DELETE (shortcut = 'Delete')</li>
			<li>Remove all your shapes by pressing ResetAll (shortcut = 'Esc')</li>
			<li>NEW IMAGE : Press 'Alt' + 'N' on the keyboard or click on the 'New image' button</li>
			<li>Move the selected zone by dragging them with the mouse  (shortcut = arrows)</li>
			<li>Change the selected shape's width and height by grabbing points (shortcut = '+' '-')</li>
		</ul>
	</div>
	<!--Image Container-->
	<div id="container" class="container noSelect" onmousedown="initZone()" onmousemove="setZone()" onmouseup="endSelectZone()" >
		<div id="imageContainer" class="noSelect">
			<img class="img-responsive" src="images/tutorial.jpg">
		</div>
	</div>
	
</body>
</html>
