<?php include 'php_script/startSession.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Sharks Tag game</title>
	<link rel="stylesheet" type="text/css" href="css/game.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<script type="text/javascript" src="javascript/game.js"></script>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<embed src="/SharksTag/music/wave.wav" autostart="true" loop="-1" hidden="true"></embed>
<audio id='player_audio' src="/SharksTag/music/buble.wav"></audio>
	<?php include('noscript.php'); ?>
	<div id="containerHead">
		<ul id="appButtons">
			<a id="tipsButton" href="javascript:void(0);" onclick="showHideTips()"><li>T</li></a>
			<a id="delete" href="javascript:void(0);" onclick="deleteZone()"><li>Delete</li></a>
			<a id="resetAll" href="javascript:void(0);" onclick ="resetAllZone()"><li>ResetAll</li></a>
			<a id="newImage" href="javascript:void(0);" onclick="newImage()"><li>New image</li></a>
		</ul>
		
		
		<div id="appMenu">
			<p>Select an area on the image below and tag the species aside</p>
			<?php include('php_script/comboBoxSharksSpecies.php'); ?>
		</div>
		
		
		<div id="tipsMenu" class="dontShow">
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
	</div>

	<div id="container" onmousedown="initZone()" onmousemove="setZone()" onmouseup="endSelectZone()" class="noSelect">
		<div id="imageContainer" class="noSelect"   >
			<img src="images/tutorial.jpg">
		</div>
	</div>
	<div id="containerBelow">
	    <a id="setZone" href="javascript:void(0);" onclick=""><li>Next</li></a>
	</div>
</body>
</html>
