<?php
	include 'dbManager.php';
	include_once 'tagAnalyse.php';

	if( !isset($_POST['imageURL']) || !isset($_POST['id_session']) || !isset($_POST['tabTagsPos'])) {
		echo "Missing parameters !";
	}
	else {
	
		$imageURL = $_POST['imageURL'];
		$id_session = $_POST['id_session'];
		$listPostedTags = json_decode($_POST['tabTagsPos'], true);
		

		$db = dbOpen();
		$taggedImageManager = new TaggedImageManager($db);

	 	//check if the image is in the database
		$imageManager = new ImageManager($db);
		$image = $imageManager->getByName($imageURL);

		if($image->analysed() == 0) {
			$taggedImage = new TaggedImage([
		  	'id_image' => $image->id(),
		  	'id_session' => $id_session
			]);
		 
			//create a taggedImage
			$taggedImageManager->add($taggedImage);
			$taggedImage = $taggedImageManager->getBySessionAndImage($taggedImage->id_session(), $taggedImage->id_image());


			$speciesManager = new SpeciesManager($db);
			$tagManager = new TagManager($db);
		
			for($i=0; $i<count($listPostedTags); $i++){
					$sharkName = $listPostedTags[$i]['sharkName'];
					$sharkNameId = $speciesManager->getIdByName($sharkName);
					$tag = new Tag([
						'id_taggedImage' => $taggedImage->id(),
						'id_species' => $sharkNameId,
					  	'x1' => $listPostedTags[$i]['x1'],
					  	'y1' => $listPostedTags[$i]['y1'],
					  	'x2' => $listPostedTags[$i]['x2'],
					  	'y2' => $listPostedTags[$i]['y2']
					]);
					
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

	
?>
