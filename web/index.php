<!DOCTYPE html>
<html>
<head>
	<title>Sharks Tag app</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="script.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
</head>
<body>
	<?php include('noscript.php'); ?>
	<div id="containerHead">
		
		<ul id="appButtons">
			<a id="tipsButton" href="javascript:void(0);" onclick="showHideTips()"><li>T</li></a>
			<a id="reset" href="javascript:void(0);" onclick="resetZone()"><li>Reset</li></a>
			<a id="newImage" href="javascript:void(0);" onclick="newImage()"><li>New image</li></a>
		</ul>
		
		
		<div id="appMenu">
			<p>Select an area on the image below and tag the species aside</p>
			<?php include('comboBoxSharksSpecies.php'); ?>
		</div>
		
		
		<div id="tipsMenu" class="dontShow">
			<p>Tips :</p>
			<ul>
				<li>T button shows/hides this tips. You can use the shortcut 'Alt' + 'T' as well.</li>
				<li>RESET : Press 'Alt' + 'R' on the keyboard or click on the 'Reset' button</li>
				<li>NEW IMAGE : Press 'Alt' + 'N' on the keyboard or click on the 'New image' button</li>
				
			</ul>
		</div>
	</div>
	<div id="container" onmousedown="initZone()" onmousemove="selectZone()" onmouseup="endSelectZone()">
		<div id="imageContainer">
			<img src="images/sharks/tutorial.jpg">
		</div>
		<div id="selectedZone" class="dontShow"></div>
		<div id="maskNorth" class="mask dontShow"></div>
		<div id="maskSouth" class="mask dontShow"></div>
		<div id="maskEast" class="mask dontShow"></div>
		<div id="maskWest" class="mask dontShow"></div>
	</div>
</body>
</html>



