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
	
	<script>
    	function getPos(){
    		var pos = $("#mainNav").height();
			$("#navGame").attr("data-offset-top", pos);
    	}

    	$(function(){
		    	var img = $('#imageContainer');
		   		var precw = img.width(); 
		   		var prech = img.height();
		    	console.log("Depart : "+precw);
		    	console.log("         "+prech);
	    		getPos();
			$(window).resize(function(){
				console.log("Suivant :"+img.width());
				console.log("         "+img.height());
				getPos();
				var pourcentw = img.width() / precw;
				var pourcenth = img.height() / prech;
				console.log(pourcentw + "  " + pourcenth);
				var i = 0;
				for(i=0; i<rank; i++){
					console.log("On resize l'element : "+i);
					var elem = $("#selectedZone"+i);
					var point1 = $("#point1"+i);
				    var point2 = $("#point2"+i);
				    var point3 = $("#point3"+i);
				    var point4 = $("#point4"+i);

					elem.width(elem.width()*pourcentw);
					elem.height(elem.height()*pourcenth);
					elem.offset({left: elem.offset().left*pourcentw , top: elem.offset().top*pourcenth });
					point1.offset({left : elem.offset().left - point1.width()/2, top : elem.offset().top - point1.height()/2});   
			        point2.offset({left : elem.offset().left + elem.width() - point2.width()/2, top: elem.offset().top - point2.height()/2});
			        point3.offset({left : elem.offset().left + elem.width() - point3.width()/2, top: elem.offset().top + elem.height() - point3.height()/2});
				    point4.offset({left : elem.offset().left - point4.width()/2, top : elem.offset().top + elem.height() - point4.height()/2});
				}
				precw = img.width();
				prech = img.height();
			});
    	});
    </script>
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
