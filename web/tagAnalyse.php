<?php
	include('class/TaggedImageManager.php');
	include('class/TagManager.php');
	include('class/Tag.php');

	include('class/Barycentre.php');	

	//at least 5 person have tagged the image
	function ($imageId){
		
		//connexion
		require 'dbConnect.php';
		$mysqli->exec ("BEGIN TRANSACTION T1");
		
		//search for all taggedimage linked to this image
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$taggedImageManager = new TaggedImageManager($db);
		$ListTaggedImages = $taggedImageManager->getListByIdImage($imageId) 
		
		$tagManager = new TagManager($db);
		$ListTags = []; //contain all tags for the image
		foreach($ListTaggedImages as $idTaggedImage){
			$ListTags = array_merge($ListTags, $tagManager->getListByIdTaggedImage($idTaggedImage));
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
		

		$thereIsAFive = false;
		$thereIsNoThreeOrFour = true;
		//we look at the number of person who agree on a tag
		for($i = 0; $i<count($tabTags); $i++) {
			if(count($tabTags[$i])>=5){
				$thereIsAFive = true;
			}
			else if (count($tabTags[$i])>=3){
				$thereIsNoThreeOrFour = false;
			}
		}
		if(!($thereIsAFive && $thereIsNoThreeOrFour)) {
			return "The conditions to stop presenting the image does'nt match";
		}
	

		//we keep the barycenter of the tags in the list for each sharks as image reference		
		$weights = [];
		$tabRef = [];
		$speciesIdTag = [];
		$tabSpec = [];

		for($i = 0; $i<count($tabTags); $i++) {
			for ($j = 0; $j<count($tabTags[$i]); $j++) {
				$weights[$j] = 1;
				$tabTagSpecies[$i][$j] = $tabTags[$i][$j]->id_species();
			}
			$barycenter[$i] = new Barycenter($tabTags[$i], $weights);
			$tabRef[$i] = $barycenter[$i]->getBarycenter();
			//print_r($tabRef[$i]->getBarycentre());

			//among all the species from the selected ones, we choose the species selected the most, if there is one
			if(count($tabTags[$i])>=5){
				$arrayCountValues[$i] = array_count_values($tabTagSpecies[$i]);
				//$arrayCountValues[$i][id_species] = %
				//max($arrayCountValues[$i]) = % max

				if (max($arrayCountValues[$i])/count($tabTags[$i]) < 0,75 ){
					return "A shark have not been tagged enough to have an agreement";
				} else {
					$speciesIdTag[$i] = array_search(max($arrayCountValues[$i]), $arrayCountValues[$i]);
				}
			}
			else{//for the tags which were tagged too few times, we don't know if there is a shark or not so they will have to be checked manually later
				$speciesIdTag[$i] = "undefined";
			}

			//if a species is choosen, the image cannot be tagged any longer			
			$q3 = $this->_db->prepare('UPDATE Image SET analysed = 1 WHERE :id_image = id');
			$q3->bindValue(':id_image', $imageId);
			$q3->execute();


			for($i = 0; $i<count($tabTags); $i++) {
				for($j = 0; $j<count($tabTags[$i]); $j++) {
					//points if the species is correct
					if($tabTags[$i][$j]->id_species() == $speciesIdTag[$i]){
						$points = 2;
					} else { //points for having just made a right selection
						$points = 1;
					}

					$q1 = $this->_db->prepare("SELECT person.id FROM Person person, Sesssion session, TaggedImage taggedImage, Tag tag WHERE tag.id_taggedImage = taggedImage.id AND session.id = taggedImage.id_session AND session.id_person = person.id AND tag.id = :id_tag");
					$q1->bindValue(':id_tag', $tabTags[$i][$j]->id());
					$donnees = $q1->fetch(PDO::FETCH_ASSOC);

					$q2 = $this->_db->prepare('UPDATE Player SET score = score + :points WHERE :id_person = id');
					$q2->bindValue(':id_person', $donnees['id']);
					$q2->bindValue(':points', $points);
					$q2->execute();
				}
			}
			
			//create the reference tags
			$taggedImage = new TaggedImage([
			  	'id_image' => '$imageId',
			]);
			$taggedImageManager = new TaggedImageManager($db);
			$taggedImageManager->addRef($taggedImage);
			$taggedImage = $taggedImageManager->getRefByImageId($taggedImage);
			
			$tagRef = new Tag([
			  	'x1' => '$tabRef[$i][0]',
			  	'y1' => '$tabRef[$i][1]',
			  	'x2' => '$tabRef[$i][2]',
			  	'y2' => '$tabRef[$i][3]',
			  	'isReference' => '1'
			]);

			$tagManager = new TagManager($db);
			$speciesManager = new SpeciesManager($db);
			if ($speciesIdTag[$i] == "undefined") $speciesIdTag[$i] = $speciesManager->getIdByName("undefined");
			$tagManager->addRef($tagRef, $taggedImage->id() , $speciesIdTag[$i]);
		}
		
	
		$mysqli->exec ("COMMIT TRANSACTON T1");
		require 'dbDisconnect.php';
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
