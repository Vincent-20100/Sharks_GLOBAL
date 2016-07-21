<?php
	/* Vincent Bessouet, DCU School of Computing, 2016 */
	
	$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
	$scores = $db->query("	SELECT username, score, COUNT(*) AS NB_TAG
							FROM Player P, Person Pe, Session S, Tag T, TaggedImage TI
							WHERE P.id_person = Pe.id
							AND Pe.id = S.id_person
							AND S.id = TI.id_session
							AND TI.id = T.id_taggedimage
							GROUP BY Pe.id
							ORDER BY score DESC, NB_TAG, username
							");


	$i = 1;

	echo '{ "records" :[ ';
	//1st occurence
	$s = $scores->fetch(PDO::FETCH_ASSOC);
	$s["rank"] = $i;
	echo json_encode($s);
	//others
	while($s = $scores->fetch()) {
		$i++;
		$s["rank"] = $i;
		
		echo ", ";
		echo json_encode($s);
	}
	echo " ] } ";
	
	$db = null;
	
?>
