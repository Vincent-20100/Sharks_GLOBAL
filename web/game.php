<?php include_once 'php_script/startSession.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Sharks Tag game</title>
	
	<?php include('php_shared/shared_Links&Scripts.php'); ?>
	
	<link rel="stylesheet" type="text/css" href="css/game.css">
	<script type="text/javascript" src="javascript/game.js"></script>
	
	<!-- in listSpecies.php -->
	<link rel="stylesheet" type="text/css" href="css/modal.css">
	<script type="text/javascript" src="javascript/comboBoxSharksSpecies.js"></script>
	<script type="text/javascript" src="javascript/modal.js"></script>
	
</head>
<body data-spy="scroll" data-target="#navGame" class="stop-scrolling" onmouseup="endSelectZone()">
<embed src="/Sharks/music/wave.wav" autostart="true" loop="-1" hidden="true"></embed>
<audio id='player_audio' src="/Sharks/music/buble.wav"></audio>
	<?php
		include 'php_shared/head.php';
		include 'php_script/navbarGame.php';
	?>

	<!--Tips-->
	<div id="tipsMenu" class="container-fluid dontShow">
		<p>Tips :</p>
		<ul>
			<li><span class="label label-success">Send</span> NEW IMAGE : Press Enter on the keyboard or click on the  button</li>
			<li><span class="label label-warning">Delete</span> Delete the selected zone by pressing  (shortcut = 'Delete')</li>
			<li><span class="label label-danger">Reset</span> Remove all your shapes by pressing  (shortcut = 'Esc')</li>
			<li><span class="label label-info">Tips</span> Show/hide tips by pressing (shortcut = 'T')</li>
			<li><span class="label label-default"><span class="glyphicon glyphicon-move"></span></span> Move the selected zone by dragging them with the mouse  (shortcut = arrows)</li>
			<li><span class="label label-default"><span class="glyphicon glyphicon-plus"></span><span class="glyphicon glyphicon-minus"></span></span> Change the selected shape's width and height by grabbing points (shortcut = '+' '-')</li>
		</ul>
	</div>
	<!--Image Container-->
	<div id="container" class="container noSelect"   onmousedown="initZone()" onmousemove="setZone()" onmouseup="endSelectZone()" ontouchstart="initZone()" ontouchmove="setZone()" ontouchend="endSelectZone()">
		<div id="imageContainer" class="noSelect">

			<?php include 'php_script/getAnImage.php'; ?>

		</div>
	</div>
	
</body>
</html>
