<?php /* Vincent Bessouet, DCU School of Computing, 2016 */ ?>
<!-- <Angular JS> -->
<div ng-app='sharksApp' ng-controller='sharksCtrl'>
	<div id="modalTableSpecies" class="modal hide">
		<!-- Modal content -->
		<div class="modal-content container">
			<span class="close">x</span>
			
			
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
				<div ng-repeat='x in sharks' class="panel panel-default">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{x.id}}" aria-expanded="false" aria-controls="collapse-{{x.id}}">
						<div class="panel-heading" role="tab" id="heading-{{x.id}}">
							<h4 class="panel-title">
							
								{{ x.name }}
							</h4>
						</div>
					</a>
					<div id="collapse-{{x.id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{x.id}}">
						<div class="panel-body">
							<table class='table-condensed'> 
								<tr class='visible-xs-block'>
									<td colspan='2'>
										<img ng-src='{{x.image}}' alt='{{x.name}}' style='width: 100%;'/>
									</td>
								</tr>
								<tr>
									<td>Other names: </td>
									<td>{{x.otherNames}}</td>
									<td class='hidden-xs' rowspan='3' >
										<img ng-src='{{x.image}}' alt='{{x.name}}' style='width: 100%;'/>
									</td>
								</tr>
								<tr>
									<td>Length:</td>
									<td>{{x.length}}</td>
								</tr>
								<tr>
									<td>Unique identifying Features:</td>
									<td>{{x.uif}}</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
    	</div>
    </div>
	
	<!-- comboBox -->
	<select id='sharkSpecies' class='form-control'>
		<option value='undefined'>-- Select a species --</option>
		<option ng-repeat='x in sharks' value='{{x.name}}'>{{x.name}}</option>
	</select>
    
	
</div><!-- </Angular JS> -->

