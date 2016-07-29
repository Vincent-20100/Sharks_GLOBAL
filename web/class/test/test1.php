<?php
	include('../Tag.php');

	$tag1 = new Tag([
		'id' => '1',
		'x1' => '1',
	  	'y1' => '1',
	  	'x2' => '3',
		'y2' => '3'
	]);

	$tag2 = new Tag([
		'id' => '2',
		'x1' => '2',
	  	'y1' => '2',
	  	'x2' => '4',
		'y2' => '4'
	]);

	$tag3 = new Tag([
		'id' => '3',
		'x1' => '1000',
	  	'y1' => '1000',
	  	'x2' => '1003',
		'y2' => '1003'
	]);

	$tag4 = new Tag([
		'id' => '4',
		'x1' => '1000',
	  	'y1' => '1000',
	  	'x2' => '1003',
		'y2' => '1003'
	]);

	$tag5 = new Tag([
		'id' => '5',
		'x1' => '500',
	  	'y1' => '500',
	  	'x2' => '600',
		'y2' => '600'
	]);

	$ListTags = [$tag1, $tag2, $tag3, $tag4, $tag5];
	print_r($ListTags);

	$tabTags = array(); //will contain multiple list of tag are overlapping 
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
	echo "<br/><br/>";
	print_r($tabTags);

	$toUnset = array();
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

	echo "<br/><br/>";
	print_r($tabTags);

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

