<div id="navGame" class="navbar navbar-default" data-spy="affix">
    
	<div class="col-xs-5">
		<div>
			<?php include 'listSpecies.php'; ?>
		</div>
	</div>
	
	<div class="col-xs-1">
		<button style="float: left;" class="btn btn-default btn-openModal" data-target="#modalTableSpecies" type="button">
			<span class="glyphicon glyphicon-book"></span>
		</button>
	</div>
	
	<div class="col-xs-6 btn-group btn-group-justified">
		<div class="btn-group">
			<button id="newImage" class="btn btn-success" onclick="newImage()">
				<span class="glyphicon glyphicon-check"></span>
				<span class="hidden-xs"> Send</span>
			</button>
		</div>
		<div class="btn-group">
			<button id="delete" class="btn btn-warning" onclick="deleteZone()">
				<span class="glyphicon glyphicon-erase"></span>
				<span class="hidden-xs"> Delete</span>
			</button>
		</div>
		<div class="btn-group">
			<button id="resetAll" class="btn btn-danger" onclick ="resetAllZone()">
				<span class="glyphicon glyphicon-trash"></span>
				<span class="hidden-xs"> Reset</span>
			</button>
		</div>
		<div class="btn-group">
			<button id="tipsButton" class="btn btn-info" onclick="showHideTips()">
				<span class="glyphicon glyphicon-option-vertical"></span>
				<span class="hidden-xs"> Tips</span>
			</button>
		</div>
	</div>
</div>
