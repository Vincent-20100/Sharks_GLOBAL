<?php
	

	$tabTags= [
		[0,4],
		[5],
		[5],
		[4],
		[0,2,4]
	];
	echo "pre<br/>";
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
					$found = true;
					echo "<br/><br/>i = ".$i." j = ".$j;

					$tabTags[$i] = mergeTab($listTag1, $listTag2);
					echo "<br/>After merging<br/>";
					print_r($tabTags);

					$toUnset[$tabToDel] = $j;
					$tabToDel++;

					echo "<br/>To unset<br/>";
					print_r($toUnset);
				}
			}
			$found = false;
		}
	}

	foreach ($toUnset as $value) {
		unset($tabTags[$value]);
	}
	echo "<br/>After unset<br/>";
	print_r($tabTags);

	$tabTags = array_values($tabTags);
	echo "<br/>After remaking tab<br/>";
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
