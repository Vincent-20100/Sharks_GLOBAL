<?php
	
	include_once('../class/TaggedImageManager.php');
	include_once('../class/TagManager.php');
	include_once('../class/Barycenter.php');	

	//at least 5 person have tagged the image
	function analyseTagsOnImage($imageId){
		
		//search for all taggedimage linked to this image
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$db->beginTransaction();
		
		$taggedImageManager = new TaggedImageManager($db);
		$ListTaggedImages = $taggedImageManager->getListByIdImage($imageId);
		
		$tagManager = new TagManager($db);
		$ListTags = []; //contain all tags for the image
		foreach($ListTaggedImages as $taggedImage){
			$ListTags = array_merge($ListTags, $tagManager->getListByIdTaggedImage($taggedImage->id()));
		}
	
		//for each tag, we gathered the neighbour tags
		
		$tabTags = []; //will contain multiple list of tags that are overlapping 
		$i = $j = 0;
		foreach($ListTags as $tag1) {
			foreach($ListTags as $tag2){
				if ($tag1->overlap($tag2)){
					$tabTags[$i][$j]= $tag2;
				}
				$j++;
			}
			$i++;
		}
		
		
		//we keep a number of list equal to the supposed number of sharks in the image (tags/users) amoung the most numerous. In case of similar list, we  merge them
		$toUnset = [];
		$merged = false;
		$tabToDel = 0;
		$found = false;

		for($i = 0; $i<count($tabTags); $i++) {
			$listTag1 = $tabTags[$i];
			for($j = $i +1; $j<count($tabTags); $j++) {
				$listTag2 = $tabTags[$j];
				foreach ($listTag1 as $keyTag => $valueTag) {
					if(!$found && in_array($valueTag, $listTag2)){
						//if we have found the value in the list previously		
						$found = true;
						
						//we merge the two list
						$tabTags[$i] = mergeTab($listTag1, $listTag2);
						//we remember to delete it afterward
						$toUnset[$tabToDel] = $j;
						$tabToDel++;

					}
				}
				//go to the next tab
				$found = false;
			}
		}
		

		//delete the tab that we merged previously
		foreach ($toUnset as $value) {
			unset($tabTags[$value]);
		}

		//reorganize the tabs
		$tabTags = array_values($tabTags);
		for ($i = 0; $i<count($tabTags); $i++) {
			$tabTags[$i] = array_values($tabTags[$i]);
		}
/*
		echo " --- tabTags : ";
		print_r($tabTags);

		echo " --- count(tabTags) : ";
		echo count($tabTags);

		for ($i = 0; $i<count($tabTags); $i++) {
			echo " --- count(tabTags[$i]) : ";
			echo count($tabTags[$i]);
		}
*/
		$willToContinue = true;
		//we look at the number of person who agree on a tag
		for($i = 0; $i<count($tabTags); $i++) {
			if($willToContinue == false) break;
			if(count($tabTags[$i])>=5){
			}
			else if (count($tabTags[$i])>=3){
				$willToContinue = false;
			}
		}
		if($willToContinue == false) {
			/**
			The conditions to stop presenting the image doesn't match
			so we exit the function and don't touch the presenting image parameter
			**/
			echo "The conditions to stop presenting the image doesn't match
			so we exit the function and don't touch the presenting image parameter";
			return 'Success';
		}
		
	

		//we keep the barycenter of the tags in the list for each sharks as image reference		
		$weights = []; //contain the weight of each tag
		$tabRef = []; //contain the barycenter of the RefTag
		$speciesIdTag = []; //contain the tagRef of the Grouped Tag
		$tabTagSpecies = []; //contain the species of each tag


		//echo " - taille tabTags : ";
		//print_r(count($tabTags));

		for($i = 0; $i<count($tabTags); $i++) {
			
			$weights = array_fill(0, count($tabTags[$i]), 1);
			for ($j=0; $j < count($tabTags[$i]); $j++) { 
				$tagsVectors[$i][$j][0] = $tabTags[$i][$j]->x1(); //x1
				$tagsVectors[$i][$j][1] = $tabTags[$i][$j]->y1(); //y1
				$tagsVectors[$i][$j][2] = $tabTags[$i][$j]->x2(); //x2
				$tagsVectors[$i][$j][3] = $tabTags[$i][$j]->y2(); //y2
			}
			
			$barycenter[$i] = new Barycenter($tagsVectors[$i], $weights);
			$tabRef[$i] = $barycenter[$i]->getBarycenter();

			/*
			echo " --- barycenter class : ";
			print_r($barycenter[$i]);
			echo " --- barycenter : ";
			print_r($tabRef[$i]);
			*/

			//among all the species from the selected ones, we choose the species selected the most, if there is one
			if(count($tabTags[$i])>=5){
				for ($j = 0; $j<count($tabTags[$i]); $j++) {
					$tabTagSpecies[$i][$j] = $tabTags[$i][$j]->id_species();
				}
				$arrayCountValues[$i] = array_count_values($tabTagSpecies[$i]);
				//$arrayCountValues[$i][id_species] = % --> see the php doc
				//max($arrayCountValues[$i]) give the maximum value among the species

				if (max($arrayCountValues[$i])/count($tabTags[$i]) < 0.75 ){
					/** 
					GOT ref : a shark has no name ;)
					A shark have not been tagged enough to have an agreement
					so we exit the function and don't touch the presenting image parameter 
					**/
					return 'Success';
				} else {
					$speciesIdTag[$i] = array_search(max($arrayCountValues[$i]), $arrayCountValues[$i]);
				}
			}
			else{//for the tags which were tagged too few times, we don't know if there is a shark or not so they will have to be checked manually later
				$speciesIdTag[$i] = "undefined";
			}

			//if a species is choosen, the image cannot be tagged any longer			
			$q3 = $db->prepare('UPDATE Image SET analysed = 1 WHERE id = :id_image');
			$q3->bindValue(':id_image', $imageId);
			$q3->execute();

			//echo "speciesIdTag : ";
			//print_r($speciesIdTag);
			
			//echo " -- taille tabTags[$i] : ";
			//print_r(count($tabTags[$i]));

			for($j = 0; $j<count($tabTags[$i]); $j++) {
				
				//points if the species is correct
				if($tabTags[$i][$j]->id_species() == $speciesIdTag[$i]){
					$points = 2;
				} else { //points for having just made a right selection
					$points = 1;
				}

				//we look for the player id who made the tag
				$tagId = $tabTags[$i][$j]->id();
				$q1 = $db->query("SELECT person.id FROM Person person, Session session, TaggedImage taggedImage, Tag tag WHERE tag.id_taggedImage = taggedImage.id AND session.id = taggedImage.id_session AND session.id_person = person.id AND tag.id = ".$tagId);
				if($q1 === false){ return null; }
				$donnees = $q1->fetch(PDO::FETCH_ASSOC);

				//update the player score
				$q2 = $db->prepare('UPDATE Player SET score = score + :points WHERE :id_person = id_person');
				$q2->bindValue(':id_person', $donnees['id']);
				$q2->bindValue(':points', $points);
				$q2->execute();
			}
			
			//create the reference tags
			$taggedImage = new TaggedImage([
			  	'id_image' => $imageId,
			]);
			$taggedImageManager = new TaggedImageManager($db);
			$taggedImageManager->addRef($taggedImage);
			$taggedImage = $taggedImageManager->getRefByImageId($imageId);
			
			$tagRef = new Tag([
			  	'x1' => $tabRef[$i][0],
			  	'y1' => $tabRef[$i][1],
			  	'x2' => $tabRef[$i][2],
			  	'y2' => $tabRef[$i][3],
			  	'isReference' => '1'
			]);

			$tagManager = new TagManager($db);
			$speciesManager = new SpeciesManager($db);
			if ($speciesIdTag[$i] == "undefined") $speciesIdTag[$i] = $speciesManager->getIdByName("undefined");
			$tagManager->addRef($tagRef, $taggedImage->id() , $speciesIdTag[$i]);
		}
		
		$db->commit();
		
		return 'Success'; //Full success
	}

	function mergeTab(array $tab1, array $tab2)
	{
		foreach ($tab2 as $valueTab2) {
			if(in_array($valueTab2, $tab1)){}
			else {
				array_push($tab1, $valueTab2);
			}
		}
		return $tab1;
	}

?>
