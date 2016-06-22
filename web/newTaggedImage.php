<?php
	//Tristan Le Nair, DCU, 2016

	function newTaggedImage($sessionPlayer, $imageId, $tags){

		//connexion
		require 'dbConnect.php';
		$mysqli->exec ("BEGIN TRANSACTION T1");

		//create a tag for each selection made
		foreach($tags as $i){
			$number = $mysqli->exec("INSERT INTO Tag(labelSpecies, posX, posY, width, height) VALUES('{$i['species']}', {$i['posX']}, {$i['posY']}, {$i['width']}, {$i['height']})");	
		}		

		//get the player
		$playerId = $mysqli->query('SELECT id FROM Player WHERE session = "$sessionPlayer"');
		//get the tags
		$tagId = $mysqli->query('SELECT id FROM Tag ORDER BY id DESC LIMIT $number');
		$tagRows = mysql_fetch_row($tagId);

		//create the tagged image
		while ($i < $tagId->num_rows){
		$mysqli->exec("INSERT INTO TaggedImage(image, player, tag) VALUES($imageId, $playerId, {$tagRows[$i]})");
		$i++;	
		}

		$mysqli->exec ("COMMIT TRANSACTON T1");
		require 'dbDisconnect.php';

	}

?>
