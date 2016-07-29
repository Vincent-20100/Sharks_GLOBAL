<?php include_once 'php_script/startSession.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/tutorial.css">
</head>
<body class="noSelect">
	<?php include 'game.php'; ?>
	<div id="tutoContainer" class="noSelect" onmousemove="passDiv()" onmouseup="endSelectZone()">
	
		<div id="instructions" num="0" class="tab-content">
			<a id="prev-tutorial"><span class="glyphicon glyphicon-chevron-left"></span></a>
			<a id="next-tutorial"><span class="glyphicon glyphicon-chevron-right"></span></a>
			<div role="tabpanel" class="tab-pane active">
				Welcome on Sharks Tag! Let's start by a little tutorial.<br />
				Go back <span class="label label-default"><span class="glyphicon glyphicon-chevron-left"></span></span> or go on <span class="label label-default"><span class="glyphicon glyphicon-chevron-right"></span></span> thanks to the arrows.
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
				To remove a frame click on it and on the <span class="label label-warning">Delete</span> button, in the menu.<br />
				To remove all your frames, just click on the <span class="label label-danger">Reset</span> button.<br />
				<b>Caution</b>, there is no back!
			</div>
			<div role="tabpanel" class="tab-pane">
				Have you seen this <span class="label label-info">Tips</span> button?<br />
				You can find keyboard shortcuts to use all what we learnt quicker.
			</div>
			<div role="tabpanel" class="tab-pane">
				The <span class="label label-success">Send</span> button stores your tags, and provide a new image to start again.<br />
			</div>
			<div role="tabpanel" class="tab-pane">
				Now click on <span class="label label-success">Play</span> to start the game.
			</div>
			<div role="tabpanel" class="tab-pane">
				Sharks <span class="glyphicon glyphicon-heart color-danger"></span>
			</div>
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
			
			//disable the send button
			$("#newImage").attr("id", "newImageTuto");
			$("#newImageTuto").attr("onclick", "finishTuto()");
			$("#newImageTuto span.hidden-xs").html(" Play");
				$("#newImageTuto").addClass("disabled");
			//set the tutorial image
			$("#imageContainer").html("<img class='img-responsive avoidrag' src='images/tutorial.jpg' alt='tutorial image'/>");
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

			if(num >= max-2) {
				//unlock the Play button
				$("#newImageTuto").removeClass("disabled");
			}
			else {
				//keep locked
				$("#newImageTuto").addClass("disabled");
			}
		}

		function finishTuto() {
			if( ! $("#newImageTuto").is(".disabled")) {
				$.ajax({
					async: true,
					// destination page
					url: 'http://www.divelikeastone.com/Sharks/php_script/finishTutorial.php',
					// use POST method
					type: 'POST',
					// POST's arguments
					data: {
						username : $("#session_id").attr("session-username")
					},
					context: this,
					// get the result
					success: checkFinishTuto
				});
			}
		}

		function checkFinishTuto(data) {
			console.log(data);
			
			if(data.endsWith("Success")){
				window.location.href = "game.php?e=GG";
			}
			else{ // data == "Failed"
				dispMsg("alert-danger", "remove-sign", data );
			}
		}

	</script>
</body>


