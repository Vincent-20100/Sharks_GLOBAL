<?php
function includeTable() {
	echo "<!-- <Angular JS> -->
	<div ng-app='myApp' ng-controller='sharksCtrl'>
	
		<table class='table-condensed' ng-repeat='x in sharks'> 
			<tr>
				<th colspan='2'>{{x.name}}</th>
				<td rowspan='4'>
					<img ng-src='{{x.image}}' alt='{{x.name}}' />
				</td>
			</tr>
			<tr>
				<td>Other names: </td>
				<td>{{x.otherNames}}</td>
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
	</div><!-- </Angular JS> -->
	";
}

function includeComboBox() {
	echo "<!-- <Angular JS> -->
	<div ng-app='myApp' ng-controller='sharksCtrl'>

		<!-- comboBox -->
		<select id='sharkSpecies' class='form-control'>
			<option value='empty'>-- Select a species --</option>
			<option ng-repeat='x in sharks' value='{{x.name}}'>{{x.name}}</option>
		</select>
	
	
	</div><!-- </Angular JS> -->
	";
}
?>
