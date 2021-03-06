<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	include 'dbManager.php';

	if(isset($_GET['s'])) {
		$session = $_GET['s'];
	}
	else {
		$session = $_COOKIE['SESSID'];
	}

	$db = dbOpen();
	$personM = new PersonManager($db);
	// test if the user session is still active
	$usr = $personM->getBySession($session);
	dbClose($db);

	if($usr->id_sessionCurrent() != null) {
		$image = getOldImage($session);
		if( $image == null) {
			$image = getNewImage();
		}
		print $image;
	}
	else {
		print getErrorDiv("
			<div>
				<span class='glyphicon glyphicon-exclamation-sign color-warning' style='font-size: 75%;'></span>
				Your session expired.
			</div>
			<div>
				<span class='glyphicon glyphicon-refresh color-info' style='font-size: 75%;'></span>
				Refresh the page to log in again.
			</div>
			<div>
				<span class='glyphicon glyphicon-tags color-success' style='font-size: 75%;'></span>
				Nevertheless, your tags have been sent.
			</div>");
	}

	


	function getOldImage($session) {


		$db = dbOpen();

		$q = $db->query("	SELECT *
							FROM Image
							WHERE analysed = 0");
		if($q === false){ return null; }
		
		while($data = $q->fetch(PDO::FETCH_ASSOC)) {
			
			$containsIP = containsIP($session, $data['id']);

			if(! $containsIP ) {
				// print the hmtl <img> tag
				$image = "<img class='img-responsive avoidrag' idImage='{$data['id']}' src='{$data['name']}' alt='a databank image' img-width='{$data['width']}' img-height='{$data['height']}'>";
				dbClose($db);

				return $image;
			}
		}
		dbClose($db);
		return null;
	}


	function getNewImage() {
		$dir = array();
		$dir['html'] = 'http://www.divelikeastone.com/private/sharks';
		$dir['server'] = $_SERVER['DOCUMENT_ROOT'] . '/private/sharks';

		// get the list of images
		$files = scandir($dir['server'], 1);
		// remove '.' and '..'
		array_pop($files);
		array_pop($files);

		$db = dbOpen();
		$prepared = $db->prepare("	SELECT *
									FROM Image
									WHERE name = :name");
		
		$filesArray = array();
		$i=0;
		foreach($files as $f) {
			// keep only the files
			if(is_file("{$dir['server']}/$f")) {
				if( ! existsInDataBase($prepared, "{$dir['html']}/$f")){
					array_push($filesArray,$f);
				}
			}
		}
		dbClose($db);

		if (count($filesArray) > 0) {
			// choose randomly one file
			$i = array_rand($filesArray);
			$imgSize = getimagesize("{$dir['server']}/{$filesArray[$i]}");
			$width = $imgSize[0];
			$height = $imgSize[1];
			// print the hmtl <img> tag
			return "<img class='img-responsive avoidrag' src='{$dir['html']}/{$filesArray[$i]}' alt='a databank image' img-width='$width' img-height='$height'>";
		}
		else {
			//print an error
			return getErrorDiv("No image found");
		}
	}

	function existsInDataBase($prepared, $image) {
		$prepared->bindValue(':name', $image);
		$prepared->execute();
		return $prepared->fetch(PDO::FETCH_ASSOC);
	}

	function containsIP($session, $idimage){
		//look if someone with the same ip adress has not already tagged the image
		$db = dbOpen();	

		$q = $db->query("	SELECT Session.ipv4, Session.id_person
							FROM Session
							WHERE Session.id = $session");
		$data = $q->fetch(PDO::FETCH_ASSOC);

		$q2 = $db->query("	SELECT Session.ipv4, Session.id_person
							FROM Session, Image, TaggedImage
							WHERE Image.id = TaggedImage.id_image
							AND Session.id = TaggedImage.id_session
							AND Image.id = $idimage");

		dbClose($db);
		
		while ($data2 = $q2->fetch(PDO::FETCH_ASSOC)){
			if (isSameIPLocation(long2ip($data2['ipv4']), long2ip($data['ipv4'])) && $data['id_person'] == $data2['id_person']){
				return true;
			}
		}
		return false;
	}


	function isSameIPLocation($ip1, $ip2){
		$ok = false;
		$tabIP1 = array();

		$token1 = strtok($ip1, ".");
		array_push($tabIP1, $token1);

		while ($token1 !== false)
		{
		   	$token1 = strtok(".");
		   	array_push($tabIP1, $token1);
		}

		$tabIP2 = array();
		$token2 = strtok($ip1, ".");
		array_push($tabIP2, $token2);
		 
		while ($token2 !== false)
		{
		   	$token2 = strtok(".");
		   	array_push($tabIP2, $token2);
		}

		for ($i=0; $i<2; $i++){
			if (! strcmp($tabIP1[$i], $tabIP2[$i]) ) {
				$ok =true;
			} else {
				return false;
			}
		}

		return $ok;
	}

	function getErrorDiv($message) {
		return "<div style='font-size: 32px; text-align: left; padding: 20px; border: solid #f00 0; margin: auto;'>$message</div>";
	}

?>
