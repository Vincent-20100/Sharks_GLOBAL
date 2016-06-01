<?php
	/* Vincent Bessouet, 2016 */
	
	$filedir = '/home/socguest/Desktop/Sharks_GLOBAL/web/private/sharksNames.txt';
	
	// get the shark species
	
	// open file
	$file = fopen($filedir, 'r');
	// read data by split on the end lines
	$content = fread($file, filesize($filedir));
	$species = explode("\n", $content);
	// close file
	fclose($file);
	
	
	// build the html combobox
	print "<select>";
	print "<option value='empty'>-- Tag a species --</option>";
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
	
?>