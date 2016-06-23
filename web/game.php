<?php// include 'php_script/startSession.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Sharks Tag game</title>
	<?php include('header.php'); ?>
	<link rel="stylesheet" type="text/css" href="css/game.css">
	<script type="text/javascript" src="javascript/game.js"></script>

</head>
<body data-spy="scroll" data-target="#navGame" >
<embed src="/SharksTag/music/wave.wav" autostart="true" loop="-1" hidden="true"></embed>
<audio id='player_audio' src="/SharksTag/music/buble.wav"></audio>
	<?php include('noscript.php'); 
		  include('mainNavBar.php');
	?>


    <!--Pour le Menu telephone-->
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
	<nav id="navGame" class="navbar navbar-default" data-spy="affix">
		<div class="container-fluid">
		    <!--La Barre de jeu-->
		    <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;" >
				<ul class="nav navbar-nav navbar-left">
					<li id="appMenu">Select an area on the image below and tag the species aside <?php include('php_script/comboBoxSharksSpecies.php'); ?></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><button id="newImage" href="javascript:void(0);" class="btn btn-success" onclick="newImage()">New image</button></li>	
					<li><button id="delete" href="javascript:void(0);" class="btn btn-warning" onclick="deleteZone()">Delete</button></li>
					<li><button id="resetAll" href="javascript:void(0);" class="btn btn-danger" onclick ="resetAllZone()">ResetAll</button></li>
					<li><button id="tipsButton" href="javascript:void(0);" class="btn btn-info" onclick="showHideTips()">T</button></li>
				</ul>
			</div>
		</div>
		<!--Tips-->
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
	</nav>
	<!--Image Container-->
	<div id="container" class="container-fluid noSelect" onmousedown="initZone()" onmousemove="setZone()" onmouseup="endSelectZone()" >
		<div id="imageContainer" class="noSelect">
			<img class="img-responsive" src="images/tutorial.jpg">
		</div>
	</div>
	
</body>
</html>
