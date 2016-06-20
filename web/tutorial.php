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
	
		<div id="instructions" class="tab-content">
			<button id="next-tutorial" num="0">Next</button>
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
		});
		
		$("#next-tutorial").click( function() {
			
			var num = parseInt($("#next-tutorial").attr("num"));
			
			$($("#instructions div")[num]).removeClass("active");
			
			num = num + 1;
			$("#next-tutorial").attr("num", num);
			$($("#instructions div")[num]).addClass("active");
		});
	</script>
</body>


