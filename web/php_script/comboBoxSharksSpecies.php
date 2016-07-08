<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	include 'dbManager.php';

	/*
	// get the shark species
	//$filedir = '/home/socguest/Desktop/Sharks_GLOBAL/web/private/sharksNames.txt';
	$filedir = '/srv/www/htdocs/Sharks_GLOBAL/web/private/sharksNames.txt';
	
	
	// open file
	$file = fopen($filedir, 'r');
	// read data by split on the end lines
	$content = fread($file, filesize($filedir));
	$species = explode("\n", $content);
	// close file
	fclose($file);
	
	
	// build the html combobox
	print "<select id='sharkSpecies' class='form-control'>";
	print "<option value='empty'>-- Tag a species --</option>";
	$category = false;
	foreach($species as $s) {
		// avoid empty strings possibly provided by split function
		if($s !== ""){
			
			// new category
			if($s[0] === "#") {
				
				// close the previous category if it exists
				if($category) {
					print "</optgroup>";
				}
				// open the new category
				$s = substr($s, 1);
				print "<optgroup label='$s'>";
				
				$category = true;
			}
			// new element
			else {
				print "<option value='$s'>$s</option>";
			}
		}
	}
	// close the previous category if it exists
	if($category) {
		print "</optgroup>";
	}
	print "</select>";
	
	*/
	
	
	
	$db = dbOpen();
	$sharks = getSharksList($db);
	
	
	
	/*
	
	print "
	<div class='dropdown'>
		<button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
		-- Select a species -- <span class='caret'></span>
		</button>
		<ul class='dropdown-menu multi-level' role='menu' aria-labelledby='dropdownMenu'>
	";
	
	*/
	
	
	/******************************
	 *
	 *
	 ******************************/
	
	
	
	
	echo '{ "records" :[ ';
	//1st occurence
	$s = $sharks->fetch(PDO::FETCH_ASSOC);
	echo json_encode($s);
	//others
	while($s = $sharks->fetch(PDO::FETCH_ASSOC)) {
		echo ", ";
		echo json_encode($s);
	}
	echo " ] } ";
	
	
	
	
	//$details = "";
	
	//print "<select id='sharkSpecies' class='form-control'>";
	//print "<option value='empty'>-- Tag a species --</option>";
	//while($s = $sharks->fetch_array()) {
		/*print "
		<option class='dropdown-submenu' value='{$s['name']}'>{$s['name']}</option>
		";
		$img = $s['image'];
		$name = $s['name'];
		$details = "
			<table class='table-condensed'>
				<tr>
					<th colspan='3'>{$s['name']}</th>
				</tr>
				<tr>
					<td>Other names:<td>
					<td>{$s['otherNames']}</td>
					<td style='position: relative'>
						<img src='$img' alt='$name'/>
					</td>
				</tr>
				<tr>
					<td>Length:</td>
					<td>{$s['length']}</td>
				</tr>
				<tr>
					<td>Unique identifying Features:</td>
					<td>{$s['uif']}</td>
				</tr>
			</table>
			";
			
			*/
			
			
	/*		
			
			
			<a tabindex='-1' href='#'>{$s['name']}</a>
			<ul class='dropdown-menu' style='width: 200px;'>
				<li>Other names: {$s['otherNames']}</li>
				<li><img href='{$s['image']}' alt='{$s['name']}'/></li>
				<li>Length: {$s['length']}</li>
				<li>Unique identifying Features: {$s['uif']}</li>
			</ul>
		</option>
		";*/
	//}
	//print "
	//	</ul>
	//</div>";
	
	//print "</select>";
	//print $details;
	
	dbClose($db);
	
	
	
	
function getSharksList($db) {
	return $db->query("	SELECT id, name, otherNames, image, length, uniqueIdentifyingFeature AS 'uif'
						FROM Species");
}
?>
