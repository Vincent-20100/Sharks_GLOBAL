<?php
if(!isset($_SPECIES_PHP)){
	include 'Species.php';
}

class SpeciesManager
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Species $species)
	{
		$q = $this->_db->prepare('INSERT INTO Species(image, length, distribution, food, commercialImportance, stateOfEndangerment, attacksOnHumans, swimmingDeep, uniqueIdentifyingFeature) VALUES(:image, :length, :distribution, :food, :commercialImportance, :stateOfEndangerment, :attacksOnHumans, :swimmingDeep, :uniqueIdentifyingFeature)');
		
		$q->bindValue(':image', $species->image());
		$q->bindValue(':length', $species->length());
		$q->bindValue(':distribution', $species->distribution());
		$q->bindValue(':food', $species->food());
		$q->bindValue(':commercialImportance', $species->commercialImportance());
		$q->bindValue(':stateOfEndangerment', $species->stateOfEndangerment());
		$q->bindValue(':attacksOnHumans', $species->attacksOnHumans());
		$q->bindValue(':swimmingDeep', $species->swimmingDeep());
		$q->bindValue(':uniqueIdentifyingFeature', $species->uniqueIdentifyingFeature());

		$q->execute();
	}

	public function delete(Species $species)
	{
		$this->_db->exec('DELETE FROM Species WHERE id = '.$species->id());
	}

	public function getById($id)
	{
		try {
			$id = (int) $id;

			$q = $this->_db->query('SELECT id, image, length, distribution, food, commercialImportance, stateOfEndangerment, attacksOnHumans, swimmingDeep, uniqueIdentifyingFeature FROM Species WHERE id = '.$id);
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

	    	return new Species($data);
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getIdByName($sharkName)
	{
		try {

			$q = $this->_db->query("SELECT id
									FROM Species
									WHERE name = '$sharkName'");
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

	    	return $data['id'];
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getList()
	{
		try {
			$species = [];
			$q = $this->_db->query('SELECT id, image, length, distribution, food, commercialImportance, stateOfEndangerment, attacksOnHumans, swimmingDeep, uniqueIdentifyingFeature FROM Species ORDER BY id');
			if($q === false){ return null; }
			while ($data = $q->fetch(PDO::FETCH_ASSOC))
			{
				$species[] = new Species($data);
			}
			return $species;
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function update(Species $species)
	{
		$q = $this->_db->prepare('UPDATE Species SET image = :image, length = :length, distribution = :distribution, food = :food, commercialImportance = :commercialImportance, stateOfEndangerment = :stateOfEndangerment, attacksOnHumans = :attacksOnHumans, swimmingDeep = :swimmingDeep, uniqueIdentifyingFeature = :uniqueIdentifyingFeature WHERE id = :id');
		
		$q->bindValue(':image', $species->image());
		$q->bindValue(':length', $species->length());
		$q->bindValue(':distribution', $species->distribution());
		$q->bindValue(':food', $species->food());
		$q->bindValue(':commercialImportance', $species->commercialImportance());
		$q->bindValue(':stateOfEndangerment', $species->stateOfEndangerment());
		$q->bindValue(':attacksOnHumans', $species->attacksOnHumans());
		$q->bindValue(':swimmingDeep', $species->swimmingDeep());
		$q->bindValue(':uniqueIdentifyingFeature', $species->uniqueIdentifyingFeature());

		$q->execute();
	}

	public function setDb(PDO $db)
	{
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$this->_db = $db;
	}

	/* To add a new Species in the DB see the example bellow

		$species = new Species([
		  	'image' => '...',
		  	'length' => ...,
		  	'distribution' => ...,
		  	'food' => ...,
		  	'commercialImportance' => ...,
		  	'stateOfEndangerment' => ...,
		  	'attacksOnHumans' => ...,
		  	'swimmingDeep' => ...,
		  	'uniqueIdentifyingFeature' => ...,

		]);
  	 
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$manager = new SpeciesManager($db);
		$manager->add($species);
		$db = null;
	 */
}
?>
