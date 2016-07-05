<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	$image = getOldImage();
	if( $image == null) {
		$image = getNewImage();
	}
	print $image;


function getOldImage() {

	if((@include 'class/ImageManager.php') == false) {
		include '../class/ImageManager.php';
	}

	$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
	$manager = new ImageManager($db);

	$q = $db->query("SELECT * FROM Image WHERE analysed = 0");
	if($q === false){ return null; }
	$donnees = $q->fetch(PDO::FETCH_ASSOC);
	
	if(! $donnees) { return null; }
	//else
	
	// print the hmtl <img> tag
	$image = "<img class='img-responsive' idImage='{$donnees['id']}' src='{$donnees['name']}' alt='a databank image'>";
	$db = null;
	return $image;
}

function getNewImage() {
	$dir = array();
	$dir['html'] = 'http://136.206.48.60/SharksTag/serverFiles/public/images/sharks';
	$dir['server'] = '/home/socguest/Desktop/serverFiles/public/images/sharks';

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
		return "<img class='img-responsive' src='{$dir['html']}/{$filesArray[$i]}' alt='a databank image'>";
	}
	else {
		//print an error
		return "<div style='font-size: 32px; text-align: center; padding: 20px; border: solid #f00 2px; margin: auto;'>No image found</div>";
	}
}

?>