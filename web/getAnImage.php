<?php
	
	$dir = array();
	$dir['html'] = '/SharksTag/serverFiles/images/sharks';
	$dir['server'] = '/home/socguest/Desktop/serverFiles/images/sharks';
	
	
	// get the list of images
	$files = scandir($dir['server'], 1);
	// remove '.' and '..'
	array_pop($files);
	array_pop($files);
	
	// keep only the files
	$filesArray = array();
	foreach($files as $f) {
		if(is_file("{$dir['server']}/$f")) {
			array_push($filesArray,$f);
		}
	}
	
	
	
	if (count($filesArray) > 0) {
		// choose randomly one file
		$i = array_rand($filesArray);
		// print the hmtl <img> tag
		print("<img src='{$dir['html']}/{$filesArray[$i]}' alt='a databank image'>");
	}
	else {
		//print an error
		print("<div style='font-size: 32px; text-align: center; padding: 20px; border: solid #f00 2px; margin: auto;'>No image found</div>");
	}
?>
