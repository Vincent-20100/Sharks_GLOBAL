<div id="navGame" class="navbar navbar-default noSelect" data-spy="affix">
    <div class="btn-toolbar" role="toolbar">

		<div class="col-xs-6">
				<?php include 'listSpecies.php'; ?>
		</div>
	
		<div class="col-xs-5 btn-group-justified">
			<div class="btn-group">
				<button style="float: left;" class="btn btn-default btn-openModal" data-target="#modalTableSpecies" type="button">
					<span class="glyphicon glyphicon-book"></span>
					<span class="hidden-sm hidden-xs"> Lexicon</span>
				</button>
			</div>
			<div class="btn-group">
				<button id="newImage" class="btn btn-secondary btn-success" onclick="newImage()">
					<span class="glyphicon glyphicon-check"></span>
					<span class="hidden-xs"> Send</span>
				</button>
			</div>
			<div class="btn-group" role="group">
				<button id="delete" class="btn btn-secondary btn-warning" onclick="deleteZone()">
					<span class="glyphicon glyphicon-erase"></span>
					<span class="hidden-xs"> Delete</span>
				</button>
			</div>
			<div class="btn-group">
				<button id="resetAll" class="btn btn-secondary btn-danger" onclick ="resetAllZone()">
					<span class="glyphicon glyphicon-trash"></span>
					<span class="hidden-xs"> Reset</span>
				</button>
			</div>
			<div class="btn-group">
				<button id="tipsButton" class="btn btn-secondary btn-info" onclick="showHideTips()">
					<span class="glyphicon glyphicon-option-vertical"></span>
					<span class="hidden-xs"> Tips</span>
				</button>
			</div>
		</div>
	</div>
</div>
