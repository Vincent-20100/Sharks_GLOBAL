<?php
	include('../class/ImageManager.php');
	include('../class/TaggedImageManager.php');
	include('../class/SpeciesManager.php');
	include('../class/TagManager.php');
	include('tagAnalyse.php');

	if( !isset($_POST['imageURL'])) {
		echo "111";
	
	}
	elseif( !isset($_POST['id_session'])) {
		echo "222";
	
	}
	elseif( !isset($_POST['tabTagsPos']))
	{
		echo "Missing parameters !";
	}
	else {
	
		$imageURL = $_POST['imageURL'];
		$id_session = $_POST['id_session'];
		$listPostedTags = json_decode($_POST['tabTagsPos'], true);
		

		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
	
	 	//check if the image is in the database
		$imageManager = new ImageManager($db);
		$image = $imageManager->getByName($imageURL);
	
		$taggedImage = new TaggedImage([
		  	'id_image' => $image->id(),
		  	'id_session' => $id_session
		]);
	 
		//create a taggedImage
		$taggedImageManager = new TaggedImageManager($db);
		$taggedImageManager->add($taggedImage);
		$taggedImage = $taggedImageManager->getBySessionAndImage($taggedImage->id_session(), $taggedImage->id_image());


		$listTags = [];
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
			
				array_push($listTags, $tag);
			
		}

			
		// at least 5 person must have tagged the image before giving points
		if(count($taggedImageManager->getList())<5)
		{
			echo 'Success';
		} else {
			echo analyseTagsOnImage($image->id());
		}
	}

	
?>
