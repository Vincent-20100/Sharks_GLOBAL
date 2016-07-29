<?php
	header('Access-Control-Allow-Origin: *');
	include 'dbManager.php';
	include_once 'tagAnalyse.php';


	if( !isset($_POST['imageURL']) || !isset($_POST['imageWidth']) || !isset($_POST['imageHeight']) ||
		!isset($_POST['id_session']) || !isset($_POST['tabTagsPos'])) {
			echo "Missing parameters !";
	}
	else {
	
		$imageURL = $_POST['imageURL'];
		$imgWidth = test_input($_POST['imageWidth']);
		$imgHeight = test_input($_POST['imageHeight']);
		$id_session = test_input($_POST['id_session']);
		$listPostedTags = json_decode($_POST['tabTagsPos'], true);
		
		$db = dbOpen();
		$taggedImageManager = new TaggedImageManager($db);

	 	//check if the image is in the database
		$imageManager = new ImageManager($db);
		
		$image = $imageManager->getByNameOrCreate($imageURL, $imgWidth, $imgHeight);

		if($image->analysed() == 0) {
			$taggedImage = new TaggedImage( array(
		  	'id_image' => $image->id(),
		  	'id_session' => $id_session
			));
		 
			//create a taggedImage
			$taggedImageManager->add($taggedImage);
			$taggedImage = $taggedImageManager->getBySessionAndImage($taggedImage->id_session(), $taggedImage->id_image());


			$speciesManager = new SpeciesManager($db);
			$tagManager = new TagManager($db);
		
			for($i=0; $i<count($listPostedTags); $i++){
					//we do not keep the tags where no species were selected
					if($listPostedTags[$i] == null || $listPostedTags[$i]['sharkName'] == 'undefined') { continue; }

					$sharkName = $listPostedTags[$i]['sharkName'];
					$sharkNameId = $speciesManager->getIdByName($sharkName);

					if($listPostedTags[$i]['x1'] < 0) {
						$listPostedTags[$i]['x1'] = 0;
					}
					if($listPostedTags[$i]['y1'] < 0) {
						$listPostedTags[$i]['y1'] = 0;
					}
					if($listPostedTags[$i]['x2'] > $imgWidth) {
						$listPostedTags[$i]['x2'] = $imgWidth;
					}
					if($listPostedTags[$i]['y2'] > $imgHeight) {
						$listPostedTags[$i]['y2'] = $imgHeight;
					}

					$tag = new Tag(array(
						'id_taggedImage' => $taggedImage->id(),
						'id_species' => $sharkNameId,
					  	'x1' => $listPostedTags[$i]['x1'],
					  	'y1' => $listPostedTags[$i]['y1'],
					  	'x2' => $listPostedTags[$i]['x2'],
					  	'y2' => $listPostedTags[$i]['y2']
					));
					
					$tagManager->add($tag);
				
				
			}
		}

			
		// at least 5 person must have tagged the image before giving points
		if(count($taggedImageManager->getListByIdImage($image->id()))<5
			|| $image->analysed() == 1)
		{
			// go to the next image
			echo 'Success';
		} else {
			echo analyseTagsOnImage($image->id());
		}

		dbClose($db);
	}

	//modify any special character like <p> </p>
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>
