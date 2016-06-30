<?php include 'php_script/startSession.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Sharks Tag game</title>
	
	<?php include('php_shared/header.php'); ?>
	
	
	<link rel="stylesheet" type="text/css" href="css/game.css">
	<link rel="stylesheet" type="text/css" href="css/dropdown-submenu.css">
	<script type="text/javascript" src="javascript/game.js"></script>
	<script type="text/javascript" src="javascript/comboBoxSharksSpecies.js"></script>
	
</head>
<body data-spy="scroll" data-target="#navGame" >
<embed src="/SharksTag/music/wave.wav" autostart="true" loop="-1" hidden="true"></embed>
<audio id='player_audio' src="/SharksTag/music/buble.wav"></audio>
	<?php include 'php_shared/head.php'; ?>

	<div id="navGame" class="navbar navbar-default" data-spy="affix">
	    <div class="container-fluid">
		    <!--La Barre de jeu-->
			<!--<ul class="nav navbar-nav navbar-left">
				<li id="appMenu">Select an area on the image below and tag the species aside </li>
			</ul>-->	
		
			<!-- Split button -->
			<div class="col-xs-6">
				<?php include 'table.php';
					includeComboBox();
				?>
			</div>
			<div class="col-xs-6 btn-group btn-group-justified">
				<div class="btn-group">
					<button id="newImage" type="button" class="btn btn-success" onclick="newImage()">
					<span class="glyphicon glyphicon-check"></span>
					<span class="hidden-xs"> Send</span></button>
				</div>
				<div class="btn-group">
				<button id="delete" class="btn btn-warning" onclick="deleteZone()">
					<span class="glyphicon glyphicon-erase"></span>
					<span class="hidden-xs"> Delete</span></button>
				</div>
				<div class="btn-group">
				<button id="resetAll" class="btn btn-danger" onclick ="resetAllZone()">
					<span class="glyphicon glyphicon-trash"></span>
					<span class="hidden-xs"> Reset</span></button>
				</div>
				<div class="btn-group">
				<button id="tipsButton" class="btn btn-info" onclick="showHideTips()">
					<span class="glyphicon glyphicon-option-vertical"></span>
					<span class="hidden-xs"> Tips</span></button>
				</div>
			</div>
		</div>
	</div>
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
