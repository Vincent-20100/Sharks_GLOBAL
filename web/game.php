<!DOCTYPE html>
<html>
<head>
	<title>Sharks Tag game</title>
	<link rel="stylesheet" type="text/css" href="css/game.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<script type="text/javascript" src="javascript/game.js"></script>
</head>
<body>
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
				<li>T button shows/hides this tips. You can use the shortcut 'Alt' + 'T' as well.</li>
				<li>Delete : Press backspace on the keyboard or click on the 'Delete' button</li>
				<li>ResetAll : Press Escape on the keyboard or click on the 'ResetAll' button</li>
				<li>NEW IMAGE : Press 'Alt' + 'N' on the keyboard or click on the 'New image' button</li>
				<li>You can move the zones by dragging them with the mouse or by using the arrow keys</li>
				<li>You cane alse change the width and the height of the zones by grabbing green points or by using '+' and '-' ok your keyboard</li>
				
			</ul>
		</div>
	</div>

	<div id="container" onmousedown="initZone()" onmousemove="setZone()" onmouseup="endSelectZone()" class="noSelect">
		<div id="imageContainer" class="noSelect"   >
			<img src="images/tutorial.jpg" style="pointer-events: none;">
		</div>
	</div>
	<div id="containerBelow">
	    <a id="setZone" href="javascript:void(0);" onclick=""><li>Next</li></a>
	</div>
</body>
</html>
