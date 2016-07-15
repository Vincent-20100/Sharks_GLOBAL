 <!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/tutorial.css">
</head>
<body class="noSelect">
	<?php
	include 'game.php';
	?>
	<div id="tutoContainer" class="noSelect" onmousemove="passDiv()" onmouseup="endSelectZone()">
	
		<div id="instructions" num="0" class="tab-content">
			<a id="prev-tutorial"><span class="glyphicon glyphicon-chevron-left"></span></a>
			<a id="next-tutorial"><span class="glyphicon glyphicon-chevron-right"></span></a>
			<div role="tabpanel" class="tab-pane active">
				Welcome on Sharks Tag!<br/>
				Let's start by a little tutorial.<br />
				When you are ready, go on the next step by clicking the 'Next' button.
			</div>
			<div role="tabpanel" class="tab-pane">
				First of all, click on the image in order to draw a selection zone.
			</div>
			<div role="tabpanel" class="tab-pane">
				To tag this selection, choose a species on the menu list.<br />
				You can change it if necessary.
			</div>
			<div role="tabpanel" class="tab-pane">
				You can resize the frame to much match to the shark place. To do that, move a point in the corner.<br />
				You can also move the entire frame by dragging it.
			</div>
			<div role="tabpanel" class="tab-pane">
				To make an other selection, just click outside the frame and proceed the same way. You can make frames as much as you want (theorically).
			</div>
			<div role="tabpanel" class="tab-pane">
				To remove a frame click on it and on the 'delete' button, in the menu.<br />
				To remove all your frames, just click on the 'reset all' button.<br />
				<b>Caution</b>, there is no back!
			</div>
			<div role="tabpanel" class="tab-pane">
				Have you seen this 'T' button?<br />
				It's T like Tips. You can find keyboard shortcuts to use all what we learnt quicker.
			</div>
			<div role="tabpanel" class="tab-pane">
				The new image button stores your tags, and provide a new image to start again.
			</div>
			<div role="tabpanel" class="tab-pane">Sharks <3 </div>
		</div>
	</div>
	
	<script>
		$(function (){
			//This is a Jquery function, it's called all the time
			//We get the position of the mouse and we put it in posym
			$("#tutoContainer").mousemove(function(e) {
				posym.x = e.pageX;
				posym.y = e.pageY;
			});

			//move the tutoContainer into the container, just after the gameContainer
			$("#container").insertAfter($("#tutoContainer"));
			
		});
		
		
		$("#next-tutorial").click( function() { switchDiv(1); } );

		$("#prev-tutorial").click( function() { switchDiv(-1); } );

		function switchDiv(step) {
			
			var num = parseInt($("#instructions").attr("num"));
			max = $("#instructions div").length;
			console.log(max);
			if(num + step >= 0 && num + step < max) {
				$($("#instructions div")[num]).removeClass("active");
				
				num = num + step;
				$("#instructions").attr("num", num);
				$($("#instructions div")[num]).addClass("active");
			}
		}

	</script>
</body>


